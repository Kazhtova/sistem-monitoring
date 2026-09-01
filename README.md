<p align="center">
  <img src="public/images/M.svg" width="150" alt="Invenkoryz Logo">
</p>

<h1 align="center">Invenkoryz - Sistem Monitoring Laboratorium</h1>

<p align="center">
  <a href="https://laravel.com"><img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel"></a>
  <a href="https://tailwindcss.com/"><img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS"></a>
  <a href="https://fullcalendar.io/"><img src="https://img.shields.io/badge/FullCalendar-4285F4?style=for-the-badge&logo=google-calendar&logoColor=white" alt="FullCalendar"></a>
  <a href="#"><img src="https://img.shields.io/badge/Real--Time-Reverb-orange?style=for-the-badge" alt="Laravel Reverb"></a>
</p>

## About The Pr

**Invenkoryz** adalah Sistem Monitoring Laboratorium terintegrasi yang dirancang untuk mengelola, melacak, dan menjadwalkan penggunaan unit komputer (PC) di berbagai laboratorium. Sistem ini memfasilitasi mahasiswa dalam mengajukan *request* perbaikan atau peminjaman, serta membantu teknisi dalam memantau aset secara *real-time*.

Aplikasi ini mengimplementasikan *Role-Based Access Control* (RBAC) yang ketat, memisahkan hak akses antara Mahasiswa, Teknisi Penanggung Jawab, dan Super Admin (Observer).

## Key Features

- **Real-time Monitoring & Notifications:** Pembaruan status *request* dan notifikasi langsung kepada mahasiswa dan teknisi menggunakan WebSockets (Laravel Reverb & Echo).
- **Smart Scheduling System:** Visualisasi jadwal pemakaian PC secara interaktif menggunakan FullCalendar untuk mencegah bentrok jadwal (*double-booking*).
- **Role-Based Access Control (RBAC):** 
  - **Mahasiswa:** Mengajukan *request*, mengunggah bukti foto, dan melihat jadwal PC.
  - **Teknisi:** Menyetujui/menolak *request*, memperbarui status perbaikan, dan mengelola PC di lab masing-masing.
  - **Super Admin:** Memiliki visibilitas global (Super Observer) untuk memantau seluruh aktivitas lab tanpa bisa mengintervensi eksekusi teknisi lokal.
- **Activity Logging:** Pelacakan rekam jejak (*audit trail*) yang komprehensif untuk setiap tindakan yang dilakukan di dalam sistem.
- **Responsive UI:** Antarmuka modern dan responsif yang dibangun menggunakan komponen Blade dan Tailwind CSS.

## Tech Stack

- **Backend:** Laravel (PHP)
- **Frontend:** Laravel Blade, Tailwind CSS, Alpine.js
- **Database:** MySQL
- **WebSockets:** Laravel Reverb & Laravel Echo
- **Assets/Libraries:** FullCalendar, SweetAlert2
- **Infrastructure:** Docker (Support for containerized environments)

## Getting Started

Ikuti langkah-langkah di bawah ini untuk menjalankan proyek Invenkoryz di mesin lokal (*local development environment*).

### Prerequisites

Pastikan perangkat kamu sudah terinstal:
- [PHP](https://www.php.net/) (v8.2 atau lebih baru)
- [Composer](https://getcomposer.org/)
- [Node.js & npm](https://nodejs.org/)
- MySQL / MariaDB

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/Kazhtova/sistem-monitoring.git
   cd sistem-monitoring
