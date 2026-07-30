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

    public function show(QrCode $qrCode): View
    {
        if ($qrCode->user_id !== auth()->id()) {
            abort(403);
        }

        return view('qrcode.show', compact('qrCode'));
    }

    public function edit(QrCode $qrCode): View
    {
        if ($qrCode->user_id !== auth()->id()) {
            abort(403);
        }

        return view('qrcode.edit', compact('qrCode'));
    }

    public function update(Request $request, QrCode $qrCode): RedirectResponse
    {
        if ($qrCode->user_id !== auth()->id()) {
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

        $qrCode->update($validated);

        if ($qrCode->filename && Storage::disk('public')->exists($qrCode->filename)) {
            Storage::disk('public')->delete($qrCode->filename);
        }

        $this->generateQrCodeImage($qrCode);

        return redirect()->route('qrcode.show', $qrCode)
            ->with('success', 'QR Code berhasil diperbarui!');
    }

    public function destroy(QrCode $qrCode): RedirectResponse
    {
        if ($qrCode->user_id !== auth()->id()) {
            abort(403);
        }

        if ($qrCode->filename && Storage::disk('public')->exists($qrCode->filename)) {
            Storage::disk('public')->delete($qrCode->filename);
        }

        $qrCode->delete();

        return redirect()->route('qrcode.index')
            ->with('success', 'QR Code berhasil dihapus!');
    }

    public function download(QrCode $qrCode): \Illuminate\Http\Response
    {
        if ($qrCode->user_id !== auth()->id()) {
            abort(403);
        }

        if (!$qrCode->filename || !Storage::disk('public')->exists($qrCode->filename)) {
            $this->generateQrCodeImage($qrCode);
        }

        $filePath = Storage::disk('public')->path($qrCode->filename);
        $extension = $qrCode->format === 'svg' ? 'svg' : 'png';

        return response()->file($filePath, [
            'Content-Type' => $qrCode->format === 'svg' ? 'image/svg+xml' : 'image/png',
            'Content-Disposition' => 'attachment; filename="' . $qrCode->title . '.' . $extension . '"',
        ]);
    }

    private function generateQrCodeImage(QrCode $qrCode): void
    {
        $qr = QrCodeFacade::format($qrCode->format === 'svg' ? 'svg' : 'png')
            ->size($qrCode->size)
            ->color(
                hexdec(substr($qrCode->foreground_color, 1, 2)),
                hexdec(substr($qrCode->foreground_color, 3, 2)),
                hexdec(substr($qrCode->foreground_color, 5, 2))
            )
            ->backgroundColor(
                hexdec(substr($qrCode->background_color, 1, 2)),
                hexdec(substr($qrCode->background_color, 3, 2)),
                hexdec(substr($qrCode->background_color, 5, 2))
            );

        $image = $qr->generate($qrCode->content);

        $filename = 'qrcodes/' . $qrCode->id . '_' . time() . '.' . $qrCode->format;

        Storage::disk('public')->put($filename, $image);

        $qrCode->update(['filename' => $filename]);
    }
}
