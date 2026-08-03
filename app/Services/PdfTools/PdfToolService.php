<?php

namespace App\Services\PdfTools;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use RuntimeException;

abstract class PdfToolService
{
    protected string $workDir;

    public function __construct()
    {
        $this->workDir = $this->makeWorkDir();
    }

    abstract public function process(array $files, array $options = []): array;

    protected function makeWorkDir(): string
    {
        $dir = storage_path('app/private/pdf-tools/'.Str::uuid());

        if (! is_dir($dir) && ! mkdir($dir, 0775, true) && ! is_dir($dir)) {
            throw new RuntimeException('Tidak dapat membuat direktori kerja.');
        }

        return $dir;
    }

    protected function storeUpload(UploadedFile $file): array
    {
        $path = $this->workDir.'/'.Str::uuid().'.'.$file->getClientOriginalExtension();

        $file->move($this->workDir, basename($path));

        return [
            'path' => $path,
            'name' => $file->getClientOriginalName(),
        ];
    }

    public function storeUploads(array $uploads): array
    {
        return array_map(fn (UploadedFile $file) => $this->storeUpload($file), $uploads);
    }

    protected function run(array $args, int $timeout = 300): array
    {
        $command = implode(' ', array_map('escapeshellarg', $args));

        $descriptors = [
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ];

        $process = proc_open($command, $descriptors, $pipes, $this->workDir, array_merge(getenv(), ['HOME' => $this->workDir]));

        if (! is_resource($process)) {
            throw new RuntimeException('Tidak dapat menjalankan proses konversi.');
        }

        $output = stream_get_contents($pipes[1]);
        $error = stream_get_contents($pipes[2]);

        fclose($pipes[1]);
        fclose($pipes[2]);

        $exitCode = proc_close($process);

        return [$exitCode, trim($output.$error)];
    }

    protected function gs(): string
    {
        return config('pdf-tools.gs');
    }

    protected function soffice(): string
    {
        return config('pdf-tools.soffice');
    }

    protected function pageCount(string $pdf): int
    {
        [$code, $output] = $this->run([
            $this->gs(), '-q', '-dNODISPLAY', '-c',
            '('.$pdf.') (r) file runpdfbegin pdfpagecount = quit',
        ]);

        if ($code !== 0 || ! is_numeric(trim($output))) {
            throw new RuntimeException('Tidak dapat membaca jumlah halaman PDF.');
        }

        return (int) trim($output);
    }

    protected function assertPageCount(string $pdf): void
    {
        if ($this->pageCount($pdf) > config('pdf-tools.max_pages')) {
            throw new RuntimeException('File PDF terlalu besar (maksimal '.config('pdf-tools.max_pages').' halaman).');
        }
    }

    protected function downloadName(string $original, string $suffix, string $extension): string
    {
        $base = pathinfo($original, PATHINFO_FILENAME);

        return Str::slug($base).$suffix.'.'.$extension;
    }

    public function cleanup(): void
    {
        if (is_dir($this->workDir)) {
            $this->deleteDirectory($this->workDir);
        }
    }

    protected function deleteDirectory(string $dir): void
    {
        $items = scandir($dir);

        foreach ($items as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }

            $path = $dir.'/'.$item;

            is_dir($path) ? $this->deleteDirectory($path) : @unlink($path);
        }

        @rmdir($dir);
    }
}
