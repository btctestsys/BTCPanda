<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class constructGene extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'constructGene';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Re-construct gene from top';

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
        $users = DB::table('users')->orderby('id')->get();

        foreach($users as $output)
        {
            $user = DB::table('users')->where('id',$output->id)->first();
            $users2 = DB::table('users')->where('referral_id',$output->id)->orderby('id')->get();
            foreach($users2 as $output2)
            {
                DB::table('users')->where('id',$output2->id)
                    ->update([
                        'gene'  =>  $user->gene.",".$output2->id
                    ]);

                $this->info($output2->id.":".$user->gene.",".$output2->id);
            }
        }
    }
}
