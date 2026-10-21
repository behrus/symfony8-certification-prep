# 🏛️ SOLID Principles in Symfony 8 Architecture

This document records how modern Symfony architectural patterns directly implement **SOLID design principles**, focusing on Single-Action Controllers, Event Subscribers, Event Listeners, Contracts, and critical exam behaviors.

---

## 🛑 The "S" in SOLID: Single Responsibility Principle (SRP)
The **Single Responsibility Principle** states that a class should have *one, and only one, reason to change*.

### 💻 Implementation: Invokable (Single-Action) Controllers
Traditional controllers often act as "God Classes" (e.g., a `ProductController` handling listing, viewing, creating, and deleting). This introduces multiple reasons to change.

By utilizing Symfony's **Invokable Controllers**, a class isolates exactly **one specific HTTP action** via the PHP magic `__invoke()` method.

👉 *Sandbox Link:* See our live implementation inside [`src/Architecture/Controller/Debug/SpyController.php`](../../src/Architecture/Controller/Debug/SpyController.php).

```php
<?php

namespace App\Controller\Debug;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/debug/spy')]
class SpyController extends AbstractController
{
    public function __invoke(Request $request): Response
    {
        $spyData = $request->attributes->get('_spy_agent', 'No spy detected');

        return new Response(sprintf(
            '<html><body><h1>🕵️‍♂️ Architecture Spy Matrix</h1><p>Status: %s</p></body></html>',
            $spyData
        ));
    }
}
```

### 🎓 Critical Exam Facts: Invokable Controllers
* **Short Routing Syntax:** When mapping an invokable controller in routing, you omit the method suffix (`::methodName`). Symfony automatically defaults to looking for `__invoke()`.
* **Lean Dependency Injection:** Traditional controllers suffer from constructor bloat because different methods need different services. Single-action controllers ensure your constructor only injects dependencies strictly required for that individual task.
* **Naming Conventions:** In pure Domain-Driven Design (DDD), developers often drop the `Controller` suffix entirely for these classes, renaming them to `Action` or `Handler` (e.g., `RegisterUserAction`). Symfony natively supports this.

---

## 🔌 The "O" in SOLID: Open/Closed Principle (OCP)
The **Open/Closed Principle** states that software entities should be **open for extension, but closed for modification**.

### 💻 Implementation: Extending the Lifecycle without Modification
If you want to alter or enrich the request lifecycle (e.g., dynamically injecting attributes before a controller executes), you should **never modify the core framework code or the target controller directly**.

Instead, you extend the application seamlessly using either an **Event Subscriber** or an **Event Listener** hooked into the `HttpKernel` lifecycle.

#### Approach A: The Event Subscriber
A subscriber is self-contained and tells the framework exactly what it listens to via an internal interface contract.

👉 *Sandbox Link:* See our live implementation inside [`src/Architecture/EventSubscriber/ArchitectureSpySubscriber.php`](../../src/Architecture/EventSubscriber/ArchitectureSpySubscriber.php).
[see ARCH-T3-SUBSCRIBER-LIFECYCLE].

```php
<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use App\Controller\Debug\SpyController;

class ArchitectureSpySubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [['onKernelRequest', 30]],
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();

        if ($request->attributes->get('_controller') === SpyController::class) {
            $request->attributes->set('_spy_agent', 'James Bond (007) successfully injected via kernel.request!');
        }
    }
}
```

#### Approach B: The Modern Event Listener (Symfony 8 Attributes)
An event listener is a flat PHP class decoupled from any framework interfaces. It is configured from the outside using PHP attributes.

```php
namespace App\EventListener;

use App\Controller\Debug\SpyController;
use Symfony\Component\HttpKernel\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

#[AsEventListener(event: KernelEvents::REQUEST, priority: 30)]
class ArchitectureSpyListener
{
    public function __invoke(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();

        if ($request->attributes->get('_controller') === SpyController::class) {
            $request->attributes->set('_spy_agent', 'James Bond (007) via Listener');
        }
    }
}
```

---

### 📊 Critical Exam Comparison: Subscriber vs. Listener

