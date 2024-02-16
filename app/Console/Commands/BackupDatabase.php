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
    protected $description = 'Backup Mysql database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
{
   // ทำการสร้าง Backup โดยใช้คำสั่ง mysqldump
   $backupPath = storage_path('app/backups');
   $date = date('Y-m-d_H-i-s');
   $fileName = "backup_$date.sql";
   $filePath = "$backupPath/$fileName";

   // ระบุค่าที่ใช้ในการเชื่อมต่อ MySQL จากไฟล์ .env
   $dbHost = env('DB_HOST');
   $dbUsername = env('DB_USERNAME');
   $dbPassword = env('DB_PASSWORD');
   $dbName = env('DB_DATABASE');

   // สร้างคำสั่ง mysqldump
   $command = "mysqldump -u $dbUsername -p$dbPassword $dbName > $filePath";
   exec($command);

   $this->info('Database backup has been created successfully.');
}

}
