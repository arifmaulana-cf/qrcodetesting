<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Database;
use App\QRGenerator;

$dotenv = file_get_contents(__DIR__ . '/../.env');
foreach (explode("\n", $dotenv) as $line) {
    $line = trim($line);
    if ($line === '' || str_starts_with($line, '#')) continue;
    [$key, $value] = explode('=', $line, 2);
    $_ENV[trim($key)] = trim($value);
}

$qrPath = null;
$inputText = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['text'])) {
    $inputText = htmlspecialchars($_POST['text'], ENT_QUOTES, 'UTF-8');

    $generator = new QRGenerator(__DIR__ . '/../storage/qrcodes');
    $fileName  = $generator->generate($_POST['text']);

    $db = Database::getInstance();
    $db->insertLog($_POST['text'], $fileName, $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0');

    $qrPath = 'storage/qrcodes/' . $fileName;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Text to QR Code</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .card {
            background: #fff;
            border-radius: 16px;
            padding: 40px;
            max-width: 520px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            text-align: center;
        }
        h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 8px;
        }
        p.sub {
            color: #777;
            margin-bottom: 28px;
        }
        textarea {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 16px;
            resize: vertical;
            min-height: 100px;
            transition: border-color 0.2s;
        }
        textarea:focus {
            outline: none;
            border-color: #667eea;
        }
        button {
            margin-top: 16px;
            background: #667eea;
            color: #fff;
            border: none;
            padding: 14px 32px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }
        button:hover { background: #5a6fd6; }
        .result { margin-top: 24px; }
        .result img {
            max-width: 100%;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .result p { margin-top: 12px; color: #555; word-break: break-all; }
        .error { color: #e74c3c; margin-top: 12px; }
    </style>
</head>
<body>
    <div class="card">
        <h1>QR Code Generator</h1>
        <p class="sub">Masukkan teks untuk diubah menjadi QR Code</p>

        <form method="post">
            <textarea name="text" placeholder="Tulis teks atau URL di sini..."><?= htmlspecialchars($inputText) ?></textarea>
            <button type="submit">Generate QR Code</button>
        </form>

        <?php if ($qrPath): ?>
            <div class="result">
                <img src="<?= $qrPath ?>" alt="QR Code untuk: <?= htmlspecialchars($inputText) ?>">
                <p>Teks: <strong><?= htmlspecialchars($inputText) ?></strong></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
