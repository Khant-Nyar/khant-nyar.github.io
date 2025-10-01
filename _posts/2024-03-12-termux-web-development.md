---
layout: post
title: "Termux တွင် Web Development လုပ်ခြင်း"
date: 2024-03-12 13:30:00 +0630
categories: termux webdev mobile
---

# Termux တွင် Web Development လုပ်ခြင်း

Termux ကို အသုံးပြုပြီး Android phone တွင် web development လုပ်ဆောင်နိုင်ပါတယ်။ ဒီဆောင်းပါးမှာ Node.js, PHP, Python web frameworks များကို Termux တွင် အသုံးပြုပုံကို လေ့လာကြမှာ ဖြစ်ပါတယ်။

## Environment Setup

### Node.js Setup

```bash
# Node.js နှင့် npm install
pkg install nodejs

# Version စစ်ဆေးခြင်း
node --version
npm --version

# npm packages install
npm install -g yarn
npm install -g pnpm
```

### PHP Setup

```bash
# PHP install
pkg install php

# Composer install
curl -sS https://getcomposer.org/installer | php
mv composer.phar ~/bin/composer
chmod +x ~/bin/composer

# Composer version
composer --version
```

### Python Setup

```bash
# Python install
pkg install python

# pip upgrade
pip install --upgrade pip

# Web frameworks
pip install flask
pip install django
pip install fastapi
```

## React Application ဖန်တီးခြင်း

```bash
# Create React App
npx create-react-app my-app
cd my-app

# Development server start
npm start

# Browser တွင် http://localhost:3000 ဖွင့်ပါ
```

### Vite ဖြင့် React Project

```bash
# Vite project
npm create vite@latest my-react-app -- --template react
cd my-react-app
npm install
npm run dev
```

## Express.js Backend

```bash
# Project folder ဖန်တီးခြင်း
mkdir my-express-app
cd my-express-app

# npm init
npm init -y

# Express install
npm install express

# Dependencies
npm install dotenv cors body-parser
npm install --save-dev nodemon
```

### server.js ဖန်တီးခြင်း

```javascript
const express = require('express');
const app = express();
const PORT = process.env.PORT || 3000;

app.use(express.json());

app.get('/', (req, res) => {
    res.json({ message: 'Welcome to Express API' });
});

app.get('/api/users', (req, res) => {
    res.json([
        { id: 1, name: 'Khant Nyar' },
        { id: 2, name: 'John Doe' }
    ]);
});

app.post('/api/users', (req, res) => {
    const user = req.body;
    res.status(201).json({ message: 'User created', user });
});

app.listen(PORT, () => {
    console.log(`Server running on port ${PORT}`);
});
```

```bash
# Server start
node server.js

# Nodemon ဖြင့် (auto-reload)
npx nodemon server.js
```

## PHP Development

### Simple PHP Server

```bash
# Project folder
mkdir my-php-app
cd my-php-app

# index.php ဖန်တီးခြင်း
cat > index.php << 'EOF'
<?php
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    echo json_encode([
        'message' => 'Welcome to PHP API',
        'timestamp' => date('Y-m-d H:i:s')
    ]);
} else {
    echo json_encode(['error' => 'Method not allowed']);
}
EOF

# Server start
php -S localhost:8000
```

### Laravel Project

```bash
# Laravel installer
composer global require laravel/installer

# Laravel project ဖန်တီးခြင်း
composer create-project laravel/laravel my-laravel-app
cd my-laravel-app

# Development server
php artisan serve --host=0.0.0.0 --port=8000
```

## Flask Web Application

```bash
# Project folder
mkdir my-flask-app
cd my-flask-app

# Virtual environment
python -m venv venv
source venv/bin/activate

# Flask install
pip install flask flask-cors
```

### app.py ဖန်တီးခြင်း

```python
from flask import Flask, jsonify, request
from flask_cors import CORS

app = Flask(__name__)
CORS(app)

@app.route('/')
def home():
    return jsonify({
        'message': 'Welcome to Flask API',
        'status': 'running'
    })

@app.route('/api/users', methods=['GET'])
def get_users():
    users = [
        {'id': 1, 'name': 'Khant Nyar'},
        {'id': 2, 'name': 'John Doe'}
    ]
    return jsonify(users)

@app.route('/api/users', methods=['POST'])
def create_user():
    user = request.json
    return jsonify({'message': 'User created', 'user': user}), 201

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)
```

```bash
# Run Flask app
python app.py
```

