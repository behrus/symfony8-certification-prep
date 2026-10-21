<?php

namespace App\DependencyInjection\Service;

/**
 * @see doc/DependencyInjection/Chapter2/Lesson1_Service_Container.md#DI_L2_NAMED_AUTOWIRING
 *
 * Context: In the service container layer, this interface represents a structural contract.
 * With multiple implementations present, it requires dedicated alias mappings (via #[AsAlias])
 * or explicit target definitions (via #[Target]) so that the container can resolve ambiguities.
 */
interface InvoiceFormatterInterface
{
    public function formatInvoice(int $id, float $amount): string;
}
