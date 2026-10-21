<?php

namespace App\DependencyInjection\Service;

use Symfony\Component\DependencyInjection\Attribute\AsAlias;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

/**
 * [see doc/DependencyInjection/Chapter2-Lesson1_Service_Container.md -> DI-L2-DEFAULTS-CONFIG]
 * This service automatically inherits 'public: false' and 'autowire: true'
 * from the global configuration defaults.
 *
 * [see doc/DependencyInjection/Chapter2-Lesson1_Service_Container.md -> DI-L2-AS-ALIAS]
 * Binds this concrete class as the default implementation for the interface via attribute.
 */
#[AsAlias(id: InvoiceFormatterInterface::class)] // Global default
#[AsAlias(id: 'pdfInvoiceFormatter')]            // For #[Target]-Binding
class PdfInvoiceFormatter implements InvoiceFormatterInterface
{
    private string $currency;

    public function __construct(
        #[Autowire(param: 'app.default_currency')]
        string $currency
    ) {
        $this->currency = $currency;
    }

    public function formatInvoice(int $id, float $amount): string
    {
        return sprintf('Invoice #%d: %.2f %s (PDF Format)', $id, $amount, $this->currency);
    }
}
