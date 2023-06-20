<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BankName;
use App\Models\Company;
use App\Models\SubCompany;
use App\Models\SubSubCompany;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\PaymentOrder;

class PaymentOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = PaymentOrder::orderBy('id', 'DESC')->get();
        return view('payment.payment_order', compact('payments'));
    }

    public function getPaymentOrderByCompany($id) {
        $payments = PaymentOrder::where('company_id', $id)->orderBy('id', 'DESC')->get();
        $html ='';
        if($payments) {
            $html .= '';
            foreach($payments as $key => $item){
                $html .= '
                         <tr>
                            <td>'.($key + 1).'</td>
                            <td>'.$item->date.'</td>
                            <td>'.$item->benefit_name.'</td>
                            <td>'.$item->price.'</td>
                            <td>'.$item->just.'</td>
                            <td>'.$item['bankName']['bank_name'].'</td>
                            <td>'.$item['subsubcompany']['subsubcompany_name'].'</td>
                            <td>'.$item->purchase_name.'</td>
                            <td>';
                if ($item->status_id == 1) {
                    $html .= '<a href="' . route('print.command', $item->id) . '" class="btn btn-secondary" title="طباعة"><i class="fa fa-print"></i></a>';
                } else {
                    $html .= '<a href="'.route('print.command', $item->id).'" class="btn btn-warning" title="طباعة"><i class="fa fa-print"></i></a>';
                }
                    $html .= ' </td>

                            <td>';
                            if ($item->status_id == 6) {
                                $html .= '<button class="btn btn-success">تم موافقة المالية</button>';
                            } elseif ($item->status_id == 7) {
                                $html .= '<button class="btn btn-danger">تم موافقة المدير</button>';
                            } elseif ($item->status_id == 3) {
                                $html .= '<button class="btn btn-danger">تم اصدار سند صرف</button>';
                            } else {
                                $html .= '<button class="btn btn-primary">تم الارسال</button>';
                            }

                    $html .= '  </td>
                            </tr>
                            ';
            }
            return $html;
        }
    }

    public function PaymentOrder() {
        $companies = Company::all();
        $subcompanies = SubCompany::all();
        $subsubcompanies = SubSubCompany::all();
        $banks = BankName::all();
        return view('payment.add_command', compact('companies',
            'subcompanies','subsubcompanies', 'banks'));
    }

    public function CommandStore(Request $request) {
        // Set cURL options
        $url = 'https://ahsibli.com/wp-admin/admin-ajax.php?action=date_numbers_1';
        $data = 'number='.$request->price;

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
            'benefit_name' => 'required',
            'price' => 'required',
            'currency_type' => 'required',
            'bank_id' => 'required',
        ],[
            'date.required' => 'التاريخ مطلوب',
            'benefit_name.required' => 'اسم المستفيد مطلوب',
            'price.required' => 'المبلغ مطلوب',
            'currency_type.required' => 'نوع العملة مطلوب',
            'bank_id.required' => 'البنك المسحوب عليه مطلوب',
        ]);

        PaymentOrder::insert([
            'date' => $request->date,
            'company_id' => $request->company_id,
            'subcompany_id' => $request->subcompany_id,
            'subsubcompany_id' => $request->subsubcompany_id,
            'benefit_name' => $request->benefit_name,
            'price' => $request->price,
            'currency_type' => $request->currency_type,
            'just' => $result,
            'bank_id' => $request->bank_id,
            'check_number' => $request->check_number,
            'iban_id' => $request->iban_id,
            'purchase_name' => $request->purchase_name,
            'project_number' => $request->project_number,
            'financial_provision' => $request->financial_provision,
            'number_financial' => $request->number_financial,
            'created_at' => Carbon::now(),
        ]);

        $request->session()->flash('status', 'تم ارسال امر الدفع بنجاح');
        return redirect('/command/pay');

    }

    public function PrintCommand($id) {

        $payment = PaymentOrder::findOrFail($id);
        return view('print.payment.print_command', compact('payment'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
