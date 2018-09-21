<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class Repositories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repositories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make Repositories Structure';

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
        if(!File::exists('App/repositories')){
            File::makeDirectory('App/repositories');
            $this->info('Repositories Folder Created!');

            File::makeDirectory('App/repositories/Interfaces');
            $this->info('Interfaces Folder Created!');

            File::makeDirectory('App/repositories/Implementations');
            $this->info('Implementations Folder Created!');

        }else{
            $this->error('Already Exists ;)');
        }
    }
}
