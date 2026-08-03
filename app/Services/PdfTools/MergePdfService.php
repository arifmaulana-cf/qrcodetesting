<?php

namespace App\Services\PdfTools;

use RuntimeException;
use setasign\Fpdi\Fpdi;

class MergePdfService extends PdfToolService
{
    public function process(array $files, array $options = []): array
    {
        $pdf = new Fpdi();

        foreach ($files as $file) {
            $this->assertPageCount($file['path']);

            $pageCount = $pdf->setSourceFile($file['path']);

            for ($page = 1; $page <= $pageCount; $page++) {
                $template = $pdf->importPage($page);
                $size = $pdf->getTemplateSize($template);

                $pdf->AddPage($size['orientation'] === 'L' ? 'L' : 'P', [$size['width'], $size['height']]);
                $pdf->useTemplate($template);
            }
        }

        $output = $this->workDir.'/merged.pdf';

        $pdf->Output('F', $output);

        return [
            'path' => $output,
            'name' => 'gabungan-'.now()->format('Ymd-His').'.pdf',
        ];
    }
}
