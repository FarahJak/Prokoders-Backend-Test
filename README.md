# Laravel Application Setup Guide

This guide provides instructions on how to set up and run the Laravel application from this GitHub repository.

### Installation Steps:
-  Step 1: Clone the Repository.
  ```bash
   git clone <repository-url>
   cd <repository-folder>
  ```
-  Step 2: Install Dependencies:
   Run the following command to install PHP dependencies:
  ```bash
   composer install
  ```
-  Step 3: Set Up Environment Variables.
      - Copy the .env.example file to .env:
         ```bash
         copy .env.example .env
         ```
      - Generate Application Key:
         ```bash
         php artisan key:generate
         ```
      - Run Migrations and Seed the Database:
         ```bash
         php artisan migrate --seed
         ```
      - Start the Development Server:
         ```bash
         php artisan serve
         ```
     
-  Step 4: File attached for Postman collection for the Api Endpoints:


-  Step 5: The image below is showing the Real-Time Notifications using pusher whenever a task's status is updated:
