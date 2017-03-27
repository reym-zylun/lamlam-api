<?php  
return [
    // basic setting
    'retention_days' => 3,
    'format' => 'YmdHis',
    'filename' => env('DB_DATABASE')."_:format.sql",
    'filepath' => realpath(storage_path()).DIRECTORY_SEPARATOR.'backup'.DIRECTORY_SEPARATOR.'db',

    // mysqldump cmd
    'mysqldump' => env('CMD_MYSQLDUMP','mysqldump'), 
];
?>
