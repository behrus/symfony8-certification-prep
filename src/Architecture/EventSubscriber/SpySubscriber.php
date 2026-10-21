<?php

namespace App\Architecture\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use App\Architecture\Controller\Debug\SpyController;

/**
 * References to Study Protocol:
 * [see doc/Architecture/Chapter_2_Lesson_1_Invokable_Architecture_and_SOLID.md -> ARCH-T3-SUBSCRIBER-LIFECYCLE] -> Open/Closed Principle & Kernel Priorities
 * [see doc/Architecture/Chapter_1_Lesson_1_HTTP_Foundation_and_Licensing.md -> ARCH-T3-MUTABLE-ATTRIBUTES]  -> HttpFoundation & Mutable ParameterBag Manipulation
 * [see doc/Architecture/Chapter_3_Lesson_2_Components_and_Service_Locators.md -> ARCH-T3-DECOUPLING-STRATEGY]  -> Enterprise Strategy Pattern Boundaries
 *
 * Set an attribute after the route listener has executed within the request event.
 *
 * This subscriber is also an example for the "S", "O" and "D" letters in SOLID.
 *
 * "O" -> Open/Closed Principle
 * By creating the ArchitectureSpySubscriber, we extended the behavior of the request lifecycle without touching a single line of code
 * inside Symfony's core HttpKernel or the SpyController. We added new functionality entirely by extension.
 *
 * "S" - Single Responsibility Principle (SRP):
 * Your SpyController has one job: process data and return a response. It shouldn't care about authentication checks
 * , request logging, or setting system-wide headers. By moving the "spy injection" logic into a separate ArchitectureSpySubscriber,
 * both classes keep a single, clean responsibility.
 *
 * "D" - Dependency Inversion Principle (DIP):
 * The controller and the subscriber do not know each other exist. They are completely decoupled.
 * They both depend on an abstraction—the Symfony EventDispatcher layer and the KernelEvents::REQUEST contract.
 */
class SpySubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            // We need to run AFTER the RouterListener (Priority 32) has matched the route,
            // so we know if we're on the correct request. Also choose priority 30.
            KernelEvents::REQUEST => [['onKernelRequest', 30]],
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        // IMPORTANT FOR THE AUDIT: Always check if it is the main request!
        // (We don't want to touch internal Sub-Requests like Twig-Fragments).
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();

        // We check if the router has matched our SpyController.
        if ($request->attributes->get('_controller') === SpyController::class) {
            // We inject the data into the mutable ParameterBag of the attributes
            // Mutable ParameterBag: Here you can see live that $request->attributes can be changed (mutable), which would be impossible with PSR-7.
            $request->attributes->set('_spy_agent', 'James Bond (007) successfully injected via kernel.request!');
        }
    }
}
