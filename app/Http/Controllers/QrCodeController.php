<?php

namespace App\Http\Controllers;

use App\Models\QrCode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QrCodeFacade;

class QrCodeController extends Controller
{
    public function index(): View
    {
        $qrCodes = QrCode::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('qrcode.index', compact('qrCodes'));
    }

    public function create(): View
    {
        return view('qrcode.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:5000'],
            'type' => ['required', 'string', 'in:text,url,email,phone,sms'],
            'foreground_color' => ['required', 'string', 'max:7'],
            'background_color' => ['required', 'string', 'max:7'],
            'size' => ['required', 'integer', 'min:100', 'max:1000'],
            'format' => ['required', 'string', 'in:png,svg'],
        ]);

        $validated['user_id'] = auth()->id();

        $qrCode = QrCode::create($validated);

        $this->generateQrCodeImage($qrCode);

        return redirect()->route('qrcode.show', $qrCode)
            ->with('success', 'QR Code berhasil dibuat!');
    }

    public function show(QrCode $qrcode): View
    {
        abort_if($qrcode->user_id !== auth()->id(), 403);

        return view('qrcode.show', compact('qrcode'));
    }

    public function edit(QrCode $qrcode): View
    {
        if ($qrcode->user_id !== auth()->id()) {
            abort(403);
        }

        return view('qrcode.edit', compact('qrcode'));
    }

    public function update(Request $request, QrCode $qrcode): RedirectResponse
    {
        if ($qrcode->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:5000'],
            'type' => ['required', 'string', 'in:text,url,email,phone,sms'],
            'foreground_color' => ['required', 'string', 'max:7'],
            'background_color' => ['required', 'string', 'max:7'],
            'size' => ['required', 'integer', 'min:100', 'max:1000'],
            'format' => ['required', 'string', 'in:png,svg'],
        ]);

        $qrcode->update($validated);

        if ($qrcode->filename && Storage::disk('public')->exists($qrcode->filename)) {
            Storage::disk('public')->delete($qrcode->filename);
        }

        $this->generateQrCodeImage($qrcode);

        return redirect()->route('qrcode.show', $qrcode)
            ->with('success', 'QR Code berhasil diperbarui!');
    }

    public function destroy(QrCode $qrcode): RedirectResponse
    {
        if ($qrcode->user_id !== auth()->id()) {
            abort(403);
        }

        if ($qrcode->filename && Storage::disk('public')->exists($qrcode->filename)) {
            Storage::disk('public')->delete($qrcode->filename);
        }

        $qrcode->delete();

        return redirect()->route('qrcode.index')
            ->with('success', 'QR Code berhasil dihapus!');
    }

    public function download(QrCode $qrcode): \Illuminate\Http\Response
    {
        if ($qrcode->user_id !== auth()->id()) {
            abort(403);
        }

        if (!$qrcode->filename || !Storage::disk('public')->exists($qrcode->filename)) {
            $this->generateQrCodeImage($qrcode);
        }

        $filePath = Storage::disk('public')->path($qrcode->filename);
        $extension = $qrcode->format === 'svg' ? 'svg' : 'png';

        return response()->file($filePath, [
            'Content-Type' => $qrcode->format === 'svg' ? 'image/svg+xml' : 'image/png',
            'Content-Disposition' => 'attachment; filename="' . $qrcode->title . '.' . $extension . '"',
        ]);
    }

    private function generateQrCodeImage(QrCode $qrcode): void
    {
        $qr = QrCodeFacade::format($qrcode->format === 'svg' ? 'svg' : 'png')
            ->size($qrcode->size)
            ->color(
                hexdec(substr($qrcode->foreground_color, 1, 2)),
                hexdec(substr($qrcode->foreground_color, 3, 2)),
                hexdec(substr($qrcode->foreground_color, 5, 2))
            )
            ->backgroundColor(
                hexdec(substr($qrcode->background_color, 1, 2)),
                hexdec(substr($qrcode->background_color, 3, 2)),
                hexdec(substr($qrcode->background_color, 5, 2))
            );

        $image = $qr->generate($qrcode->content);

        $filename = 'qrcodes/' . $qrcode->id . '_' . time() . '.' . $qrcode->format;

        Storage::disk('public')->put($filename, $image);

        $qrcode->update(['filename' => $filename]);
    }
}
