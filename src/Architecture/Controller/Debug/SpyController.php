<?php

namespace App\Architecture\Controller\Debug;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * [see doc/Architecture/Chapter_2_Lesson_1_Invokable_Architecture_and_SOLID.md -> ARCH-T3-INVOKABLE-SRP] -> Single Responsibility Principle & Invokable Architecture
 *
 * Example for Single-Action / Invokable Controller.
 * (The letter "S" (Single Responsibility Principle) in SOLID).
 */
#[Route('/debug/spy')]
class SpyController extends AbstractController
{
    public function __invoke(Request $request): Response
    {
        // Read a custom attribute injected by our upcoming event subscriber
        $spyData = $request->attributes->get('_spy_agent', 'No spy detected');

        return new Response(sprintf(
            '<html><body><h1>🕵️‍♂️ Architecture Spy Matrix</h1><p>Status: %s</p></body></html>',
            $spyData
        ));
    }
}
