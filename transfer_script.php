<?php
echo "=== Transfer Data MySQL -> Vercel PostgreSQL ===\n\n";

// Connect to local MySQL
try {
    $mysql = new PDO('mysql:host=127.0.0.1;dbname=porto;charset=utf8mb4', 'root', '');
    $mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "[OK] Connected to local MySQL\n";
} catch (Exception $e) {
    echo "[ERROR] Cannot connect to MySQL: " . $e->getMessage() . "\n";
    exit(1);
}

// Tables to transfer
$tables = ['users', 'site_settings', 'portfolios', 'skills', 'experiences', 'social_links', 'posts'];

$data = [];
$totalRows = 0;

foreach ($tables as $table) {
    try {
        $stmt = $mysql->query("SELECT * FROM `$table`");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $data[$table] = $rows;
        $count = count($rows);
        $totalRows += $count;
        echo "[OK] $table: $count rows\n";
    } catch (Exception $e) {
        echo "[SKIP] $table: " . $e->getMessage() . "\n";
        $data[$table] = [];
    }
}

echo "\nTotal: $totalRows rows to transfer\n";
echo "Sending to Vercel...\n\n";

$json = json_encode($data, JSON_UNESCAPED_UNICODE);
echo "Payload size: " . round(strlen($json) / 1024, 1) . " KB\n";

// Send to Vercel API route (api middleware = no CSRF)
$url = 'https://ftrporto.vercel.app/import-transfer';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json',
]);
curl_setopt($ch, CURLOPT_TIMEOUT, 120);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

echo "\nHTTP Status: $httpCode\n";
if ($error) {
    echo "cURL Error: $error\n";
}
echo "Response: $response\n";

if ($httpCode === 200 && strpos($response, 'Success') !== false) {
    echo "\n✅ TRANSFER BERHASIL! Data sudah masuk ke Vercel PostgreSQL.\n";
} else {
    echo "\n❌ TRANSFER GAGAL. Periksa response di atas.\n";
}
