<?php

namespace App\DependencyInjection\Service;

/**
 * @see doc/DependencyInjection/Chapter2/Lesson1_Service_Container.md#DI_L2_HTML_FORMATTER
 */
#[AsAlias(id: 'htmlInvoiceFormatter')] // For #[Target]-Binding
class HtmlInvoiceFormatter implements InvoiceFormatterInterface
{
    public function formatInvoice(int $id, float $amount): string
    {
        return sprintf('<div class="invoice">Invoice #%d: %.2f (HTML Format)</div>', $id, $amount);
    }
}
