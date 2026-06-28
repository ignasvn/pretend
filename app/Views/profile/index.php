<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Profile<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="max-w-xl">
    <h3 class="text-xl font-bold mb-6">Profile Saya</h3>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-sm">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">

        <!-- Avatar -->
        <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-100 dark:border-gray-700">
            <div class="w-16 h-16 bg-indigo-600 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                <?= strtoupper(substr($user['nama'], 0, 1)) ?>
            </div>
            <div>
                <h4 class="text-lg font-bold"><?= esc($user['nama']) ?></h4>
                <span class="text-xs px-2 py-1 rounded-full font-semibold
                    <?= $user['role'] === 'admin' ? 'bg-red-100 text-red-600' :
                       ($user['role'] === 'dosen' ? 'bg-blue-100 text-blue-600' :
                        'bg-green-100 text-green-600') ?>">
                    <?= ucfirst($user['role']) ?>
                </span>
            </div>
        </div>

        <!-- Info -->
        <div class="space-y-4">
            <div>
                <p class="text-xs text-gray-400 mb-1">Nama Lengkap</p>
                <p class="font-medium"><?= esc($user['nama']) ?></p>
            </div>
            <div>
                <p class="text-xs text-gray-400 mb-1">Username</p>
                <p class="font-medium"><?= esc($user['username']) ?></p>
            </div>
            <div>
                <p class="text-xs text-gray-400 mb-1">Email</p>
                <p class="font-medium"><?= esc($user['email']) ?></p>
            </div>
            <div>
                <p class="text-xs text-gray-400 mb-1">Bergabung Sejak</p>
                <p class="font-medium"><?= date('d F Y', strtotime($user['created_at'])) ?></p>
            </div>
        </div>

        <!-- Tombol Edit -->
        <div class="mt-6 pt-6 border-t border-gray-100 dark:border-gray-700">
            <a href="/profile/edit"
               class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm px-6 py-2 rounded-lg transition">
                Edit Profile
            </a>
        </div>
    </div>

    <!-- Settings Card -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 mt-4">
        <h4 class="font-bold mb-4">Pengaturan Tampilan</h4>
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium">Tema Gelap</p>
                <p class="text-xs text-gray-400">Ubah tampilan aplikasi</p>
            </div>
            <!-- Toggle dark mode pakai Alpine dari layout -->
            <button x-data @click="$dispatch('toggle-dark')"
                    class="w-12 h-6 bg-gray-300 dark:bg-indigo-600 rounded-full relative transition-colors duration-300">
                <span class="absolute top-1 left-1 dark:left-7 w-4 h-4 bg-white rounded-full transition-all duration-300"></span>
            </button>
        </div>
    </div>
</div>

<?= $this->endSection() ?>