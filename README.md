Authors
Maxim Kernazhytski - 46589

Event Management System
Project Overview
The Event Management System is a web-based application designed to manage events. Built with PHP for backend logic and MySQL for database management, the application allows users to register, log in, and manage their events. Docker Compose is used to set up the entire environment for the project.

Technologies Used

PHP 8.1: Backend logic

MySQL: Database management

Docker: Containerization

phpMyAdmin: Web interface for managing the MySQL database

Setup Instructions

To get started with the Event Management System, ensure the following are installed:
Docker
Docker Compose
A web browser (to access the application and phpMyAdmin)

1. Download as ZIP

Go to your repository on GitHub: https://github.com/lacelyn5/Final.
Click the green "Code" button.
Select "Download ZIP" from the options.
Extract the ZIP file to your desired location on your computer.

Alternatively

Open Git Bash or Command Prompt on your local machine.

Navigate to the location where you want to clone the repository.

Clone the repository using the command:


git clone https://github.com/lacelyn5/Final.git

This command will download your entire project folder from GitHub to your local machine. 

2. Build and Start the Containers

Open a CMD window go to the folder where the project is located

Use Docker Compose to build and start the application containers:

docker-compose up --build
This command will:

Build Docker images
Start the following containers:
PHP and Apache web server for serving the application
MySQL for database management
phpMyAdmin for managing MySQL through a web interface

3. Accessing the Application
After running docker-compose up --build, you can access the application via the following URLs:

Web Application: http://localhost:8080
phpMyAdmin: http://localhost:8080

Setting Up the Database

The database and required tables are created automatically when you start the containers. You can manage database records through phpMyAdmin.

However, if you need to manually create the database and tables, follow these steps:

Open phpMyAdmin at http://localhost:8081.

Log in using the following credentials:

Username: root

Password: rootpassword (as specified in docker-compose.yml)

Select the event_management database (it should already exist). If not, create it.

Click the SQL tab and paste the following SQL code:

"

CREATE DATABASE IF NOT EXISTS event_management;

USE event_management;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE


);
CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    event_date DATETIME NOT NULL,
    location VARCHAR(255) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

"

Click Go to execute the SQL and create the tables manually.

This manual setup is optional, as the database is already pre-configured during deployment.

5. Using the Application
Once the database is set up, you can start using the application:

Register a new user by navigating to the registration page.
Login with the credentials you registered.
After logging in, you can:
Create new events
Update existing events
Delete events
Troubleshooting
If the application doesn't start, ensure Docker and Docker Compose are correctly installed.
If you encounter issues with phpMyAdmin, double-check the login credentials in docker-compose.yml.
