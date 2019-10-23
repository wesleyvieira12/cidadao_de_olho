<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Deputy;
use App\Repositories\IndemnityAmountRepository;

class UpdateIndemnityAmounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:amounts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the amounts of members reimbursed funds';

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
        $deputies = Deputy::all();
        foreach($deputies as $deputy){
            $indemnity_amount = new IndemnityAmountRepository;
            $indemnity_amount->updateIndemnityAmount($deputy->id);
        }
    }
}
