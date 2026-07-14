<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-slate-900 tracking-tight">
                {{ __('Details - Unpending Request') }}
            </h2>
            <a href="{{ route('teknisi.dashboard.accept') }}" 
               class="inline-flex items-center px-4 py-2 bg-white rounded-xl shadow-sm border border-gray-200 hover:border-slate-300 hover:bg-slate-50 text-sm font-bold text-gray-600 hover:text-slate-600 transition-all duration-300 group">
                <svg class="w-4 h-4 mr-2 text-gray-400 group-hover:text-slate-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back
            </a>
        </div>
    </x-slot>

    @php
    // 1. Parsing Waktu dengan Carbon
    \Carbon\Carbon::setLocale('id');

    $mulai = \Carbon\Carbon::parse($data->tanggal_mulai);
    $selesai = \Carbon\Carbon::parse($data->perkiraan_selesai);
    $sekarang = \Carbon\Carbon::now();

    // 2. Kalkulasi Durasi Elapsed (Berjalan)
    $elapsedDiff = $mulai->diff($sekarang);
    $elapsedStr = [];
    if ($elapsedDiff->d > 0) $elapsedStr[] = $elapsedDiff->d . ' Hari';
    if ($elapsedDiff->h > 0) $elapsedStr[] = $elapsedDiff->h . ' Jam';
    if ($elapsedDiff->i > 0) $elapsedStr[] = $elapsedDiff->i . ' Mnt';
    $waktuBerjalan = implode(' ', $elapsedStr) ?: '0m';

    // 3. Kalkulasi Persentase Progress Bar
    $totalMenit = $mulai->diffInMinutes($selesai);
    $menitBerjalan = $mulai->diffInMinutes($sekarang);
    $totalMenit = $totalMenit > 0 ? $totalMenit : 1; // Mencegah division by zero
    $persentase = round(($menitBerjalan / $totalMenit) * 100);
    $persentase = min(100, max(0, $persentase)); // Batasi 0% - 100%

    $durasiDiff = $mulai->diff($selesai);
    $durasiArray = [];
    
    // Pecah menjadi translatedFormat d (days), h (hours), dan m (minutes)
    if ($durasiDiff->d > 0) $durasiArray[] = $durasiDiff->d . ' Hari';
    if ($durasiDiff->h > 0) $durasiArray[] = $durasiDiff->h . ' Jam';
    if ($durasiDiff->i > 0) $durasiArray[] = $durasiDiff->i . ' Mnt';
    
    // Gabungkan array menjadi teks tunggal (contoh keluaran: "3h 30m")
    $estimasiDurasi = implode(' ', $durasiArray) ?: '0m';

    // 4. Pembersihan Data Software
    $softwareList = array_map('trim', explode(',', $data->software));
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 font-sans">

    <!-- ================= MAIN GRID ================= -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- KOLOM KIRI (Lebar 2/3) -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- 1. Foto Container -->
            <div class="relative w-full aspect-video md:aspect-[21/9] bg-slate-100 rounded-3xl overflow-hidden shadow-sm border border-slate-200/60 group" id="foto-container-{{ $data->id_request }}">
                @if($data->foto_bukti)
                    <img id="img-{{ $data->id_request }}" src="{{ asset('storage/' . $data->foto_bukti) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 cursor-pointer" onclick="bukaModal(this.src)" alt="Bukti Foto">
                @else
                    <div id="placeholder-{{ $data->id_request }}" class="w-full h-full flex flex-col items-center justify-center text-slate-400 bg-slate-50">
                        <svg class="w-12 h-12 mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="text-xs uppercase tracking-widest font-bold opacity-60">Belum Ada Foto</span>
                    </div>
                @endif

                <!-- Gradient Overlay & Text Bawah -->
                <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-black/80 to-transparent pointer-events-none"></div>
                <div class="absolute bottom-6 left-6 z-10 pointer-events-none">
                    <p class="text-[13px] font-black tracking-widest text-white/80 uppercase mb-0.5">Bukti Foto</p>
                </div>

                <!-- Badge Status (Kanan Atas) -->
                <div class="absolute top-6 right-6 z-10">
                    <span class="inline-flex items-center gap-1.5 bg-slate-900/75 backdrop-blur-sm border border-white/20 text-white px-3 py-1.5 rounded-full text-[11px] font-black shadow-sm cursor-default transition-all duration-300 hover:bg-slate-900 hover:border-white/40 uppercase">
                        @php
                            $statusText = ucfirst($data->status);
                            $dotColor = 'bg-slate-400'; 

                            if ($data->status === 'setuju') {
                                $statusText = 'Running';
                                $dotColor   = 'bg-emerald-500'; 
                            } elseif ($data->status === 'selesai') {
                                $statusText = 'Selesai';
                                $dotColor   = 'bg-blue-500';    
                            } elseif ($data->status === 'tolak') {
                                $statusText = 'Ditolak';
                                $dotColor   = 'bg-red-500';    
                            }
                        @endphp
                        <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }}"></span>
                        {{ $statusText }}
                    </span>
                </div>
            </div>

            <!-- 2. Request Details Card -->
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-200">
                <h2 class="text-xl font-bold text-slate-900 mb-6">Request Detail</h2>
                <div class="w-full h-px bg-slate-100 mb-8"></div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <!-- Workstation -->
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center flex-shrink-0 text-slate-600 border border-slate-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-base font-bold text-slate-500 mb-0.5">Komputer</p>
                            <p class="text-base font-bold text-slate-900">{{ $data->komputer->nama_komputer }}</p>
                        </div>
                    </div>

                    <!-- Location -->
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center flex-shrink-0 text-slate-600 border border-slate-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2M5 21H3m4 0h10M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5"></path></svg>
                        </div>
                        <div>
                            <p class="text-base font-bold text-slate-500 mb-0.5">Laboratorium</p>
                            <p class="text-base font-bold text-slate-900">{{ $data->laboratorium->nama_lab }}</p>
                        </div>
                    </div>

                    <!-- Software Required -->
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center flex-shrink-0 text-slate-600 border border-slate-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-base font-bold text-slate-500 mb-2">Software</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($softwareList as $software)
                                    @if(!empty($software))
                                        <span class="px-3 py-1 bg-slate-100 text-slate-700 text-sm font-semibold rounded-lg border border-slate-200/50">{{ $software }}</span>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Contact -->
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center flex-shrink-0 text-slate-600 border border-slate-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        </div>
                        <div>
                            <p class="text-base font-bold text-slate-500 mb-0.5">Contact</p>
                            <p class="text-base font-bold text-slate-900">{{ $data->no_hp }}</p>
                        </div>
                    </div>
                </div>

                <!-- Dosen Pengampu -->
                <div class="flex items-center gap-4 p-4 rounded-2xl border border-slate-200">
                    <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center flex-shrink-0 text-slate-600 border border-slate-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                        </svg>
                    </div>
                    
                    <div>
                        <p class="text-base font-bold text-slate-500 mb-0.5">Dosen</p>
                        <p class="text-base font-bold text-slate-900">{{ $data->dosen_ta }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN (Lebar 1/3) -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-200">
                <h1 class="text-xl font-bold text-slate-900 mb-6">Data Profile</h1>
                
            <div class="w-full h-px bg-slate-100 mb-6"></div>

            <div class="flex items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">{{ $data->mahasiswa->nama }}</h1>
                    <div class="flex items-center gap-2 mt-4">
                        <span class="px-2 py-0.5 bg-slate-100 text-slate-900 text-[12px] font-bold rounded uppercase tracking-wider">Mahasiswa</span>
                        <span class="font-bold text-slate-900 text-sm">&bull; NRP: {{ $data->mahasiswa->nrp ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>

            <div class="text-sm font-medium text-slate-600 pt-7">
            </div>

            <div class="flex items-center gap-3 pt-10">
                
                @if($data->status === 'setuju')
                    <form id="form-reject-{{ $data->id_request }}" action="{{ route('teknisi.cancel.request', $data->id_request) }}" method="POST" class="m-0">
                        @csrf
                        @method('PATCH')
                        <button type="button" onclick="confirmDelete('{{ $data->id_request }}')" class="inline-flex items-center gap-2 px-5 py-2.5 bg-rose-600 border border-transparent text-white text-sm font-bold rounded-xl hover:bg-rose-700 transition shadow-sm active:scale-95">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Selesaikan Request
                        </button>
                    </form>

                @elseif($data->status === 'selesai')
                    <div class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-blue-700 bg-blue-50 border border-blue-200 rounded-xl shadow-sm cursor-default">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Selesai
                    </div>

                @elseif($data->status === 'tolak')
                    <div class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-red-700 bg-red-50 border border-red-200 rounded-xl shadow-sm cursor-default">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Ditolak
                    </div>
                @endif
            </div>

        </div>

        <div class="lg:col-span-1 space-y-6">
            
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-200">
                <h2 class="text-xl font-bold text-slate-900 mb-6">Waktu Request</h2>
                <div class="w-full h-px bg-slate-100 mb-8"></div>

                <div class="relative">
                    <div class="absolute left-2.5 top-2 bottom-2 w-[2px] bg-slate-200"></div>
                    
                    <div class="relative pl-10 mb-10">
                        <div class="absolute left-0 top-1 w-5 h-5 rounded-full bg-white border-[5px] border-slate-600 ring-4 ring-white z-10"></div>
                        <p class="text-[13px] font-black tracking-widest text-slate-500 uppercase mb-1.5">Waktu Mulai</p>
                        
                        <div class="flex flex-col gap-2">
                            <p class="text-2xl font-black text-slate-900 leading-none">{{ $mulai->translatedFormat('D d M Y') }}</p>
                            <p class="text-base font-medium text-slate-700">
                                &bull; {{ $mulai->translatedFormat('H:i') }} WIB
                            </p>
                        </div>
                    </div>

                    <div class="relative pl-10 mb-10">
                        <div class="absolute left-[7px] top-2 bg-white z-10 py-1">
                            <svg class="w-3 h-3 text-slate-400" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                            </svg>
                        </div>
                        
                        <div class="inline-flex items-center gap-3 px-4 py-2 bg-slate-50/80 border border-slate-100/50 rounded-lg">
                            <span class="relative flex h-2.5 w-2.5 flex-shrink-0">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-slate-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-slate-500"></span>
                            </span>
                            
                            <p class="text-sm font-bold text-slate-700 whitespace-nowrap">
                                In Progress <span class="text-slate-300 mx-2">|</span> {{ $waktuBerjalan }} Berlalu
                            </p>
                        </div>
                    </div>

                    <div class="relative pl-10">
                        <div class="absolute left-0 top-1 w-5 h-5 rounded-full bg-slate-600 border-4 border-white ring-2 ring-slate-600 z-10"></div>
                        
                        <div class="flex flex-wrap lg:flex-nowrap justify-between items-start gap-6 pr-2">
                            <div class="min-w-0">
                                <p class="text-[13px] font-black tracking-widest text-slate-500 uppercase mb-1.5">Estimasi Selesai</p>
                                
                                <div class="flex flex-wrap items-baseline gap-2">
                                    <p id="tgl-selesai-teknisi-{{ $data->id_request }}" class="text-2xl font-black text-slate-900 leading-none whitespace-nowrap">
                                        {{ $selesai->translatedFormat('D d M Y') }}
                                    </p>
                                    
                                    <p id="jam-selesai-teknisi-{{ $data->id_request }}" class="text-base font-medium text-slate-700 whitespace-nowrap">
                                        &bull;  {{ $selesai->translatedFormat('H:i') }} WIB
                                    </p>
                                </div>
                            </div>
                            
                            <div class="text-left lg:text-center flex-shrink-0">
                                <p class="text-[10px] font-black tracking-widest text-slate-500 uppercase mb-2">Total Durasi</p>
                                <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-bold bg-slate-50 text-slate-700 border border-slate-200 shadow-sm">
                                    {{ $estimasiDurasi }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalGambar" class="fixed inset-0 z-[999] hidden bg-slate-900/95 backdrop-blur-xl flex items-center justify-center p-8 transition-opacity duration-300" onclick="tutupModal()">
    <div class="relative max-w-5xl w-full flex justify-center">
        <button class="absolute -top-12 right-0 text-white/70 text-5xl font-light hover:text-red-500 hover:rotate-90 transition-all duration-300">&times;</button>
        <img id="gambarUtuh" class="max-w-full max-h-[85vh] rounded-3xl shadow-2xl object-contain border border-white/10" onclick="event.stopPropagation()">
    </div>
</div>

<script>
    function bukaModal(src) {
        const modal = document.getElementById('modalGambar');
        const gambar = document.getElementById('gambarUtuh');
        gambar.src = src;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function tutupModal() {
        const modal = document.getElementById('modalGambar');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function confirmDelete(id) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: "Ingin Menyelesaikan Request?",
                text: "Anda akan menyelesaikan Request yang sedang berjalan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#e11d48", 
                cancelButtonColor: "#94a3b8", 
                confirmButtonText: "Ya, Selesaikan",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-reject-' + id).submit();
                }
            });
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        if (typeof window.Echo !== 'undefined') {
            // Listener Foto
            window.Echo.channel('foto-channel')
            .listen('.FotoView', (e) => {
                const container = document.getElementById('foto-container-' + e.id_request);
                if(container){
                    const newImageUrl = '/storage/' + e.path;
                    let existingImg = document.getElementById('img-' + e.id_request);
                    let placeholder = document.getElementById('placeholder-' + e.id_request);

                    if(existingImg){
                        existingImg.src = newImageUrl;
                    } else { 
                        if(placeholder) placeholder.remove();
                        const newImg = document.createElement('img');
                        newImg.id = 'img-' + e.id_request;
                        newImg.src = newImageUrl;
                        newImg.className = 'w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 cursor-pointer';
                        newImg.onclick = function (){ bukaModal(this.src) };
                        container.insertBefore(newImg, container.firstChild);
                    }
                }
            });

            window.Echo.channel('teknisi-channel')
            .listen('.WaktuUpdated', (e) => {
                let tglTarget = document.getElementById('tgl-selesai-teknisi-' + e.id_request);
                let jamTarget = document.getElementById('jam-selesai-teknisi-' + e.id_request);
                
                if(tglTarget && jamTarget && e.waktu_baru) {
                    
                    let timeMatch = e.waktu_baru.match(/(\d{1,2}):(\d{2})/);
                    
                    if (timeMatch) {
                        let jam = timeMatch[1].padStart(2, '0');
                        let menit = timeMatch[2].padStart(2, '0');
                        
                        jamTarget.innerHTML = `&bull;  ${jam}:${menit} WIB`;
                    }

                    let dateMatch = e.waktu_baru.match(/(\d{4})[-\/](\d{2})[-\/](\d{2})/);
                    if (dateMatch) {
                        let tahun = dateMatch[1];
                        let bulanIndex = parseInt(dateMatch[2]) - 1;
                        let tanggal = dateMatch[3].padStart(2, '0');
                        
                        let dateObj = new Date(tahun, bulanIndex, tanggal);
                        const hariIndo = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
                        const bulanIndo = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];

                        tglTarget.innerText = `${hariIndo[dateObj.getDay()]} ${tanggal} ${bulanIndo[bulanIndex]} ${tahun}`;
                    }

                }
            });
        }
    });
</script>

</x-app-layout>