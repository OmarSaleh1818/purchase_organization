<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BankName;
use App\Models\Company;
use App\Models\ReceiptCatch;
use App\Models\SubCompany;
use App\Models\SubSubCompany;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountCatchController extends Controller
{

    public function AccountCatchView() {

        $catches = ReceiptCatch::orderBy('id', 'DESC')->get();
        return view('accountant.catch.account_catch', compact('catches'));
    }

    public function getAccountcatchByCompany($id) {
        $catches = ReceiptCatch::where('company_id', $id)->orderBy('id', 'DESC')->get();
        $html ='';
        if($catches) {
            $html .= '';
            foreach($catches as $key => $item){
                $html .= '
                         <tr>
                            <td>'.($key + 1).'</td>
                            <td>'.$item->date.'</td>
                            <td>'.$item->gentlemen.'</td>
                            <td>'.$item->financial_provision.'</td>
                            <td>'.$item->price.'</td>
                            <td>'.$item->just.'</td>
                            <td>'.$item['subsubcompany']['subsubcompany_name'].'</td>
                            <td>'.$item['bankName']['bank_name'].'</td>
                            <td>';
                if ($item->status_id == 1) {
                    $html .= '<a href="' . route('print.receipt.catch', $item->id) . '" class="btn btn-secondary" title="طباعة"><i class="fa fa-print"></i></a>';
                } else {
                    $html .= '<a href="'.route('print.receipt.catch', $item->id).'" class="btn btn-warning" title="طباعة"><i class="fa fa-print"></i></a>';
                }
                $html .= ' </td>
                            <td>';
                $html .= '<a href="'.route('accountant.catch.edit', $item->id).'" class="btn btn-info" title="تعديل الطلب"><i class="las la-pen"></i></a>';
                $html .= '  </td>
                            <td>';
                if ($item->status_id == 6) {
                    $html .= '<button class="btn btn-success">تم موافقة المالية</button>';
                } elseif ($item->status_id == 7) {
                    $html .= '<button class="btn btn-dark">تم موافقة المدير</button>';
                } else {
                    $html .= '<button class="btn btn-primary">تم ارسال سند قبض</button>';
                }
                $html .= '  </td>
                        </tr>
                ';
            }
            return response()->json(['html' => $html]);
        }
    }

    public function AddAccountCatch() {
        $companies = Company::all();
        $subcompanies = SubCompany::all();
        $subsubcompanies = SubSubCompany::all();
        $banks = BankName::all();
        return view('accountant.catch.addaccount_catch', compact('companies', 'subcompanies'
        , 'subsubcompanies', 'banks'));
    }

    public function AccountCatchStore(Request $request){

        // Set cURL options
        $url = 'https://ahsibli.com/wp-admin/admin-ajax.php?action=date_numbers_1';
        $data = 'number=' . $request->price;

        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                'authority: ahsibli.com',
                'accept: */*',
                'accept-language: en-US,en;q=0.9,ar;q=0.8',
                'content-type: application/x-www-form-urlencoded; charset=UTF-8',
                'cookie: _gid=GA1.2.1200696489.1685273984; _gat_gtag_UA_166450035_1=1; _ga_ZSCB2L9KV5=GS1.1.1685273984.1.0.1685273984.0.0.0; _ga=GA1.1.554570941.1685273984; __gads=ID=5f01af1de5c542fc-22db0e9221e000e8:T=1685273984:RT=1685273984:S=ALNI_MYwwhfNBetLRtXSGsPPMr4LZdkrEA; __gpi=UID=00000c364d77d5ca:T=1685273984:RT=1685273984:S=ALNI_MZ7D_ac8H9HvpAIArSyXiZTznxl0Q',
                'origin: https://ahsibli.com',
                'referer: https://ahsibli.com/tool/number-to-words/',
                'sec-ch-ua: "Chromium";v="113", "Not-A.Brand";v="24"',
                'sec-ch-ua-mobile: ?0',
                'sec-ch-ua-platform: "Linux"',
                'sec-fetch-dest: empty',
                'sec-fetch-mode: cors',
                'sec-fetch-site: same-origin',
                'user-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36',
                'x-requested-with: XMLHttpRequest'
            )
        );

// Initialize cURL session
        $curl = curl_init();
        curl_setopt_array($curl, $options);

// Execute the request
        $response = curl_exec($curl);

// Close the cURL session
        curl_close($curl);

