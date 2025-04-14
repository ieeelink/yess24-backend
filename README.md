# IEEE YESS'24 Backend (Laravel)

## Description
IEEE YESS(Yearly Engineering Students Summit) is a flagship event organized by IEEE LINK comprising more than 3000 participants. The event was one of the largest gatherings of aspiring innovators, technologists, etc. The registration desk is one of the most challenging processes in such an event. The traditional method of registration involved using an Excel sheet, asking for names, marking it, and so on. It can become tediously overwhelming for volunteers to use such a method. We devised a plan to create a QR Code Generation Based Ticketing System for the event. Later, we would also use the same system to provide certificates for the participants.


## Features
- Admin Panel
- QR Code Ticket Generation
- Verification of IEEE Members
- Certificate Generation


## Installation & Usage
###### Requires npm & composer
1. Clone the repository:
    ```bash
    git clone https://github.com/your-username/your-repo.git
    ```
2. Navigate to the project directory:
    ```bash
    cd your-repo
    ```
3. Install dependencies:
    ```bash
    npm install && composer install
    ```
4. Generate Key:
    ```bash
    php artisan key:generate
    ```

5. Make Migrations:
    ```bash
    php artisan migrate
    ```

6. Run Project:
    ```bash
    npm run build && php artisan serve
    ```