| Feature | Event Subscriber | Event Listener (Modern Symfony 8) |
| :--- | :--- | :--- |
| **Interface** | Must implement `EventSubscriberInterface`. | No interface registration required. |
| **Self-Configuration** | Self-configured via the static `getSubscribedEvents()` method. | Configured via the `#[AsEventListener]` PHP attribute above the class. |
| **Method Target** | You can name execution methods whatever you want within the mapping array. | Defaults to looking for `__invoke()` or a method matching the event name. |
| **Best Practice Scope** | Best when a single class needs to listen to **multiple coupled events** sequentially. | Best when a class handles **exactly one action for one specific event** (Strict SRP). |

---

## 🔄 The "L" in SOLID: Liskov Substitution Principle (LSP)
The **Liskov Substitution Principle** states that *objects of a superclass should be replaceable with objects of its subclasses without breaking the application*.

### 💻 Implementation: Contract-Driven Adapters
Symfony avoids binding your code to concrete infrastructure implementations. Instead, it relies on strict **Component Contracts** (Interfaces).

A perfect example is Symfony's Cache Component. When writing code, you exclusively type-hint the abstract interface, allowing Symfony to swap out the low-level storage engine behind the scenes without rewriting a single line of business logic.

```php
namespace App\Service;

use Symfony\Contracts\Cache\CacheInterface; // The stable abstraction

class SpyRegistry
{
    public function __construct(
        private CacheInterface $cache 
    ) {}
}
```

### 🎓 Critical Exam Facts: LSP & Component Contracts
* **The `symfony/contracts` Strategy:** Symfony splits its codebase into standalone components and decoupled contracts. Contracts contain zero execution logic—only pure interfaces and traits designed to enforce LSP across third-party packages.
* **Type-Hinting Best Practice:** The exam heavily rewards type-hinting interfaces over concrete classes (e.g., type-hinting `Psr\Log\LoggerInterface` instead of `Symfony\Component\HttpKernel\Log\Logger`).

---

## 🎨 The "I" in SOLID: Interface Segregation Principle (ISP)
The **Interface Segregation Principle** states that *clients should not be forced to depend upon interfaces they do not use*. It favors many small, highly-specific interfaces over one giant "fat" interface.

### 💻 Implementation: Micro-Interfaces in Symfony Core
Symfony's component design is a textbook example of ISP. Instead of shipping massive, multi-purpose interfaces, the framework splits responsibilities into minimal, atomic contracts.

For instance, the Event Dispatcher component separates the action of triggering events from the action of registering listeners:
1. `Symfony\Component\EventDispatcher\EventDispatcherInterface` ➔ Only forces you to know about `dispatch()`.
2. `Symfony\Component\EventDispatcher\EventSubscriberInterface` ➔ Only forces you to know about `getSubscribedEvents()`.

By doing this, an internal service that only needs to trigger an announcement is never forced to implement or understand listener management mechanics.

### 🎓 Critical Exam Facts: ISP Examples
* **Authentication Passport Badges:** Symfony's modern security layer uses tiny, isolated badges (e.g., `RememberMeBadge`, `CsrfTokenBadge`) attached to a Passport. Each badge does exactly one thing, preventing a single "Fat Security Object".
* **The Serializer Component:** It segregates its core jobs into two distinct micro-interfaces: `NormalizerInterface` (Object ⇄ Array) and `EncoderInterface` (Array ⇄ String format like JSON/XML). A class can implement one without being forced to implement the other.

---

## ⚙️ The "D" in SOLID: Dependency Inversion Principle (DIP)
The **Dependency Inversion Principle** states that *high-level modules should not depend on low-level modules; both must depend on abstractions*.

### 💻 Implementation: The Dependency Injection Container
In your sandbox, your high-level application code (the `SpyController`) does not look for database ports, construct network clients, or read raw environment strings. Instead, it declares its structural requirements via constructor or method signatures, and the **Dependency Injection Container** fulfills those abstractions automatically via **Autowiring**.

---

## 📊 Quick Summary Checklist for the Exam

| SOLID Letter | Architectural Tool in Symfony | Core Certification Takeaway |
| :--- | :--- | :--- |
