<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CleanupPdfTools extends Command
{
    protected $signature = 'pdf-tools:cleanup';

    protected $description = 'Menghapus file sementara Alat PDF yang sudah kedaluwarsa (lebih dari 1 jam)';

    public function handle(): int
    {
        $dir = storage_path('app/private/pdf-tools');

        if (! is_dir($dir)) {
            $this->info('Direktori kerja belum ada, tidak ada yang dibersihkan.');

            return Command::SUCCESS;
        }

        $cutoff = now()->subHour()->timestamp;
        $removed = 0;

        foreach (array_merge(glob($dir.'/*') ?: [], glob($dir.'/.[!.]*') ?: []) as $path) {
            if (is_dir($path) && filemtime($path) < $cutoff) {
                $this->deleteDirectory($path);
                $removed++;
            }
        }

        $this->info("Pembersihan selesai: {$removed} direktori dihapus.");

        return Command::SUCCESS;
    }

    private function deleteDirectory(string $dir): void
    {
        foreach (glob($dir.'/*') as $path) {
            is_dir($path) ? $this->deleteDirectory($path) : @unlink($path);
        }

        @rmdir($dir);
    }
}
