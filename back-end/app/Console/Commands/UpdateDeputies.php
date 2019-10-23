<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\DeputyRepository;

class UpdateDeputies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:deputies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update table of deputies in office';

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
        $deputy = new DeputyRepository;
        $deputy->updateDeputy();
    }
}
