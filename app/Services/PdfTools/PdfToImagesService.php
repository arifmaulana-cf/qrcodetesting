<?php

namespace App\Services\PdfTools;

use RuntimeException;
use ZipArchive;

class PdfToImagesService extends PdfToolService
{
    private const DEVICES = [
        'jpg' => 'jpeg',
        'png' => 'png16m',
    ];

    private const RESOLUTIONS = [96, 150, 300];

    public function process(array $files, array $options = []): array
    {
        $input = $files[0]['path'];

        $this->assertPageCount($input);

        $format = $options['format'] ?? 'jpg';
        $resolution = (int) ($options['resolution'] ?? 150);

        if (! isset(self::DEVICES[$format])) {
            throw new RuntimeException('Format gambar tidak valid.');
        }

        if (! in_array($resolution, self::RESOLUTIONS, true)) {
            throw new RuntimeException('Resolusi tidak valid.');
        }

        $pattern = $this->workDir.'/halaman-%03d.'.($format === 'jpg' ? 'jpg' : 'png');

        [$code, $stderr] = $this->run([
            $this->gs(),
            '-sDEVICE='.self::DEVICES[$format],
            '-r'.$resolution,
            '-dNOPAUSE',
            '-dBATCH',
            '-dQUIET',
            '-dSAFER',
            '-sOutputFile='.$pattern,
            $input,
        ]);

        if ($code !== 0) {
            throw new RuntimeException('Konversi PDF ke gambar gagal. '.$stderr);
        }

        $images = glob($this->workDir.'/halaman-*.'.$format);

        if (empty($images)) {
            throw new RuntimeException('Tidak ada gambar yang dihasilkan.');
        }

        $zipPath = $this->workDir.'/images.zip';
        $zip = new ZipArchive();

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new RuntimeException('Tidak dapat membuat file ZIP.');
        }

        foreach ($images as $image) {
            $zip->addFile($image, basename($image));
        }

        $zip->close();

        return [
            'path' => $zipPath,
            'name' => $this->downloadName($files[0]['name'], '-gambar', 'zip'),
        ];
    }
}
