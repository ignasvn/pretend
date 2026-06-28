<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Jadwal / Kelas<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-6">
    <h3 class="text-xl font-bold">Daftar Jadwal / Kelas</h3>
    <a href="/jadwal/create"
       class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm px-4 py-2 rounded-lg transition">
        + Tambah Kelas
    </a>
</div>

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

<div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-indigo-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
            <tr>
                <th class="px-4 py-3 text-left">#</th>
                <th class="px-4 py-3 text-left">Nama Kelas</th>
                <th class="px-4 py-3 text-left">Dosen</th>
                <th class="px-4 py-3 text-left">Hari</th>
                <th class="px-4 py-3 text-left">Jam</th>
                <th class="px-4 py-3 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
            <?php if (empty($kelas)): ?>
                <tr>
                    <td colspan="6" class="text-center py-6 text-gray-400">Belum ada data kelas.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($kelas as $i => $k): ?>
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-4 py-3"><?= $i + 1 ?></td>
                    <td class="px-4 py-3 font-medium"><?= esc($k['nama_kelas']) ?></td>
                    <td class="px-4 py-3"><?= esc($k['nama_dosen']) ?></td>
                    <td class="px-4 py-3"><?= esc($k['hari']) ?></td>
                    <td class="px-4 py-3">
                        <?= substr($k['jam_mulai'], 0, 5) ?> - <?= substr($k['jam_selesai'], 0, 5) ?>
                    </td>
                    <td class="px-4 py-3 flex gap-2">
                        <a href="/jadwal/edit/<?= $k['id_kelas'] ?>"
                           class="bg-yellow-400 hover:bg-yellow-500 text-white text-xs px-3 py-1 rounded transition">
                            Edit
                        </a>
                        <a href="/jadwal/delete/<?= $k['id_kelas'] ?>"
                           onclick="return confirm('Yakin hapus kelas ini?')"
                           class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded transition">
                            Hapus
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>