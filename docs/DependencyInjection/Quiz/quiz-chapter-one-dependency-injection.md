# Symfony 8.0 Certified Developer Exam Practice Quiz
## Topic 9: Dependency Injection (Chapter 1)

This practice quiz contains advanced, exam-level scenarios focusing on the low-level architectural behaviors, container lifecycle phases, and programmatic APIs of the `DependencyInjection` component.

---

### Question 1: Invalid Reference Behaviors
You are programmatically configuring a `Definition` via `addMethodCall` for a service requiring a non-existent optional dependency. You specify `ContainerInterface::IGNORE_ON_INVALID_REFERENCE` for a constructor argument (`addArgument()`). What happens during the container compilation phase?

- [ ] A) The container compiles successfully and passes `null` to the constructor.
- [ ] B) The constructor call is skipped entirely, instantiating the class with fewer arguments.
- [x] C) Symfony throws a compilation exception because constructor arguments cannot be ignored or omitted; `IGNORE_ON_INVALID_REFERENCE` is only valid for method calls (setters/properties).
- [ ] D) A lazy proxy is created for the missing constructor argument.

**Correct Answer: C**
*Explanation:* `IGNORE_ON_INVALID_REFERENCE` is designed exclusively for method calls and property injections where the container can safely omit calling the setter if the service is missing. Constructor arguments define the mandatory instantiation signature of a class and cannot be dynamically skipped or omitted during compilation.

---

### Question 2: Compiler Optimization and Service Removal
During the optimization phase of the container building workflow, the `RemoveUnusedDefinitionsPass` evaluates service definitions. Which of the following statements is precisely true regarding public versus private service definitions during this removal pass?

- [ ] A) Both public and private unused services are automatically stripped out to optimize memory usage.
- [x] B) Public services are retained in the container even if they are unreferenced and unused by any other service, whereas private services that have no incoming references and are not tagged/aliased are stripped out.
- [ ] C) Private services are never removed by compiler passes because their lifecycle is managed externally.
- [ ] D) Public services are removed if they do not implement `ResetInterface`.

**Correct Answer: B**
*Explanation:* Public definitions are preserved as part of the container's public API surface because they might be fetched directly from the container via `$container->get()`, so the removal pass never prunes them. Private definitions without incoming service references or special tags are stripped out by the removal compiler pass to minimize memory footprint.

---

### Question 3: ConfigCache and Resource Tracking
When writing a custom compiler pass or configuration loader that leverages Symfony's `ConfigCache`, you record a `ReflectionClassResource` alongside a standard `FileResource`. How does `ReflectionClassResource` utilize the class state to validate cache freshness compared to a standard file path check?

- [ ] A) It compiles the class bytecode into the cache file directly, rendering external PHP files unnecessary.
- [ ] B) It operates identically to a `FileResource` by checking only the modification timestamp (`filemtime`) of the file where the class is declared.
- [x] C) `ReflectionClassResource` tracks changes to class metadata, methods, properties, and constants via reflection metadata tracked during cache generation rather than just file timestamps.
- [ ] D) It forces PHP to re-evaluate `opcache_invalidate()` for the class file every single request.

**Correct Answer: C**
*Explanation:* `ReflectionClassResource` serializes and monitors class reflection states, allowing the cache to invalidate if class annotations, method signatures, or structural attributes change, even if the file timestamp behaves unexpectedly. Changing code *inside* a method body will not invalidate this resource, but altering signatures or annotations will.

---

### Question 4: Definition Argument Manipulation
When manipulating a service's positional arguments using `Definition::setArguments()` with an associative array containing explicit integer keys (e.g., `[1 => new Reference('logger'), 0 => 'admin@example.com']`), how does Symfony's argument resolver process these keys during compilation?

- [ ] A) Symfony automatically re-indexes the array sequentially from 0, ignoring the custom integer keys and misaligning the values.
- [ ] B) Symfony throws a compilation exception because array keys must be sequential strings representing named parameters.
- [ ] C) Symfony converts them into named key-value pairs matching parameter names.
- [x] D) Symfony preserves the explicit numeric keys and maps them directly to the corresponding positional constructor parameters, regardless of the array's literal order.

**Correct Answer: D**
*Explanation:* Associative integer keys allow developers to define exact positional indices out of standard sequential order while ensuring proper alignment with constructor parameter positions. Symfony respects explicit numeric array keys when mapping positional constructor arguments.

---

### Question 5: Container Building Workflow
You register a custom compiler pass with `PassConfig::TYPE_AFTER_REMOVING`. If your compiler pass attempts to register a new private service definition and adds method calls referencing other existing services, what is the expected outcome?

- [ ] A) The new definition will be fully optimized, processed by removal passes, and cached normally.
- [x] B) The container has already completed optimization and removal passes at this late stage, making dynamic service registration unreliable or ineffective as the container structure is already finalized.
- [ ] C) Symfony re-runs the entire compilation workflow from the Load Phase to incorporate the new service.
- [ ] D) The service is successfully registered and added to the compiled container instance without issues.

**Correct Answer: B**
*Explanation:* Registering compiler passes at `TYPE_AFTER_REMOVING` is strictly intended for final sanity checks or metadata extraction, not for introducing new services that require optimization or dependency resolution. Late additions after the removal pass risk creating dangling references or missing compiled map entries, making it an architectural anti-pattern.

---

* **Q:** What happens to unused private services during `$container->compile()`?
    * **A:** They are completely eliminated by the `RemoveUnusedDefinitionsPass` and will not be dumped into the final cached container class code.
* **Q:** Can container parameters be dynamically updated after the container has been compiled?
    * **A:** No. Once `compile()` executes, the parameter bag is frozen to guarantee maximum performance when loading the static cache class.
