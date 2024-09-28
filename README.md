# Blog Application (API Based)

## Description

This project is a blog application built using PHP. It provides a RESTful API for managing blog posts,
categories, tags, and comments. Users can create, read, update, and delete posts. The application also supports user
authentication and authorization, ensuring that only authenticated users can create or modify their own posts. The
project uses Laravel as the backend framework and includes features such as pagination, filtering, and validation.

### Assumptions

- The application is designed to be used by authenticated users only. Unauthenticated users cannot create, update, or
  delete posts.
- Admin can perform all CRUD operations on users,posts, categories, tags, and comments.
- Users can only create, update, and delete their own posts but can view all posts.
- Users can only create, update, and delete their own comments but can view all comments.
- Users can only view categories and tags.
- The application uses a token-based authentication system to authenticate users. Users must provide a valid token to
  access protected routes.
- The application uses a role-based authorization system to restrict access to certain routes based on the user's role.

## Installation

### Prerequisites

- PHP >= 8.2
- Composer

### Steps

1. Clone the repository:
    ```bash
    git clone https://github.com/Dipesh79/blogApplication.git
    cd blogApplication
    ```

2. Install PHP dependencies:
    ```bash
    composer install
    ```

3. Set up environment variables:
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
4. Create a new database and update the `.env` file with the database credentials.
5. Run database migrations:
    ```bash
    php artisan migrate
    ```
6. Seed the database:
    ```bash
    php artisan db:seed
    ```
   
## Usage

### Running the Application

To start the application, use the following command:

```bash
php artisan serve
```

The application will be accessible at `http://localhost:8000` and you can view the API documentation at
`http://localhost:8000/docs/api`.
