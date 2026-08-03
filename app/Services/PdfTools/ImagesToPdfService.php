<?php

namespace App\Services\PdfTools;

use RuntimeException;

class ImagesToPdfService extends PdfToolService
{
    public function process(array $files, array $options = []): array
    {
        $orientation = ($options['orientation'] ?? 'auto') === 'landscape' ? 'L' : 'P';

        $pdf = new \FPDF($orientation, 'mm', 'A4');

        foreach ($files as $file) {
            $this->addImage($pdf, $file['path'], $orientation);
        }

        $output = $this->workDir.'/images.pdf';

        $pdf->Output('F', $output);

        return [
            'path' => $output,
            'name' => 'gambar-'.now()->format('Ymd-His').'.pdf',
        ];
    }

    private function addImage(\FPDF $pdf, string $path, string $orientation): void
    {
        $info = @getimagesize($path);

        if ($info === false) {
            throw new RuntimeException('File gambar tidak valid: '.basename($path));
        }

        [$widthPx, $heightPx, $type] = $info;

        $allowed = [IMAGETYPE_JPEG, IMAGETYPE_PNG];

        if (! in_array($type, $allowed, true)) {
            throw new RuntimeException('Format gambar tidak didukung: '.basename($path).' (hanya JPG/PNG).');
        }

        $pageW = $pdf->GetPageWidth();
        $pageH = $pdf->GetPageHeight();

        $ratio = $widthPx / $heightPx;

        if ($ratio >= 1) {
            $w = $pageW - 20;
            $h = $w / $ratio;
        } else {
            $h = $pageH - 20;
            $w = $h * $ratio;
        }

        if ($h > $pageH - 20) {
            $h = $pageH - 20;
            $w = $h * $ratio;
        }

        $pdf->AddPage();
        $pdf->Image($path, ($pageW - $w) / 2, ($pageH - $h) / 2, $w, $h);
    }
}