// Extract the desired result using regular expressions
        $pattern = '/<table class="resultable">.*?<tr><td>الرقم بالحروف<\/td><td>(.*?)<\/td><\/tr>/s';
        preg_match($pattern, $response, $matches);

        if (isset($matches[1])) {
            $result = $matches[1];
        } else {
            echo 'Error';
        }
        $request->validate([
            'date' => 'required',
            'gentlemen' => 'required',
            'price' => 'required',
            'currency_type' => 'required',
            'bank_id' => 'required',
        ], [
            'date.required' => 'التاريخ مطلوب',
            'gentlemen.required' => 'اسم السيد مطلوب',
            'price.required' => 'المبلغ مطلوب',
            'currency_type.required' => 'نوع العملة مطلوب',
            'bank_id.required' => 'البنك المسحوب عليه مطلوب',
        ]);

        ReceiptCatch::insert([
            'date' => $request->date,
            'company_id' => $request->company_id,
            'subcompany_id' => $request->subcompany_id,
            'subsubcompany_id' => $request->subsubcompany_id,
            'gentlemen' => $request->gentlemen,
            'price' => $request->price,
            'currency_type' => $request->currency_type,
            'just' => $result,
            'bank_id' => $request->bank_id,
            'iban_id' => $request->iban_id,
            'check_number' => $request->check_number,
            'purchase_name' => $request->purchase_name,
            'project_number' => $request->project_number,
            'financial_provision' => $request->financial_provision,
            'number_financial' => $request->number_financial,
            'created_at' => Carbon::now(),
        ]);

        $request->session()->flash('status', 'تم اصدار سند القبض بنجاح');
        return redirect('/account/catch');
    }

    public function AccountantCatchEdit($id) {
        $companies = Company::all();
        $subcompanies = SubCompany::all();
        $subsubcompanies = SubSubCompany::all();
        $banks = BankName::all();
        $catches = ReceiptCatch::findOrFail($id);
        return view('accountant.catch.account_catch_edit', compact('catches', 'companies'
            , 'subcompanies', 'subsubcompanies', 'banks'));
    }

    public function AccountantCatchUpdate(Request $request, $id) {
        // Set cURL options
        $url = 'https://ahsibli.com/wp-admin/admin-ajax.php?action=date_numbers_1';
        $data = 'number=' . $request->price;

        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                'authority: ahsibli.com',
                'accept: */*',
                'accept-language: en-US,en;q=0.9,ar;q=0.8',
                'content-type: application/x-www-form-urlencoded; charset=UTF-8',
                'cookie: _gid=GA1.2.1200696489.1685273984; _gat_gtag_UA_166450035_1=1; _ga_ZSCB2L9KV5=GS1.1.1685273984.1.0.1685273984.0.0.0; _ga=GA1.1.554570941.1685273984; __gads=ID=5f01af1de5c542fc-22db0e9221e000e8:T=1685273984:RT=1685273984:S=ALNI_MYwwhfNBetLRtXSGsPPMr4LZdkrEA; __gpi=UID=00000c364d77d5ca:T=1685273984:RT=1685273984:S=ALNI_MZ7D_ac8H9HvpAIArSyXiZTznxl0Q',
                'origin: https://ahsibli.com',
                'referer: https://ahsibli.com/tool/number-to-words/',
                'sec-ch-ua: "Chromium";v="113", "Not-A.Brand";v="24"',
                'sec-ch-ua-mobile: ?0',
                'sec-ch-ua-platform: "Linux"',
                'sec-fetch-dest: empty',
                'sec-fetch-mode: cors',
                'sec-fetch-site: same-origin',
                'user-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36',
                'x-requested-with: XMLHttpRequest'
            )
        );

// Initialize cURL session
        $curl = curl_init();
        curl_setopt_array($curl, $options);

// Execute the request
        $response = curl_exec($curl);

// Close the cURL session
        curl_close($curl);

