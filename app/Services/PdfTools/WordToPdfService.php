<?php

namespace App\Services\PdfTools;

use RuntimeException;

class WordToPdfService extends PdfToolService
{
    public function process(array $files, array $options = []): array
    {
        $input = $files[0]['path'];
        $profile = $this->workDir.'/lo-profile';

        [$code] = $this->run([
            $this->soffice(),
            '--headless',
            '--norestore',
            '-env:UserInstallation=file://'.$profile,
            '--convert-to',
            'pdf',
            '--outdir',
            $this->workDir,
            $input,
        ]);

        $this->deleteDirectory($profile);

        $output = $this->workDir.'/'.pathinfo(basename($input), PATHINFO_FILENAME).'.pdf';

        if ($code !== 0 || ! is_file($output)) {
            throw new RuntimeException('Konversi Word ke PDF gagal. Pastikan file dokumen valid dan tidak rusak.');
        }

        return [
            'path' => $output,
            'name' => $this->downloadName($files[0]['name'], '', 'pdf'),
        ];
    }
}
