<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Manajemen User<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-6">
    <h3 class="text-xl font-bold">Daftar Pengguna</h3>
    <a href="/users/create"
       class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm px-4 py-2 rounded-lg transition">
        + Tambah User
    </a>
</div>

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

<!-- Tabel -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-indigo-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
            <tr>
                <th class="px-4 py-3 text-left">#</th>
                <th class="px-4 py-3 text-left">Nama</th>
                <th class="px-4 py-3 text-left">Username</th>
                <th class="px-4 py-3 text-left">Email</th>
                <th class="px-4 py-3 text-left">Role</th>
                <th class="px-4 py-3 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
            <?php if (empty($users)): ?>
                <tr>
                    <td colspan="6" class="text-center py-6 text-gray-400">Belum ada data user.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($users as $i => $user): ?>
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-4 py-3"><?= $i + 1 ?></td>
                    <td class="px-4 py-3 font-medium"><?= esc($user['nama']) ?></td>
                    <td class="px-4 py-3"><?= esc($user['username']) ?></td>
                    <td class="px-4 py-3"><?= esc($user['email']) ?></td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                            <?= $user['role'] === 'admin' ? 'bg-red-100 text-red-600' :
                               ($user['role'] === 'dosen' ? 'bg-blue-100 text-blue-600' :
                                'bg-green-100 text-green-600') ?>">
                            <?= ucfirst($user['role']) ?>
                        </span>
                    </td>
                    <td class="px-4 py-3 flex gap-2">
                        <a href="/users/edit/<?= $user['id_user'] ?>"
                           class="bg-yellow-400 hover:bg-yellow-500 text-white text-xs px-3 py-1 rounded transition">
                            Edit
                        </a>
                        <a href="/users/delete/<?= $user['id_user'] ?>"
                           onclick="return confirm('Yakin hapus user ini?')"
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