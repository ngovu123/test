<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

use PayPal\Api\ExecutePayment;

use PayPal\Api\PaymentExecution;


use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

use Auth,DateTime,DB;
use App\Media;
use App\User;
use App\Admin_users;
use App\Transition_log;
use App\Download_log;

class PaymentController extends Controller
{
    private $apiContext;

    public function __construct()
    {
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                config('paypal.client_id'),
                config('paypal.secret')
            )
        );
        $this->apiContext->setConfig(config('paypal.settings'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $payment_id = Session::get('payment_id');
        Session::forget('payment_id');

        $execution = new PaymentExecution();
        $execution->setPayerId($_GET['PayerID']);
        $payment = payment::get($payment_id,$this->apiContext);

        try {
            $result = $payment->execute($execution,$this->apiContext);
            if ($result->getState() =='approved') 
            {

                $id = Session::get('media_id');
                $m = Session::get('u_id');
                Session::forget('u_id');
                $m_name = Session::get('name');
                Session::forget('name');
                
                $media = Media::where("id", "=", $id)->first();
                $media->count_download = $media->count_download+1;
                $media->save();
                $total = floatval(Session::get('total_pay'));    
                Session::forget('total');           
                if ($m == 0) {
                    $admin = Admin_users::where('id','=',1)->first();
                    $admin->cash = $admin->cash + $total ;
                    $admin->save();         

                    $down = new Download_log();
                    $down->media_id = $id;
                    $down->payment_id = $payment_id;
                    $down->user_id = Auth::user()->id;
                    $down->created_at = new DateTime;
                    $down->save();
                               
                } else {
                    $u = User::where('id','=',intval($m))->first();

                    $sub = floatval(($total*70)/100);
                    $c = floatval($u->cash);
                    $u->cash = $c + $sub ;
                    $u->save();

                    $admin = Admin_users::where('id','=',1)->first();
                    $sub_admin = floatval(($total*30)/100);
                    $admin->cash = $admin->cash + $sub_admin ;
                    $admin->save();

                    $log = new Transition_log();
                    $log->log_type = 'Receive : '.$sub.' $';
                    $log->log_detail = 'Received ';
                    $log->log_mesage = 'Received from the media : '.$m_name;
                    $log->user_id = $m;
                    $log->m_id = $id;
                    $log->created_at = new DateTime;
                    $log->save();

                    $down = new Download_log();
                    $down->media_id = $id;
                    $down->payment_id = $payment_id;
                    $down->user_id = Auth::user()->id;                 

                    $down->created_at = new DateTime;
                    $down->save();
                    // dd($down);
                }            
                return redirect(url('/afterdownload/'.$id)); 

            } else {
               dd('error'); 
            }
        } catch (Exception $e) {
                dd('Unfortunately there was an error in the payment process');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)    {
        
         // ### Payer
        // A resource representing a Payer that funds a payment
        // For paypal account payments, set payment method
        // to 'paypal'.
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");
        // // ### Itemized information
        // // (Optional) Lets you specify item wise
        // // information
        $p = floatval($request->txtprice);

        $item1 = new Item();
        $item1->setName($request->txtname)
            ->setCurrency('USD')
            ->setQuantity(1)
            // ->setSku("123123") // Similar to `item_number` in Classic API
            ->setPrice($p);
        
        $itemList = new ItemList();
        $itemList->setItems(array($item1));
        // ### Additional payment details
        // Use this optional field to set additional
        // payment information such as tax, shipping
        // charges etc.
        $details = new Details();
        $details->setSubtotal($p);
            // ->setShipping(1)
            // ->setTax(1)
            
        // ### Amount
        // Lets you specify a payment amount.
        // You can also specify additional details
        // such as shipping, tax.
        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal($p)
            ->setDetails($details);
        // ### Transaction
        // A transaction defines the contract of a
        // payment - what is the payment for and who
        // is fulfilling it. 
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription(Auth::user()->name)
            ->setInvoiceNumber(uniqid());
            // dd($transaction);
        // ### Redirect urls
        // Set the urls that the buyer must be redirected to after 
        // payment approval/ cancellation.
        // $baseUrl = getBaseUrl();
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(route('payment.create'))
            ->setCancelUrl(route('payment.create'));
        // ### Payment
        // A Payment Resource; create one using
        // the above types and intent set to 'sale'
        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));
        // For Sample Purposes Only.
        // $request = clone $payment;
        // ### Create Payment
        // Create a payment by calling the 'create' method
        // passing it a valid apiContext.
        // (See bootstrap.php for more on `ApiContext`)
        // The return object contains the state and the
        // url to which the buyer must be redirected to
        // for payment approval
        try {
            $payment->create($this->apiContext);
        } catch (Exception $ex) {
            // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
            // ResultPrinter::printError("Created Payment Using PayPal. Please visit the URL to Approve.", "Payment", null, $request, $ex);
            echo 'that bai';
            exit(1);
        }
        // ### Get redirect url
        // The API response provides the url that you must redirect
        // the buyer to. Retrieve the url from the $payment->getApprovalLink()
        // method
        $approvalUrl = $payment->getApprovalLink();
        // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
         // ResultPrinter::printResult("Created Payment Using PayPal. Please visit the URL to Approve.", "Payment", "<a href='$approvalUrl' >$approvalUrl</a>", $request, $payment);
        // echo "<pre>";
        // return $payment;

        Session::put('payment_id', $payment->id);

        Session::put('media_id', $request->txtid);     
        Session::put('u_id', $request->txtuid);   
        Session::put('name', $request->txtname);   

        Session::put('total_pay', $payment->transactions[0]->amount->total);        

        return redirect($approvalUrl);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
