# 📄 System Protocol: Components Architecture & Service Locators (Symfony 8)

### 🧩 SOLID Principles Reference
* **Interface Segregation Principle (ISP):** Fully respected by the decoupled nature of `symfony/contracts` and the Strategy Pattern. Consumers and consuming applications rely on thin, laser-focused, highly specific interfaces (like `PaymentStrategyInterface`) instead of heavy monolithic dependencies.
* **Dependency Inversion Principle (DIP):** The textbook implementation of DIP. High-level execution modules (like controllers or core service managers) interact exclusively with abstractions (Interfaces), remaining completely decoupled from concrete low-level implementations (like a specific Redis/Filesystem caching driver or unique payment processing engines).

  👉 *Sandbox Context:** High-level execution modules interact with framework abstractions instead of global superglobals. See: [`src/Architecture/Controller/Debug/SpyController.php`](../../src/Architecture/Controller/Debug/SpyController.php).

---

## 1. Components vs. Bridges vs. Contracts
* **Symfony Contracts (`symfony/contracts`):** A lightweight collection of strict PHP interfaces and abstract traits that contain **zero executable business logic**. Built exclusively to maximize application decoupling across the PHP ecosystem.
* **Symfony Bridges:** The actual physical integration layer or "glue" code that binds non-Symfony third-party engines (such as *Twig* or *Doctrine*) seamlessly into the core framework infrastructure.
* **PSR-7 Standard Integration:** PSR-7 specifies immutable HTTP message interfaces for PHP ecosystem interoperability. Symfony does **not** consume PSR-7 natively; however, it offers comprehensive support through an optional `PSR-7 Bridge` adapter.

---

## 2. Core Component Internals
* **Asset Component:** Generates and abstracts asset path management inside templates via `{{ asset() }}`. It provides effortless runtime switching for Content Delivery Networks (CDNs) and native cache-busting version routines using the configured `json_manifest_path`.
* **Cache Component:** Enforces a rigid architectural separation between technical **Adapters** (the concrete physical storage drivers like Redis, Memcached, or Filesystem) and **Pools** (isolated logical application drawers). Advanced profiles include *Cache Tagging* (which explicitly mandates the `TagAwareAdapterInterface`) and *Stampede Protection* (probabilistic early expiration).
* **Config Component:** Responsible for loading and validating application parameters once at build-time using schemas defined via `TreeBuilder`. Validated schemas compile into raw PHP code inside `/var/cache/` while *Resource Tracking* monitors file system change dates.
* **Internal Framework Space:** Classes, methods, or parameters flagged with the `@internal` PHPDoc tag are strictly excluded from the Backwards Compatibility (BC) Promise. Using internal markers in custom business code is completely forbidden.

---

## 3. Enterprise Strategy Pattern via Service Locator
* **The Problem:** Dynamically dealing with dozens of strategies (e.g., 20 distinct payment providers or data formatters) would require a fat, heavy constructor if all variations were injected simultaneously, causing severe memory overhead and triggering the "Fat Constructor" anti-pattern.
* **The Solution:** A localized **Service Locator** functions as an ultra-lightweight service container subset acting as a runtime configuration registry for the **Strategy Pattern**.
* **Lazy Loading Engine:** Strategies implementing a unified interface receive an automated tag via `autoconfigure: true`. Utilizing the modern `#[TaggedLocator]` attribute allows the application to resolve dependencies **strictly lazily**. Concrete services wake up in RAM only when called via `$locator->get('service_id')`, keeping memory allocations clean and dramatically shrinking your application's RAM and CPU footprint.

  👉 *Sandbox Context:* While our execution layers here remain minimal, the decoupling principle matches the architectural boundaries used in [`src/Architecture/EventSubscriber/ArchitectureSpySubscriber.php`](../../src/Architecture/EventSubscriber/ArchitectureSpySubscriber.php).
  [see ARCH-T3-DECOUPLING-STRATEGY].

---

## 4. Code Organization & Directory Standards

### 🧩 SOLID Principles Reference
* **Open-Closed Principle (OCP):** Supported by the central domain layout. Scaling the application with new features simply involves placing new classes inside subfolders without touching existing configuration layers. Symfony uses directory-based scanning (Autodiscovery) for routes and services, meaning you extend the application by *adding files* (Open for extension) rather than *editing central config files* (Closed for modification).
* **Dependency Inversion Principle (DIP):** Strictly enforced by the interplay of autowiring and interfaces. High-level execution modules (like controllers or managers) do not depend directly on low-level technical implementations (like specific database/caching drivers); instead, both depend on shared abstractions (Interfaces).

---

## 4.1. Domain Architecture vs. Technical Bundles
* **Modern Convention:** Creating custom application-specific bundles (e.g., `src/UserBundle/`) has been completely deprecated since Symfony 4+. All application code resides flat and unbundled directly inside the root `/src` directory under the default `App\` namespace.
* **Handling Massive Entities (100+ Controllers/Services):** To maintain maximum legibility when dealing with a high volume of files, structural separation is achieved using strict domain-driven subfolders matching nested PHP namespaces (e.g., `src/Controller/Cart/PaymentController.php` maps onto `namespace App\Controller\Cart;`).

---

## 4.2. Automated Configuration & Service Management
* **Zero Mapping Redundancies:** Keeping massive, independent XML or YAML routing configurations is fully obsolete. Modern setups use **PHP Attributes** directly over class methods to manage paths. The core framework configuration executes a singular global auto-scan engine (`type: attribute`) targeting the root `../src/Controller/` path.
* **Autodiscovery:** Using the default configuration block in `config/services.yaml`, Symfony automatically scans the entire `src/` directory during container compilation. Every valid PHP class created there is automatically registered as a service inside the Dependency Injection container.
* **Autowiring:** Symfony intelligently inspects the type-hints in a class constructor, matches them against available container signatures, and automatically injects the required dependency upon instantiation.

---

## 4.3. Standard Environment Directory Behavior
* `/public`: The only web-facing root directory accessible to external traffic. It holds the core front-controller (`index.php`) and public assets.
* `/var`: The internal temporary workspace for engine logs and compiled cache data. On Linux production or container environments (Docker/FrankenPHP), it strictly requires mandatory write permissions (`chmod`) allocated to the system webserver user account (`www-data`).

---
Licensed under the [MIT License](../../LICENSE).
