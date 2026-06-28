<!DOCTYPE html>
<html lang="id" x-data="{ 
    sidebarOpen: true,
    dark: localStorage.getItem('theme') === 'dark',
    init() {
        this.$watch('dark', val => localStorage.setItem('theme', val ? 'dark' : 'light'))
    }
}" 
:class="{ 'dark': dark }"
@toggle-dark.window="dark = !dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRETEND — <?= $this->renderSection('title') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100 flex h-screen overflow-hidden">

    <!-- SIDEBAR -->
    <aside :class="sidebarOpen ? 'w-64' : 'w-16'"
           class="bg-indigo-900 dark:bg-gray-800 text-white flex flex-col transition-all duration-300 ease-in-out">

        <!-- Logo -->
        <div class="flex items-center justify-between px-4 py-5 border-b border-indigo-700">
            <span x-show="sidebarOpen" class="text-xl font-bold tracking-widest">PRETEND</span>
            <button @click="sidebarOpen = !sidebarOpen" class="text-white focus:outline-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        <!-- Menu -->
        <nav class="flex-1 px-2 py-4 space-y-1">

            <!-- Dashboard -->
            <a href="/dashboard"
               class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-indigo-700 transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6"/>
                </svg>
                <span x-show="sidebarOpen" class="text-sm">Dashboard</span>
            </a>

            <!-- Presensi -->
            <a href="/presensi"
               class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-indigo-700 transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2
                             M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <span x-show="sidebarOpen" class="text-sm">Presensi</span>
            </a>

            <!-- Jadwal (Dosen & Admin) -->
            <?php if (in_array(session()->get('role'), ['admin', 'dosen'])): ?>
            <a href="/jadwal"
               class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-indigo-700 transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7
                             a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span x-show="sidebarOpen" class="text-sm">Jadwal / Kelas</span>
            </a>
            <?php endif; ?>

            <!-- Manajemen User (Admin only) -->
            <?php if (session()->get('role') === 'admin'): ?>
            <a href="/users"
               class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-indigo-700 transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 20h5v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2h5
                             M12 12a4 4 0 100-8 4 4 0 000 8z"/>
                </svg>
                <span x-show="sidebarOpen" class="text-sm">Manajemen User</span>
            </a>
            <?php endif; ?>

            <!-- Laporan (Dosen & Admin) -->
            <?php if (in_array(session()->get('role'), ['admin', 'dosen'])): ?>
            <a href="/laporan"
               class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-indigo-700 transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 17v-2m3 2v-4m3 4v-6M4 20h16a1 1 0 001-1V5
                             a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/>
                </svg>
                <span x-show="sidebarOpen" class="text-sm">Laporan / Rekap</span>
            </a>
            <?php endif; ?>

        </nav>

        <!-- Versi Aplikasi -->
        <div class="px-4 py-3 border-t border-indigo-700">
            <span x-show="sidebarOpen" class="text-xs text-indigo-300">Version 1.0.0</span>
            <span x-show="!sidebarOpen" class="text-xs text-indigo-300">v1</span>
        </div>
    </aside>

    <!-- MAIN AREA -->
    <div class="flex-1 flex flex-col overflow-hidden">

        <!-- TOPBAR -->
        <header class="bg-white dark:bg-gray-800 shadow px-6 py-3 flex items-center justify-between">
            <h2 class="text-lg font-semibold"><?= $this->renderSection('title') ?></h2>

            <!-- Profile Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open"
                        class="flex items-center gap-2 hover:bg-gray-100 dark:hover:bg-gray-700 px-3 py-2 rounded-lg transition">
                    <div class="w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center text-white text-sm font-bold">
                        <?= strtoupper(substr(session()->get('nama'), 0, 1)) ?>
                    </div>
                    <span class="text-sm font-medium"><?= session()->get('nama') ?></span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open" @click.away="open = false"
                     class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 rounded-lg shadow-lg z-50 py-1">

                    <a href="/profile"
                       class="flex items-center gap-2 px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                        👤 Profile
                    </a>

                    <button @click="dark = !dark"
                            class="w-full flex items-center gap-2 px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                        🌙 Tema
                    </button>

                    <hr class="my-1 border-gray-200 dark:border-gray-600">

                    <a href="/logout"
                       class="flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-gray-600">
                        🚪 Logout
                    </a>
                </div>
            </div>
        </header>

        <!-- CONTENT AREA -->
        <main class="flex-1 overflow-y-auto p-6">
            <?= $this->renderSection('content') ?>
        </main>

    </div>

</body>
</html>