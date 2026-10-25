# 🚀 Symfony 8 Certified Developer – Preparation Sandbox

**Status:** 🛠️ In Progress  
**Target:** Symfony 8.0+ / PHP 8.4+

> 💡 **Note for Tech-Leads & Recruiters:** This repository is my personal sandbox for the upcoming Symfony 8 certification exam. Working on this alongside my full-time job, so commits happen in focused bursts rather than daily updates. It's used purely to verify framework edge cases, compiler passes, and modern PHP 8.4 features.

This sandbox runs on **Ubuntu 24.04** with **PHP 8.4+** and **Symfony 8.x** inside a **FrankenPHP** containerized environment. It serves as a hands-on tracker for digging into framework internals.

---

## 🧠 Anki Spaced Repetition Workflow

To internalize complex framework internals, compiler exceptions, and strict CLI flags for the English multiple-choice exam, this repository utilizes a **dual-documentation system**:

1. **The Core Concepts (`.md`):** Detailed architectural write-ups inside the respective subfolders of `docs/`.
2. **The Anki Flashcards (`_ANKI_CARD.txt`):** Every single lesson includes a dedicated, tab-separated flashcard file inside its local `Anki_Cards/` subfolder, ready for bulk-import into the Anki Software.

---

## 📅 Progress Tracker & Master Plan

Structured around the 14 core topics from the `sfcelearning.com` curriculum.

### 🏛️ Weeks 1 & 2: Core Foundations & Infrastructure

#### 🏗️ Architecture & HttpKernel Lifecycle (SFCE Topic 3)
* [x] **HTTP Foundation & Flex**
    * 📑 Docs: [Chapter_1_Lesson_1_HTTP_Foundation_Flex_Licensing.md](docs/Architecture/Chapter_1_Lesson_1_HTTP_Foundation_Flex_Licensing.md)
    * 🎴 Flashcards: [%20Chapter_1_Lesson_1_HTTP_Foundation_Flex_Licensing_ANKI_CARD.txt%20](docs/Architecture/Anki_Cards/%20Chapter_1_Lesson_1_HTTP_Foundation_Flex_Licensing_ANKI_CARD.txt%20)
* [x] **Configuration Hierarchy**
    * 📑 Docs: [Chapter_1_Lesson_2_Environment_Variables _Configuration_Hierarchy.md](docs/Architecture/Chapter_1_Lesson_2_Environment_Variables%20_Configuration_Hierarchy.md)
    * 🎴 Flashcards: [Chapter_1_Lesson_2_Environment_Variables_Configuration_Hierarchy_ANKI_CARD.txt](docs/Architecture/Anki_Cards/Chapter_1_Lesson_2_Environment_Variables_Configuration_Hierarchy_ANKI_CARD.txt)
* [x] **Invokable Architecture & SOLID**
    * 📑 Docs: [Chapter_2_Lesson_1_Invokable_Architecture_and_SOLID.md](docs/Architecture/Chapter_2_Lesson_1_Invokable_Architecture_and_SOLID.md)
    * 🎴 Flashcards: [Chapter_2_Lesson_1_Invokable_Architecture_and_SOLID_ANKI_CARD.txt](docs/Architecture/Anki_Cards/Chapter_2_Lesson_1_Invokable_Architecture_and_SOLID_ANKI_CARD.txt)
* [x] **HttpKernel Lifecycle & Core Events**
    * 📑 Docs: [Chapter_3_Lesson_1_HttpKernel_Lifecycles_Events_Exceptions.md](docs/Architecture/Chapter_3_Lesson_1_HttpKernel_Lifecycles_Events_Exceptions.md)
    * 🎴 Flashcards: [Chapter_3_Lesson_1_HttpKernel_Lifecycles_Events_Exceptions_ANKI_CARD.txt](docs/Architecture/Anki_Cards/Chapter_3_Lesson_1_HttpKernel_Lifecycles_Events_Exceptions_ANKI_CARD.txt)
* [x] **Components & Service Locators**
    * 📑 Docs: [Chapter_3_Lesson_2_Components_and_Service_Locators.md](docs/Architecture/Chapter_3_Lesson_2_Components_and_Service_Locators.md)
    * 🎴 Flashcards: [Chapter_3_Lesson_2_Components_and_Service_Locators_ANKI_CARD.txt](docs/Architecture/Anki_Cards/Chapter_3_Lesson_2_Components_and_Service_Locators_ANKI_CARD.txt)
* [x] **Exam Reference Sheets**
    * 📜 Cheatsheet: [exam-cheatsheet-architecture.md](docs/Architecture/exam-cheatsheet-architecture.md)
* [x] **Sandbox Verification**
    * 💻 Code: `SpyController.php` | `SpySubscriber.php`

#### ⚡ Dependency Injection & Container Compilation (SFCE Topic 9)
* [x] **Dependency Injection Component Basics**
    * 📑 Docs: [Chapter1_Lesson1-Dependency_Injection_Component.md](docs/DependencyInjection/Chapter1_Lesson1-Dependency_Injection_Component.md)
    * 🎴 Flashcards: [Chapter1_Lesson1-Dependency_Injection_Component_ANKI_CARD.txt](docs/DependencyInjection/Anki_Cards/Chapter1_Lesson1-Dependency_Injection_Component_ANKI_CARD.txt)
* [x] **Container Lifecycle & Compiler Phases**
    * 📑 Docs: [Chapter1-Lesson3-Container_Lifecycle_&_Phases.md](docs/DependencyInjection/Chapter1-Lesson3-Container_Lifecycle_&_Phases.md)
    * 🎴 Flashcards: [Chapter1-Lesson3-Container_Lifecycle_&_Phases_ANKI_CARD.txt](docs/DependencyInjection/Anki_Cards/Chapter1-Lesson3-Container_Lifecycle__Phases_ANKI_CARD.txt)
* [x] **Service Container Basics (Sandbox State)**
    * 📑 Docs: [Chapter2-Lesson1_Service_Container.md](docs/DependencyInjection/Chapter2-Lesson1_Service_Container.md)
    * 🎴 Flashcards: [Chapter2-Lesson1_Service_Container_ANKI_CARD.txt](docs/DependencyInjection/Anki_Cards/Chapter2-Lesson1_Service_Container_ANKI_CARD.txt)
    * 📜 Context-Docs: [Interface_aliasing _in_Symfony.md](docs/DependencyInjection/Interface_aliasing%20_in_Symfony.md) | [Service_container.md](docs/DependencyInjection/Service_container.md)
    * 🔬 Manager: `InvoiceManager.php`
    * 💻 Implementations: `InvoiceFormatterInterface.php` | `PdfInvoiceFormatter.php` | `HtmlInvoiceFormatter.php`
* [ ] **EventDispatcher & Core Events (SFCE Topic 11)**

### ⚙️ Weeks 3 & 4: HTTP & Application Logic
* [ ] Advanced Routing & Edge Cases (SFCE Topic 5)
* [ ] Controller Utility & Argument Resolvers (SFCE Topic 4)
* [ ] Configuration & Secrets System (SFCE Topic 2)

### 🔐 Week 5: Enterprise Features
* [ ] Security Deep-Dive (SFCE Topic 10)
* [ ] Messenger, Workflow & Cache-Pools (SFCE Topics 10, 14)

### 🔍 Week 6: Testing & Tooling
* [ ] WebTestCase & Profiler Tests (SFCE Topic 13)
* [ ] Console Commands & CLI Flags (SFCE Topic 12)
* [ ] Mock-Exam Simulations

---

## 💻 Environment

* **OS:** Ubuntu 24.04 LTS
* **Engine:** PHP 8.4+ (FrankenPHP Docker Container)
* **Framework:** Symfony 8.x (Skeleton)
* **Database:** PostgreSQL 16
* **IDE:** PhpStorm

---

## 🛠️ Local Setup

```bash
# 1. Clone & Navigate
git clone https://github.com
cd symfony8-certification-prep

# 2. Spin up containers (compiles custom FrankenPHP image with pdo_pgsql)
docker compose up -d --build

# 3. Install dependencies inside container
docker compose exec web composer install

# 4. Setup DB
docker compose exec web php bin/console doctrine:database:create
```

App is available at 👉 http://localhost

---

## 👤 Profile

* **Name:** Behrouz Heidarzadeh
* **Role:** Senior Backend Engineer
* **LinkedIn:** [Behrouz Heidarzadeh](https://linkedin.com)
