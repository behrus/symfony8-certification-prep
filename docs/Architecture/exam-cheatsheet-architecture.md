# 🏆 Symfony 8 Certification Cheat Sheet: Sektion 1 – Architecture

This cheat sheet compiles the absolute critical "Exam Traps" and core architectural facts for Sektion 1 (Topic 1: Architecture) based on the official Symfony certification standards. Review this right before the exam!

---

## 🚨 1. Top 5 "Exam Traps" to Watch For (Answering Pitfalls)

### Trap 1: HTTP Header Case Sensitivity
* **The Trap:** The exam shows code like `$request->headers->get('User-Agent');` and asks if it is correct.
* **The Fact:** While it might work in production due to Symfony's internal fallbacks, for the exam **all internal header keys are strictly normalized to lowercase**. The only 100% correct answer is: `$request->headers->get('user-agent');`.

### Trap 2: Bypassing the Controller via Early Response
* **The Trap:** A question asks which events or resolvers are triggered when a listener calls `$event->setResponse()` during `kernel.request`.
* **The Fact:** Setting an early response triggers a **short-circuit**. The `ControllerResolver`, `ArgumentResolver`, and the actual controller class are **completely skipped**. The system routes execution straight into `kernel.response`.

### Trap 3: The `kernel.terminate` Execution Guarantee
* **The Trap:** A True/False question asks: *"Does kernel.terminate always run to clean up background tasks?"*
* **The Fact:** **False.** `kernel.terminate` only fires if the HTTP request completed its regular loop and the response was successfully flushed to the client via `$response->send()`. If the application crashes midway with a fatal 500 error, `kernel.terminate` is **never reached**.

### Trap 4: Object Mutability Standards (Symfony vs. PSR-7)
* **The Trap:** A question implies that Symfony uses PSR-7 HTTP messages natively because they are standard.
* **The Fact:** **False.** Symfony's `HttpFoundation` objects (`Request`/`Response`) are **mutable** (can be changed inline via parameters). PSR-7 objects are strictly **immutable**. Symfony supports PSR-7 *exclusively* via an optional external wrapper called the `PSR-7 Bridge`.

### Trap 5: Cascading Errors inside `kernel.exception`
* **The Trap:** What happens if a custom error listener crashes with a new exception while trying to handle a previous exception?
* **The Fact:** Symfony immediately cuts off the event propagation loop to prevent infinite recursion traps. It halts the framework cycle and bubbles the failure straight up as a **raw PHP primitive error**.

---

## 🏎️ 2. The Core Lifecycle Engine (Fast Review)

### The Entry Chain
1. **Runtime Component:** Intercepts the closure inside `public/index.php`, inspects the environment (`APP_ENV`/`APP_DEBUG`), boots the `Kernel`, and automatically instantiates the `Request` object from global server state (`$_GET`, `$_POST`, etc.).
2. **Kernel Initialization:** The Kernel constructor *only* takes `APP_ENV` and `APP_DEBUG`. All other application environmental variables (like `DATABASE_URL`) are read and populated in the system globally during the `$kernel->boot()` phase via `symfony/dotenv`.

### Direct Event Checklist (Chronological Order)
1. `kernel.request` ➔ Used to match URLs (`RouterListener` priority `32`).
2. `kernel.controller` ➔ Controller callable established; perfect for global inspection.
3. `kernel.controller_arguments` ➔ Fired right after `ArgumentResolver` maps arguments onto the controller.
4. `kernel.view` ➔ **Only fires** if the controller returns a non-Response variant (like a raw array).
5. `kernel.response` ➔ Final payload modification (adding headers, profiling data).
6. `kernel.finish_request` ➔ Cleans up the request stack, crucial for restoring locale contexts during sub-requests.
7. `kernel.terminate` ➔ Post-response loop for heavy non-blocking background logic (mail queues, system logs).

---

## 🛠️ 3. Architectural Rules of Thumb

* **Event Dispatcher Direction:** Integers drive priority. **Higher positive numbers execute first**. To enforce a listener as the absolute final step, configure high negative values (e.g., `-255`).
* **Sub-Request Identification:** Modern hooks check context via `$event->isMainRequest()`. Old legacy calls like `isMasterRequest()` are obsolete since version 5.3+.
* **The `@internal` PHPDoc Promise:** Code marked with `@internal` is strictly for internal framework mechanics. It is fully excluded from the Backwards Compatibility (BC) promise and must never be referenced inside custom application logic.
* **Contracts vs. Bridges:** Contracts (`symfony/contracts`) are decoupled, zero-logic PHP interfaces. Bridges are structural wrappers that adapt heavy third-party software (like Doctrine or Twig) to work natively within the Symfony container.
* **Cache Pool Partitioning:** Pools are logical application compartments (e.g., `blog.cache`) enforcing separate scopes. Adapters are the actual storage backends (Redis, Filesystem). Custom cache tagging explicitly requires the `TagAwareAdapterInterface`.

