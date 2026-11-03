# Topic 9: Dependency Injection (DI) 

## Chapter 1 - Lesson 3 - Container Working Flow

### Container Lifecycle & Phases
1. **Definition Phase (`ContainerBuilder`):**
    * Services are registered exclusively as blueprints using `Definition` objects.
    * Arguments are configured using `Reference` objects (representing target service IDs) or parameter placeholders, rather than live instantiated service objects.
    * The container remains fully mutable (`$container->setDefinition()`) during this phase.
2. **Compilation Phase (`$container->compile()`):**
    * Executes all registered **Compiler Passes** in sequential order based on their pass types.
    * Inspects the service graph and throws a `ServiceCircularReferenceException` if a circular dependency occurs.
    * Converts the parameter bag into a frozen state. After this, the container becomes immutable (read-only).
3. **Dumping Phase (`PhpDumper`):**
    * Generates a highly optimized, raw PHP class (`ProjectServiceContainer`) inside the cache directory (`var/cache/`).  [see `DI-L3-PHP-DUMPER`]
    * Eliminates the performance overhead of dynamic reflection lookups during application runtime.


## 🧠 Exam Flashcards
- **Question:** What are the four main phases of the Symfony Container Lifecycle in their precise chronological order?

  **Answer:**
    1. Compile (Optimization & Optimization Passes)
    2. Freeze (Locking definitions)
    3. Cache Generation (Writing PHP files to disk)
    4. Instantiation (Runtime execution)

- **Question:** Why does Symfony completely remove or inline private services during the container optimization phase?

  **Answer:** To drastically reduce memory usage and speed up service instantiation at runtime by eliminating tracking overhead inside the cached container.

---


Licensed under the [MIT License](../../LICENSE).
