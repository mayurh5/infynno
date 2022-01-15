<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Blog;
use Log;
use DB;

class BlogExpiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:expiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        Log::info(print_r("Expiry Blog", true)); 

        $todayDate =  date('Y-m-d H:i', strtotime(date('Y-m-d H:i')));

        $blog = Blog::where(DB::raw("DATE_FORMAT(expiration,'%Y-%m-%d %H:%i')"),'<=',$todayDate)->delete();
        
        $this->info('Successfully delete blog.');
    }
}
