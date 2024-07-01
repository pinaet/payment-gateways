<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

use App\Http\Controllers\MailsController;

use App\Order;
use App\Endpoint;
use App\SourceType;
use App\Log;

class OrdersController extends Controller
{
    public function genOrder( Request $request )
    {
        /** endpoint redirect */
        $payload    = json_decode( request()->order, true );


        $check   = true;
        if (empty($payload['endpoint_id'])      ) $check = false;
        if (empty($payload['amount'])           ) $check = false;
        if (empty($payload['currency'])         ) $check = false;
        if (empty($payload['description'])      ) $check = false;
        if (empty($payload['reference_order'])  ) $check = false;
        if (empty($payload['customer_name'])    ) $check = false;
        if (empty($payload['customer_email'])   ) $check = false;
        //        $payload['ref2']
        //        $payload['ref3']
        if( $check==false ) {
            dd('redirect to the page said not enough info to proceed order, back to merchant', $payload );
            return redirect(); //redirect to the page said not enough info to proceed order
        }
        else {
            //before gen new order, reference_order is duplicated? update : create
            // is this reference_order endded ? 'redirect to the end of payment' : 'let customer pay normally'
            $order = Order::where('reference_order', $payload['reference_order'])
                            ->where('status', 'p' )
                            ->where('email_sent', 0)
                            ->first();
            if( empty($order)==false ){
                //update data
                $order['endpoint_id']           = $payload['endpoint_id'];
                $order['amount']                = $payload['amount'];
                $order['total_amount']          = $payload['amount'];
                $order['currency']              = $payload['currency'];
                $order['description']           = $payload['description'];
                $order['reference_order']       = $payload['reference_order'];
                $order['customer_name']         = $payload['customer_name'];
                $order['customer_email']        = $payload['customer_email'];
                $order['source_type_id']        = null;
                $order['source_type']           = '';
                $order['status']                = 'p'; //pending
                $order['ref']                   = $order['ref'];
                $order['ref2']                  = $order['ref2'];
                $order['ref3']                  = $order['ref3'];
                $order['transaction_id']        = null;
                $order['email_sent']            = 0;

                $order->save();
            }
            else {
                //create data
                $attributes['endpoint_id']      = $payload['endpoint_id'];
                $attributes['amount']           = $payload['amount'];
                $attributes['total_amount']     = $payload['amount'];
                $attributes['currency']         = $payload['currency'];
                $attributes['description']      = $payload['description'];
                $attributes['reference_order']  = $payload['reference_order'];
                $attributes['customer_name']    = $payload['customer_name'];
                $attributes['customer_email']   = $payload['customer_email'];
                $attributes['source_type_id']   = null;
                $attributes['source_type']      = '';
                $attributes['status']           = 'p'; //pending
                $attributes['ref']              = '';
                $attributes['ref2']             = empty($payload['ref2']) == false ? $payload['ref2'] : '';
                $attributes['ref3']             = empty($payload['ref3']) == false ? $payload['ref3'] : '';
                $attributes['transaction_id']   = null;
                $attributes['email_sent']       = 0;

                $order                          = Order::create( $attributes );
                $order->ref                     = $order->id . '.' . $order->reference_order;
                $order->save();
            }

            $endpoint       = Endpoint::find( $order['endpoint_id'] );
            $sourceTypes    = SourceType::all();

            $gateConf       = config( 'gate' );

            return view( 'pages.order-index', [
                'order'         => $order,
                'endpoint'      => $endpoint,
                'sourceTypes'   => $sourceTypes,
                'gateConf'      => $gateConf,
            ] );
        }
    }

    public function updateSourceType()
    {
        $order_temp       = json_decode(request()->order, true);
        $payload          = json_decode(request()->payload, true);

        $order            = Order::find( $order_temp['id'] );
        // dd($order_temp, $payload );

        $order->total_amount   = $payload['amount'];
        $order->source_type_id = $order_temp['source_type_id'];
        $order->source_type    = $order_temp['source_type'];
        $order->transaction_id = 0;
        $order->status         = 'p'; //pending

        $order->save();

        return response('200 OK');
    }

