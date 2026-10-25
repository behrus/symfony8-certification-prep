# Topic 9: Dependency Injection (DI)

## Chapter 2 - Lesson 1: Service Container & Autowiring

### Global Container Defaults [Anchor: DI-L2-DEFAULTS-CONFIG]
* **Mechanism:** Managed via the `_defaults:` key in `services.yaml`. It automatically applies settings like `autowire: true`, `autoconfigure: true`, and `public: false` to all discovered services in this file.
* **`autowire: true`:** Automatically injects dependencies into constructors by inspecting type-hints via PHP Reflection.
* **`autoconfigure: true`:** Automatically registers services into framework subsystems based on their class hierarchy or attributes (e.g., adds `console.command` tag to classes extending `Command`).
* **`public: false`:** By default, all services are private. They cannot be fetched directly via `$container->get()`.
* **Sandbox Code:** See the core configuration verifications inside [`src/DependencyInjection/Service/PdfInvoiceFormatter.php`](../../src/DependencyInjection/Service/PdfInvoiceFormatter.php).
* **Exam Trap:** Explicit service configurations lower down in the YAML file always override these global defaults.

### Attribute-Driven Interface Aliasing [Anchor: DI-L2-AS-ALIAS]
* **Mechanism:** Using the PHP attribute `#[AsAlias(id: MyInterface::class)]` over a concrete class allows the full-stack framework to automatically register it as the default implementation for that interface during Autodiscovery.
* **Sandbox Code:** See our live implementation inside [`src/DependencyInjection/Service/PdfInvoiceFormatter.php`](../../src/DependencyInjection/Service/PdfInvoiceFormatter.php).
* **Exam Trap:** If a manual alias is also defined in `services.yaml`, the YAML configuration wins and silently overrides the PHP class attribute.

---
## Block B: Handling Ambiguities (Symfony 8.0 Standard)

### Ambiguous Implementations & Target Attributes <a id="DI_L2_NAMED_AUTOWIRING"></a>
When multiple classes implement the same interface, Symfony's automatic type-hinting is disabled due to ambiguity. In Symfony 8.0, we solve this elegantly using a decentralized, attribute-driven approach without touching the `services.yaml` file.

* **Mechanism:** Each concrete implementation declares a unique string alias via the `#[AsAlias]` attribute. The consumer type-hints the interface and selects the specific service using the `#[Target]` attribute.
* **⚠️ Golden Rule for the Exam:** When using the `#[Target('my_alias')]` attribute, the corresponding service class **must** be explicitly assigned a matching string alias using `#[AsAlias(id: 'my_alias')]`. Otherwise, the container compilation will fail with a `DefinitionErrorException`, as a target cannot resolve a pure FQCN class during interface autowiring.
* **Advantage:** Complete independence from the internal variable names of the consumer class, making it fully refactoring-safe.

#### Practice Matrix of Involved Components:
* [`InvoiceFormatterInterface`](../../src/DependencyInjection/Service/InvoiceFormatterInterface.php) — The shared interface (Abstraction).
* [`PdfInvoiceFormatter`](../../src/DependencyInjection/Service/PdfInvoiceFormatter.php) — Features `#[AsAlias(id: 'pdfInvoiceFormatter')]` for target binding [Anchor: DI_L2_PDF_FORMATTER].
* [`HtmlInvoiceFormatter`](../../src/DependencyInjection/Service/HtmlInvoiceFormatter.php) — Features `#[AsAlias(id: 'htmlInvoiceFormatter')]` for target binding [Anchor: DI_L2_HTML_FORMATTER].
* [`InvoiceManager`](../../src/DependencyInjection/Service/InvoiceManager.php) — The consumer enforcing resolution via `#[Target('pdfInvoiceFormatter')]` and `#[Target('htmlInvoiceFormatter')]`.
* [`DebugInvoiceCommand`](../../src/DependencyInjection/Command/DebugInvoiceCommand.php) — The active CLI entry point.

### 🧠 Critical Exam Knowledge: Compiler Optimization
If a private service (`public: false`) or an interface alias is **not** actively requested as a dependency by any registered framework entry point (such as a console command or controller), the `RemoveUnusedDefinitionsPass` kicks in during container compilation.

* **Behavior:** Symfony silently removes these unused definitions from the DI container (Dead Code Elimination).
* **Effect:** The `cache:clear` command succeeds without errors, but running `debug:container <Service-ID>` will fail with a critical error because the ID no longer exists in the compiled container. The entire DI chain is only preserved once it is linked to an active entry point like our command.

## 🧠 Exam Flashcards
- **Question:** What happens if a service alias is defined via the `#[AsAlias]` attribute on a class, but a different alias for the same interface is explicitly set in `services.yaml`?

  **Answer:** The YAML configuration takes precedence and silently overrides the PHP class attribute.

- **Question:** When using the `#[Target('invoice_pdf')]` attribute to resolve an ambiguous interface implementation, what must the target class declare?

  **Answer:** The target class must explicitly be assigned a matching string alias using the attribute `#[AsAlias(id: 'invoice_pdf')]`. Otherwise, compilation fails with a `DefinitionErrorException`.

- **Question:** Why might a correctly configured private service disappear from `debug:container <Service-ID>` even though `cache:clear` runs without errors?

  **Answer:** The `RemoveUnusedDefinitionsPass` removed it. If a private service is not injected into any active framework entry point (like a Controller or Command), Symfony purges it from the compiled container during optimization.

- **Question:** What three configuration keys are applied by default under the `_defaults:` block in a standard Symfony `services.yaml`?

  **Answer:** `autowire: true` (resolves dependencies via reflection), `autoconfigure: true` (automatically adds tags based on class hierarchy), and `public: false` (makes services private by default).

Look at this service class constructor utilizing a core DI attribute:
```php
namespace App\Manager;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\Target;

class OrderManager {
    public function __construct(
        #[Target('localLogger')]
        private LoggerInterface \$appLogger
    ) {}
}
```
- **Question:** What determines whether this dependency autowires successfully: the attribute string argument `'localLogger'` or the native PHP variable name `$appLogger`?

  **Answer:** The attribute string **`'localLogger'`** determines success. **Reason:** The `#[Target]` attribute explicitly instructs the compiler pass to look for a registered service or alias with the exact ID `localLogger`. Once `#[Target]` is explicitly defined, the actual variable name (`$appLogger`) is completely ignored by the container's dependency resolution mechanics.

---
Licensed under the [MIT License](../../LICENSE).
