<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class IDEHelperCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generator';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates all the IDE Helper files Auto';

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
     * @return mixed
     */
    public function handle()
    {
        \Artisan::call('ide-helper:generate');
        \Artisan::call('ide-helper:models', [
            '--write' => true
        ]);
        \Artisan::call('ide-helper:meta');
    }
}
