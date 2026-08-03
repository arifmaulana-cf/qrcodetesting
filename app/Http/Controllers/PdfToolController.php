<?php

namespace App\Http\Controllers;

use App\Services\PdfTools\CompressPdfService;
use App\Services\PdfTools\ImagesToPdfService;
use App\Services\PdfTools\MergePdfService;
use App\Services\PdfTools\PdfToImagesService;
use App\Services\PdfTools\PdfToolService;
use App\Services\PdfTools\RotatePdfService;
use App\Services\PdfTools\SplitPdfService;
use App\Services\PdfTools\WordToPdfService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PdfToolController extends Controller
{
    private const SERVICES = [
        'word-to-pdf' => WordToPdfService::class,
        'merge' => MergePdfService::class,
        'split' => SplitPdfService::class,
        'compress' => CompressPdfService::class,
        'pdf-to-images' => PdfToImagesService::class,
        'images-to-pdf' => ImagesToPdfService::class,
        'rotate' => RotatePdfService::class,
    ];

    public function index()
    {
        return view('pdf-tools.index', [
            'tools' => config('pdf-tools.tools'),
        ]);
    }

    public function show(string $tool)
    {
        $key = $this->resolveKey($tool);

        return view('pdf-tools.show', [
            'tool' => config('pdf-tools.tools.'.$key),
            'key' => $key,
        ]);
    }

    public function process(Request $request, string $tool)
    {
        $key = $this->resolveKey($tool);
        $config = config('pdf-tools.tools.'.$key);

        $validated = $request->validate($this->rules($key, $config));

        $service = app(self::SERVICES[$key]);

        try {
            $uploads = $service->storeUploads($validated['files'] ?? [$validated['file']]);

            $result = $service->process($uploads, $validated);

            register_shutdown_function(fn () => $service->cleanup());

            return response()->download($result['path'], $result['name'])->deleteFileAfterSend(true);
        } catch (ValidationException $e) {
            $service->cleanup();
            throw $e;
        } catch (\Throwable $e) {
            $service->cleanup();

            throw ValidationException::withMessages(['file' => $e->getMessage()]);
        }
    }

    private function resolveKey(string $tool): string
    {
        if (! isset(self::SERVICES[$tool])) {
            abort(404);
        }

        return $tool;
    }

    private function rules(string $key, array $config): array
    {
        $maxKb = config('pdf-tools.max_size_kb');

        $base = [
            'file' => ['required_without:files', 'file', 'max:'.$maxKb, 'mimes:'.$config['mimes']],
            'files' => ['required_without:file', 'array', 'min:2', 'max:'.config('pdf-tools.max_files')],
            'files.*' => ['required', 'file', 'max:'.$maxKb, 'mimes:'.$config['mimes']],
        ];

        $extra = match ($key) {
            'word-to-pdf' => [],
            'merge' => [],
            'split' => ['pages' => ['required', 'string', 'max:100', 'regex:/^[\d,\-\s]+$/']],
            'compress' => ['quality' => ['required', 'in:screen,ebook,printer']],
            'pdf-to-images' => [
                'format' => ['required', 'in:jpg,png'],
                'resolution' => ['required', 'in:96,150,300'],
            ],
            'images-to-pdf' => [
                'orientation' => ['required', 'in:auto,landscape'],
                'files' => ['required', 'array', 'min:1', 'max:'.config('pdf-tools.max_images')],
            ],
            'rotate' => ['angle' => ['required', 'in:90,180,270']],
            default => [],
        };

        return array_merge($base, $extra);
    }
}
