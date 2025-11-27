<?php

namespace App\Console\Commands;

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
    public function handle()
    {
        $surveysToClose = Survey::where('end_date', '<=', now())
            ->whereNotNull('token')
            ->get();

        foreach ($surveysToClose as $survey) {
            event(new SurveyClosed($survey));

        }

        $this->info("Tous les sondages à fermer ont été traités.");

    }
}
