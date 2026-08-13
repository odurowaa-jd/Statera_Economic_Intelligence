<!-- sidebar.php -->
<nav class="fixed bottom-0 left-0 right-0 lg:relative lg:w-72 bg-slate-950 border-t lg:border-t-0 lg:border-r border-slate-800 p-4 lg:p-8 z-[100] flex lg:flex-col justify-around lg:justify-start">
    
    <!-- Branding: Now consistently open on all pages -->
    <div class="hidden lg:flex items-center gap-3 mb-12">
        <div class="h-10 w-10 bg-emerald-500 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/20">
            <i data-lucide="bar-chart-3" class="text-white"></i>
        </div>
        <h1 class="text-2xl font-bold tracking-tighter text-white">Statera<span class="text-emerald-500">.</span></h1>
    </div>
    
    <ul class="flex lg:flex-col gap-2 lg:gap-4 w-full">
        <li class="w-full">
            <a href="index.php" class="flex flex-col lg:flex-row items-center gap-4 p-3 rounded-xl transition-all <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'text-emerald-400 bg-emerald-500/10 border border-emerald-500/20' : 'text-slate-400 hover:text-white'; ?>">
                <i data-lucide="layout-grid" size="20"></i> 
                <span class="text-[10px] lg:text-sm font-bold uppercase tracking-widest">Overview</span>
            </a>
        </li>

        <li class="w-full">
            <a href="vault.php" class="flex flex-col lg:flex-row items-center gap-4 p-3 rounded-xl transition-all <?php echo basename($_SERVER['PHP_SELF']) == 'vault.php' ? 'text-emerald-400 bg-emerald-500/10 border border-emerald-500/20' : 'text-slate-400 hover:text-white'; ?>">
                <i data-lucide="database" size="20"></i> 
                <span class="text-[10px] lg:text-sm font-bold uppercase tracking-widest">Data Vault</span>
            </a>
        </li>

        <li class="w-full">
            <a href="forecasting.php" class="flex flex-col lg:flex-row items-center gap-4 p-3 rounded-xl transition-all <?php echo basename($_SERVER['PHP_SELF']) == 'forecasting.php' ? 'text-emerald-400 bg-emerald-500/10 border border-emerald-500/20' : 'text-slate-400 hover:text-white'; ?>">
                <i data-lucide="trending-up" size="20"></i> 
                <span class="text-[10px] lg:text-sm font-bold uppercase tracking-widest">Forecast</span>
            </a>
        </li>

        <li class="w-full">
            <a href="export.php" class="flex flex-col lg:flex-row items-center gap-4 p-3 rounded-xl transition-all text-rose-400 hover:bg-rose-500/10">
                <i data-lucide="download" size="20"></i> 
                <span class="text-[10px] lg:text-sm font-bold uppercase tracking-widest">Export</span>
            </a>
        </li>
    </ul>
</nav>