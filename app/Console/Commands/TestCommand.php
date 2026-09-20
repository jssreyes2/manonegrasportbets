<?php

namespace App\Console\Commands;

use App\Jobs\SendMassivePickEmailJob;
use App\Jobs\UpdateExpiredSubscriptionsJob;
use App\Models\Pick;
use App\Models\Subscription;
use App\Services\Operations\PickServices;
use App\Services\SendMailServices;
use App\Services\WebPage\WebPageServices;
use Illuminate\Console\Command;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:test';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       
       /* $data=[
            'plan_id' => 4,
            'sport' => 'MLB',
            'match' => 'Colorado vs kansa',
            'bet_type' => null,
            'selection' => 'Over 8.5',
            'detail' => 'Detroit hace 3.5 carreras 1:34 p.m.',
        ];
        
        $response= app(PickServices::class)->store($data);
        //UpdateExpiredSubscriptionsJob::dispatch();      */
        
        $pick=Pick::find(6);
        
        $job = new SendMassivePickEmailJob($pick);
        $response = $job->handle();
        
            dd($response);
    }
}
