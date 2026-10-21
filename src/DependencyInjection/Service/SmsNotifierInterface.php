<?php

namespace App\DependencyInjection\Service;

interface SmsNotifierInterface
{
    public function send(string $message): void;
}
