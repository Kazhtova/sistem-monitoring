<?php

namespace App\Console\Commands;

use App\Models\Request;
use Illuminate\Console\Command;

class UpdateExpiredRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-expired-request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menghapus Request Yang Sudah Selesai';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Request::where('status', '!=', 'selesai')
        ->where('perkiraan_selesai', '<=', now())
        ->update(['status' => 'selesai']);

        $this->info('Status Berhasil Diperbarui Secara Otomatis');
    }
}