<?php

namespace App\Console\Commands;

use App\Models\Request;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CleanRejectRequests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'request:clean-rejected';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menghapus Request Yang Ditolak Setelah 1 Jam';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $deleteCount = Request::where('status', 'tolak')
        ->where('updated_at', '<', Carbon::now()->subMinutes(5))
        ->delete();

        $this->info("Berhasil Menghapus {$deleteCount} Data Yang Di Tolak");
    }
}