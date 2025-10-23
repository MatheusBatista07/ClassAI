<?php
// Carrega o arquivo .env para pegar a chave
require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$apiKey = $_ENV['GOOGLE_API_KEY'] ?? null;

if (!$apiKey) {
    die("<h1>ERRO CRÍTICO</h1><p>A variável GOOGLE_API_KEY não foi encontrada no seu arquivo .env. Verifique o arquivo.</p>");
}

echo "<h1>Diagnóstico da API do Google Gemini</h1>";
echo "<p>Testando com a chave de API que termina em: " . substr($apiKey, -4) . "</p><hr>";

// --- Lista de Endpoints para Testar ---
$endpoints = [
    "v1beta / gemini-1.0-pro" => 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.0-pro:generateContent?key=' . $apiKey,
    "v1 / gemini-1.5-flash-latest" => 'https://generativelanguage.googleapis.com/v1/models/gemini-1.5-flash-latest:generateContent?key=' . $apiKey,
    "v1beta / gemini-pro (antigo )" => 'https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=' . $apiKey,
];

$data = [
    'contents' => [['parts' => [['text' => 'Olá, mundo!']]]]
];

foreach ($endpoints as $name => $url ) {
    echo "<h2>Testando Endpoint: '$name'</h2>";
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Para XAMPP

    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE );
    curl_close($ch);

    if ($httpcode === 200 ) {
        echo "<p style='color:green; font-weight:bold;'>SUCESSO! (Código: $httpcode )</p>";
        echo "<p><b>Este é o endpoint que funciona!</b> Use a URL correspondente no seu UserController.php.</p>";
        echo "<p>Resposta da API:</p>";
        echo "<pre>" . htmlspecialchars($response) . "</pre>";
    } else {
        echo "<p style='color:red; font-weight:bold;'>FALHA (Código: $httpcode )</p>";
        echo "<p>Resposta da API:</p>";
        echo "<pre>" . htmlspecialchars($response) . "</pre>";
    }
    echo "<hr>";
}
