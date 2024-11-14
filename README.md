# Laravel Blog API

This project is a RESTful API built with Laravel for managing blog posts and comments. It includes Docker for setting up MySQL and Adminer, making it easy to manage and view the database. Below is a detailed guide for installation, setup, and using the API.

## Table of Contents

- [Getting Started](#getting-started)
  - [Cloning project](#cloning-project)
  - [Environment Configuration](#environment-configuration)
  - [Docker Setup](#docker-setup)
- [Authentication](#authentication)
- [Endpoints](#endpoints)
  - [Posts](#posts)
  - [Comments](#comments)
  - [User Authentication](#user-authentication)


## Getting Started

### Cloning Project
1. Clone the Repository

    ```bash
    Copy code
    git clone https://github.com/yourusername/laravel-blog-api.git
    cd laravel-blog-api
    ```

### Environment Configuration

1. **Configure `.env`**:  
   Update your `.env` file with the following database settings to connect Laravel with the Dockerized MySQL database:

   ```plaintext
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=blog-api
   DB_USERNAME=root
   DB_PASSWORD=root
   ```

2. **Install Composer Dependencies**:
   ```bash
   composer install
   ```

3. **Run Migrations**:
   ```bash
   php artisan migrate
   ```

4. **Serve the API**:
   ```bash
   php artisan serve
   ```

### Docker Setup

1. **Install Docker**:  
   Make sure Docker is installed on your system. If not, [download and install Docker here](https://www.docker.com/products/docker-desktop).

2. **Run Docker Containers**:
   This project includes Docker configuration to set up MySQL and Adminer. Once Docker is installed, navigate to the project directory and run the following command:

   ```bash
   docker-compose up -d
   ```

   This command will start both MySQL and Adminer in detached mode, allowing you to access and manage your database.

3. **Access Adminer**:  
   After Docker containers are running, access Adminer at [http://localhost:8080](http://localhost:8080) to view and manage the MySQL database.

## Authentication

This API uses token-based authentication. Register and log in to receive a token, which must be included in the `Authorization` header for accessing protected endpoints.

## Endpoints

### Posts

- **GET /posts**  
  Retrieves all blog posts.

- **GET /posts/{post_id}**  
  Retrieves a specific post by its ID.

- **POST /posts**  
  Creates a new post.  
  **Body Parameters**:
  - `user_id` (integer): ID of the user creating the post
  - `title` (string): Title of the post
  - `content` (string): Content of the post

- **PUT /posts/{post_id}**  
  Updates an existing post.  
  **Query Parameters**:
  - `title` (string): Updated title
  - `content` (string): Updated content

- **DELETE /posts/{post_id}**  
  Deletes a post by its ID.

- **GET /posts/{post_id}/user**  
  Retrieves the user who created the post.

- **GET /posts/{post_id}/comments**  
  Retrieves all comments for a specific post.

### Comments

- **GET /comments**  
  Retrieves all comments across all posts.

- **GET /comments/{comment_id}**  
  Retrieves details of a specific comment by its ID.

- **POST /comments**  
  Creates a new comment.  
  **Query Parameter**:
  - `post_id` (integer): ID of the post  
  **Body Parameters**:
  - `user_id` (integer): ID of the user adding the comment
  - `content` (string): Content of the comment

- **PUT /comments/{comment_id}**  
  Updates a comment.  
  **Query Parameter**:
  - `content` (string): Updated content

- **DELETE /comments/{comment_id}**  
  Deletes a comment by its ID.

- **GET /comments/{comment_id}/user**  
  Retrieves the user who created the comment.

- **GET /comments/{comment_id}/post**  
  Retrieves the post to which the comment belongs.

### User Authentication

- **POST /register**  
  Registers a new user.  
  **Request Headers**:
  - `Accept`: `application/json`  
  **Body (JSON)**:
  ```json
  {
    "name": "Mario Nan",
    "email": "marionan2@gmail.com",
    "password": "password123",
    "password_confirmation": "password123"
  }
  ```

- **POST /login**  
  Logs in an existing user.  
  **Request Headers**:
  - `Accept`: `application/json`  
  **Body (JSON)**:
  ```json
  {
    "email": "marionan2@gmail.com",
    "password": "password123"
  }
  ```

- **POST /logout**  
  Logs out the authenticated user.  
  **Request Headers**:
  - `Accept`: `application/json`  


