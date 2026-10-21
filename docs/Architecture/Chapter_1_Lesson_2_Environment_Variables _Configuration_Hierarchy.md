# 📄 Session Protocol: Symfony 8 Environment Variables & Configuration Hierarchy

**Topic:** Environment Variables, Convention over Configuration, and Team Workflows  
**Section:** Section 1 – Architecture & Core Lifecycles (Extension)

---

## 🏛️ 1. The Principle: "Convention over Configuration"
* **Definition:** If your local configuration files (e.g., `config/packages/cache.yaml`) define no explicit values or are completely commented out, Symfony will not crash. Instead, the framework automatically resolves back to its built-in bundle defaults (**Conventions**).
* **Practical Example:** An empty `cache.yaml` causes Symfony's `FrameworkBundle` to implicitly fall back to using `cache.adapter.filesystem` as the underlying driver for the core application cache pool (`cache.app`).
* **Live Container Inspection Command:**
  ```bash
  docker compose exec web bin/console debug:config framework cache
  ```
  *Note: This command does not print file contents; it inspects the actual, active runtime configuration compiled into container memory.*

---

## 🔑 2. The Git & Security Boundary for Environments

In a professional enterprise team architecture, a strict line is drawn between **structural behavioral configuration** and **environmental secrets (credentials/passwords)**.

### 🟢 Files That Belong in Git (Committed)
1. **`.env` (The Lowest Common Denominator):** Contains safe baseline defaults for the *entire development team*. It should strictly utilize lightweight technologies guaranteed to run out of the box on any machine without external dependencies (e.g., `CACHE_ADAPTER=cache.adapter.filesystem`).
2. **`.env.prod` (The Production Blueprint):** Defines structural, non-sensitive production configurations (e.g., `APP_ENV=prod`, `APP_DEBUG=0`, `CACHE_ADAPTER=cache.adapter.redis`). It must **never** contain actual live passwords, tokens, or encryption keys.

### 🔴 Mechanisms That NEVER Belong in Git (Ignored)
1. **`.env.local`:** Reserved for *personal, localized overrides* on an individual developer's laptop (e.g., when you want to explicitly test Redis locally while your team remains on the filesystem default).
2. **`.env.prod.local` (Legacy/Shared Hosting Fallback):** Resides strictly on the physical production server to override `.env.prod` with real live database strings and passwords.
3. **Real System Environment Variables (The Senior Standard):** Injected directly into the operating system environment, Web Server, or container orchestration pipeline (Docker Compose, Kubernetes). **Real system environment variables always win over `.env` files.**

---

## 📊 3. The Runtime Resolution Hierarchy (Strict Exam Priority)

When Symfony encounters an environmental parameter placeholder (e.g., `%env(CACHE_ADAPTER)%`), it scans available vectors in a **strict, unalterable sequence**. The first source that contains the variable wins immediately:

* **Priority 1:** Real System Environment Variables (OS / Container Environment)
* **Priority 2:** `.env.$APP_ENV.local` (e.g., `.env.prod.local` - Server-specific overrides)
* **Priority 3:** `.env.$APP_ENV` (e.g., `.env.prod` - Target environment blueprint, in Git)
* **Priority 4:** `.env.local` (Developer's local machine overrides)
* **Priority 5:** `.env` (Global team baselines, in Git)

---

## 💡 4. The Architectural Bridge to Dependency Inversion (DIP)

By pairing this environment priority stack with stable abstractions, Symfony achieves perfect infrastructure decoupling:
* Your high-level application code requests an abstraction via type-hinting: `private CacheInterface $cache`.
* The configuration passes a placeholder to delegate implementation: `app: '%env(CACHE_ADAPTER)%'`.
* **The Outcome:** On your local laptop, Symfony injects a `FilesystemAdapter`. On the cloud server, it seamlessly injects a `RedisAdapter` into *the exact same execution path*. Your business PHP code remains 100% untouched, fully honoring the SOLID principles.

---
*End of Protocol.*

---

Licensed under the [MIT License](../../LICENSE).
