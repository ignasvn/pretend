<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Greeting -->
<div class="mb-6">
    <h3 class="text-2xl font-bold">Selamat Datang, <?= esc($nama) ?>! 👋</h3>
    <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
        Role: <span class="capitalize font-medium text-indigo-600"><?= esc($role) ?></span>
    </p>
</div>

<!-- Stat Cards — beda per role -->
<?php if ($role === 'mahasiswa'): ?>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4">
            <p class="text-xs text-gray-500">Total Hadir</p>
            <p class="text-3xl font-bold text-green-500">0</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4">
            <p class="text-xs text-gray-500">Sakit</p>
            <p class="text-3xl font-bold text-yellow-500">0</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4">
            <p class="text-xs text-gray-500">Izin</p>
            <p class="text-3xl font-bold text-blue-500">0</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4">
            <p class="text-xs text-gray-500">Alpha</p>
            <p class="text-3xl font-bold text-red-500">0</p>
        </div>
    </div>

<?php elseif (in_array($role, ['dosen', 'admin'])): ?>

    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4">
            <p class="text-xs text-gray-500">Total Mahasiswa</p>
            <p class="text-3xl font-bold text-indigo-500">0</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4">
            <p class="text-xs text-gray-500">Hadir Hari Ini</p>
            <p class="text-3xl font-bold text-green-500">0</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4">
            <p class="text-xs text-gray-500">Total Kelas Aktif</p>
            <p class="text-3xl font-bold text-blue-500">0</p>
        </div>
    </div>

<?php endif; ?>

<!-- Placeholder grafik -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
    <h4 class="font-semibold mb-3">Grafik Kehadiran Mingguan</h4>
    <div class="h-40 flex items-center justify-center text-gray-400 text-sm border-2 border-dashed rounded-lg">
        Grafik akan ditampilkan di sini
    </div>
</div>

<?= $this->endSection() ?>