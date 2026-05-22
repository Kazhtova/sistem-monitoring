<?php

namespace App\Console\Commands;

use App\Models\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

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

        $count = 0;

        Request::whereIn('status', ['selesai', 'tolak'])->chunkById(100, function($requests) use (&$count) {
            
            $idToDelete = [];

            foreach($requests as $request){
 
                if($request->foto_bukti && Storage::disk('public')->exists($request->foto_bukti)){
                    Storage::disk('public')->delete($request->foto_bukti);
                }

                $idToDelete[] = $request->getKey();
            }
            
            if(!empty($idToDelete)){
                Request::whereIn((new Request)->getKeyName(), $idToDelete)->delete();    
                
                    $count +=count($idToDelete);
                }
        });
        $this->info('Request Berstatus Selesai Berhasil Dihapus');
    }
}