<x-apps-layout>
    <x-slot name="header">
<style>
        /* Menghilangkan warna kuning bawaan untuk Hari Ini */
        .fc .fc-day-today {
            background-color: #ffff !important; 
        }
        
        .fc-theme-standard td, .fc-theme-standard th {
            border-color: #e2e8f0;
        }

        /* 🟢 DESAIN ULANG BLOK EVENT (Anti Ngumpet) */
        .fc-v-event, .fc-timegrid-event {
            min-height: 52px !important; /* Paksa tinggi minimal 52px agar teks 2 baris muat */
            border-radius: 8px !important;
            border: none !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            overflow: hidden; 
        }

        .fc-v-event:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 50 !important;
        }
    </style>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 w-full">
           <!-- Sisi Kiri: Judul Kalender dan Lab -->
            <h2 class="font-bold text-2xl text-slate-800 tracking-tight">
                Kalender Pemakaian: {{ $komputer->nama_komputer }} : {{ $komputer->laboratorium->nama_lab }}
            </h2>
            
            <!-- Sisi Kanan: Tombol Back (Merapat ke Pojok Kanan) -->
            <div class="flex-shrink-0">
                <a href="{{ route('mahasiswa.dashboard.pc_list') }}" 
                class="inline-flex items-center px-4 py-2 bg-white rounded-xl shadow-sm border border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-sm font-bold text-slate-600 hover:text-slate-900 transition-all duration-300 group">
                    <svg class="w-4 h-4 mr-2 text-slate-400 group-hover:text-slate-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <!-- Panggil CSS FullCalendar -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Legenda Warna -->
            <div class="mb-6 flex gap-4">
                <div class="flex items-center gap-2">
                    <span class="w-4 h-4 rounded-full bg-[#e11d48]"></span>
                    <span class="text-sm font-bold text-slate-700">Sedang Jalan (Setuju)</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-4 h-4 rounded-full bg-[#eab308]"></span>
                    <span class="text-sm font-bold text-slate-700">Dalam Antrean (Pending)</span>
                </div>
            </div>

            <!-- Wadah Kalender -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200">
                <div id="calendar"></div>
            </div>

        </div>
    </div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                
                locale: 'id',
                slotLabelFormat: { hour: '2-digit', minute: '2-digit', hour12: false },
                initialView: 'timeGridWeek', 
                
                slotMinTime: '00:00:00',
                slotMaxTime: '24:00:00',
                slotDuration: '00:30:00', 
                expandRows: true,

                eventMinHeight: 52, 
                eventShortHeight: 52,

                events: "{{ route('mahasiswa.api.komputer.jadwal', $komputer->id_komputer) }}",

                eventContent: function(arg) {
                    let bgColor = arg.event.backgroundColor;
                    let timeText = arg.timeText;
                    let titleText = arg.event.title;
                    
                    let htmlString = `
                        <div style="background-color: ${bgColor}; width: 100%; height: 100%; padding: 4px 8px; box-sizing: border-box; display: flex; flex-direction: column; justify-content: flex-start; color: #ffffff;">
                            <div style="font-size: 10px; opacity: 0.95; font-weight: 700; letter-spacing: 0.5px; line-height: 1.2;">
                                ${timeText}
                            </div>
                            <div style="font-size: 12px; font-weight: 800; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-top: 2px; line-height: 1.2;">
                                ${titleText}
                            </div>
                        </div>
                    `;

                    return { html: htmlString };
                },

                eventClick: function(info) {
                    let props = info.event.extendedProps;
                    let title = info.event.title;
                    let mulai = info.event.start.toLocaleString('id-ID');
                    let selesai = info.event.end ? info.event.end.toLocaleString('id-ID') : 'N/A';

                    alert(`Status: ${title}\nMahasiswa: ${props.mahasiswa}\nSoftware: ${props.software}\nMulai: ${mulai}\nSelesai: ${selesai}`);
                }
            });

            calendar.render();
        });
    </script>
    @endpush
</x-apps-layout>