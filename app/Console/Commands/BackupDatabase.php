<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:database';

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
        $file_path = config('backup.filepath');
        $file_name = str_replace(':format', \Carbon\Carbon::now()->format(config('backup.format')), config('backup.filename'));

        $command   = sprintf(config('backup.mysqldump').' --host=%s --user=%s --password=%s %s > %s',
            env('DB_HOST'),
            env('DB_USERNAME'),
            env('DB_PASSWORD'),
            env('DB_DATABASE'),
            $file_path.$ds.$file_name
        );

        if(!\File::exists($file_path)) {
            \File::makeDirectory($file_path,0775,true);
        }
        exec($command);
        $this->info('created backup...');

        // check and remove old backups
        $files = \File::allFiles($file_path);
        $days_ago = \Carbon\Carbon::now()->subDays(config('backup.retention_days'))->format('Ymd');
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
