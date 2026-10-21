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

## 3. Framework Licensing
* **MIT License Standards:** The core Symfony Framework, along with its official Flex recipe database, is released under the highly permissive **MIT License**. This explicitly permits free, closed-source commercial utilization without any legal obligation to open-source your unique business code.

---
Licensed under the [MIT License](../../LICENSE).
