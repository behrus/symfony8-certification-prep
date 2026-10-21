### 🚀 Symfony 8 Certified Developer – Preparation Sandbox

Status-Badge:
[](https://github.com/behrus/symfony8-certification-prep) 

Symfony-Badge:
[](https://symfony.com) 

💡 **Note for Recruiters and Tech-Leads:** This repository is my active training ground for the upcoming Symfony 8 certification. Since I am working on this **alongside my full-time job**, updates occur in focused bursts rather than daily commits. It is an evolving sandbox designed to systematically test code examples, custom compiler passes, and framework edge cases. 

Welcome to the active preparation repository for the official **Symfony Certified Developer** exam.
This sandbox is built on **Ubuntu 24.04** using **PHP 8.4+** and **Symfony 8.x** inside a fully containerized environment powered by **FrankenPHP**. 

The goal of this repository is to deep-dive into the framework's architecture, master modern PHP attributes, practice core enterprise components, and track my progress through the core exam topics. 

### 📅 6-Week Certification Master Plan & Progress Tracker

A structured preparation roadmap aligned strictly with the official 14 core topics of the Symfony Framework Certification Exam curriculum from [sfcelearning.com](https://sfcelearning.com/8.0/topics/). 

### 🏛️ Weeks 1 & 2: Core Foundations & Infrastructure

#### 🏗️ Architecture & HttpKernel Lifecycle (SFCE Topic 3)

* [x] **HTTP Foundation & Flex** 

    * 📑 Theory Reference: [Chapter 1 Lesson 1 – HTTP Foundation & Flex](./docs/Architecture/Chapter_1_Lesson_1_HTTP_Foundation_Flex_Licensing.md)
* [x] **Configuration Hierarchy** 

    * 📑 Theory Reference: [Chapter 1 Lesson 2 – Environment Variables & Configuration](./docs/Architecture/Chapter_1_Lesson_2_Environment_Variables%20_Configuration_Hierarchy.md)
* [x] **Invokable Architecture & SOLID** 

    * 📑 Theory Reference: [Chapter 2 Lesson 1 – Invokable Architecture and SOLID](./docs/Architecture/Chapter_2_Lesson_1_Invokable_Architecture_and_SOLID.md)
* [x] **HttpKernel Lifecycle & Core Events** 

    * 📑 Theory Reference: [Chapter 3 Lesson 1 – HttpKernel Lifecycles, Events & Exceptions](./docs/Architecture/Chapter_3_Lesson_1_HttpKernel_Lifecycles_Events_Exceptions.md)
* [x] **Components & Service Locators** 

    * 📑 Theory Reference: [Chapter 3 Lesson 2 – Components and Service Locators](./docs/Architecture/Chapter_3_Lesson_2_Components_and_Service_Locators.md)
    * 📜 Quick-Review: [Architecture Exam Cheatsheet](./docs/Architecture/exam-cheatsheet-architecture.md)
* [x] **Code Sandbox Verification** 

    * 💻 Active Controller: [SpyController.php](./src/Architecture/Controller/Debug/SpyController.php)
    * 💻 Active Subscriber: [SpySubscriber.php](./src/Architecture/EventSubscriber/SpySubscriber.php)

#### ⚡ Dependency Injection & Container Compilation (SFCE Topic 9)

* [x] **Dependency Injection Component Basics** 

    * 📑 Theory Reference: [Chapter 1 Lesson 1 – Dependency Injection Component](./docs/DependencyInjection/Chapter1_Lesson1-Dependency_Injection_Component.md)
* [x] **Container Lifecycle & Compiler Phases** 

    * 📑 Theory Reference: [Chapter 1 Lesson 3 – Container Lifecycle & Phases](./docs/DependencyInjection/Chapter1-Lesson3-Container_Lifecycle_&_Phases.md)
* [x] **Service Container Basics (Basics & Sandbox State)** 

    * 📑 Theory Reference: [Chapter 2 Lesson 1 – Service Container](./docs/DependencyInjection/Chapter2-Lesson1_Service_Container.md)
    * 🔬 Active Core Core-Manager: [InvoiceManager.php](./src/DependencyInjection/Service/InvoiceManager.php)
    * 💻 Active Formatter Architecture: [InvoiceFormatterInterface.php](./src/DependencyInjection/Service/InvoiceFormatterInterface.php) | [PdfInvoiceFormatter.php](./src/DependencyInjection/Service/PdfInvoiceFormatter.php) | [HtmlInvoiceFormatter.php](./src/DependencyInjection/Service/HtmlInvoiceFormatter.php)
* [ ] **EventDispatcher & Core Events** (SFCE Topic 11)

### ⚙️ Weeks 3 & 4: HTTP & Application Logic

* [ ] **Advanced Routing & Edge Cases** (SFCE Topic 5)
* [ ] **Controller Utility & Argument Resolvers** (SFCE Topic 4)
* [ ] **Configuration, ParameterBags & Secrets System** (SFCE Topic 2)

### 🔐 Week 5: Deep-Dive Enterprise Features

* [ ] **Security** (SFCE Topic 10)
* [ ] **Messenger, Workflow, Cache-Pools & Serializer** (SFCE Topics 10, 14)

### 🔍 Week 6: Testing, Tooling & Polish

* [ ] **WebTestCase, Crawler & Profiler Tests** (SFCE Topic 13)
* [ ] **Console, CLI Flags & Config Structures** (SFCE Topic 12)
* [ ] **Daily Mock-Exam Simulations** (Time management and focus training)

### 💻 Tech Stack & Environment

* **OS:** Ubuntu 24.04 LTS (Host machine)
* **Engine:** PHP 8.4+ (Inside an automated FrankenPHP Docker Container)
* **Framework:** Symfony 8.x (Skeleton build)
* **Database:** PostgreSQL 16 (via Docker)
* **IDE:** JetBrains PhpStorm

### 🛠️ Local Setup & Installation

Follow these steps to get this Symfony 8 Docker sandbox running on your local machine: 

### 1. Prerequisites

Make sure you have **Docker** and **Docker Compose** installed on your system. To run commands smoothly without sudo, ensure your user is added to the system group: 

bash

sudo usermod -aG docker $USER
newgrp docker

Verwende Code mit Vorsicht.

### 2. Clone the Repository

bash

git clone https://github.com/behrus/symfony8-certification-prep.git
cd symfony8-certification-prep

Verwende Code mit Vorsicht.

### 3. Build and Start the Docker Containers

This command compiles your custom FrankenPHP image (automatically injecting required system extensions like pdo_pgsql) and boots the stack in the background: 

bash

docker compose up -d --build

Verwende Code mit Vorsicht.

### 4. Install PHP Dependencies

Since PHP runs completely isolated inside the container, execute Composer via the running web service wrapper: 

bash

docker compose exec web composer install

Verwende Code mit Vorsicht.

### 5. Initialize the Database

Create your persistent database structure inside the PostgreSQL cluster and validate your ecosystem setup: 

bash

docker compose exec web php bin/console doctrine:database:create

Verwende Code mit Vorsicht.

### 6. Access the Application

Open your web browser and navigate to:
👉 **http://localhost** 

### 👤 Contact & Professional Profile

* **Name:** Behrouz Heidarzadeh
* **Role:** Senior Backend Engineer
* **LinkedIn:** [https://www.linkedin.com/in/behrouz-heidarzadeh-927a87282/](https://www.linkedin.com/in/behrouz-heidarzadeh-927a87282/)
