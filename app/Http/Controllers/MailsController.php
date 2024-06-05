<?php

namespace App\Http\Controllers;

use App\Log;

use App\Order;
use App\Endpoint;

use App\SourceType;
use App\Mail\ThankYouMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailsController extends Controller
{

    public function sendThankYouMail($order, $endpoint, $sourceType, $timezone)
    {
        $to  = empty($order['customer_email']) ? [] : explode(',', $order['customer_email']);
        $bcc = empty($endpoint['bcc']) ? [] : explode(',', $endpoint['bcc']);

        try {
            Mail::to($to)
                ->bcc($bcc)
                ->send(new ThankYouMail($order, $endpoint, $sourceType, $timezone));
        } 
        catch (\Exception $e) {
            /* log before sending email */
            $attributes['type'] = 'Error - MailsController.sendThankYouMail';
            $attributes['log' ] = 'order:' . json_encode($order) . ', sourceType:' . json_encode($sourceType) . ', endpoint:' . json_encode($endpoint);
            $attributes['log2'] = 'Error: ' . $e->getMessage();
            Log::create($attributes);
            dd('Thank you!. Your payment is successful!');
        }
    }
}
