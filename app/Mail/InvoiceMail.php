<?php

namespace App\Mail;

use App\Models\Invoice;
use App\Models\Pesanan;
use App\Services\InvoiceService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;
    public $pesanan;

    /**
     * Create a new message instance.
     */
    public function __construct(Invoice $invoice, Pesanan $pesanan)
    {
        $this->invoice = $invoice;
        $this->pesanan = $pesanan;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invoice Pembelian - ' . $this->invoice->nomor_invoice . ' - ALKES SHOP',
            from: config('mail.from.address', 'noreply@alkesshop.com')
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.invoice',
            with: [
                'invoice' => $this->invoice,
                'pesanan' => $this->pesanan,
                'user' => $this->pesanan->user,
                'company' => [
                    'name' => 'ALKES SHOP',
                    'address' => 'Jl. Kesehatan No. 123, Jakarta, Indonesia',
                    'phone' => '+62 21 1234567',
                    'email' => 'info@alkesshop.com',
                    'website' => 'www.alkesshop.com'
                ]
            ]
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        $invoiceService = new InvoiceService();
        
        return [
            Attachment::fromData(
                fn () => $invoiceService->getInvoiceContent($this->invoice->id_invoice),
                'Invoice_' . $this->invoice->nomor_invoice . '.pdf'
            )->withMime('application/pdf'),
        ];
    }
}