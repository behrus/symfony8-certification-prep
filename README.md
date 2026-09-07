# 🚀 Symfony 8 Certified Developer – Preparation Sandbox

Welcome to my active preparation repository for the official **Symfony Certified Developer** exam.
This sandbox is built on **Ubuntu 24.04** using **PHP 8.3+** and **Symfony 8.x** inside a fully containerized environment.

The goal of this repository is to deep-dive into the framework's architecture, master modern PHP attributes, practice core components, and track my daily progress through the official exam topics.

---

## 📅 3-Week Sprint & Progress Tracker
Based on the 14 core topics from SFCE Learning, mapped to the official certification guide.

### 🏛️ Section 1: Architecture & Core Lifecycles
- [ ] **Topic 1: Architecture** (HttpKernel, Request/Response lifecycle, HTTP Cache)
- [ ] **Topic 2: Dependency Injection** (Service Container, Autowiring, Compiler Passes, Service Locators)
- [ ] **Topic 3: EventDispatcher** (Event Listeners vs. Subscribers, Core Kernel Events)

### 🛠️ Section 2: HTTP & Application Logic
- [ ] **Topic 4: Routing** (Attributes, Route matching, Parameters, Requirements)
- [ ] **Topic 5: Controller** (Argument resolvers, Injections, AbstractController utilities)
- [ ] **Topic 6: Configuration** (Environment variables, Parameters, Bundle configuration)

### 🔐 Section 3: Security & Enterprise Features
- [ ] **Topic 7: Security** (Authenticators, Passports/Badges, Custom Voters, Role hierarchies)
- [ ] **Topic 8: Messenger & Workflow** (Busses, Transport, Middleware, Envelopes/Stamps)
- [ ] **Topic 9: Cache** (Cache pools, Tagging, Adapters)

### 📝 Section 4: Data, Forms & Tooling
- [ ] **Topic 10: Form & Validation** (Form types, Data mappers, Validation constraints, CSRF)
- [ ] **Topic 11: Internationalization (i18n)** (Translations, Locales, Catalogue)
- [ ] **Topic 12: Automated Tests** (WebTestCase, Crawler, Profiler integration in tests)
- [ ] **Topic 13: Console** (Custom commands, Input/Output options)
- [ ] **Topic 14: Serializer & Twig** (Normalization, Encoding, Twig extensions)

---

## 💻 Tech Stack & Environment
* **OS:** Ubuntu 24.04 LTS
* **Engine:** PHP 8.3+ (Inside FrankenPHP Docker Container)
* **Framework:** Symfony 8.x (Webapp Skeleton)
* **Database:** PostgreSQL (via Docker)
* **IDE:** JetBrains PhpStorm

---

## 🛠️ Local Setup & Installation

Follow these steps to get this Symfony 8 Docker sandbox running on your local machine:

### 1. Prerequisites
Make sure you have **Docker** and **Docker Compose** installed on your system.

### 2. Clone the Repository
```bash
git clone https://github.com/behrus/symfony8-certification-prep.git
cd symfony8-certification-prep
```

### 3. Build and Start the Docker Containers
This command builds your custom FrankenPHP image (including required extensions like `pdo_pgsql`) and starts the PostgreSQL database and mailer in the background:
```bash
docker compose up -d --build
```

### 4. Install PHP Dependencies
Since PHP runs inside the container, use `docker compose exec` to run Composer safely without needing PHP installed on your host machine:
```bash
docker compose exec webapp composer install
```

### 5. Initialize the Database
Create the database inside the container and ensure the schema is validated:
```bash
docker compose exec webapp php bin/console doctrine:database:create
```

### 6. Access the Application
Open your browser and navigate to:
👉 **http://127.0.0.1:8000**

You should see the default Symfony welcome page. All your code changes in `src/` will sync automatically.

---
*Created and maintained by a passionate PHP & Symfony Developer striving for architectural excellence.*
