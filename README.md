## Telegram Framework on Laravel


### Introduction


Welcome to the demo project built with Laravel! This project is designed to showcase my skills and understanding of the Laravel framework. It includes various features and functionalities that demonstrate best practices and effective use of Laravel's capabilities.

## Features

- User Authentication: Register, login, and manage user accounts with built-in Laravel authentication.
- RESTful API: A simple RESTful API for the resource with JSON responses
- Eloquent ORM: Utilization of Eloquent ORM for database interactions.
- Form Validation: Server-side validation of forms.
- Middleware: Custom middleware for request filtering and authorization.
- Database Seeding: Pre-filled database with sample data for demonstration purposes.
- Framework for working with telegram bots


### Installation
1. #### Clone the repository
```sh
git clone https://github.com/Zbara/telegram-framework.git

cd telegram-framework
```
2. #### Build docker

```sh
docker-compose up -d --build app
```

3. #### Run App

```sh

docker-compose up -d

#### Command List 
docker-compose run --rm composer update
docker-compose run --rm artisan migrate --seed
```
