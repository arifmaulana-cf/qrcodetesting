<?php

namespace App\Services\PdfTools;

use RuntimeException;

class CompressPdfService extends PdfToolService
{
    private const SETTINGS = [
        'screen' => '/screen',
        'ebook' => '/ebook',
        'printer' => '/printer',
    ];

    public function process(array $files, array $options = []): array
    {
        $input = $files[0]['path'];

        $this->assertPageCount($input);

        $level = $options['quality'] ?? 'ebook';

        if (! isset(self::SETTINGS[$level])) {
            throw new RuntimeException('Level kompresi tidak valid.');
        }

        $output = $this->workDir.'/compressed.pdf';

        [$code, $stderr] = $this->run([
            $this->gs(),
            '-sDEVICE=pdfwrite',
            '-dCompatibilityLevel=1.4',
            '-dPDFSETTINGS='.self::SETTINGS[$level],
            '-dNOPAUSE',
            '-dBATCH',
            '-dQUIET',
            '-sOutputFile='.$output,
            $input,
        ]);

        if ($code !== 0 || ! is_file($output)) {
            throw new RuntimeException('Kompresi PDF gagal. '.$stderr);
        }

        return [
            'path' => $output,
            'name' => $this->downloadName($files[0]['name'], '-terkompres', 'pdf'),
        ];
    }
}
