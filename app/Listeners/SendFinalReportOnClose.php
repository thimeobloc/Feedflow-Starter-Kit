<?php

namespace App\Listeners;

use App\Events\SurveyClosed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

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
    public function handle(SurveyClosed $event): void
    {
        Mail::to('test@feedflow.local')->send(
            new SurveyClosedMail($event->survey));
    }
}
