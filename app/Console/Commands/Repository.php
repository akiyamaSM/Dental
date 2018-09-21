<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class Repository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {ModuleName?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to create new plain repository file and its implementation';

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
        if($this->checkBase()){

            if($module = $this->argument('ModuleName')){

                if($this->checkModule($module)){
                    $this->makeInterface($module);
                    $this->makeImplementation($module);
                    $this->info('The Repository '. $module . ' has been created!');
                }

            }else{

            $this->error('Sorry, You have to mention the Models name as an Argument!'); // error

            }
        }


    }


    private function checkBase(){
        if(!File::exists('App/Repositories')){
            $this->error('The Repositories folder doesnt exists yet!');
            $this->error('Make a fresh one using the make:repositories command');
            return false;
        }
        return true;
    }

    private function checkModule($model){
        if(File::exists('App/Repositories/Interfaces/'.$model.'RepositoryInterface.php')){
            $this->error("The ".$model." Interface Already exists");
            return false;
        }

        if(File::exists('App/Repositories/Implementations/'.$model.'Repository.php')){
            $this->error("The ".$model." Implementation Already exists");
            return false;
        }

        return true;
    }


    private function makeInterface($model){
        $this->makeCore($model);
        $this->info('The Interface Repository has been created!');
    }

    private function makeImplementation($model){
        $this->makeCore($model,'Implementation');
        $this->info('The Implementation Repository has been created!');
    }


    private function makeCore($model, $type = 'Interface'){
        $content = "<?php \n";
        if($type == 'Interface')
             $namespace = "namespace App\Repositories\Interfaces; \n \n";
        else
            $namespace = "namespace App\Repositories\Implementations; \n \n";

        if($type == 'Interface')
            $core = $type. " ".$model."Repository".$type." {\n}";
        else
            $core = "Class ".$model."Repository implements ".$model."RepositoryInterface {\n}";

        if($type == 'Interface')
            $path = 'App/repositories/'.$type.'s/'.$model.'Repository'.$type.'.php';
        else
            $path = 'App/repositories/'.$type.'s/'.$model.'Repository.php';

        File::put($path, $content);
        File::append($path, $namespace);
        File::append($path, $core);

    }
}
