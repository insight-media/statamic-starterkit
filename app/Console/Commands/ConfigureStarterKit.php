<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ConfigureStarterKit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insightmedia:configure:starterkit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Additional configuration for the Statamic Insight Media Starter Kit';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $this->info('Configuring Insight Media Starter Kit');

        if (config('app.env') == 'local') {
            // Rename .env.example to .env.master
            $this->rename(base_path('.env'), base_path('.env.main'));

            // Copy .gitignore.stub to .gitignore
            copy(base_path('.gitignore.stub'), base_path('.gitignore'));

            // Publish vendor files
            $this->publishVendorFiles();
        }

        return 0;
    }

    private function rename($from, $to)
    {
        if (! file_exists($to) && file_exists($from)) {
            rename($from, $to);
            $this->info("Renamed $from to $to");
        }
    }

    private function publishVendorFiles()
    {
        Artisan::call('vendor:publish', [
            '--tag' => 'statamic-recaptcha',
        ]);

        Artisan::call('vendor:publish', [
            '--provider' => 'InsightMedia\StatamicGoogleAnalytics\ServiceProvider',
            '--tag' => 'statamic-google-analytics-config',
        ]);

        $this->info('Published vendor files');
    }

}
