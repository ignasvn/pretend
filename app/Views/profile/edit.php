<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Edit Profile<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="max-w-xl">
    <h3 class="text-xl font-bold mb-6">Edit Profile</h3>

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
        <form action="/profile/edit" method="POST">
            <?= csrf_field() ?>

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Nama Lengkap</label>
                <input type="text" name="nama"
                       value="<?= old('nama', $user['nama']) ?>"
                       class="w-full border rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Username</label>
                <input type="text" value="<?= esc($user['username']) ?>"
                       class="w-full border rounded-lg px-4 py-2 text-sm bg-gray-100 dark:bg-gray-600 cursor-not-allowed"
                       disabled>
                <p class="text-xs text-gray-400 mt-1">Username tidak bisa diubah.</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Email</label>
                <input type="email" name="email"
                       value="<?= old('email', $user['email']) ?>"
                       class="w-full border rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold mb-1">Password Baru</label>
                <input type="password" name="password"
                       class="w-full border rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600"
                       placeholder="Kosongkan jika tidak ingin mengubah">
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm px-6 py-2 rounded-lg transition">
                    Simpan
                </button>
                <a href="/profile"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm px-6 py-2 rounded-lg transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>