<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Greeting -->
<div class="mb-6">
    <h3 class="text-2xl font-bold">Selamat Datang, <?= esc($nama) ?>! 👋</h3>
    <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
        Role: <span class="capitalize font-medium text-indigo-600"><?= esc($role) ?></span>
        · <?= date('l, d F Y') ?>
    </p>
</div>

<!-- ── MAHASISWA ── -->
<?php if ($role === 'mahasiswa'): ?>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4">
            <p class="text-xs text-gray-500">Total Hadir</p>
            <p class="text-3xl font-bold text-green-500"><?= $total_hadir ?></p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4">
            <p class="text-xs text-gray-500">Sakit</p>
            <p class="text-3xl font-bold text-yellow-500"><?= $total_sakit ?></p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4">
            <p class="text-xs text-gray-500">Izin</p>
            <p class="text-3xl font-bold text-blue-500"><?= $total_izin ?></p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4">
            <p class="text-xs text-gray-500">Alpha</p>
            <p class="text-3xl font-bold text-red-500"><?= $total_alpha ?></p>
        </div>
    </div>

    <!-- Persentase Kehadiran -->
    <?php $persen = $total_presensi > 0 ? round(($total_hadir / $total_presensi) * 100) : 0; ?>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5 mb-6">
        <div class="flex justify-between mb-2">
            <span class="text-sm font-semibold">Persentase Kehadiran</span>
            <span class="text-sm font-bold <?= $persen >= 75 ? 'text-green-500' : 'text-red-500' ?>">
                <?= $persen ?>%
            </span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-3">
            <div class="h-3 rounded-full <?= $persen >= 75 ? 'bg-green-500' : 'bg-red-500' ?>"
                 style="width: <?= $persen ?>%"></div>
        </div>
        <p class="text-xs text-gray-400 mt-2">
            <?= $persen >= 75 ? '✅ Kehadiran kamu memenuhi syarat minimum 75%' : '⚠️ Kehadiran kamu di bawah 75%, segera perbaiki!' ?>
        </p>
    </div>

    <!-- Riwayat Terakhir -->
    <h4 class="font-semibold mb-3">5 Presensi Terakhir</h4>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-indigo-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                <tr>
                    <th class="px-4 py-3 text-left">Tanggal</th>
                    <th class="px-4 py-3 text-left">Kelas</th>
                    <th class="px-4 py-3 text-left">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                <?php if (empty($riwayat)): ?>
                    <tr>
                        <td colspan="3" class="text-center py-6 text-gray-400">Belum ada riwayat presensi.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($riwayat as $r): ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-4 py-3"><?= date('d M Y', strtotime($r['tanggal'])) ?></td>
                        <td class="px-4 py-3"><?= esc($r['nama_kelas']) ?></td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                <?= $r['status'] === 'Hadir' ? 'bg-green-100 text-green-600' :
                                   ($r['status'] === 'Sakit' ? 'bg-yellow-100 text-yellow-600' :
                                   ($r['status'] === 'Izin'  ? 'bg-blue-100 text-blue-600' :
                                    'bg-red-100 text-red-600')) ?>">
                                <?= $r['status'] ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

<!-- ── DOSEN ── -->
<?php elseif ($role === 'dosen'): ?>

    <div class="grid grid-cols-2 gap-4 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4">
            <p class="text-xs text-gray-500">Total Kelas Saya</p>
            <p class="text-3xl font-bold text-indigo-500"><?= $total_kelas ?></p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4">
            <p class="text-xs text-gray-500">Hadir Hari Ini</p>
            <p class="text-3xl font-bold text-green-500"><?= $total_hadir_hari ?></p>
        </div>
    </div>

    <h4 class="font-semibold mb-3">Rekap Per Kelas</h4>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-indigo-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                <tr>
                    <th class="px-4 py-3 text-left">Kelas</th>
                    <th class="px-4 py-3 text-left">Hari</th>
                    <th class="px-4 py-3 text-center">Hadir</th>
                    <th class="px-4 py-3 text-center">Sakit</th>
                    <th class="px-4 py-3 text-center">Izin</th>
                    <th class="px-4 py-3 text-center">Alpha</th>
                    <th class="px-4 py-3 text-center">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                <?php if (empty($rekap_kelas)): ?>
                    <tr>
                        <td colspan="7" class="text-center py-6 text-gray-400">Belum ada data presensi.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($rekap_kelas as $r): ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-4 py-3 font-medium"><?= esc($r['nama_kelas']) ?></td>
                        <td class="px-4 py-3"><?= esc($r['hari']) ?></td>
                        <td class="px-4 py-3 text-center text-green-600 font-semibold"><?= $r['total_hadir'] ?></td>
                        <td class="px-4 py-3 text-center text-yellow-500 font-semibold"><?= $r['total_sakit'] ?></td>
                        <td class="px-4 py-3 text-center text-blue-500 font-semibold"><?= $r['total_izin'] ?></td>
                        <td class="px-4 py-3 text-center text-red-600 font-semibold"><?= $r['total_alpha'] ?></td>
                        <td class="px-4 py-3 text-center"><?= $r['total_presensi'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

<!-- ── ADMIN ── -->
<?php else: ?>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4">
            <p class="text-xs text-gray-500">Total Mahasiswa</p>
            <p class="text-3xl font-bold text-indigo-500"><?= $total_mahasiswa ?></p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4">
            <p class="text-xs text-gray-500">Total Dosen</p>
            <p class="text-3xl font-bold text-blue-500"><?= $total_dosen ?></p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4">
            <p class="text-xs text-gray-500">Total Kelas</p>
            <p class="text-3xl font-bold text-yellow-500"><?= $total_kelas ?></p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4">
            <p class="text-xs text-gray-500">Hadir Hari Ini</p>
            <p class="text-3xl font-bold text-green-500"><?= $total_hadir_hari ?></p>
        </div>
    </div>

<?php endif; ?>

<?= $this->endSection() ?>