<?php require_once 'logic.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><title>Statera | Home</title>
    <script src="https://cdn.tailwindcss.com"></script><script src="https://unpkg.com/lucide@latest"></script><script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Geist'; background-color: #020617; color: #f8fafc; }
        .glass { background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.08); }
        .statie-head { animation: float 3s infinite; }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
    </style>
</head>
<body class="flex flex-col lg:flex-row min-h-screen">
    <?php include 'sidebar.php'; ?>
    <main class="flex-1 p-6 lg:p-12 overflow-y-auto h-screen pb-32">
        <header class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
            <div><h2 class="text-3xl font-bold italic font-serif">Economic Intelligence</h2><p class="text-slate-500">Longitudinal Study: 2016 — 2026</p></div>
            <form action="index.php" method="GET">
                <select name="year" onchange="this.form.submit()" class="bg-slate-900 border border-slate-700 text-white px-6 py-3 rounded-2xl outline-none ring-emerald-500 focus:ring-2 cursor-pointer">
                    <?php foreach($availableYears as $yr): ?><option value="<?php echo $yr; ?>" <?php echo ($selectedYear == $yr) ? 'selected' : ''; ?>>Fiscal Year <?php echo $yr; ?></option><?php endforeach; ?>
                </select>
            </form>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <!-- Inflation Card -->
            <div class="glass p-8 rounded-[2rem]">
                <div class="flex justify-between items-start mb-6">
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">Inflation Index</p>
                    <form action="index.php" method="GET">
                        <input type="hidden" name="year" value="<?php echo $selectedYear; ?>">
                        <select name="month" onchange="this.form.submit()" class="bg-transparent text-emerald-400 text-[10px] border border-emerald-500/20 px-2 py-1 rounded">
                            <?php foreach($history as $row): ?><option value="<?php echo $row['record_date']; ?>" <?php echo ($current['record_date'] == $row['record_date']) ? 'selected' : ''; ?>><?php echo date('F', strtotime($row['record_date'])); ?></option><?php endforeach; ?>
                        </select>
                    </form>
                </div>
                <h4 class="text-5xl font-bold mb-4"><?php echo $current['inflation_rate']; ?>%</h4>
                <p class="text-[10px] font-bold <?php echo ($infChange <= 0) ? 'text-emerald-500' : 'text-rose-500'; ?>">
                    <?php echo ($infChange <= 0) ? '↓' : '↑'; ?> <?php echo abs(number_format($infChange, 2)); ?>% from last month
                </p>
            </div>

            <!-- Currency Card -->
            <div class="glass p-8 rounded-[2rem] border-l-4 border-indigo-500">
                <div class="flex justify-between items-start mb-6">
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">Cedi Rates</p>
                    <form action="index.php" method="GET">
                        <input type="hidden" name="year" value="<?php echo $selectedYear; ?>">
                        <select name="month" onchange="this.form.submit()" class="bg-transparent text-indigo-400 text-[10px] border border-indigo-500/20 px-2 py-1 rounded">
                            <?php foreach($history as $row): ?><option value="<?php echo $row['record_date']; ?>" <?php echo ($current['record_date'] == $row['record_date']) ? 'selected' : ''; ?>><?php echo date('F', strtotime($row['record_date'])); ?></option><?php endforeach; ?>
                        </select>
                    </form>
                </div>
                <div class="grid grid-cols-3 gap-2 mb-4">
                    <div><p class="text-[10px] text-slate-500">USD</p><p class="font-bold">₵<?php echo number_format($current['exchange_rate_usd'], 2); ?></p></div>
                    <div><p class="text-[10px] text-slate-500">GBP</p><p class="font-bold text-slate-400">₵<?php echo number_format($current['exchange_rate_gbp'], 2); ?></p></div>
                    <div><p class="text-[10px] text-slate-500">EUR</p><p class="font-bold text-slate-400">₵<?php echo number_format($current['exchange_rate_eur'], 2); ?></p></div>
                </div>
                <p class="text-[10px] text-slate-500 italic">Live Feed: USD/GHS ₵<?php echo number_format($liveRates['USD'], 2); ?></p>
            </div>

            <!-- GDP Card -->
            <div class="glass p-8 rounded-[2rem]">
                <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mb-6">GDP Expansion</p>
                <h4 class="text-5xl font-bold text-emerald-400 mb-4"><?php echo $current['gdp_growth']; ?>%</h4>
                <div class="w-full bg-slate-800 h-1.5 rounded-full overflow-hidden"><div class="bg-emerald-500 h-full" style="width: <?php echo ($current['gdp_growth'] * 10); ?>%"></div></div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 glass p-10 rounded-[3rem] h-[450px]"><canvas id="mainChart"></canvas></div>
            <div class="glass p-8 rounded-[3rem] h-[450px] overflow-y-auto">
                <h4 class="text-lg font-bold mb-6">Yearly Momentum</h4>
                <?php foreach($history as $row): ?>
                <div class="flex justify-between border-b border-slate-800 pb-4 mb-4">
                    <div><p class="font-bold"><?php echo date('F', strtotime($row['record_date'])); ?></p><p class="text-[10px] text-slate-500"><?php echo substr($row['notes'], 0, 40); ?>...</p></div>
                    <div class="text-right"><p class="text-emerald-400 font-bold"><?php echo $row['inflation_rate']; ?>%</p><p class="text-[10px] text-indigo-400">₵<?php echo $row['exchange_rate_usd']; ?></p></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- STATIE -->
        <div class="fixed bottom-24 lg:bottom-10 right-10 z-[120] group">
            <div id="statie-bubble" class="hidden absolute bottom-full right-0 mb-6 w-80 glass p-6 rounded-3xl text-sm border-emerald-500/30 text-emerald-100 shadow-2xl">
                <p class="font-bold text-emerald-400 mb-2 underline">Statie's Analysis for <?php echo $selectedYear; ?>:</p><?php echo $statieFactual; ?>
            </div>
            <div class="statie-head h-16 w-16 bg-emerald-500 rounded-3xl flex items-center justify-center cursor-pointer shadow-2xl" onclick="document.getElementById('statie-bubble').classList.toggle('hidden')">
                <svg width="40" height="40" viewBox="0 0 40 40"><rect x="8" y="12" width="24" height="18" rx="6" fill="white" fill-opacity="0.3"/><circle cx="15" cy="21" r="2.5" fill="white"/><circle cx="25" cy="21" r="2.5" fill="white"/><rect x="16" y="26" width="8" height="1.5" rx="1" fill="#10b981"/></svg>
            </div>
        </div>
    </main>
    <script>
        lucide.createIcons();
        new Chart(document.getElementById('mainChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: <?php echo json_encode(array_map(fn($r) => date('M', strtotime($r['record_date'])), $history)); ?>,
                datasets: [
                    { label: 'Inflation %', data: <?php echo json_encode(array_column($history, 'inflation_rate')); ?>, borderColor: '#10b981', tension: 0.4, fill: true, backgroundColor: 'rgba(16,185,129,0.05)' },
                    { label: 'USD/GHS', data: <?php echo json_encode(array_column($history, 'exchange_rate_usd')); ?>, borderColor: '#6366f1', borderDash: [5,5], tension: 0.4 }
                ]
            },
            options: { responsive: true, maintainAspectRatio: false, scales: { y: { grid: { color: 'rgba(255,255,255,0.03)' } } } }
        });
    </script>
</body>
</html>