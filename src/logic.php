<?php
require_once 'db.php';

// 1. Inputs: Year and Month
$selectedYear = isset($_GET['year']) ? (int)$_GET['year'] : 2026;
$selectedMonth = isset($_GET['month']) ? $_GET['month'] : null;

// 2. Fetch Years for Dropdown
$availableYears = $pdo->query("SELECT DISTINCT YEAR(record_date) as yr FROM macro_indicators ORDER BY yr DESC")->fetchAll(PDO::FETCH_COLUMN);

// 3. Fetch all records for the selected YEAR
$stmt = $pdo->prepare("SELECT * FROM macro_indicators WHERE YEAR(record_date) = ? ORDER BY record_date ASC");
$stmt->execute([$selectedYear]);
$history = $stmt->fetchAll();

// 4. Determine Active Month Record
if (!$selectedMonth && !empty($history)) {
    $current = end($history);
} else {
    foreach ($history as $row) {
        if ($row['record_date'] == $selectedMonth) { $current = $row; break; }
    }
}
if(!$current && !empty($history)) $current = end($history);

// 5. Comparison Logic (MoM)
$prevIndex = -1;
foreach ($history as $index => $row) {
    if ($row['record_date'] == $current['record_date']) { $prevIndex = $index - 1; break; }
}
$previous = ($prevIndex >= 0) ? $history[$prevIndex] : $current;

$infChange = $current['inflation_rate'] - $previous['inflation_rate'];
$usdDiff = $current['exchange_rate_usd'] - $previous['exchange_rate_usd'];

// 6. Global History for Forecasting
$fullHistory = $pdo->query("SELECT inflation_rate, exchange_rate_usd FROM macro_indicators ORDER BY record_date ASC")->fetchAll();
$globalInflation = array_column($fullHistory, 'inflation_rate');
$globalFX = array_column($fullHistory, 'exchange_rate_usd');

// 7. Live Currency Logic
function getLiveRates() {
    $apiKey = '0d96684ba696089ae1324d4b';
    $url = "https://v6.exchangerate-api.com/v6/0d96684ba696089ae1324d4b/latest/USD";
    $res = @file_get_contents($url);
    if($res) {
        $d = json_decode($res, true)['conversion_rates'];
        return ['USD' => $d['GHS'], 'GBP' => $d['GHS'] / $d['GBP'], 'EUR' => $d['GHS'] / $d['EUR']];
    }
    return ['USD' => 15.80, 'GBP' => 20.10, 'EUR' => 17.20]; // Factual mid-2024 fallbacks
}
$liveRates = getLiveRates();

// 8. Statie's Factual Storyteller (2016-2026)
function getYearlyStory($year) {
    $stories = [
        2016 => "A period of fiscal strain. The 'Dumsor' energy crisis hit manufacturing hard, while election-year spending kept inflation high at 15.4%.",
        2017 => "The Rebound. Sankofa oil fields boosted GDP to a staggering 8.1%. The new government launched 'Free SHS' and began fiscal consolidation.",
        2018 => "The Banking Cleanup. The Central Bank consolidated the financial sector, license revocations restored trust, and inflation hit single digits.",
        2019 => "Year of Return. Tourism and services boomed. Ghana successfully exited its IMF program with a record $6.5% GDP growth rate.",
        2020 => "The COVID-19 Shock. Growth stalled to 0.4% as lockdowns froze trade. Emergency spending pushed the debt-to-GDP ratio toward 76%.",
        2021 => "Fragile Recovery. Global supply chain disruptions began driving food inflation back to 12.6% as the Cedi started feeling pressure.",
        2022 => "The Macro Crisis. External shocks and credit downgrades triggered a Cedi freefall. Inflation peaked at a historic 54.1% by December.",
        2023 => "IMF Stabilization. Ghana secured a $3bn ECF deal. The Domestic Debt Exchange Program (DDEP) was launched to restore sustainability.",
        2024 => "Election Year Resilience. Gold and Cocoa exports remained strong. Fiscal discipline was maintained despite election-cycle currency pressure.",
        2025 => "The Great Cooling. Inflation returned to single-digit bands (8.2%) as the Central Bank's tight monetary policy finally stabilized the Cedi.",
        2026 => "The Golden Reset. Ghana enters a sustainable growth era. Projections show 6.5% growth and a stabilized currency exchange environment."
    ];
    return $stories[$year] ?? "During $year, the economy showed resilience amidst fluctuating global commodity prices.";
}
$statieFactual = getYearlyStory($selectedYear);