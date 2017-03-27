<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TokenLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean login token logs.';

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
        $yesterday = \Carbon\Carbon::yesterday();
        $tokens = \App\AccessToken::withoutGlobalScope(\App\Scopes\ValidScope::class)->whereDate('updated_at','<=',$yesterday)->where('valid',config('define.valid.false') )->delete();
        $this->info($tokens." record/s deleted.");
    }
}
