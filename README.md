# 🚀 Symfony 8 Certified Developer – Preparation Sandbox

[![Status: In Progress](https://shields.io)](https://github.com)
[![Symfony: 8.1](https://shields.io)](https://symfony.com)

> 💡 **Please note:** This repository is my active training ground for the upcoming Symfony 8 certification. Since I am working on this **alongside my full-time job**, updates occur in focused bursts rather than daily commits. It is an evolving sandbox designed to systematically test code examples, custom compiler passes, and framework edge cases.

Welcome to the active preparation repository for the official **Symfony Certified Developer** exam.
This sandbox is built on **Ubuntu 24.04** using **PHP 8.4+** and **Symfony 8.x** inside a fully containerized environment powered by **FrankenPHP**.

The goal of this repository is to deep-dive into the framework's architecture, master modern PHP attributes, practice core enterprise components, and track my progress through the core exam topics.

---

## 📅 6-Week Certification Master Plan & Progress Tracker
A structured, work-life-balanced preparation roadmap tailored for experienced Senior Developers studying alongside full-time employment.

### 🏛️ Weeks 1 & 2: Core Foundations & Infrastructure
- [ ] **Architecture & HttpKernel Lifecycle** (Request/Response lifecycle, Short-circuiting, SOLID patterns)
- [ ] **Dependency Injection & Container Compilation** (Autowiring, Compiler Passes, Service Locators, Custom Tags)
- [ ] **EventDispatcher & Core Events** (Listeners, Subscribers, Priority, Event Propagation)

### ⚙️ Weeks 3 & 4: HTTP & Application Logic
- [ ] **Advanced Routing & Edge Cases** (Attributes, Route matching conditions, Localized routing)
- [ ] **Controller Utility & Argument Resolvers** (Value resolvers, Injections, AbstractController utilities)
- [ ] **Configuration, ParameterBags & Secrets System** (Environment variables, Vault, Service parameters)

### 🔐 Week 5: Deep-Dive Enterprise Features
- [ ] **Security** (Authenticators, Passport/Badge-System, Custom Voters, Role hierarchies)
- [ ] **Messenger, Workflow, Cache-Pools & Serializer** (Buses, Transports, Async workers, Serialization contexts)

### 🔍 Week 6: Testing, Tooling & Polish
- [ ] **WebTestCase, Crawler & Profiler Tests** (Integration testing, HTTP client assertions)
- [ ] **Console, CLI Flags & Config Structures** (Custom commands, Signal handling, memorizing critical defaults)
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
