<?php

namespace App\Services\PdfTools;

use RuntimeException;
use setasign\Fpdi\Fpdi;

class SplitPdfService extends PdfToolService
{
    public function process(array $files, array $options = []): array
    {
        $input = $files[0]['path'];

        $this->assertPageCount($input);

        $pdf = new Fpdi();
        $totalPages = $pdf->setSourceFile($input);
        $pages = $this->parseRanges($options['pages'] ?? '', $totalPages);

        foreach ($pages as $page) {
            $template = $pdf->importPage($page);
            $size = $pdf->getTemplateSize($template);

            $pdf->AddPage($size['orientation'] === 'L' ? 'L' : 'P', [$size['width'], $size['height']]);
            $pdf->useTemplate($template);
        }

        $output = $this->workDir.'/split.pdf';

        $pdf->Output('F', $output);

        return [
            'path' => $output,
            'name' => $this->downloadName($files[0]['name'], '-bagian', 'pdf'),
        ];
    }

    private function parseRanges(string $input, int $max): array
    {
        $input = trim($input);

        if ($input === '') {
            throw new RuntimeException('Silakan masukkan rentang halaman yang ingin diekstrak.');
        }

        $pages = [];

        foreach (explode(',', $input) as $part) {
            $part = trim($part);

            if (preg_match('/^(\d+)\s*-\s*(\d+)$/', $part, $m)) {
                $start = max(1, (int) $m[1]);
                $end = min((int) $m[2], $max);

                for ($i = $start; $i <= $end; $i++) {
                    $pages[] = $i;
                }
            } elseif (ctype_digit($part)) {
                $page = (int) $part;

                if ($page >= 1 && $page <= $max) {
                    $pages[] = $page;
                }
            } else {
                throw new RuntimeException('Format rentang halaman tidak valid. Contoh: 1-3, 5, 8');
            }
        }

        $pages = array_values(array_unique($pages));

        if (empty($pages)) {
            throw new RuntimeException('Tidak ada halaman valid yang dipilih.');
        }

        return $pages;
    }
}
