<?php

namespace App\DependencyInjection\Service;

/**
 * [see DI-L1-COMPILE-VS-RUNTIME]
 * Context: Demonstrates component decoupling. This class exists strictly as a
 * recipe-based Definition object inside the ContainerBuilder during Compile Time.
 *
 * The #[AsAlias] attribute tells Symfony: "Whenever someone type-hints
 * SmsNotifierInterface, automatically inject this TwilioSmsNotifier class."
 */
#[AsAlias(id: SmsNotifierInterface::class)]
class TwilioSmsNotifier implements SmsNotifierInterface
{
    public function send(string $message): void
    {
        // Logic for Twilio
    }
}
