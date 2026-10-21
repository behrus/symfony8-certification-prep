# 🚀 Symfony 8 Certified Developer – Preparation Sandbox

Status-Badge:
[![Status: In Progress](https://img.shields.io/static/v1?label=Status&message=In%20Progress&color=orange&style=flat-square&logo=github&logoColor=white)](https://github.com/behrus)

Symfony-Badge:
[![Symfony: 8.1](https://img.shields.io/static/v1?label=Symfony&message=8.1&color=6170f4&style=flat-square&logo=symfony&logoColor=white)](https://symfony.com)


> 💡 **Note for Recruiters and Tech-Leads:** This repository is my active training ground for the upcoming Symfony 8 certification. Since I am working on this **alongside my full-time job**, updates occur in focused bursts rather than daily commits. It is an evolving sandbox designed to systematically test code examples, custom compiler passes, and framework edge cases.

Welcome to the active preparation repository for the official **Symfony Certified Developer** exam.
This sandbox is built on **Ubuntu 24.04** using **PHP 8.4+** and **Symfony 8.x** inside a fully containerized environment powered by **FrankenPHP**.

The goal of this repository is to deep-dive into the framework's architecture, master modern PHP attributes, practice core enterprise components, and track my progress through the core exam topics.

---

## 📅 6-Week Certification Master Plan & Progress Tracker
A structured preparation roadmap aligned strictly with the 14-topic curriculum of sfcelearning.com.

### 🏛️ Weeks 1 & 2: Core Foundations & Infrastructure
- [x] **Architecture & HttpKernel Lifecycle** (SFCE Topic 3)
    * 📑 Theory Reference: [1. Components & Service Locators](./doc/1_Components_Architecture_Service_Locators.md)
    * 📑 Theory Reference: [2. HTTP Foundation & Flex](./doc/2_HTTP_Foundation_Flex_Licensing.md)
    * 📑 Theory Reference: [3. HttpKernel Lifecycles & Events](./doc/3_HttpKernel_Lifecycles_Events_Exceptions.md)
    * 📑 Theory Reference: [4. Invokable Architecture](./doc/4_Single_Action_Controllers_Invokable_Architecture.md)
    * 📑 Theory Reference: [5. SOLID Principles in Symfony](./doc/5_SOLID_Principles_Symfony_8_Architecture.md)
    * 🔬 Code Sandbox: [`SpyController.php`](./src/Controller/Debug/SpyController.php) | [`ArchitectureSpySubscriber.php`](./src/EventSubscriber/ArchitectureSpySubscriber.php)
- [ ] **Dependency Injection & Container Compilation** (SFCE Topic 9)
    * 📑 Theory Reference: *[6. DI Container Lifecycle](./doc/6_Dependency_Injection_Container_Lifecycle.md) (Next Up ⏳)*
    * 📑 Theory Reference: *[7. DI Compiler Passes](./doc/7_Dependency_Injection_Compiler_Passes.md) (Planned)*
- [ ] **EventDispatcher & Core Events** (SFCE Topic 11)

### ⚙️ Weeks 3 & 4: HTTP & Application Logic
- [ ] **Advanced Routing & Edge Cases** (SFCE Topic 5)
- [ ] **Controller Utility & Argument Resolvers** (SFCE Topic 4)
- [ ] **Configuration, ParameterBags & Secrets System** (SFCE Topic 2)

### 🔐 Week 5: Deep-Dive Enterprise Features
- [ ] **Security** (SFCE Topic 10)
- [ ] **Messenger, Workflow, Cache-Pools & Serializer** (SFCE Topics 10, 14)

### 🔍 Week 6: Testing, Tooling & Polish
- [ ] **WebTestCase, Crawler & Profiler Tests** (SFCE Topic 13)
- [ ] **Console, CLI Flags & Config Structures** (SFCE Topic 12)
- [ ] **Daily Mock-Exam Simulations**
ing, memorizing critical defaults)
- [ ] **Daily Mock-Exam Simulations** (Time management and focus training)

---

## 💻 Tech Stack & Environment
* **OS:** Ubuntu 24.04 LTS (Host machine)
* **Engine:** PHP 8.4+ (Inside an automated FrankenPHP Docker Container)
* **Framework:** Symfony 8.x (Skeleton build)
* **Database:** PostgreSQL 16 (via Docker)
* **IDE:** JetBrains PhpStorm

---

## 🛠️ Local Setup & Installation

Follow these steps to get this Symfony 8 Docker sandbox running on your local machine:

### 1. Prerequisites
Make sure you have **Docker** and **Docker Compose** installed on your system. To run commands smoothly without `sudo`, ensure your user is added to the system group:
```bash
sudo usermod -aG docker $USER
newgrp docker
```

### 2. Clone the Repository
```bash
git clone https://github.com
cd symfony8-certification-prep
```

### 3. Build and Start the Docker Containers
This command compiles your custom FrankenPHP image (automatically injecting required system extensions like `pdo_pgsql`) and boots the stack in the background:
```bash
docker compose up -d --build
```

### 4. Install PHP Dependencies
Since PHP runs completely isolated inside the container, execute Composer via the running `web` service wrapper:
```bash
docker compose exec web composer install
```

### 5. Initialize the Database
Create your persistent database structure inside the PostgreSQL cluster and validate your ecosystem setup:
```bash
docker compose exec web php bin/console doctrine:database:create
```

### 6. Access the Application
Open your web browser and navigate to:
👉 **http://localhost**

---

## 👤 Contact & Professional Profile

* **Name:** Behrouz Heidarzadeh
* **Role:** Senior Backend Engineer
* **LinkedIn:** [https://www.linkedin.com/in/behrouz-heidarzadeh-927a87282/]
