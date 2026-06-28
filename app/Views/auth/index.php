<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — PRETEND</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-950 to-indigo-900 flex items-center justify-center">

    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-8">

        <!-- Logo / Judul -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-indigo-800 tracking-wide">PRETEND</h1>
            <p class="text-gray-500 text-sm mt-1">Presence & Attendance System</p>
        </div>

        <!-- Tampilkan error kalau ada -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <!-- Form Login -->
        <form action="/login" method="POST">
            <?= csrf_field() ?>  <!-- keamanan: cegah serangan CSRF -->

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-1">
                    Username / Email
                </label>
                <input
                    type="text"
                    name="username"
                    placeholder="Masukkan username atau email"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm"
                    required
                >
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-semibold mb-1">
                    Password
                </label>
                <input
                    type="password"
                    name="password"
                    placeholder="Masukkan password"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm"
                    required
                >
            </div>

            <button
                type="submit"
                class="w-full bg-indigo-700 hover:bg-indigo-800 text-white font-bold py-2 rounded-lg transition duration-200"
            >
                Masuk
            </button>
        </form>

        <p class="text-center text-gray-400 text-xs mt-6">version 1.0 — PRETEND © 2025</p>
    </div>

</body>
</html>