<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckDatabaseConnections extends Command
{
    protected $signature = 'db:check';
    protected $description = 'Check database connections';

    public function handle()
    {
        $connections = ['db_keypoint2', 'masterdata'];

        foreach ($connections as $connection) {
            try {
                DB::connection($connection)->getPdo();
                $this->info("Connection to '{$connection}' is successful!");
            } catch (\Exception $e) {
                $this->error("Failed to connect to '{$connection}': " . $e->getMessage());
            }
        }
    }
}
