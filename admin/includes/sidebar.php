<?php
$current_page = basename(path: $_SERVER['PHP_SELF']);

?>
<aside>
<nav class="flex-1 p-4 space-y-1 overflow-y-auto scrollbar-thin">
        <p class="px-3 mb-3 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Menu</p>

        <a href="../admin/dashboard.php"
        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 <?= $current_page === 'dashboard.php' ? 'bg-black text-white shadow-lg shadow-black/25' : 'text-zinc-400 hover:text-white hover:bg-white/5' ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 12a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1v-7z"/>
            </svg>
            Dashboard
        </a>

        <a href="../admin/products.php"
        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 <?= $current_page === 'products.php' ? 'bg-black text-white shadow-lg shadow-black/25' : 'text-zinc-400 hover:text-white hover:bg-white/5' ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            Products
        </a>
    
        <a href="../admin/users.php"
        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 <?= $current_page === 'users.php' ? 'bg-black text-white shadow-lg shadow-black/25' : 'text-zinc-400 hover:text-white hover:bg-white/5' ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            Users
        </a>
    </nav>
</aside>