// Extract the desired result using regular expressions
        $pattern = '/<table class="resultable">.*?<tr><td>الرقم بالحروف<\/td><td>(.*?)<\/td><\/tr>/s';
        preg_match($pattern, $response, $matches);

        if (isset($matches[1])) {
            $result = $matches[1];
        } else {
            echo 'Error';
        }
        $request->validate([
            'date' => 'required',
            'gentlemen' => 'required',
            'price' => 'required',
            'currency_type' => 'required',
            'bank_id' => 'required',
        ], [
            'date.required' => 'التاريخ مطلوب',
            'gentlemen.required' => 'اسم السيد مطلوب',
            'price.required' => 'المبلغ مطلوب',
            'currency_type.required' => 'نوع العملة مطلوب',
            'bank_id.required' => 'البنك المسحوب عليه مطلوب',
        ]);

        ReceiptCatch::findOrFail($id)->update([
            'date' => $request->date,
            'company_id' => $request->company_id,
            'subcompany_id' => $request->subcompany_id,
            'subsubcompany_id' => $request->subsubcompany_id,
            'gentlemen' => $request->gentlemen,
            'price' => $request->price,
            'currency_type' => $request->currency_type,
            'just' => $result,
            'bank_id' => $request->bank_id,
            'iban_id' => $request->iban_id,
            'check_number' => $request->check_number,
            'purchase_name' => $request->purchase_name,
            'project_number' => $request->project_number,
            'financial_provision' => $request->financial_provision,
            'number_financial' => $request->number_financial,
            'created_at' => Carbon::now(),
        ]);
        $request->session()->flash('status', 'تم حفظ سند القبض بنجاح');
        return redirect('/account/catch');
    }

    public function AddSafeCatch() {

        $companies = Company::all();
        $subcompanies = SubCompany::all();
        $subsubcompanies = SubSubCompany::all();
        $banks = BankName::all();
        return view('accountant.catch.addsafe_catch', compact('companies', 'subcompanies'
            , 'subsubcompanies', 'banks'));
    }

    public function SafeCatchStore(Request $request) {

        // Set cURL options
        $url = 'https://ahsibli.com/wp-admin/admin-ajax.php?action=date_numbers_1';
        $data = 'number=' . $request->price;

        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                'authority: ahsibli.com',
                'accept: */*',
                'accept-language: en-US,en;q=0.9,ar;q=0.8',
                'content-type: application/x-www-form-urlencoded; charset=UTF-8',
                'cookie: _gid=GA1.2.1200696489.1685273984; _gat_gtag_UA_166450035_1=1; _ga_ZSCB2L9KV5=GS1.1.1685273984.1.0.1685273984.0.0.0; _ga=GA1.1.554570941.1685273984; __gads=ID=5f01af1de5c542fc-22db0e9221e000e8:T=1685273984:RT=1685273984:S=ALNI_MYwwhfNBetLRtXSGsPPMr4LZdkrEA; __gpi=UID=00000c364d77d5ca:T=1685273984:RT=1685273984:S=ALNI_MZ7D_ac8H9HvpAIArSyXiZTznxl0Q',
                'origin: https://ahsibli.com',
                'referer: https://ahsibli.com/tool/number-to-words/',
                'sec-ch-ua: "Chromium";v="113", "Not-A.Brand";v="24"',
                'sec-ch-ua-mobile: ?0',
                'sec-ch-ua-platform: "Linux"',
                'sec-fetch-dest: empty',
                'sec-fetch-mode: cors',
                'sec-fetch-site: same-origin',
                'user-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36',
                'x-requested-with: XMLHttpRequest'
            )
        );

// Initialize cURL session
        $curl = curl_init();
        curl_setopt_array($curl, $options);

// Execute the request
        $response = curl_exec($curl);

// Close the cURL session
        curl_close($curl);

// Extract the desired result using regular expressions
        $pattern = '/<table class="resultable">.*?<tr><td>الرقم بالحروف<\/td><td>(.*?)<\/td><\/tr>/s';
        preg_match($pattern, $response, $matches);

        if (isset($matches[1])) {
            $result = $matches[1];
        } else {
            echo 'Error';
        }
        $request->validate([
            'date' => 'required',
            'gentlemen' => 'required',
            'price' => 'required',
            'currency_type' => 'required',
            'bank_id' => 'required',
        ], [
            'date.required' => 'التاريخ مطلوب',
            'gentlemen.required' => 'اسم السيد مطلوب',
            'price.required' => 'المبلغ مطلوب',
            'currency_type.required' => 'نوع العملة مطلوب',
            'bank_id.required' => 'البنك المسحوب عليه مطلوب',
        ]);

        ReceiptCatch::insert([
            'date' => $request->date,
            'company_id' => $request->company_id,
            'subcompany_id' => $request->subcompany_id,
            'subsubcompany_id' => $request->subsubcompany_id,
            'gentlemen' => $request->gentlemen,
            'price' => $request->price,
            'currency_type' => $request->currency_type,
            'just' => $result,
            'bank_id' => $request->bank_id,
            'iban_id' => $request->iban_id,
            'check_number' => $request->check_number,
            'purchase_name' => $request->purchase_name,
            'project_number' => $request->project_number,
            'financial_provision' => $request->financial_provision,
            'number_financial' => $request->number_financial,
            'created_at' => Carbon::now(),
        ]);

        $request->session()->flash('status', 'تم اصدار سند القبض بنجاح');
        return redirect('/catch/receipt');
    }



}
