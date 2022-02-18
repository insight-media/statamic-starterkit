<?php

namespace App\Console\Commands;

use DirectoryIterator;
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

        $this->info("Configuring Insight Media Starter Kit");

        if (config('app.env') == "local")
        {
            // Merge files in public folder to www
            $this->moveFiles(base_path('public'), base_path('www'));

            // Rename .env.example to .env.master
            $this->rename(base_path('.env.example'), base_path('.env.master'));

            // Publish vendor files
            $this->publishVendorFiles();
        }

        return 0;
    }

    private function moveFiles($from, $to)
    {

        $s = DIRECTORY_SEPARATOR;

        // If source is not a directory stop processing
        if(!is_dir($from)) return false;

        // If the destination directory does not exist create it
        if(!is_dir($to)) {
            if(!mkdir($to)) {
                // If the destination directory could not be created stop processing
                return false;
            }
        }

        // Open the source directory to read in files
        $i = new DirectoryIterator($from);
        foreach($i as $f) {
            if($f->isFile()) {
                rename($f->getRealPath(), $to . $s . $f->getFilename());
            } else if(!$f->isDot() && $f->isDir()) {
                $this->moveFiles($f->getRealPath(), $to . $s .$f);
                if (is_dir($f->getRealPath())) rmdir($f->getRealPath());
            }
        }
        rmdir($from);

    }

    private function rename($from, $to)
    {
        if (!file_exists($to) && file_exists($from)) {
            rename($from, $to);
            $this->info("Renamed $from to $to");
        }
    }

    private function publishVendorFiles()
    {
        Artisan::call('vendor:publish', [
            '--tag' => 'statamic-recaptcha'
        ]);

        Artisan::call('vendor:publish', [
            '--provider' => 'AryehRaber\Logbook\LogbookServiceProvider'
        ]);

        Artisan::call('vendor:publish', [
            '--provider' => 'Cnj\Seotamic\ServiceProvider',
            '--tag' => 'config'
        ]);

        Artisan::call('vendor:publish', [
            '--provider' => 'Jonassiewertsen\ExternalLink\ServiceProvider'
        ]);
    }

}
