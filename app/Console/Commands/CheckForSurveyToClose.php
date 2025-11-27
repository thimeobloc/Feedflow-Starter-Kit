<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\DB; // ← ICI !
use Illuminate\Console\Command;
use App\Models\Survey;
use App\Events\SurveyClosed;
class CheckForSurveyToClose extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-for-survey-to-close';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */


    //Function listening the evenment to inactive it after the date
    public function handle()
    {
        Survey::where('end_date', '<=', now())
            ->whereNotNull('token')
            //ChunkById load only 100 surveys
            ->chunkById(100, function ($surveys) {
                foreach ($surveys as $survey) {
                    DB::transaction(function () use ($survey) {
                        //Refresh database
                        $survey = $survey->fresh();
                        if (is_null($survey->token)) {
                            return;
                        }

                        $survey->token = null;
                        //Save the new survey
                        $survey->save();

                        //Do event
                        event(new SurveyClosed($survey));
                    });
                }
            });

        $this->info("Tous les sondages à fermer ont été traités.");
    }
}

