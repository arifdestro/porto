<?php
$mysql = new PDO('mysql:host=127.0.0.1;dbname=porto;charset=utf8', 'root', '');
$tables = ['users', 'site_settings', 'portfolios', 'skills', 'experiences', 'social_links', 'posts'];
$data = [];
foreach ($tables as $table) {
    $stmt = $mysql->query("SELECT * FROM $table");
    $data[$table] = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
$json = json_encode($data);
$ch = curl_init('https://ftrporto.my.id/api/import-transfer');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Content-Length: ' . strlen($json)
]);
$response = curl_exec($ch);
echo "Response: " . $response;
