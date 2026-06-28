<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Presensi<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h3 class="text-xl font-bold mb-2">Presensi Hari Ini</h3>
<p class="text-gray-500 text-sm mb-6">Hari: <strong><?= $hariIni ?></strong> — <?= date('d F Y') ?></p>

<!-- Flash Message -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-sm">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<!-- Kelas Hari Ini -->
<?php if (empty($kelasHariIni)): ?>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 text-center text-gray-400 mb-6">
        Tidak ada kelas hari ini.
    </div>
<?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
        <?php foreach ($kelasHariIni as $kelas): ?>
            <?php $sudah = $statusPresensi[$kelas['id_kelas']] ?? null; ?>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5">
                <h4 class="font-bold text-lg mb-1"><?= esc($kelas['nama_kelas']) ?></h4>
                <p class="text-sm text-gray-500 mb-4">
                    <?= substr($kelas['jam_mulai'], 0, 5) ?> - <?= substr($kelas['jam_selesai'], 0, 5) ?>
                </p>

                <?php if ($sudah): ?>
                    <!-- Sudah presensi -->
                    <div class="flex items-center gap-2">
                        <span class="px-3 py-1 rounded-full text-sm font-semibold
                            <?= $sudah['status'] === 'Hadir' ? 'bg-green-100 text-green-600' :
                               ($sudah['status'] === 'Sakit' ? 'bg-yellow-100 text-yellow-600' :
                               ($sudah['status'] === 'Izin'  ? 'bg-blue-100 text-blue-600' :
                                'bg-red-100 text-red-600')) ?>">
                            <?= $sudah['status'] ?>
                        </span>
                        <span class="text-xs text-gray-400">pukul <?= substr($sudah['waktu_hadir'], 0, 5) ?></span>
                    </div>
                <?php else: ?>
                    <!-- Belum presensi — tampilkan tombol -->
                    <form action="/presensi/store" method="POST">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id_kelas" value="<?= $kelas['id_kelas'] ?>">
                        <div class="flex flex-wrap gap-2">
                            <button type="submit" name="status" value="Hadir"
                                    class="bg-green-500 hover:bg-green-600 text-white text-sm px-4 py-2 rounded-lg transition">
                                ✅ Hadir
                            </button>
                            <button type="submit" name="status" value="Sakit"
                                    class="bg-yellow-400 hover:bg-yellow-500 text-white text-sm px-4 py-2 rounded-lg transition">
                                🤒 Sakit
                            </button>
                            <button type="submit" name="status" value="Izin"
                                    class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-4 py-2 rounded-lg transition">
                                📋 Izin
                            </button>
                            <button type="submit" name="status" value="Alpha"
                                    class="bg-red-500 hover:bg-red-600 text-white text-sm px-4 py-2 rounded-lg transition">
                                ❌ Alpha
                            </button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- Riwayat Presensi -->
<h3 class="text-lg font-bold mb-3">Riwayat Kehadiran</h3>
<div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-indigo-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
            <tr>
                <th class="px-4 py-3 text-left">Tanggal</th>
                <th class="px-4 py-3 text-left">Kelas</th>
                <th class="px-4 py-3 text-left">Jam</th>
                <th class="px-4 py-3 text-left">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
            <?php if (empty($riwayat)): ?>
                <tr>
                    <td colspan="4" class="text-center py-6 text-gray-400">Belum ada riwayat presensi.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($riwayat as $r): ?>
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-4 py-3"><?= date('d M Y', strtotime($r['tanggal'])) ?></td>
                    <td class="px-4 py-3"><?= esc($r['nama_kelas']) ?></td>
                    <td class="px-4 py-3"><?= $r['waktu_hadir'] ? substr($r['waktu_hadir'], 0, 5) : '-' ?></td>
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

<?= $this->endSection() ?>