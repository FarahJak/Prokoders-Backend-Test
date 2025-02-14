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
     
- File attached for Postman collection for the Api Endpoints:
[Download the JSON file](https://github.com/user-attachments/files/18804333/ProkodersTest.postman_collection.json)

- The image below is showing the Email Notification that sent to the associated user When All Subtasks Are Completed:
  ![image_2025-02-14_23-34-04](https://github.com/user-attachments/assets/bf3ffe2d-65dd-4388-886d-ba616d376522)


