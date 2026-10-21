# 🚀 Symfony 8 Certified Developer – Preparation Sandbox

**Status:** 🛠️ In Progress  
**Target:** Symfony 8.1 / PHP 8.4+

> 💡 **Note for Tech-Leads & Recruiters:** This repository is my personal sandbox for the upcoming Symfony 8 certification exam. Working on this alongside my full-time job, so commits happen in focused bursts rather than daily updates. It's used purely to verify framework edge cases, compiler passes, and modern PHP 8.4 features.
This sandbox runs on **Ubuntu 24.04** with **PHP 8.4+** and **Symfony 8.x** inside a **FrankenPHP** containerized environment. It serves as a hands-on tracker for digging into framework internals. 

### 📅 Progress Tracker & Master Plan

Structured around the 14 core topics from the [sfcelearning.com](https://sfcelearning.com/8.0/topics/) curriculum. 

### 🏛️ Weeks 1 & 2: Core Foundations & Infrastructure

#### 🏗️ Architecture & HttpKernel Lifecycle (SFCE Topic 3)

* [x] **HTTP Foundation & Flex** 

    * 📑 Docs: [Chapter 1 Lesson 1 – HTTP Foundation & Flex](./docs/Architecture/Chapter_1_Lesson_1_HTTP_Foundation_Flex_Licensing.md)
* [x] **Configuration Hierarchy** 

    * 📑 Docs: [Chapter 1 Lesson 2 – Environment Variables & Configuration](./docs/Architecture/Chapter_1_Lesson_2_Environment_Variables%20_Configuration_Hierarchy.md)
* [x] **Invokable Architecture & SOLID** 

    * 📑 Docs: [Chapter 2 Lesson 1 – Invokable Architecture and SOLID](./docs/Architecture/Chapter_2_Lesson_1_Invokable_Architecture_and_SOLID.md)
* [x] **HttpKernel Lifecycle & Core Events** 

    * 📑 Docs: [Chapter 3 Lesson 1 – HttpKernel Lifecycles, Events & Exceptions](./docs/Architecture/Chapter_3_Lesson_1_HttpKernel_Lifecycles_Events_Exceptions.md)
* [x] **Components & Service Locators** 

    * 📑 Docs: [Chapter 3 Lesson 2 – Components and Service Locators](./docs/Architecture/Chapter_3_Lesson_2_Components_and_Service_Locators.md)
    * 📜 Cheatsheet: [Architecture Exam Notes](./docs/Architecture/exam-cheatsheet-architecture.md)
* [x] **Sandbox Verification** 

    * 💻 Code: [SpyController.php](./src/Architecture/Controller/Debug/SpyController.php) | [SpySubscriber.php](./src/Architecture/EventSubscriber/SpySubscriber.php)

#### ⚡ Dependency Injection & Container Compilation (SFCE Topic 9)

* [x] **Dependency Injection Component Basics** 

    * 📑 Docs: [Chapter 1 Lesson 1 – Dependency Injection Component](./docs/DependencyInjection/Chapter1_Lesson1-Dependency_Injection_Component.md)
* [x] **Container Lifecycle & Compiler Phases** 

    * 📑 Docs: [Chapter 1 Lesson 3 – Container Lifecycle & Phases](./docs/DependencyInjection/Chapter1-Lesson3-Container_Lifecycle_&_Phases.md)
* [x] **Service Container Basics (Sandbox State)** 

    * 📑 Docs: [Chapter 2 Lesson 1 – Service Container](./docs/DependencyInjection/Chapter2-Lesson1_Service_Container.md)
    * 🔬 Manager: [InvoiceManager.php](./src/DependencyInjection/Service/InvoiceManager.php)
    * 💻 Implementations: [InvoiceFormatterInterface.php](./src/DependencyInjection/Service/InvoiceFormatterInterface.php) | [PdfInvoiceFormatter.php](./src/DependencyInjection/Service/PdfInvoiceFormatter.php) | [HtmlInvoiceFormatter.php](./src/DependencyInjection/Service/HtmlInvoiceFormatter.php)
* [ ] **EventDispatcher & Core Events** (SFCE Topic 11)

### ⚙️ Weeks 3 & 4: HTTP & Application Logic

* [ ] **Advanced Routing & Edge Cases** (SFCE Topic 5)
* [ ] **Controller Utility & Argument Resolvers** (SFCE Topic 4)
* [ ] **Configuration & Secrets System** (SFCE Topic 2)

### 🔐 Week 5: Enterprise Features

* [ ] **Security Deep-Dive** (SFCE Topic 10)
* [ ] **Messenger, Workflow & Cache-Pools** (SFCE Topics 10, 14)

### 🔍 Week 6: Testing & Tooling

* [ ] **WebTestCase & Profiler Tests** (SFCE Topic 13)
* [ ] **Console Commands & CLI Flags** (SFCE Topic 12)
* [ ] **Mock-Exam Simulations**

### 💻 Environment

* **OS:** Ubuntu 24.04 LTS
* **Engine:** PHP 8.4+ (FrankenPHP Docker Container)
* **Framework:** Symfony 8.x (Skeleton)
* **Database:** PostgreSQL 16
* **IDE:** PhpStorm

### 🛠️ Local Setup

bash

# 1. Clone & Navigate
git clone https://github.com/behrus/symfony8-certification-prep.git
cd symfony8-certification-prep

# 2. Spin up containers (compiles custom FrankenPHP image with pdo_pgsql)
docker compose up -d --build

# 3. Install dependencies inside container
docker compose exec web composer install

# 4. Setup DB
docker compose exec web php bin/console doctrine:database:create

Verwende Code mit Vorsicht.

App is available at 👉 **http://localhost** 

### 👤 Profile

* **Name:** Behrouz Heidarzadeh
* **Role:** Senior Backend Engineer
* **LinkedIn:** [https://www.linkedin.com/in/behrouz-heidarzadeh-927a87282/](https://www.linkedin.com/in/behrouz-heidarzadeh-927a87282/)
