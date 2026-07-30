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

$db = Database::getInstance();
$history = $db->getHistory(20);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Text to QR Code</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 min-h-screen py-8 px-4">
    <div class="max-w-2xl mx-auto space-y-6">

        <div class="bg-white rounded-2xl shadow-2xl p-8 text-center">
            <h1 class="text-3xl font-bold text-gray-800">QR Code Generator</h1>
            <p class="text-gray-500 mt-1 mb-6">Masukkan teks untuk diubah menjadi QR Code</p>

            <form method="post">
                <textarea name="text" rows="4"
                    class="w-full border-2 border-gray-200 rounded-xl p-4 text-gray-700 focus:border-indigo-400 focus:ring focus:ring-indigo-200 transition resize-none"
                    placeholder="Tulis teks atau URL di sini..."><?= htmlspecialchars($inputText) ?></textarea>
                <button type="submit"
                    class="mt-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-8 rounded-xl transition shadow-lg hover:shadow-indigo-300">
                    Generate QR Code
                </button>
            </form>

            <?php if ($qrPath): ?>
            <div class="mt-8 pt-6 border-t border-gray-100">
                <img src="<?= $qrPath ?>" alt="QR Code"
                    class="mx-auto rounded-xl shadow-lg w-48 h-48 object-cover">
                <p class="mt-3 text-gray-600 text-sm break-all">
                    Teks: <span class="font-semibold text-gray-800"><?= htmlspecialchars($inputText) ?></span>
                </p>
            </div>
            <?php endif; ?>
        </div>

        <?php if (count($history) > 0): ?>
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <h2 class="text-xl font-bold text-gray-800 mb-1">Riwayat QR Code</h2>
            <p class="text-gray-400 text-sm mb-5">20 generate terakhir</p>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                <?php foreach ($history as $row): ?>
                <div class="bg-gray-50 rounded-xl p-3 border border-gray-100 hover:shadow-lg transition group">
                    <a href="storage/qrcodes/<?= htmlspecialchars($row['file_name']) ?>" target="_blank">
                        <img src="storage/qrcodes/<?= htmlspecialchars($row['file_name']) ?>"
                            alt="QR"
                            class="w-full aspect-square rounded-lg object-cover">
                    </a>
                    <p class="mt-2 text-xs text-gray-500 truncate" title="<?= htmlspecialchars($row['input_text']) ?>">
                        <?= htmlspecialchars($row['input_text']) ?>
                    </p>
                    <p class="text-[10px] text-gray-400">
                        <?= date('d/m/Y H:i', strtotime($row['created_at'])) ?>
                    </p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

    </div>
</body>
</html>
