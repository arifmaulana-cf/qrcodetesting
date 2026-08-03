<?php

namespace App\Services\PdfTools;

use RuntimeException;
use setasign\Fpdi\Fpdi;

class RotatePdfService extends PdfToolService
{
    public function process(array $files, array $options = []): array
    {
        $input = $files[0]['path'];
        $angle = (int) ($options['angle'] ?? 90);

        if (! in_array($angle, [90, 180, 270], true)) {
            throw new RuntimeException('Sudut putar tidak valid.');
        }

        $this->assertPageCount($input);

        $pdf = new RotatedFpdi();
        $totalPages = $pdf->setSourceFile($input);

        for ($page = 1; $page <= $totalPages; $page++) {
            $template = $pdf->importPage($page);
            $size = $pdf->getTemplateSize($template);

            if ($angle === 90 || $angle === 270) {
                $w = $size['height'];
                $h = $size['width'];

                $pdf->AddPage('P', [$w, $h]);
                $pdf->Rotate($angle, $w / 2, $h / 2);
                $pdf->useTemplate($template, ($w - $size['width']) / 2, ($h - $size['height']) / 2, $size['width'], $size['height']);
            } else {
                $pdf->AddPage($size['orientation'] === 'L' ? 'L' : 'P', [$size['width'], $size['height']]);
                $pdf->Rotate($angle, $size['width'] / 2, $size['height'] / 2);
                $pdf->useTemplate($template, 0, 0, $size['width'], $size['height']);
            }

            $pdf->Rotate(0);
        }

        $output = $this->workDir.'/rotated.pdf';

        $pdf->Output('F', $output);

        return [
            'path' => $output,
            'name' => $this->downloadName($files[0]['name'], '-diputar'.$angle, 'pdf'),
        ];
    }
}
