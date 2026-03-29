# 📝 ToDoList

> Project by [Vtr-Frt](https://github.com/Vtr-Frt)

A web application built in PHP where multiple users can sign in and manage their own to-do list.

---

## 🚀 Features

- User authentication (login / logout)
- Personal to-do list per user
- Add, complete, and delete tasks
- Persistent data stored in a MySQL database

---

## 🛠️ Tech Stack

| Layer    | Technology     |
|----------|----------------|
| Backend  | PHP            |
| Frontend | HTML / CSS     |
| Database | MySQL          |

---

## 📁 Project Structure

```
toDoList/
├── app/        # PHP logic (controllers, models, routing)
├── public/     # Entry point, assets (CSS, JS, images)
├── sql/        # Database schema and seed files
├── README.md
└── LICENCE.md
```

---

## ⚙️ Installation

### Prerequisites

- PHP >= 8.0
- MySQL >= 5.7
- A local server (e.g. [XAMPP](https://www.apachefriends.org/), [Laragon](https://laragon.org/), or PHP built-in server)

### Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/Vtr-Frt/toDoList.git
   cd toDoList
   ```

2. **Set up the database**
   - Create a MySQL database (e.g. `todolist`)
   - Import the SQL file:
     ```bash
     mysql -u root -p todolist < sql/todolist.sql
     ```

3. **Configure the database connection**
   - Edit the config file in `app/` with your credentials:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_NAME', 'todolist');
     define('DB_USER', 'root');
     define('DB_PASS', '');
     ```

4. **Start the server**
   ```bash
   php -S localhost:8000 -t public
   ```

5. Open your browser at `http://localhost:8000`

---

## 📜 License

This project is licensed under the MIT License — see the [LICENCE.md](LICENCE.md) file for details.
