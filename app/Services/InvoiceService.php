<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceService
{
    /**
     * Generate invoice for order
     */
    public function generateInvoice(Pesanan $pesanan)
    {
        // Load order relationships
        $pesanan->load([
            'user',
            'items.produk.toko',
            'pembayaran.metodePembayaran',
            'pembayaran.nomorRekeningPengguna',
            'jasaPengiriman'
        ]);

        // Generate unique invoice number
        $invoiceNumber = $this->generateInvoiceNumber();

        // Create invoice record
        $invoice = Invoice::create([
            'id_invoice' => Str::uuid(),
            'id_pesanan' => $pesanan->id_pesanan,
            'nomor_invoice' => $invoiceNumber,
            'kirim_ke_email' => $pesanan->user->email,
            'status_kirim' => 'pending',
        ]);

        // Generate PDF
        $pdfContent = $this->generatePDF($pesanan, $invoice);
        
        // Save PDF file
        $fileName = 'invoice_' . $invoiceNumber . '_' . time() . '.pdf';
        $filePath = 'invoices/' . $fileName;
        
        Storage::disk('public')->put($filePath, $pdfContent->output());

        // Update invoice with file path
        $invoice->update(['file_path' => $filePath]);

        return $invoice;
    }

    /**
     * Generate unique invoice number
     */
    private function generateInvoiceNumber()
    {
        $date = now()->format('Ymd');
        $count = Invoice::whereDate('created_at', today())->count() + 1;
        return 'INV-' . $date . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Generate PDF content
     */
    private function generatePDF(Pesanan $pesanan, Invoice $invoice)
    {
        $data = [
            'pesanan' => $pesanan,
            'invoice' => $invoice,
            'company' => [
                'name' => 'ALKES SHOP',
                'address' => 'Jl. Kesehatan No. 123, Jakarta, Indonesia',
                'phone' => '+62 21 1234567',
                'email' => 'info@alkesshop.com',
                'website' => 'www.alkesshop.com'
            ]
        ];

        $pdf = Pdf::loadView('invoices.template', $data);
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf;
    }

    /**
     * Download invoice
     */
    public function downloadInvoice($invoiceId)
    {
        $invoice = Invoice::findOrFail($invoiceId);
        
        if (!Storage::disk('public')->exists($invoice->file_path)) {
            // Regenerate PDF if file doesn't exist
            $pesanan = $invoice->pesanan;
            $this->generatePDF($pesanan, $invoice);
        }

        return Storage::disk('public')->download($invoice->file_path, 'Invoice_' . $invoice->nomor_invoice . '.pdf');
    }

    /**
     * Get invoice file content for email attachment
     */
    public function getInvoiceContent($invoiceId)
    {
        $invoice = Invoice::findOrFail($invoiceId);
        
        if (!Storage::disk('public')->exists($invoice->file_path)) {
            // Regenerate PDF if file doesn't exist
            $pesanan = $invoice->pesanan;
            $pdfContent = $this->generatePDF($pesanan, $invoice);
            Storage::disk('public')->put($invoice->file_path, $pdfContent->output());
        }

        return Storage::disk('public')->get($invoice->file_path);
    }
}