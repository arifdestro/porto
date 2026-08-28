<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TransferDatabase extends Command
{
    protected $signature = 'db:transfer';
    protected $description = 'Transfer all data from local MySQL to Vercel PostgreSQL';

    public function handle()
    {
        $this->info('Starting database transfer...');

        $tables = [
            'users',
            'site_settings',
            'portfolios',
            'skills',
            'experiences',
            'social_links',
            'posts',
        ];

        foreach ($tables as $table) {
            $this->info("Transferring table: $table");

            // Empty destination table first to prevent duplicate errors
            DB::connection('pgsql')->table($table)->delete();

            // Fetch from local MySQL
            $rows = DB::connection('mysql_local')->table($table)->get()->map(function ($row) {
                return (array) $row;
            })->toArray();

            if (!empty($rows)) {
                // Insert into Postgres
                foreach (array_chunk($rows, 100) as $chunk) {
                    DB::connection('pgsql')->table($table)->insert($chunk);
                }
                $this->line(" - Inserted " . count($rows) . " rows.");
            } else {
                $this->line(" - No data found.");
            }
        }

        $this->info('Transfer complete!');
    }
}
