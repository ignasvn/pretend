<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Laporan / Rekap<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h3 class="text-xl font-bold mb-6">Laporan Rekap Kehadiran</h3>

<?php if (session()->getFlashdata('error')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<!-- Filter -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5 mb-6">
    <form action="/laporan" method="GET" class="flex flex-wrap gap-4 items-end">

        <div>
            <label class="block text-sm font-semibold mb-1">Kelas</label>
            <select name="id_kelas"
                    class="border rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                <option value="">-- Pilih Kelas --</option>
                <?php foreach ($kelas as $k): ?>
                    <option value="<?= $k['id_kelas'] ?>"
                        <?= $id_kelas == $k['id_kelas'] ? 'selected' : '' ?>>
                        <?= esc($k['nama_kelas']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label class="block text-sm font-semibold mb-1">Dari Tanggal</label>
            <input type="date" name="dari" value="<?= $dari ?>"
                   class="border rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
        </div>

        <div>
            <label class="block text-sm font-semibold mb-1">Sampai Tanggal</label>
            <input type="date" name="sampai" value="<?= $sampai ?>"
                   class="border rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
        </div>

        <div class="flex gap-2">
            <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm px-6 py-2 rounded-lg transition">
                Tampilkan
            </button>

            <?php if ($id_kelas): ?>
                <a href="/laporan/export-csv?id_kelas=<?= $id_kelas ?>&dari=<?= $dari ?>&sampai=<?= $sampai ?>"
                   class="bg-green-600 hover:bg-green-700 text-white text-sm px-6 py-2 rounded-lg transition">
                    ⬇ Export CSV
                </a>
            <?php endif; ?>
        </div>

    </form>
</div>

<!-- Tabel Rekap -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-indigo-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
            <tr>
                <th class="px-4 py-3 text-left">#</th>
                <th class="px-4 py-3 text-left">Nama</th>
                <th class="px-4 py-3 text-left">Username</th>
                <th class="px-4 py-3 text-center">Hadir</th>
                <th class="px-4 py-3 text-center">Sakit</th>
                <th class="px-4 py-3 text-center">Izin</th>
                <th class="px-4 py-3 text-center">Alpha</th>
                <th class="px-4 py-3 text-center">Total</th>
                <th class="px-4 py-3 text-center">% Hadir</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
            <?php if (empty($rekap)): ?>
                <tr>
                    <td colspan="9" class="text-center py-6 text-gray-400">
                        <?= $id_kelas ? 'Belum ada data untuk filter ini.' : 'Pilih kelas dan rentang tanggal.' ?>
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($rekap as $i => $r): ?>
                    <?php
                        $persen = $r['total_pertemuan'] > 0
                            ? round(($r['total_hadir'] / $r['total_pertemuan']) * 100)
                            : 0;
                    ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-4 py-3"><?= $i + 1 ?></td>
                        <td class="px-4 py-3 font-medium"><?= esc($r['nama']) ?></td>
                        <td class="px-4 py-3"><?= esc($r['username']) ?></td>
                        <td class="px-4 py-3 text-center">
                            <span class="bg-green-100 text-green-600 px-2 py-1 rounded-full text-xs font-semibold">
                                <?= $r['total_hadir'] ?>
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="bg-yellow-100 text-yellow-600 px-2 py-1 rounded-full text-xs font-semibold">
                                <?= $r['total_sakit'] ?>
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded-full text-xs font-semibold">
                                <?= $r['total_izin'] ?>
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="bg-red-100 text-red-600 px-2 py-1 rounded-full text-xs font-semibold">
                                <?= $r['total_alpha'] ?>
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center font-semibold"><?= $r['total_pertemuan'] ?></td>
                        <td class="px-4 py-3 text-center">
                            <span class="font-semibold <?= $persen >= 75 ? 'text-green-600' : 'text-red-500' ?>">
                                <?= $persen ?>%
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>