    public function updateOrder($data)
    {
        /**
         * data:
            "transaction_id":58,
            "ref":"1.12345",
            "amount":"1.02",
            "currency":"THB",
            "description":"Awesome Product",
            "source_type":"alipay",
            "reference_order":"12345",
            "payment_status":"completed",
         */
        $id         = explode('.', $data['ref'])[0];
        $order      = Order::find($id);

        if ($data['payment_status'] == 'completed') {
            $order['status'] = 'c'; //completed
        } else if ($data['payment_status'] == 'declined') {
            $order['status'] = 'd'; //declined
        }
        else if ($data['payment_status'] == 'conflict') {
            $order['status'] = 'f'; //failed
        } else {
            $order['status'] = 'p'; //pending
        }

        $order['transaction_id'] = $data['transaction_id'];
        $order->save();

        return $order;
    }

    /**
     * receive notify from payment node:
     *      action when status='c': send_email and notify endpoint
     * */
    public function notify()
    {
        $data = request()->data;
        $attributes['type'] = 'notify';
        $attributes['log']  = $data['source_type'];
        $attributes['log2'] = json_encode($data);
        Log::create( $attributes );

        $order = $this->updateOrder( $data );

        $this->emailhook( $order );

        return response('200 OK');
    }

    public function emailhook( $order )
    {
        if ($order['status'] == 'c') {
            if ($order['email_sent'] == 0) {
                $sourceType         = SourceType::find($order['source_type_id']);
                $endpoint           = Endpoint::find($order['endpoint_id']);
                $timezone           = config('app.timezone');

                // 1. webhook - to notify endpoint payment successful
                $url                = $endpoint['notify_url'];
                $this->webhook($order['reference_order'], $order['source_type'], $order['status'], $url, $order );

                // 2.  sending email: customer_name, customer_email
                // 2.1 sending email.
                (new MailsController)->sendThankYouMail($order, $endpoint, $sourceType, $timezone);
                // 2.2 update email_sent
                $order['email_sent'] = 1;
                $order->save();
            }
        }
        return $order;
    }

    /**
     * get callback from paymentgateway:tbank
     */
    public function t_callback()
    {
        /**
         * tbank
        <input type="hidden" name="response_code"   value="<?=$response_code?>"> 00=sucess, 79=cancelled-by-card-holder
        <input type="hidden" name="approval_code"   value="<?=$approval_code?>"> Payment ID
        <input type="hidden" name="reference_order" value="<?=$reference_order?>">
        <input type="hidden" name="customer_id"     value="<?=$customer_id?>">
        <input type="hidden" name="amount" 			value="<?=$amount?>">
        <input type="hidden" name="currency"    	value="<?=$currency?>">
        <input type="hidden" name="pan"       		value="<?=$pan?>">
		<input type="hidden" name="expdate"   		value="<?=$expdate?>">
        <input type="hidden" name="transaction_id"  value="<?=$transaction_id?>">

         * data:
            "transaction_id":58,
            "ref":"1.12345",
            "amount":"1.02",
            "currency":"THB",
            "description":"Awesome Product",
            "source_type":"alipay",
            "reference_order":"12345",
            "payment_status":"completed",
         */

        $data['response_code']   = request()->response_code;
        $data['reference_order'] = request()->reference_order;
        $data['pan']             = request()->pan;
        $data['transaction_id']  = request()->transaction_id;

        /** log create */
        $attributes['type'] = 'callback - tbank';
        $attributes['log2'] = json_encode( $data );
        $log                = Log::create( $attributes );

        $id    = explode( '.', $data['reference_order'] )[0];
        $order = Order::find( $id );

        if ($data['response_code'] == '00') {
            $order['status'] = 'c';//completed
        }
        else {
            $order['status'] = 'd';//declined or failed
        }

        $order['transaction_id'] = $data['transaction_id'];
        $order['source']         = $data['pan'];

        /** log update */
        $log['log']  = $order['source_type'];
        $log->save();

        /** sending email */
        $order = $this->emailhook( $order );

        $sourceType = SourceType::find($order['source_type_id']);
        $endpoint   = Endpoint::find($order['endpoint_id']);
        $timezone   = config('app.timezone');

        return view('pages.order-result', [
            'order'     => $order,
            'sourceType'=> $sourceType,
            'endpoint'  => $endpoint,
            'timezone'  => $timezone,
        ]);
    }

