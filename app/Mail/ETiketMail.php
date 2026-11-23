<?php

namespace App\Mail;

use App\Models\Pemesanan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ETiketMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Pemesanan $pemesanan)
    {
        $this->pemesanan->loadMissing([
            'user',
            'penumpang',
            'jadwal.bus',
            'jadwal.rute.terminalAsal.kota',
            'jadwal.rute.terminalTujuan.kota',
        ]);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'E-Tiket BusGo Anda - ' . $this->pemesanan->kode,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.etiket',
        );
    }

    public function attachments(): array
    {
        $pdf = Pdf::loadView('pdf.etiket', [
            'pemesanan' => $this->pemesanan,
        ])->setPaper('a4', 'portrait');

        return [
            Attachment::fromData(fn() => $pdf->output(), 'ETiket-' . $this->pemesanan->kode . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
