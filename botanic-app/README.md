# Botanic App

## Overview
The Botanic App is a Laravel-based application designed to manage MongoDB user entities. It provides a user-friendly interface for creating, editing, and viewing user data.

## Project Structure
The project is organized as follows:

```
botanic-app
├── app
│   ├── Models
│   │   └── MongoUser.php
│   ├── MoonShine
│   │   └── Resources
│   │       └── MongoUser
│   │           ├── MongoUserResource.php
│   │           ├── Forms
│   │           │   └── MongoUserForm.php
│   │           └── Pages
│   │               ├── MongoUserIndexPage.php
│   │               └── MongoUserFormPage.php
├── routes
│   └── web.php
├── composer.json
├── artisan
├── .env.example
└── README.md
```

## Installation
1. Clone the repository:
   ```
   git clone <repository-url>
   ```
2. Navigate to the project directory:
   ```
   cd botanic-app
   ```
3. Install the dependencies:
   ```
   composer install
   ```
4. Copy the example environment file:
   ```
   cp .env.example .env
   ```
5. Generate the application key:
   ```
   php artisan key:generate
   ```
6. Configure your database settings in the `.env` file.

## Usage
To start the development server, run:
```
php artisan serve
```
You can access the application at `http://localhost:8000`.

## Features
- Create, edit, and view MongoDB user records.
- User-friendly forms for data input.
- Responsive design for various devices.

## Contributing
Contributions are welcome! Please submit a pull request or open an issue for any enhancements or bug fixes.

## License
This project is licensed under the MIT License. See the LICENSE file for details.