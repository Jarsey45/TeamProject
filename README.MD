# FishingSpot

## Contents
- [App description](#app-description)
- [Let's start!](#lets-start)
- [Screenshots](#screenshots)
- [ERD Diagram](#erd-diagram)







## App description
FishingSpot is an application that allows you to connect with your fishing friends!

## Let's start!

### 1. Clone Repository
To clone repository you can use the command below:
```shell
git clone https://github.com/Jarsey45/TeamProject.git
```

### 2. Run Docker Image
You need to have [Docker](https://www.docker.com/) installed on your environment  
Move to the project's directory and run the command below:

```shell
docker-compose up --build
```


### 3. Symfony
To install Symfony inside Docker, run:

```shell
docker exec -it php_project-php-1 composer require symfony/runtime
```

### 4. Database

You can create database using:
```shell
docker exec -it php_project-php-1 php bin/console doctrine:database:create
```

Migration:
```shell
docker exec -it php_project-php-1 php bin/console doctrine:migrations:migrate
```

You can delete database using:
```shell
docker exec -it php_project-php-1 php bin/console doctrine:database:drop --force
```






## Screenshots

### Dashboard

![Dashboard](https://i.imgur.com/W9mgyqR.png)

### Login Page
![Login Page](https://i.imgur.com/gLyvfaM.png)

### Registration Page
![Registration Page](https://i.imgur.com/Ahmy9M4.png) 


### Profile
![Profile](https://i.imgur.com/cexrrxz.png) 


## ERD Diagram

```mermaid
erDiagram
    User ||--o{ Post : creates
    User ||--o{ Comment : writes
    User ||--o{ Likes : gives
    Post ||--o{ Comment : has
    Post ||--o{ Likes : receives
    Comment ||--o{ Comment : has

    User {
        int id PK
        string uuid
        string first_name
        string last_name
        string email
        string password
        string phone_number
        json roles
        datetime created_at
        datetime updated_at
    }

    Post {
        int id PK
        string title
        string content
        string media
        bool isPublished
        string slug
        datetime createdAt
        datetime updatedAt
    }

    Comment {
        int id PK
        string content
        int post_id FK
        int parent_comment_id FK "nullable"
        int author_id FK
        datetime createdAt
        datetime updatedAt
    }

    Likes {
        int id PK
        int user_id FK
        int post_id FK
        datetime createdAt
    }

    Friend {
        int id PK
        int userId FK
        int relatedUserId FK
        datetime createdAt
        datetime updatedAt
    }

    Invite {
        int id PK
        int userId FK
        int relatedUserId FK
        datetime createdAt
        datetime updatedAt
    }

    Role {
        int id PK
        string name
        string description
        datetime createdAt
        datetime updatedAt
    }
```
