<?php

namespace App\Listeners;

use App\Events\SurveyClosed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;
class SendFinalReportOnClose implements ShouldQueue

{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    //3Take the event and send email
    //Function to send email to testfeedflow@gmail.com
    public function handle(SurveyClosed $event): void
    {
        Mail::to('testfeedflow@gmail.com')->send(
            new SurveyClosed($event->survey));
    }
}
