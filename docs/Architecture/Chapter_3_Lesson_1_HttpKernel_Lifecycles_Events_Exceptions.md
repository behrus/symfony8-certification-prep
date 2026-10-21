# 📄 System Protocol: HttpKernel Lifecycles, Events & Exceptions (Symfony 8)

### 🧩 SOLID Principles Reference
* **Single Responsibility Principle (SRP):** Honored by **Invokable Controllers** (Single-Action). Rather than writing giant classes tracking CRUD logic, specialized classes resolve exactly **one HTTP endpoint** via PHP's magic `__invoke()` method.

---

## 1. Evolving Framework Boots (Runtime & Invoke)
* **The Magic `__invoke()` Pattern:** Converts any standard object into a PHP `callable` type. It permits invoking the instance like a function (`$controller()`). Symfony uses it heavily for single-action controllers and asynchronous *Messenger Handlers*.
* **The Modern Entry Loop:** Modern entry files (`public/index.php`) return a static closure wrapping a runtime `$context` array containing environment settings (`APP_ENV`, `APP_DEBUG`). The standalone `Runtime` component intercepts this closure, instantiates the kernel, builds the global `Request` data from server state, and pushes execution to the framework loop.

---

## 2. The 8 Core HttpKernel Events Order
When `$kernel->handle($request)` initiates, the application triggers a sequential stack of events:

1. **`kernel.request`:** Initial request inspection. The built-in **`RouterListener`** (Priority `32`) matches routes and writes mappings directly to `$request->attributes`.
    * *💡 Early Response:* If any listener returns a response object via `$event->setResponse()`, propagation cuts out immediately. It skips the controllers entirely and routes straight to `kernel.response`.
2. **`kernel.controller`:** The active callable controller has been found. Allows global injection, overrides, or checking custom action security attributes.
3. **`kernel.controller_arguments`:** Triggers once the `ArgumentResolver` maps parameters onto the controller action signature. Last option to override arguments before the controller runs.
4. **`kernel.view` (Optional):** Fires **only** if the executed controller returns non-Response variants (e.g., a native PHP array). An active listener must capture this array and render a real `Response` (via Twig or JSON conversions).
5. **`kernel.response`:** The final `Response` payload is established. Used to alter headers or inject the WebProfiler debug bar.
6. **`kernel.finish_request`:** Pops the request stack. Vital for **Sub-Requests** (e.g., Twig rendering a controller fragment) to reset system states like locales back to the main request context.
7. **`kernel.terminate`:** Fires **after** output buffers have been flushed to the browser client (`$response->send()`). Ideal for heavy, non-blocking background logic (e.g., mail queues, flush operations).
    * *⚠️ Failure Mode:* If the framework encounters a fatal crash or an unhandled exception before output delivery, `kernel.terminate` is **never** reached.

---

## 3. Exception Handling Structures
* **The Emergency Airbag:** Uncaught application failures stop processing instantly and launch **`kernel.exception`**.
* **Sub-Request Errors:** The internal `ErrorListener` intercepts the failure and kicks off an internal isolated **Sub-Request** directed at an error rendering controller. This creates a formatted error response page and passes it directly down to `kernel.response`.
* **Cascading Failures:** If a custom listener throws an exception *inside* the `kernel.exception` sequence, Symfony aborts to block infinite recursive loop traps and exposes the failure as a raw, primitive PHP error.
* **Errors During Terminate:** Exceptions thrown inside the post-send `kernel.terminate` cycle are quietly trapped by the `ErrorHandler` and piped to server logs. They cannot output an HTML error page because client data streams are already shut down.

---

## 4. Technical Engine Settings
* **Event Dispatcher Priorities:** Configured as integer markers. **Higher positive numbers execute first**. To enforce a execution sequence as the absolute final step, use high negative values (e.g., `-255`).
* **Sub-Request Isolation:** Inside a listener method, always query **`$event->isMainRequest()`** to check whether you are handling the primary browser entry or an internal loop (Symfony versions prior to 5.2 used `isMasterRequest()`).

---
Licensed under the [MIT License](../../LICENSE).