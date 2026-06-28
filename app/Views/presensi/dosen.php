<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Rekap Presensi<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h3 class="text-xl font-bold mb-6">Rekap Presensi Mahasiswa</h3>

<?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-sm">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<!-- Filter -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5 mb-6">
    <form action="/presensi" method="GET" class="flex flex-wrap gap-4 items-end">
        <div>
            <label class="block text-sm font-semibold mb-1">Pilih Kelas</label>
            <select name="id_kelas"
                    class="border rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                <option value="">-- Pilih Kelas --</option>
                <?php foreach ($kelasDosen as $k): ?>
                    <option value="<?= $k['id_kelas'] ?>"
                        <?= $id_kelas == $k['id_kelas'] ? 'selected' : '' ?>>
                        <?= esc($k['nama_kelas']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label class="block text-sm font-semibold mb-1">Tanggal</label>
            <input type="date" name="tanggal" value="<?= $tanggal ?>"
                   class="border rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
        </div>
        <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm px-6 py-2 rounded-lg transition">
            Tampilkan
        </button>
    </form>
</div>

<!-- Tabel Presensi -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-indigo-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
            <tr>
                <th class="px-4 py-3 text-left">#</th>
                <th class="px-4 py-3 text-left">Nama</th>
                <th class="px-4 py-3 text-left">Username</th>
                <th class="px-4 py-3 text-left">Jam Hadir</th>
                <th class="px-4 py-3 text-left">Status</th>
                <th class="px-4 py-3 text-left">Koreksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
            <?php if (empty($presensiList)): ?>
                <tr>
                    <td colspan="6" class="text-center py-6 text-gray-400">
                        <?= $id_kelas ? 'Belum ada data presensi untuk filter ini.' : 'Pilih kelas dan tanggal untuk melihat data.' ?>
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($presensiList as $i => $p): ?>
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-4 py-3"><?= $i + 1 ?></td>
                    <td class="px-4 py-3 font-medium"><?= esc($p['nama']) ?></td>
                    <td class="px-4 py-3"><?= esc($p['username']) ?></td>
                    <td class="px-4 py-3"><?= $p['waktu_hadir'] ? substr($p['waktu_hadir'], 0, 5) : '-' ?></td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                            <?= $p['status'] === 'Hadir' ? 'bg-green-100 text-green-600' :
                               ($p['status'] === 'Sakit' ? 'bg-yellow-100 text-yellow-600' :
                               ($p['status'] === 'Izin'  ? 'bg-blue-100 text-blue-600' :
                                'bg-red-100 text-red-600')) ?>">
                            <?= $p['status'] ?>
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <form action="/presensi/koreksi/<?= $p['id_presensi'] ?>" method="POST" class="flex gap-2">
                            <?= csrf_field() ?>
                            <select name="status"
                                    class="border rounded px-2 py-1 text-xs dark:bg-gray-700 dark:border-gray-600">
                                <option value="Hadir" <?= $p['status'] === 'Hadir' ? 'selected' : '' ?>>Hadir</option>
                                <option value="Sakit" <?= $p['status'] === 'Sakit' ? 'selected' : '' ?>>Sakit</option>
                                <option value="Izin"  <?= $p['status'] === 'Izin'  ? 'selected' : '' ?>>Izin</option>
                                <option value="Alpha" <?= $p['status'] === 'Alpha' ? 'selected' : '' ?>>Alpha</option>
                            </select>
                            <button type="submit"
                                    class="bg-indigo-500 hover:bg-indigo-600 text-white text-xs px-3 py-1 rounded transition">
                                Simpan
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>