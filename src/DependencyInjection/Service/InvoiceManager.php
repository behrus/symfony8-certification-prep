<?php

namespace App\DependencyInjection\Service;

class InvoiceManager
{
    public function __construct(
        #[Target('pdfInvoiceFormatter')]
        private InvoiceFormatterInterface $pdf,

        #[Target('htmlInvoiceFormatter')]
        private InvoiceFormatterInterface $html
    ) {}

    public function processPdf(int $id, float $amount): string
    {
        return $this->pdf->formatInvoice($id, $amount);
    }

    public function processHtml(int $id, float $amount): string
    {
        return $this->html->formatInvoice($id, $amount);
    }
}