---

## 📝More Practice Questions & Answers

### ❓ Question 1: HttpKernel Events & Lifecycle
A developer registers a listener for the `kernel.request` event. Inside this listener, the developer calls `$event->setResponse(new Response('Hello'));`. Which of the following statements are correct? *(Select 2 answers)*

* [ ] **A)** The `ArgumentResolver` is executed immediately after to validate the controller arguments.
* [x] **B) The remaining listeners of the `kernel.request` event with lower priorities are skipped.**
* [ ] **C)** The router (`RouterListener`) will still attempt to match the incoming URL regardless.
* [x] **D) The framework completely bypasses the controller and short-circuits straight to the `kernel.response` event.**

> **💡 Exam Fact:** Calling `$event->setResponse()` triggers an immediate **short-circuit**. It instantly stops event propagation (skipping all subsequent listeners in `kernel.request`) and bypasses the `ControllerResolver`, `ArgumentResolver`, and the controller itself, routing execution straight into `kernel.response`.

---

### ❓ Question 2: HTTP Foundation & Headers
You want to check inside a controller if the request contains the custom header `X-Custom-Auth`. For the purpose of the certification exam, which of the following is the *only 100% correct* way to retrieve it? *(Select 1 answer)*

* [ ] **A)** `$request->headers->get('X-Custom-Auth');`
* [x] **B) `$request->headers->get('x-custom-auth');`**
* [ ] **C)** `$request->getHeaders()->get('X-Custom-Auth');`
* [ ] **D)** `$request->server->get('HTTP_X_CUSTOM_AUTH');`

> **💡 Exam Fact:** This is a classic exam trap. Even though Symfony is forgiving in production, the official documentation states that all internal header keys in the `HeaderBag` are **strictly normalized to lowercase**. Therefore, `x-custom-auth` is the only theoretically correct answer.

---

### ❓ Question 3: Kernel Exception Handling
During the processing of an HTTP request, the application crashes inside a controller due to an uncaught exception. What happens next within the HttpKernel lifecycle? *(Select 2 answers)*

* [ ] **A)** The `kernel.terminate` event is triggered to flush logs and free up system resources.
* [x] **B) The `kernel.exception` event is dispatched, and the built-in `ErrorListener` kicks off an internal Sub-Request.**
* [ ] **C)** The `kernel.view` event is triggered because the controller failed to return a valid Response object.
* [x] **D) If a custom listener throws a *new* exception *inside* the `kernel.exception` cycle, Symfony cuts off propagation and bubbles up a raw PHP primitive error.**

> **💡 Exam Fact:** Uncaught errors immediately dispatch `kernel.exception`. The framework handles this via an isolated **Sub-Request** to render an error page. However, if your error-handling code *also* crashes, Symfony halts event processing to prevent an infinite recursive loop trap, resulting in a **raw PHP primitive error**. Also note that `kernel.terminate` is *never* reached if a fatal crash occurs mid-flight.

---

### ❓ Question 4: Service Locator & Strategy Pattern
You implement the Strategy Pattern to handle 20 distinct payment providers using Symfony's modern `#[TaggedLocator]` attribute. Which statement regarding performance and memory management is correct? *(Select 1 answer)*

* [ ] **A)** All 20 payment service instances are eagerly loaded into RAM immediately when the Kernel boots.
* [x] **B) The concrete strategy services are lazy-loaded and instantiated *only* when explicitly requested via `$locator->get('service_id')`.**
* [ ] **C)** Utilizing a Service Locator in this manner violates the Dependency Inversion Principle (DIP) and is discouraged in Symfony 8.
* [ ] **D)** Without explicit, manual XML or YAML compiler configuration, the Service Locator cannot map the tagged instances.

> **💡 Exam Fact:** A localized **Service Locator** is the textbook solution for the Strategy Pattern in Symfony. By pairing it with `#[TaggedLocator]`, all heavy concrete services are **strictly lazy-loaded**. They wake up in memory only when called via `$locator->get()`, keeping your application's RAM and CPU footprint exceptionally small.

---

Licensed under the [MIT License](../../LICENSE).
