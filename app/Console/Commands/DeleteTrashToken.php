<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DeleteTrashToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:trashtoken';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete trash login tokens.';

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
        $retention_days = 7;

        $clearday = \Carbon\Carbon::now()
            ->subDays($retention_days + 1)
            ->Format('Y-m-d');

        $delete_cnt = \App\AccessToken::withoutGlobalScope(\App\Scopes\ValidScope::class)
            ->whereDate('refresh_token_expired_date','<=',$clearday)
            ->where('valid',config('define.valid.false'))
            ->delete();

        $this->info($delete_cnt." record/s deleted.");
    }
}
