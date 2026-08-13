<?php 
require_once 'logic.php'; 

/**
 * SQL for the Vault:
 * We calculate the Yearly Averages and the Peak FX rate to show 
 * a high-level decade-long summary (2016-2026).
 */
$vaultStmt = $pdo->query("
    SELECT 
        YEAR(record_date) as yr, 
        AVG(inflation_rate) as avg_inf, 
        MAX(exchange_rate_usd) as peak_fx, 
        AVG(gdp_growth) as avg_gdp,
        MAX(notes) as yearly_note
    FROM macro_indicators 
    GROUP BY YEAR(record_date) 
    ORDER BY yr DESC
");
$vaultData = $vaultStmt->fetchAll();

// 10-Year Global Stats for the top cards
$tenYearInf = array_sum(array_column($vaultData, 'avg_inf')) / count($vaultData);
$historicalMax = max(array_column($vaultData, 'peak_fx'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Statera | Data Vault</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Geist'; background-color: #020617; color: #f8fafc; }
        .glass { background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.08); }
        /* Custom scrollbar for a pro look */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #020617; }
        ::-webkit-scrollbar-thumb { background: #1e293b; border-radius: 10px; }
    </style>
</head>
<body class="flex flex-col lg:flex-row min-h-screen">

    <!-- Unified Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <main class="flex-1 p-6 lg:p-12 overflow-y-auto h-screen">
        
        <!-- Header -->
        <header class="mb-12">
            <h2 class="text-4xl font-bold tracking-tighter italic font-serif">Annual Data Vault</h2>
            <p class="text-slate-500 uppercase text-xs tracking-widest mt-2">Consolidated Economic Records (2016 — 2026)</p>
        </header>

        <!-- Global Archive Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            <div class="bg-slate-900/50 border border-slate-800 p-6 rounded-3xl">
                <p class="text-slate-500 text-[10px] font-bold uppercase mb-2">Decadal Inflation Avg</p>
                <p class="text-3xl font-bold text-emerald-400"><?php echo number_format($tenYearInf, 1); ?>%</p>
            </div>
            <div class="bg-slate-900/50 border border-slate-800 p-6 rounded-3xl">
                <p class="text-slate-500 text-[10px] font-bold uppercase mb-2">Historical FX Resistance</p>
                <p class="text-3xl font-bold text-rose-400">₵<?php echo number_format($historicalMax, 2); ?></p>
            </div>
            <div class="bg-slate-900/50 border border-slate-800 p-6 rounded-3xl md:col-span-2 lg:col-span-1">
                <p class="text-slate-500 text-[10px] font-bold uppercase mb-2">Total Data Points</p>
                <p class="text-3xl font-bold text-white"><?php echo count($globalInflation); ?> Months Tracked</p>
            </div>
        </div>

        <!-- Yearly Intelligence Table -->
        <div class="glass overflow-hidden rounded-[2.5rem] border border-slate-800 shadow-2xl mb-12">
            <table class="w-full text-left">
                <thead class="bg-slate-900/80 text-[10px] text-slate-500 uppercase tracking-widest">
                    <tr>
                        <th class="p-6">Fiscal Year</th>
                        <th class="p-6">Avg Inflation</th>
                        <th class="p-6">FX Peak (USD)</th>
                        <th class="p-6">Avg GDP Growth</th>
                        <th class="p-6">Historical Insight</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    <?php foreach($vaultData as $row): ?>
                    <tr class="hover:bg-slate-800/30 transition-all group">
                        <td class="p-6 font-bold text-xl text-white"><?php echo $row['yr']; ?></td>
                        <td class="p-6 text-emerald-400 font-bold"><?php echo number_format($row['avg_inf'], 1); ?>%</td>
                        <td class="p-6 text-indigo-400 font-bold">₵<?php echo number_format($row['peak_fx'], 2); ?></td>
                        <td class="p-6 font-bold"><?php echo number_format($row['avg_gdp'], 1); ?>%</td>
                        <td class="p-6 text-slate-400 text-sm italic leading-relaxed">
                            <?php echo $row['yearly_note']; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Research Note -->
        <div class="p-8 bg-emerald-500/5 border border-emerald-500/10 rounded-3xl flex items-start gap-4">
            <div class="h-10 w-10 bg-emerald-500/20 rounded-xl flex items-center justify-center shrink-0">
                <i data-lucide="book-open" class="text-emerald-500" size="20"></i>
            </div>
            <div>
                <h4 class="font-bold text-emerald-400 mb-1">Academic Context</h4>
                <p class="text-slate-500 text-sm leading-relaxed">
                    This vault centralizes disparate economic data from the Ghana Statistical Service and the Bank of Ghana. It is designed to provide longitudinal clarity on how structural shocks (COVID-19, Energy crises) correlate with currency volatility and inflation peaks.
                </p>
            </div>
        </div>

    </main>

    <script>
        // Initialize Lucide Icons
        lucide.createIcons();
    </script>
</body>
</html>