<?php

namespace App\Console\Commands;

use App\Models\Request;
use Illuminate\Console\Command;

class DeleteFinishedRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'request:delete-finished-request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menghapus Request Yang Berstatus Selesai';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Request::where('status', 'selesai')->delete();
        
        $this->info('Request Berstatus Selesai Berhasil Dihapus');
    }
}