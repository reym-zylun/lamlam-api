<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup for current database.';

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
        $ds        = DIRECTORY_SEPARATOR;
        $prev_bak  = array();

        $file_path = realpath(storage_path('backup/db'));
        $file_name = env('DB_DATABASE')."_".\Carbon\Carbon::now()->format('YmdHis').".sql";

        $command   = sprintf('mysqldump --user=%s --password=%s %s > %s',
            env('DB_USERNAME'),
            env('DB_PASSWORD'),
            env('DB_DATABASE'),
            $file_path.$ds.$file_name
        );
        exec($command);
        $this->info('created backup...');

        // check and remove old backups
        $files = \File::allFiles($file_path);
        $days_ago = \Carbon\Carbon::now()->subDays(env('DB_BACKUP_RETENTION_DAYS'))->format('Ymd');
        if(count($files)) {
            foreach($files as $file) {
                $temp_file  = str_replace(env('DB_DATABASE')."_", '', $file->getFileName());
                $temp_file  = str_replace('.sql', '', $temp_file);
                $created_at = substr($temp_file, 0,-6);

                if($created_at < $days_ago) {
                    array_push($prev_bak, $file->getrealPath());
                }
            }
        }
        if(count($prev_bak)) {
            \File::delete($prev_bak);
            $this->info('deleted old backups...');
        }
        // **
    }
}
