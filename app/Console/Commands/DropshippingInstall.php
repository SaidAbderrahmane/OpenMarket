<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DropshippingInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dropshipping:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install dummy data for dropshipping application';

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
        if ($this->confirm('this will delete all your current data and install the default dummy data, are you sure?')) {
            $this->callSilent('storage:link');
            $this->call('migrate:fresh', [
                '--seed' => true,
            ]);
            $this->call('db:seed', [
                '--class' => 'VoyagerDatabaseSeeder',
            ]);
            // $this->call('db:seed', [
            //     '--class' => 'VoyagerConfigSeeder',
            // ]);
            $this->call('db:seed');

            $this->info('dummy data installed');


            return 0;
        }
    }
}
