# Topic 9: Dependency Injection (DI)

## Chapter 1 - Lesson 1: Dependency Injection Component

**Core Concept:** The DI component operates completely decoupled from the full-stack framework. It relies on a strict operational separation between *Compile Time* (mutable configuration phase) and *Runtime* (immutable execution phase) [Anchor: DI-L1-COMPILE-VS-RUNTIME].

### Standalone Interface Binding [Anchor: DI-L1-INTERFACE-BINDING]
* **Mechanism:** In the raw Component layer, an interface cannot be automatically instantiated. It requires a manual reference map or an explicit alias assignment so that the `ContainerBuilder` knows which concrete service ID to resolve when the interface is requested.
* **Sandbox Code:** See the structural contract declaration inside [`src/DependencyInjection/Service/InvoiceFormatterInterface.php`](../../src/DependencyInjection/Service/InvoiceFormatterInterface.php).
* **Exam Trap:** Requesting a raw interface without any registered alias or backing service definition always causes a `ServiceNotFoundException` during container compilation.
