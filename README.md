# Post Management API

A Laravel-based REST API for managing posts with admin approval workflow and notifications.

## Features

- Post creation and management
- Admin approval workflow for posts
- Real-time notifications for:
  - Admins when new posts are submitted
  - Authors when posts are approved/rejected
- RESTful API endpoints
- Authentication and Authorization

## Requirements

- PHP >= 8.1
- Composer
- MySQL/PostgreSQL
- Laravel 10.x

## Installation

1. Clone the repository
2. Run `composer install`
3. Run `php artisan migrate`
4. Run `php artisan serve`

```
git clone https://github.com/yourusername/post-management-api.git
cd post-management-api
```

## Install dependencies

```
composer install
```

## Create environment file

```
cp .env.example .env
```

## Generate application key

```
php artisan key:generate
```

## Run migrations

```
php artisan migrate
```

## Run the seeder

To create an admin user, run the following command:


php artisan db:seed --class=AdminUserSeeder  
The default admin credentials are:
- Email: `admin@example.com`
- Password: `password`

## Run the server

```
php artisan serve
```


## API Endpoints

### Posts
- `GET /api/posts` - Get all posts
- `POST /api/posts` - Create a new post
- `GET /api/posts/{id}` - Get specific post
- `PUT /api/posts/{id}` - Update a post
- `DELETE /api/posts/{id}` - Delete a post

### Admin
- `PUT /api/posts/{id}/approve` - Approve a post
- `PUT /api/posts/{id}/reject` - Reject a post
