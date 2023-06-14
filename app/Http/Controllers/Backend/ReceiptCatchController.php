<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CommandCatch;
use App\Models\ReceiptCatch;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReceiptCatchController extends Controller
{

    public function AddReceiptCatch($id) {

        $catch = CommandCatch::find($id);
        return view('receipt.catch.add_receipt_catch', compact('catch'));
    }

    public function ReceiptCatchStore(Request $request) {

        $id = $request->id;
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
            'bank_name' => 'required',
        ], [
            'date.required' => 'التاريخ مطلوب',
            'gentlemen.required' => 'اسم السيد مطلوب',
            'price.required' => 'المبلغ مطلوب',
            'currency_type.required' => 'نوع العملة مطلوب',
            'bank_name.required' => 'البنك المسحوب عليه مطلوب',
        ]);

        ReceiptCatch::insert([
            'date' => $request->date,
            'company_name' => $request->company_name,
            'gentlemen' => $request->gentlemen,
            'price' => $request->price,
            'currency_type' => $request->currency_type,
            'just' => $result,
            'bank_name' => $request->bank_name,
            'check_number' => $request->check_number,
            'purchase_name' => $request->purchase_name,
            'project_name' => $request->project_name,
            'project_number' => $request->project_number,
            'financial_provision' => $request->financial_provision,
            'number_financial' => $request->number_financial,
            'created_at' => Carbon::now(),
        ]);

        DB::table('command_catches')
            ->where('id', $id)
            ->update(['status_id' => 3]);

        $request->session()->flash('status', 'تم ارسال امر القبض بنجاح');
        return redirect('/catch/receipt');
    }

    public function PrintReceiptCatch($id) {

        $catch = ReceiptCatch::findOrFail($id);
        return view('print.receipt.receipt_catch', compact('catch'));
    }


}
