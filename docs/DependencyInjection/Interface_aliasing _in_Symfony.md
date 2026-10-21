# Topic 9: Dependency Injection (DI) — Study Protocol

# Interface Aliasing in Symfony Dependency Injection

## The Type-Hint Dilemma
When autowiring encounters a constructor parameter type-hinted with an interface (e.g., `PaymentProcessorInterface`), Symfony searches its container registry for a service ID matching the exact interface string name. Because interfaces cannot be instantiated, this lookup fails by default, throwing a `RuntimeException` if multiple implementations exist or no direct match is found.

## The Alias Solution
An interface alias resolves this by introducing a compile-time pointer in `services.yaml`. It explicitly instructs the container builder: *"Whenever this interface is requested, resolve it to this specific concrete service ID."*

## Under the Hood: Compile Time vs. Runtime
* **Compile Time:** The `ContainerBuilder` processes the configuration and registers an alias pointer rather than creating a new standalone service.
* **Autowiring Pass:** As Symfony parses consumer constructors, it intercepts the interface type-hint request, detects the alias, and seamlessly substitutes it with the reference to the concrete service (e.g., `@App\Payment\StripePaymentProcessor`).
* **Dumping Phase (`PhpDumper`):** In the final optimized cache, the interface abstraction is completely stripped away. The `PhpDumper` generates linear PHP code that instantiates the concrete consumer with the concrete dependency passed directly into the constructor.

## Examples:
* App\Service\OrderProcessor
* App\Service\SmsNotifierInterface
* App\Service\TwilioSmsInterface
* Interface aliasing definition in services.yaml
---

Licensed under the [MIT License](../../LICENSE).
