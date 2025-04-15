# IEEE YESS'24 Backend

## Contents
- [Description](#description)
- [Features](#features)
- [Programming Languages](#programming-languages)
- [Tech Stack](#tech-stack)
- [Technical Side](#technical-side)
- [Installation & Usage](#installation-&-usage)


## Description
IEEE YESS(Yearly Engineering Students Summit) is a flagship event organized by IEEE LINK comprising more than 3000 participants. The event was one of the largest gatherings of aspiring innovators, technologists, etc. The registration desk is one of the most challenging event processes. The traditional method of registration involved using an Excel sheet, asking for names, marking it, and so on. It can become tediously overwhelming for volunteers to use such a method. We devised a plan to create a QR Code Generation Based Ticketing System for the event. Later, we would also use the same system to provide certificates for the participants.

## Features
- Admin Panel
- QR Code Ticket Generation
- Verification of IEEE Members
- Certificate Generation

## Programming Languages
- NodeJs (Node.js 22)
- PHP (PHP 8.2)

## Tech Stack
- Laravel (Backend)
- MySql
- Tailwind CSS
- AWS

## Technical Side
- If you are interested in checking out the logical side of the project, check the [app/Http/Controllers](https://github.com/ieeelink/yess24-backend/tree/main/app/Http/Controllers) folder.
- Models used are defined in the [app/Models](https://github.com/ieeelink/yess24-backend/tree/main/app/Models) folder.
- The databases side of things is in the [database](https://github.com/ieeelink/yess24-backend/tree/main/database) folder including the migrations involved.
- All the routes can be found in the [routes](https://github.com/ieeelink/yess24-backend/tree/main/routes) folder.
- I have also defined specific use case utils in the [app/Utils](https://github.com/ieeelink/yess24-backend/tree/main/app/Utils) folder.

## Installation & Usage
###### Requires npm & composer
1. Clone the repository:
    ```bash
    git clone https://github.com/ieeelink/yess24-backend.git
    ```
2. Navigate to the project directory:
    ```bash
    cd yess24-backend
    ```
3. Install dependencies:
    ```bash
    npm install && composer install
    ```
4. Making .env:
   ```bash
    cp .env.example .env
   ```
5. Generate Key:
    ```bash
    php artisan key:generate
    ```

6. Make Migrations:  
   *Before migrating I would recommend setting up .env file for MySql. You can also run the project by setting DB_CONNECTION to sqlite*
    ```bash
    php artisan migrate
    ```

7. Run Project:
    ```bash
    npm run build && php artisan serve
    ```
