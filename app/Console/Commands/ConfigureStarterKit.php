<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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

        $this->info("Configuring Insight Media Starter Kit");

        if (config('app.env') == "local")
        {
            $this->rename(base_path('public'), base_path('www'));
            $this->rename(base_path('.env.example'), base_path('.env.master'));
        }

        return 0;
    }

    private function rename($from, $to)
    {

        if (!file_exists($to) && file_exists($from)) {
            rename($from, $to);
            $this->info("Renamed $from to $to");
        }
    }

}