    /**
     * get callback from payment node:
     *      request()->data is already json string
     *      dispay payment result to user
     */
    public function callback()
    {
        $data = json_decode(request()->data, true );
        $attributes['type'] = 'callback';
        $attributes['log']  = $data['source_type'];
        $attributes['log2'] = json_encode( $data );
        Log::create( $attributes );

        $order      = $this->updateOrder( $data );

        $sourceType = SourceType::find($order['source_type_id']);
        $endpoint   = Endpoint::find($order['endpoint_id']);
        $timezone   = config('app.timezone');

        return view('pages.order-result', [
            'order'     => $order,
            'sourceType'=> $sourceType,
            'endpoint'  => $endpoint,
            'timezone'  => $timezone,
        ]);
    }

    /** for testing: perform as an endpoint */
    public function endpoint()
    {
        /**
         * simulate request from endpoint
         */
        //exchange data using json
        //in array then to json string
        $order['endpoint_id']       = 1;
        $order['amount']            = 1.0;
        $order['currency']          = 'THB';
        $order['description']       = 'Summer Course';
        $order['reference_order']   = 'SUM211' . rand(1000,9999);
        $order['customer_name']     = 'Naet Poonsarakhun';
        $order['customer_email']    = 'naet_ph@harrowschool.ac.th';

        return view( 'pages.endpoint', [
            'order' => $order,
        ]);
    }

    public function webhook($reference_order, $source_type, $status, $url, $order)
    {

        $http    = new Client;

        $data['reference_order'] = $reference_order;
        $data['source_type']     = $source_type;
        $data['status']          = $status;
        $data['ref2']            = $order['ref2'];
        $data['ref3']            = $order['ref3'];

        try {
            $http->post($url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => ['data' => $data],
            ]);
        } catch (\Exception $e) {
            $attributes['type'] = 'webhook - error';
            $attributes['log']  = json_encode($data);
            $attributes['log2'] = $e->getMessage();
            Log::create($attributes);
        }
    }

    public function testCallback()
    {
        // data

        $id    = explode( '.', '972.E10060026' )[0];
        $order = Order::find( $id );
        dd($order);

        $order      = Order::find(80);

        /**
        $order['id']               = 2;
        $order['endpoint_id']      = 1;
        $order['amount']           = 1.00;
        $order['total_amount']     = 1.02;
        $order['currency']         = 'THB';
        $order['description']      = 'Summer Course';
        $order['reference_order']  = 'SUM2190001';
        $order['customer_name']    = 'Mr Naet Poonsarakhun';
        $order['customer_email']   = 'naet_ph@harrowschool.ac.th';
        $order['source_type_id']   = 2;
        $order['source_type']      = 'alipay';
        $order['status']           = 'c';
        $order['ref']              = '2.123456';
        $order['ref2']             = '';
        $order['ref3']             = '';
        $order['transaction_id']   = 65;
        $order['email_sent']       = 1;
        $order['updated_at']       = '2019-11-08 10:44:13.697';
        //  */


        $sourceType = SourceType::find( $order['source_type_id']);//equal to $order->source_type()
        $endpoint   = Endpoint::find( $order['endpoint_id'] );
        $timezone   = config('app.timezone');

        /** updateOrder() */
        // sending email.
        if ($order['status'] == 'c') {
            (new MailsController)->sendThankYouMail($order, $endpoint, $sourceType, $timezone);
            $order['email_sent'] = 1;
            $order->save();
        }

        // webhook - to notify endpoint
        $url = $endpoint['notify_url'];
        $this->webhook( $order['reference_order'], $order['source_type'], $order['status'], $url, $order );

        /** end updateOrder() */


        return view('pages.order-result', [
            'order'     => $order,
            'sourceType'=> $sourceType,
            'endpoint'  => $endpoint,
            'timezone'  => $timezone,
        ]);
    }
}
