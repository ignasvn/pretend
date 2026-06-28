<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Tambah User<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="max-w-xl">
    <h3 class="text-xl font-bold mb-6">Tambah User Baru</h3>

    <!-- Error Validasi -->
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
            <ul class="list-disc list-inside">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
        <form action="/users/create" method="POST">
            <?= csrf_field() ?>

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Nama Lengkap</label>
                <input type="text" name="nama" value="<?= old('nama') ?>"
                       class="w-full border rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600"
                       placeholder="Nama lengkap">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Username</label>
                <input type="text" name="username" value="<?= old('username') ?>"
                       class="w-full border rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600"
                       placeholder="Username unik">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Email</label>
                <input type="email" name="email" value="<?= old('email') ?>"
                       class="w-full border rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600"
                       placeholder="email@example.com">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Password</label>
                <input type="password" name="password"
                       class="w-full border rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600"
                       placeholder="Minimal 6 karakter">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold mb-1">Role</label>
                <select name="role"
                        class="w-full border rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                    <option value="">-- Pilih Role --</option>
                    <option value="admin"      <?= old('role') === 'admin'      ? 'selected' : '' ?>>Admin</option>
                    <option value="dosen"      <?= old('role') === 'dosen'      ? 'selected' : '' ?>>Dosen</option>
                    <option value="mahasiswa"  <?= old('role') === 'mahasiswa'  ? 'selected' : '' ?>>Mahasiswa</option>
                </select>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm px-6 py-2 rounded-lg transition">
                    Simpan
                </button>
                <a href="/users"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm px-6 py-2 rounded-lg transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>