## Database Setup

### SQLite

```bash
# SQLite install (usually pre-installed)
pkg install sqlite

# Database ဖန်တီးခြင်း
sqlite3 mydb.db

# SQL commands
CREATE TABLE users (
    id INTEGER PRIMARY KEY,
    name TEXT NOT NULL,
    email TEXT UNIQUE
);

INSERT INTO users (name, email) VALUES ('Khant', 'khant@example.com');
SELECT * FROM users;
.quit
```

### MariaDB

```bash
# MariaDB install
pkg install mariadb

# Initialize
mysql_install_db

# Start server
mysqld_safe -u root &

# Connect
mysql -u root

# Database ဖန်တီးခြင်း
CREATE DATABASE myapp;
USE myapp;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100)
);
```

## Git Version Control

```bash
# Git config
git config --global user.name "Your Name"
git config --global user.email "your@email.com"

# Repository initialize
git init

# .gitignore ဖန်တီးခြင်း
cat > .gitignore << 'EOF'
node_modules/
vendor/
venv/
__pycache__/
*.pyc
.env
.DS_Store
EOF

# First commit
git add .
git commit -m "Initial commit"

# Remote repository ချိတ်ဆက်ခြင်း
git remote add origin https://github.com/username/repo.git
git push -u origin main
```

## API Testing

### Using curl

```bash
# GET request
curl http://localhost:3000/api/users

# POST request
curl -X POST http://localhost:3000/api/users \
  -H "Content-Type: application/json" \
  -d '{"name":"New User","email":"user@example.com"}'

# Pretty print JSON
curl http://localhost:3000/api/users | python -m json.tool
```

### Using httpie

```bash
# httpie install
pkg install httpie

# GET request
http GET localhost:3000/api/users

# POST request
http POST localhost:3000/api/users name="New User" email="user@example.com"
```

## Process Management with tmux

```bash
# tmux install
pkg install tmux

# New session
tmux new -s dev

# Window ဖန်တီးခြင်း
# Ctrl+b c - New window
# Ctrl+b n - Next window
# Ctrl+b p - Previous window

# Pane split
# Ctrl+b % - Vertical split
# Ctrl+b " - Horizontal split

# Session detach
# Ctrl+b d

# Session list
tmux ls

# Attach to session
tmux attach -t dev
```

## Development Workflow Example

```bash
# tmux session start
tmux new -s webdev

# Backend window
cd ~/projects/backend
npm run dev

# New window (Ctrl+b c)
cd ~/projects/frontend
npm start

# New window for database
mysqld_safe -u root &
mysql -u root

# Detach (Ctrl+b d)
# Terminal ပိတ်လို့ရပြီ၊ processes တွေက background မှာ run နေမယ်

# Reattach လုပ်ရန်
tmux attach -t webdev
```

## Useful Tips

### Auto-start Services

`~/.bashrc` တွင် ထည့်ပါ:

```bash
# Auto-start MySQL
if ! pgrep -x "mysqld" > /dev/null; then
    mysqld_safe -u root &
fi
```

### Port Forwarding

Computer မှ phone ၏ web server ကို access လုပ်ရန် SSH port forwarding:

```bash
# Phone တွင်
sshd

# Computer မှ
ssh -L 8080:localhost:3000 username@phone-ip -p 8022
# Browser မှာ localhost:8080 ဖွင့်ပါ
```

### Code Editor

```bash
# Neovim install (Better than vim)
pkg install neovim

# Micro editor (Easy to use)
pkg install micro

# VS Code alternative
pkg install code-server
code-server
# Browser မှာ localhost:8080 ဖွင့်ပါ
```

## Performance Tips

၁. **Node modules** - `node_modules` က storage များစွာ သုံးတယ်၊ လိုအပ်ချက်မရှိရင် ဖျက်ပါ
၂. **Development mode** - Production build ထက် development က memory များ သုံးတယ်
၃. **Background processes** - မလိုအပ်သော processes များကို ရပ်ပါ
၄. **Swap file** - RAM နည်းရင် swap file ဖန်တီးပါ

## နိဂုံး

Termux သည် mobile device တွင် full-stack web development လုပ်ဆောင်နိုင်စေပါတယ်။ Node.js, PHP, Python framework များကို အလွယ်တကူ run နိုင်ပြီး၊ computer မရှိတဲ့ အခြေအနေမှာလည်း web applications များ ဖန်တီးနိုင်ပါတယ်။
