# Symfony 8 Certification – Flashcards, Notes and Sandbox

**Status:** In Progress  
**Target:** Symfony 8.0 / PHP 8.4

> Personal study repository for the Symfony 8 certification exam. It is a work in progress and not meant as a production project.

This sandbox runs on **Ubuntu 24.04** with **PHP 8.4+** and **Symfony 8.0.x** inside a **FrankenPHP** containerized environment. It serves as a hands-on tracker for digging into framework internals.

> **Version and security note:** The exam covers only Symfony 8.0, so all `symfony/*` packages are pinned to `8.0.*` (not 8.1). Symfony 8.0 is end of life and Composer blocks it because of known security advisories (denial of service in `symfony/yaml` and `symfony/http-foundation`). Six advisory IDs are therefore listed under `policy.advisories.ignore-id` in `composer.json`. This is acceptable only for a local study sandbox: the ports are bound to `127.0.0.1`, and the code must never be deployed.

---

## Study Strategy

The preparation is built around **Anki flashcards** (spaced repetition), because the exam is an English multiple-choice test that rewards exact knowledge of framework behaviour. Structured around the 14 core topics from the `sfcelearning.com` curriculum.

1. **Flashcards (`_ANKI_CARD.txt`):** Each lecture has a tab-separated card file in the `Anki_Cards/` folder of its topic, ready for bulk import into Anki.
2. **Short notes (`.md`):** Lectures with flows or easily confused topics get a one-page note that links to its cards. Older notes in this repository are longer; new ones are kept short.
3. **Sandbox:** Unclear behaviour is tried in the Symfony 8.0 sandbox of this repository, and the result goes back into a card.
4. **Practice questions:** Questions in exam format show gaps that cards alone do not. So far there is a quiz for Dependency Injection; more are added per topic.

---

## What is in this repository

* [`docs/Architecture`](docs/Architecture): HttpFoundation, HttpKernel, Flex, configuration
* [`docs/DependencyInjection`](docs/DependencyInjection): container, autowiring, service tags
* [`docs/Security`](docs/Security): firewall, authenticators, voters
* [`docs/DataValidation`](docs/DataValidation): validator constraints
* [`docs/Miscellaneous`](docs/Miscellaneous): serializer context
* [`src/`](src): sandbox code that is used to verify the behaviour

---

## Environment

* **OS:** Ubuntu 24.04 LTS
* **Engine:** PHP 8.4+ (FrankenPHP Docker Container)
* **Framework:** Symfony 8.0.x (Skeleton)
* **Database:** PostgreSQL 16
* **IDE:** PhpStorm

---

## Local Setup

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

App is available at http://localhost

---

## Profile

* **Name:** Behrouz Heidarzadeh
* **Role:** Senior Backend Engineer
* **LinkedIn:** [Behrouz Heidarzadeh](https://linkedin.com)
