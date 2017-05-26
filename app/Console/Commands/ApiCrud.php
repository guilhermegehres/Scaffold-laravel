<?php

namespace App\Console\Commands;

use App\Library\Scaffold;

use Illuminate\Console\Command;

class ApiCrud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apiCrud {table} {is_routed?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gerando crud';

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
        //
        $ignore = [
            "id_",
            "is_"
        ];
        $scaf = new Scaffold();
        $scaf->generateCrud($this->argument('table'), $ignore);
    }
}
