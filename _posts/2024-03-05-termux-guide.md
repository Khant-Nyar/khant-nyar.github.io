---
layout: post
title: "Termux - Android Phone တွင် Linux Terminal အသုံးပြုခြင်း"
date: 2024-03-05 15:00:00 +0630
categories: termux android linux
---

# Termux - Android Phone တွင် Linux Terminal အသုံးပြုခြင်း

Termux သည် Android device များတွင် Linux terminal environment ကို အသုံးပြုနိုင်စေသော အလွန်အသုံးဝင်တဲ့ application တစ်ခုဖြစ်ပါတယ်။ Root permission မလိုအပ်ပဲ အသုံးပြုနိုင်ပါတယ်။

## Termux ကို Install လုပ်ခြင်း

Termux ကို F-Droid မှ download လုပ်ရပါမယ် (Google Play Store မှ version က outdated ဖြစ်နေပါတယ်):

၁. F-Droid app ကို install လုပ်ပါ (https://f-droid.org)
၂. F-Droid တွင် Termux ကို ရှာပြီး install လုပ်ပါ
၃. Termux ကို ဖွင့်ပြီး စတင်အသုံးပြုနိုင်ပါပြီ

## အခြေခံ Setup

### Packages Update လုပ်ခြင်း

```bash
# Package lists များကို update လုပ်ခြင်း
pkg update

# Installed packages များကို upgrade လုပ်ခြင်း
pkg upgrade
```

### Storage Access Permission

```bash
# Internal storage ကို access လုပ်ရန်
termux-setup-storage
```

ဒီ command ကို run လုပ်ရင် permission dialog ပေါ်လာပြီး allow လုပ်ပေးရပါမယ်။ ပြီးရင် `~/storage` folder ကနေ phone storage ကို access လုပ်နိုင်ပါပြီ။

## အသုံးဝင်သော Packages များ Install လုပ်ခြင်း

```bash
# Development tools
pkg install git
pkg install python
pkg install nodejs
pkg install php
pkg install ruby
pkg install golang

# Text editors
pkg install vim
pkg install nano
pkg install emacs

# Network tools
pkg install curl
pkg install wget
pkg install openssh

# Database
pkg install mariadb
pkg install postgresql
pkg install sqlite

# Others
pkg install htop
pkg install tree
pkg install tmux
pkg install zip unzip
```

## Python Development

```bash
# Python install လုပ်ခြင်း
pkg install python

# pip upgrade
pip install --upgrade pip

# Virtual environment
pip install virtualenv

# Virtual environment ဖန်တီးခြင်း
python -m venv myenv
source myenv/bin/activate

# Packages install
pip install flask django requests
```

## Web Development

```bash
# Node.js နှင့် npm
pkg install nodejs

# Package install
npm install -g express-generator
npm install -g create-react-app
npm install -g @vue/cli

# PHP
pkg install php
php -v

# Local server run
php -S localhost:8000
```

## Git အသုံးပြုခြင်း

```bash
# Git configuration
git config --global user.name "Your Name"
git config --global user.email "your.email@example.com"

# Repository clone
git clone https://github.com/username/repo.git

# SSH key generation
pkg install openssh
ssh-keygen -t rsa -b 4096 -C "your.email@example.com"

# Public key ကြည့်ခြင်း
cat ~/.ssh/id_rsa.pub
```

## SSH Server Setup

```bash
# OpenSSH install
pkg install openssh

# SSH server start
sshd

# Username စစ်ဆေးခြင်း
whoami

# Password သတ်မှတ်ခြင်း
passwd

# IP address စစ်ဆေးခြင်း
ifconfig
```

Computer မှ Termux ကို SSH ဖြင့် connect လုပ်ရန်:
```bash
ssh username@phone-ip-address -p 8022
```

## File Management

```bash
# Current directory
pwd

# List files
ls -la

# Navigate
cd ~/storage/downloads
cd ../

# Copy files
cp file.txt backup.txt

# Move/Rename
mv oldname.txt newname.txt

# Remove
rm file.txt
rm -rf folder/

# Create directory
mkdir my-folder

# View file content
cat file.txt
less file.txt
```

## Text Editing

### Vim အသုံးပြုခြင်း

```bash
# Install Vim
pkg install vim

# File edit
vim myfile.txt

# Vim commands
# i - Insert mode
# Esc - Command mode
# :w - Save
# :q - Quit
# :wq - Save and quit
# :q! - Quit without saving
```

### Nano အသုံးပြုခြင်း

```bash
# Install Nano
pkg install nano

# File edit
nano myfile.txt

# Ctrl+O - Save
# Ctrl+X - Exit
# Ctrl+K - Cut line
# Ctrl+U - Paste
```

## MariaDB Database

```bash
# Install MariaDB
pkg install mariadb

# Initialize database
mysql_install_db

# Start MySQL server
mysqld_safe -u root &

# Connect to MySQL
mysql -u root

# MySQL commands
CREATE DATABASE mydb;
SHOW DATABASES;
USE mydb;
CREATE TABLE users (id INT, name VARCHAR(50));
```

## Useful Scripts

### Termux Customization

`.bashrc` file edit လုပ်ခြင်း:

```bash
nano ~/.bashrc
```

Add these lines:

```bash
# Aliases
alias ll='ls -la'
alias ..='cd ..'
alias update='pkg update && pkg upgrade'

# Custom prompt
PS1='\[\e[1;32m\]\u@termux:\[\e[1;34m\]\w\[\e[0m\]\$ '

# Welcome message
echo "Welcome to Termux!"
echo "Type 'help' for commands"
```

### Backup Script

```bash
#!/bin/bash
# backup.sh

BACKUP_DIR="$HOME/storage/downloads/backups"
DATE=$(date +%Y%m%d_%H%M%S)

mkdir -p $BACKUP_DIR
tar -czf $BACKUP_DIR/backup_$DATE.tar.gz $HOME/projects

echo "Backup completed: backup_$DATE.tar.gz"
```

## Keyboard Shortcuts

Termux တွင် အသုံးဝင်သော keyboard shortcuts:

- **Ctrl + A** - Move cursor to beginning
- **Ctrl + E** - Move cursor to end
- **Ctrl + K** - Delete to end of line
- **Ctrl + U** - Delete to beginning of line
- **Ctrl + C** - Cancel current command
- **Ctrl + D** - Exit terminal
- **Volume Up + Q** - Show extra keys
- **Volume Down** - Control key

## Termux:API

Phone features များကို access လုပ်ရန်:

```bash
# Install Termux:API
pkg install termux-api

# Examples
termux-battery-status
termux-camera-photo picture.jpg
termux-location
termux-notification "Hello" "This is a notification"
termux-toast "Toast message"
termux-clipboard-get
termux-clipboard-set "text to copy"
```

## Tips နှင့် Tricks

၁. **Screen lock ပြဿနာ** - Termux:Wake Lock app သုံးပါ
၂. **Extra keys** - Volume Up + Q ကို နှိပ်ပါ
၃. **Background process** - `tmux` သို့မဟုတ် `screen` သုံးပါ
၄. **Quick commands** - Aliases များ ဖန်တီးပါ
၅. **Backup** - အရေးကြီးသော files များကို regular backup လုပ်ပါ

## နိဂုံး

Termux သည် Android device တွင် programming လုပ်ရန်၊ scripts များ run ရန်၊ နှင့် development လုပ်ရန် အလွန်အသုံးဝင်ပါတယ်။ Computer မရှိသော အခြေအနေများတွင် mobile device ပေါ်မှာပဲ coding လုပ်နိုင်စေပါတယ်။
