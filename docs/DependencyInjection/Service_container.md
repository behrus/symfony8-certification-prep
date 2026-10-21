# Topic 9: Dependency Injection (DI) — Study Protocol

## Lecture 2: Service Container (Framework Integration)
**Core Concept:** The full-stack framework automates the entire DI container lifecycle via the `Kernel` class, loading declarative configurations from YAML, XML, or PHP configuration files.

### Global Defaults (`_defaults`)
* `autowire: true`: Resolves constructor type-hints automatically.
* `autoconfigure: true`: Automatically applies tags to services based on implemented interfaces or PHP 8 attributes (e.g., Event Listeners, CLI Commands).
* `public: false`: Ensures services are **private** by default.

### Public vs. Private Services & Compiler Optimization
* **Private Services (`public: false`):** Cannot be retrieved directly via `$container->get()`. They exist purely to be injected into other services.
* **Compiler Inlining (Prod Mode):** If a private service is referenced by only *one* consumer service, the compiler deletes its standalone factory method and embeds its instantiation code (`new LocalLogger()`) directly into the consumer's factory block.
* **Interface Aliasing:** Defining a direct alias (`App\Interface: '@App\ConcreteClass'`) establishes the default 1:1 dependency mapping for single autowired type-hints, but it does not resolve multi-service collections (which require explicit tagging, `#[AutowireIterator]`, or `#[AutowireLocator]`).
* **Parameters vs. Environment Variables:** Container parameters (`%parameter_name%`) are fully resolved at compile time and hardcoded as static scalars. Environment variables (`%env(ENV_VAR)%`) are preserved as dynamic runtime instructions evaluated on the fly by the environment processors.

### The Test Container Mechanism
* In the `test` environment, automatic **inlining and the removal of unused private services are disabled by default**.
* `static::getContainer()` provides access to a dedicated test container that maintains a mapping layer over these non-optimized private services, allowing seamless integration testing without cluttering production configurations with `public: true`.

### 🧠 Senior Certification Questions (Lecture 2)
* **Q:** How does the `PhpDumper` optimize a private service that has exactly one consumer in production mode?
    * **A:** Through **Inlining**. The standalone service factory definition is stripped, and the instantiation logic is embedded directly inside the factory method of the consumer service.
* **Q:** What happens if you try to dynamically fetch a private service via its ID from the main container at runtime?
    * **A:** A `ServiceNotFoundException` is thrown because private services are omitted from the container's public runtime mapping.

---

Licensed under the [MIT License](../../LICENSE).
