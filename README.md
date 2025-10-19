# Company Dashboard Application

This project is a containerized web application built with Laravel 12 (PHP) for the backend API and ReactJS for the frontend. It features role-based module access, dynamic theming based on the user's company, and a searchable navigation tree.

## Table of Contents

- [Features](#features)
- [Technologies Used](#technologies-used)
- [Prerequisites](#prerequisites)
- [Installation and Setup](#installation-and-setup)
- [Sample Credentials](#sample-credentials)
- [Project Structure](#project-structure)
- [Presentation](#presentation)

## Features

- **User Authentication:** Secure login using Laravel Sanctum tokens.
- **Company-Based Theming:** Dashboard appearance changes dynamically based on the selected company's primary and accent colors.
- **Permission-Filtered Navigation:** Users only see modules/submodules assigned to them via the `user_submodule` pivot table.
- **Searchable Module Tree:** Left-side navigation allows searching through systems, modules, and submodules.
- **Containerized Deployment:** Runs using Docker Compose for easy setup and consistency.

## Technologies Used

- **Backend:** Laravel 12 (PHP 8.3+)
- **Frontend:** ReactJS (using Create React App)
- **Database:** PostgreSQL
- **Authentication:** Laravel Sanctum
- **Containerization:** Docker, Docker Compose

## Prerequisites

Before you begin, ensure you have the following installed on your system:

- [Docker Desktop](https://www.docker.com/products/docker-desktop/)
- [Git](https://git-scm.com/) (Optional, for cloning)

## Installation and Setup

1.  **Clone or Download the Repository:**
    - If you have Git: `git clone <your-repository-url>`
    - Or download the source code as a ZIP file and extract it.

2.  **Navigate to Project Directory:**
    ```bash
    cd company-dashboard
    ```

3.  **Build and Start Services:**
    This command will build the necessary Docker images (if not already built) and start the backend, frontend, and database containers.
    ```bash
    docker compose up --build
    ```
    *Note: The first build might take a few minutes.*

4.  **Run Migrations and Seeders:**
    In a new terminal window/tab, while the services are running, execute the following command to set up the database schema and populate it with sample data (users, companies, modules, permissions).
    ```bash
    docker compose exec backend php artisan migrate --seed
    ```
    *If you encounter issues, you might need to generate the application key first: `docker compose exec backend php artisan key:generate`*

5.  **Access the Application:**
    - Open your web browser and go to `http://localhost:3000`.
    - The Laravel backend API will be accessible at `http://localhost:8000`.

## Sample Credentials

Use the following credentials to log in and test the application:

| Username | Password   | Company        |
| :------- | :--------- | :------------- |
| alice    | Passw0rd!  | ACME Corporation (Blue theme) |
| bob      | Passw0rd!  | BETA Industries (Red theme)   |
| charlie    Passw0rd!    GAMMA Solutions (Green theme) |


## Project Structure

A brief overview of the key files and directories:

- `backend/`: Contains the Laravel application code (Controllers, Models, Migrations, Seeders, Routes, etc.).
- `frontend/`: Contains the React application code (Components, Pages, etc.).
- `docker-compose.yml`: Defines the Docker services (backend, frontend, db).
- `backend/Dockerfile`: Defines the Docker image for the Laravel backend.
- `frontend/Dockerfile`: Defines the Docker image for the React frontend.

