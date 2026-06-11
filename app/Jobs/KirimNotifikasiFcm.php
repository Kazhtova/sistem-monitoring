<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kreait\Firebase\Messaging\CloudMessage;
use Illuminate\Support\Facades\Log;

class KirimNotifikasiFcm implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    protected mixed $mahasiswa;
    protected string $software;
    protected int $id_request;
    protected string $nama_komputer;
    public function __construct(mixed $mahasiswa, string $software, int $id_request, string $nama_komputer)
    {
        $this->mahasiswa = $mahasiswa;
        $this->software = $software;
        $this->id_request = $id_request;
        $this->nama_komputer = $nama_komputer;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Validasi keberadaan token mahasiswa sebelum menembak Google FCM
        if ($this->mahasiswa && isset($this->mahasiswa->fcm_token)) { 
            try {
                $messaging = app('firebase.messaging'); 

                $message = CloudMessage::fromArray([
                    'token'        => $this->mahasiswa->fcm_token, 
                    'notification' => [
                        'title' => 'Request Disetujui!', 
                        'body'  => "Request Software '{$this->software}' Dengan '{$this->nama_komputer}' Telah Disetujui.", 
                    ],
                    'webpush' => [ 
                        'notification' => [ 
                            'title'        => 'Request Disetujui!', 
                            'body'         => "Request Software '{$this->software}' Dengan '{$this->nama_komputer}' Telah Disetujui.", 
                            'icon'         => '/favicon.ico', 
                            'click_action' => '/mahasiswa/dashboard-mahasiswa', 
                        ],
                        'headers' => [ 
                            'Urgency' => 'high', 
                        ]
                    ],
                    'data' => [
                        'id_request' => (string) $this->id_request, 
                        'type'       => 'request_accepted', 
                        'title'      => 'Request Disetujui!', 
                        'body'       => "Request Software '{$this->software}' telah disetujui .",
                    ],
                ]);

                // Kirim paket data ke Firebase
                $messaging->send($message); 
                
                $studentId = data_get($this->mahasiswa, 'id_mahasiswa', 'Unknown');
                Log::info("FCM Notification Successfully Sent to Student ID: " . $studentId);
            } catch (\Exception $e) { 
                Log::error('FCM Notification Failed: ' . $e->getMessage()); 
            }
        }
    }
}