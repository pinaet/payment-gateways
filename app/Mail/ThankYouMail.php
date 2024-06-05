<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ThankYouMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $endpoint;
    public $sourceType;
    public $timezone;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $endpoint, $sourceType, $timezone)
    {
        $this->order      = $order;   
        $this->endpoint   = $endpoint;   
        $this->sourceType = $sourceType;   
        $this->timezone   = $timezone;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $endpoint_id = $this->order['endpoint_id'];
        $subject     = 'Your online payment for '. $this->order['description'].' at Harrow International School Bangkok';
        // dd( $order);

        if( $endpoint_id==2 || $endpoint_id==3 ){
            return $this->subject( $subject )
                ->view('emails.school-fee');
        }
        else{
            //Summer Programmes
            return $this->subject( $subject )
                ->view('emails.summer-programme');
        }
    }
}
