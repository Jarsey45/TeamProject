# FishingSpot

## Contents
- [App description](#app-description)
- [Let's start!](#lets-start)
- [Database](#doctrine-database)
- [Screenshots](#screenshots)







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
### 3. Doctrine database

If you don't have database yet use:
```shell
php bin/console doctrine:database:create
```
Migration:
```shell
php bin/console doctrine:migrations:migrate
```






## Screenshots

### Login Page
| Desktop       | Mobile     |
|:-------------:|:------------:|
|![Login Page Desktop](https://i.imgur.com/s5xLPnL.png) | ![Login Page Mobile](https://i.imgur.com/example.png)

### Register Page
| Desktop       | Mobile     |
|:-------------:|:------------:|
|![Register Page Desktop](https://i.imgur.com/YFZaJcY.png) | ![Register Page Mobile](https://i.imgur.com/example.png)

<details>
  <summary>Dashboard</summary>

  | Desktop       | Mobile     |
  |:-------------:|:------------:|
  |![Login Desktop](https://i.imgur.com/example.png) | ![Login Mobile](https://i.imgur.com/example.png)

</details>

<details>
  <summary>Profile</summary>

  | Desktop       | Mobile     |
  |:-------------:|:------------:|
  |![Register Desktop](https://i.imgur.com/example.png) | ![Register Mobile](https://i.imgur.com/example.png)

</details>

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
