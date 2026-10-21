<?php

namespace App\DependencyInjection\Command;

use App\DependencyInjection\Service\InvoiceManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:debug-invoice', description: 'Test the invoice formatter chain')]
class DebugInvoiceCommand extends Command
{
    public function __construct(
        private InvoiceManager $invoiceManager
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln($this->invoiceManager->processPdf(101, 250.50));
        $output->writeln($this->invoiceManager->processHtml(102, 120.00));

        return Command::SUCCESS;
    }
}
