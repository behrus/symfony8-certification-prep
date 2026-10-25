# 📄 System Protocol: HTTP Foundation, Flex & Licensing (Symfony 8)

### 🧩 SOLID Principles Reference
* **Dependency Inversion Principle (DIP):** The `HttpFoundation` layer encapsulates raw server superglobals into object-oriented models. This ensures application controllers depend directly on safe object abstractions rather than low-level global environment variables.

  👉 *Sandbox Context:* The single-action endpoint depends on safe abstractions provided by HttpFoundation. See: [`src/Architecture/Controller/Debug/SpyController.php`](../../src/Architecture/Controller/Debug/SpyController.php).

---

## 1. The HttpFoundation Component
* **Mutable HTTP Model:** Symfony uses its own custom **mutable** HTTP object ecosystem. Every HTTP property relies on a dedicated `ParameterBag` instance:
    * `$request->query` ➔ Resolves GET parameters.
    * `$request->request` ➔ Resolves POST form data.
    * `$request->headers` ➔ Resolves HTTP headers. **Exam Trap:** Internal header keys are strictly normalized to **lowercase** (e.g., `user-agent`).

  👉 *Sandbox Context:* We dynamically manipulate the mutable request attributes inside [`src/Architecture/EventSubscriber/ArchitectureSpySubscriber.php`](../../src/Architecture/EventSubscriber/ArchitectureSpySubscriber.php).
  [see ARCH-T3-MUTABLE-ATTRIBUTES].
* **Response Framework:** Specialized classes like `JsonResponse` automatically encode payloads and append appropriate headers (`application/json`). Within the full framework architecture, `$response->send()` is **never** invoked manually; the execution loop is entirely managed by the `HttpKernel`.
* **IpUtils Helper:** A standalone utility class for handling security-sensitive IP checks. The static method `IpUtils::checkIp()` validates client IP addresses against CIDR subnets.

---

## 2. Symfony Flex & Project Composition
* **Automated Package Recipes:** Symfony Flex is a Composer plugin that manages application architecture via automated configuration files called **Recipes**. It directly handles the registration layer inside `config/bundles.php`.
* **Deprecation of Custom Bundles:** Designing custom application-specific bundles (e.g., `src/UserBundle/`) has been completely obsolete since Symfony 4+. All local source code must reside flat within the root `src/` directory structure.

---

## 🧠 Exam Flashcards

Given the standard entry point of a modern Symfony 8 application running with Symfony Flex:
```php
// public/index.php
use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return static function (array \$context) {
    return new Kernel(\$context['APP_ENV'], (bool) \$context['APP_DEBUG']);
};
```
- **Question:** Where are the standard lifecycle methods `$kernel->handle($request)->send();` executed, since they are no longer visible in `public/index.php`?

  **Answer:** They are executed internally by the **Symfony Runtime Component** inside **`vendor/autoload_runtime.php`**. The application bootstrap returns a closure, which is intercepted by the configuration runner (e.g., `SymfonyRuntime`) that automatically manages Request creation, Kernel handling, and sending the Response back to the server buffer.

---

Look at this controller snippet attempting to read a raw JSON payload from an incoming POST request:
```php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiController {
    public function handle(Request \$request): Response {
        // Line to fetch raw body content
        \$content = \$request->getContent();
    }
}
```
- **Question:** True or False: If you call `$request->getContent(true)` (passing `true` as the first argument), Symfony will return a PHP resource stream instead of a string, which is highly optimized for memory when handling large JSON payloads.

  **Answer:** **True.** Passing `true` to `$request->getContent()` returns a **PHP resource pointer (stream)** instead of loading the entire payload into a PHP string variable, which complies with memory-efficiency standards for large payloads.

---

- **Question:** During a Symfony Flex recipe installation, a bundle requires configuration injection into `config/packages/`. What is the exact name and format of the file that a custom Flex recipe uses internally to define these automated framework configurations and file-copy tasks?

  **Answer:** The **`manifest.json`** file, which resides within the specific Flex recipe repository structure to map targets, configuration files, and environment variable defaults.

---


Licensed under the [MIT License](../../LICENSE).
