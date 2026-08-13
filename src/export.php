<?php
require_once 'db.php';
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=statera_economic_data.csv');

$output = fopen('php://output', 'w');
fputcsv($output, array('ID', 'Date', 'Inflation Rate (%)', 'Exchange Rate (USD/GHS)', 'GDP Growth (%)', 'Notes'));

$stmt = $pdo->query("SELECT id, record_date, inflation_rate, exchange_rate_usd, gdp_growth, notes FROM macro_indicators ORDER BY record_date DESC");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, $row);
}
fclose($output);
?>