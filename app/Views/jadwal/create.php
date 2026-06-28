<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Tambah Kelas<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="max-w-xl">
    <h3 class="text-xl font-bold mb-6">Tambah Kelas Baru</h3>

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
        <form action="/jadwal/create" method="POST">
            <?= csrf_field() ?>

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Nama Kelas</label>
                <input type="text" name="nama_kelas" value="<?= old('nama_kelas') ?>"
                       class="w-full border rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600"
                       placeholder="Contoh: Pemrograman Web A">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Dosen Pengampu</label>
                <select name="id_dosen"
                        class="w-full border rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                    <option value="">-- Pilih Dosen --</option>
                    <?php foreach ($dosen as $d): ?>
                        <option value="<?= $d['id_user'] ?>"
                            <?= old('id_dosen') == $d['id_user'] ? 'selected' : '' ?>>
                            <?= esc($d['nama']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Hari</label>
                <select name="hari"
                        class="w-full border rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                    <option value="">-- Pilih Hari --</option>
                    <?php foreach (['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $h): ?>
                        <option value="<?= $h ?>" <?= old('hari') === $h ? 'selected' : '' ?>>
                            <?= $h ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-semibold mb-1">Jam Mulai</label>
                    <input type="time" name="jam_mulai" value="<?= old('jam_mulai') ?>"
                           class="w-full border rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Jam Selesai</label>
                    <input type="time" name="jam_selesai" value="<?= old('jam_selesai') ?>"
                           class="w-full border rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm px-6 py-2 rounded-lg transition">
                    Simpan
                </button>
                <a href="/jadwal"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm px-6 py-2 rounded-lg transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>