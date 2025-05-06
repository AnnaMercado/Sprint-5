🍽️ Bocao API

A RESTful API built with Laravel to manage users, restaurants, and comments. It features OAuth2 authentication with Laravel Passport and role-based access control using Spatie.
⚙️ Requirements

    PHP 8.2+

    Laravel 12.x

    MySQL or compatible DB

    Composer

    XAMPP (for local development)

    Laravel Passport

    Spatie Laravel Permission


📦 Installed Dependencies

    laravel/framework – Laravel core

    laravel/passport – OAuth2 authentication

    spatie/laravel-permission – Roles and permissions

    fakerphp/faker – Fake data generator for seeders

    phpunit/phpunit – Testing

    mockery/mockery, nunomaduro/collision, laravel/tinker – Dev tools


☕ Installation

Clone the repository:

git clone https://github.com/AnnaMercado/Sprint-5
cd bocao-api

Install dependencies:

composer install

Set up your environment file:

cp .env.example .env

    🔧 In some environments, set APP_MAINTENANCE_DRIVER=file in your .env.

Generate application key:

php artisan key:generate


🔐 Install and Configure Passport

composer require laravel/passport
php artisan migrate
php artisan passport:install

🔑 Add Passport Secrets to .env

After running:

php artisan passport:install

You’ll see output like this:

Personal access client created successfully.
Client ID: 1
Client Secret: abc123def456...

Password grant client created successfully.
Client ID: 2
Client Secret: xyz789ghi012...

Use the exact values from that output and add them to your .env file:

PASSPORT_PERSONAL_ACCESS_CLIENT_ID=1
PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET=abc123def456...

PASSPORT_PASSWORD_GRANT_CLIENT_ID=2
PASSPORT_PASSWORD_GRANT_CLIENT_SECRET=xyz789ghi012...

    🔐 Important: These values must match what Passport generated. If you lose them, you can retrieve them from the database:

SELECT * FROM oauth_clients;

That table contains all client IDs and secrets.

🛡️ Install Spatie Permissions

composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate

🧪 Seeding the Database

Make sure your .env file is configured to point to a valid database.

Seed the app with:

php artisan db:seed

This will:

    Create roles (admin, user)

    Create test users

    Create Passport clients

    Populate restaurants and comments



🔐 Roles and Permissions

The API uses a custom RoleService to enforce fine-grained permissions based on the user's role.
Roles

    Admin: Full access to all resources.

    User: Can interact with comments and view restaurant data.

Permissions by Resource
Action	Admin	User
View all users	✅	❌
View user profiles	✅	❌
Update user profiles	✅	❌
Create restaurants	✅	❌
Update restaurants	✅	❌
Delete restaurants	✅	❌
Create comments	✅	✅
View comments	✅	✅
Update own comments	✅	✅
Delete own comments	✅	✅

    Regular users can only update or delete their own comments. All other actions require admin privileges.


Token Authentication

All protected routes require a valid OAuth2 token:

    Use the /api/tokens endpoint to login and obtain a token.

    Use Authorization: Bearer {token} in headers for authenticated requests.

    Use DELETE /api/tokens to log out and revoke the current token.
    

🧰 Tech Stack

    Laravel 12 – PHP web framework

    Laravel Passport – OAuth2 API authentication

    Spatie Permission – Role & permission management

    MySQL – Database

    PHP 8.2 – Backend language

    XAMPP – Development environment

    Postman – For testing API endpoints