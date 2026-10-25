# Topic 9: Dependency Injection (DI)

## Chapter 1 - Lesson 1: Dependency Injection Component

**Core Concept:** The DI component operates completely decoupled from the full-stack framework. It relies on a strict operational separation between *Compile Time* (mutable configuration phase) and *Runtime* (immutable execution phase) [Anchor: DI-L1-COMPILE-VS-RUNTIME].

### Standalone Interface Binding [Anchor: DI-L1-INTERFACE-BINDING]
* **Mechanism:** In the raw Component layer, an interface cannot be automatically instantiated. It requires a manual reference map or an explicit alias assignment so that the `ContainerBuilder` knows which concrete service ID to resolve when the interface is requested.
* **Sandbox Code:** See the structural contract declaration inside [`src/DependencyInjection/Service/InvoiceFormatterInterface.php`](../../src/DependencyInjection/Service/InvoiceFormatterInterface.php).
* **Exam Trap:** Requesting a raw interface without any registered alias or backing service definition always causes a `ServiceNotFoundException` during container compilation.



## 🧠 Exam Flashcards
- **Question:** What is the primary architectural benefit of using Dependency Injection over hardcoding class instantiations?

  **Answer:** It achieves loose coupling, making classes highly testable and maintainable by decoupling a class from its dependencies' creation logic.

- **Question:** What is the structural difference between a Service Definition and a Compiler Pass inside the DI container?

  **Answer:** A Service Definition is the configuration blueprint for a single service, whereas a Compiler Pass is a PHP class that can manipulate multiple definitions at once during container compilation.

Look at this configuration mix inside a Symfony 8 project:
```yaml
# config/services.yaml
services:
    App\Service\AnalyticsService:
        autowire: false
```
```php
// src/Service/AnalyticsService.php
namespace App\Service;
use Symfony\Component\HttpFoundation\ChainRequestMatcher;

class AnalyticsService {
    public function __construct(private ChainRequestMatcher \$matcher) {}
}
```
- **Question:** What happens when Symfony attempts to compile the service container?

  **Answer:** The container compilation will **fail** and throw a `DependencyInjectionException` (or `RuntimeError`). **Reason:** The explicit `autowire: false` declaration in `services.yaml` completely disables the framework's automatic type-hint resolution for this specific service. Symfony will not attempt to guess or inject the `ChainRequestMatcher` dependency, leaving it unresolvable.

- **Question:** True or False: If a service class contains no PHP attributes but has clear type-hints in its constructor, setting `autowire: true` (or relying on `_defaults: autowire: true`) in `services.yaml` is fully sufficient for Symfony to register and resolve its dependencies.

  **Answer:** **True.** Standard autowiring in Symfony relies purely on native PHP type-hints. Core PHP attributes (like `#[Target]` or `#[AsAlias]`) are only necessary when you need to resolve structural ambiguities, define specific non-standard injection keys, or create custom aliases.

--- 


Licensed under the [MIT License](../../LICENSE).
