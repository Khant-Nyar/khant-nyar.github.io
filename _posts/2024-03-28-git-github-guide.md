---
layout: post
title: "Git နှင့် GitHub - Version Control အခြေခံများ"
date: 2024-03-28 14:30:00 +0630
categories: git github versioncontrol
---

# Git နှင့် GitHub - Version Control အခြေခံများ

Git သည် version control system တစ်ခုဖြစ်ပြီး၊ code changes များကို track လုပ်နိုင်စေပါတယ်။ GitHub သည် Git repositories များကို host လုပ်ပေးတဲ့ platform တစ်ခုဖြစ်ပါတယ်။

## Git ကို Install လုပ်ခြင်း

### Linux
```bash
# Ubuntu/Debian
sudo apt-get install git

# Fedora
sudo dnf install git

# Termux
pkg install git
```

### Mac
```bash
brew install git
```

### Windows
Git for Windows ကို https://git-scm.com မှ download လုပ်ပါ။

## Git Configuration

```bash
# User information သတ်မှတ်ခြင်း
git config --global user.name "Your Name"
git config --global user.email "your.email@example.com"

# Default editor သတ်မှတ်ခြင်း
git config --global core.editor "vim"

# Configuration စစ်ဆေးခြင်း
git config --list
git config user.name
```

## Repository ဖန်တီးခြင်း

### Local Repository

```bash
# Project folder ဖန်တီးခြင်း
mkdir my-project
cd my-project

# Git initialize
git init

# Status စစ်ဆေးခြင်း
git status
```

### Clone Remote Repository

```bash
# GitHub repository clone
git clone https://github.com/username/repository.git

# Specific branch clone
git clone -b branch-name https://github.com/username/repository.git
```

## အခြေခံ Git Commands

### Files ထည့်ခြင်းနှင့် Commit လုပ်ခြင်း

```bash
# File ဖန်တီးခြင်း
echo "# My Project" > README.md

# Staging area သို့ ထည့်ခြင်း
git add README.md

# အားလုံးကို staging area သို့
git add .
git add -A

# Commit လုပ်ခြင်း
git commit -m "Initial commit"

# Add နှင့် commit တစ်ခါတည်း
git commit -am "Update files"
```

### Changes ကြည့်ခြင်း

```bash
# Working directory changes
git status

# Unstaged changes
git diff

# Staged changes
git diff --staged

# Specific file
git diff filename.txt

# Commit history
git log
git log --oneline
git log --graph --oneline --all
```

### Undo Changes

```bash
# Working directory changes undo
git checkout -- filename.txt

# Unstage file
git reset HEAD filename.txt

# Last commit undo (keep changes)
git reset --soft HEAD~1

# Last commit undo (discard changes)
git reset --hard HEAD~1

# Specific commit သို့ ပြန်သွားခြင်း
git reset --hard commit-hash
```

## Branches

```bash
# Branch list
git branch

# New branch ဖန်တီးခြင်း
git branch feature-login

# Branch switch
git checkout feature-login

# ဖန်တီးပြီး switch (တစ်ခါတည်း)
git checkout -b feature-signup

# Branch rename
git branch -m old-name new-name

# Branch delete
git branch -d feature-name
git branch -D feature-name  # Force delete
```

## Merging

```bash
# feature branch ကို main သို့ merge
git checkout main
git merge feature-login

# Merge conflicts ဖြေရှင်းခြင်း
# 1. Conflicted files များကို edit လုပ်ပါ
# 2. Resolved files များကို add လုပ်ပါ
git add resolved-file.txt
# 3. Merge commit လုပ်ပါ
git commit -m "Merge feature-login"
```

## Remote Repository

### Remote ထည့်ခြင်း

```bash
# Remote repository ချိတ်ဆက်ခြင်း
git remote add origin https://github.com/username/repo.git

# Remote list
git remote -v

# Remote URL ပြောင်းခြင်း
git remote set-url origin https://github.com/username/new-repo.git
```

### Push နှင့် Pull

```bash
# Push to remote
git push origin main

# First push (-u သတ်မှတ်ပါ)
git push -u origin main

# All branches push
git push --all origin

# Pull from remote
git pull origin main

# Fetch (download without merge)
git fetch origin
```

## GitHub Workflow

### SSH Key Setup

```bash
# SSH key ဖန်တီးခြင်း
ssh-keygen -t ed25519 -C "your.email@example.com"

# Public key ကြည့်ခြင်း
cat ~/.ssh/id_ed25519.pub

# GitHub Settings > SSH Keys တွင် ထည့်ပါ
```

### Repository ဖန်တီးပြီး Push လုပ်ခြင်း

```bash
# Local project
git init
git add .
git commit -m "Initial commit"

# GitHub တွင် repository ဖန်တီးပါ
# Remote ချိတ်ဆက်ပါ
git remote add origin git@github.com:username/repo.git

# Push
git push -u origin main
```

## Pull Requests

Pull Request workflow:

၁. Repository ကို fork လုပ်ပါ
၂. Clone your fork
```bash
git clone https://github.com/your-username/repo.git
```
၃. New branch ဖန်တီးပါ
```bash
git checkout -b fix-bug
```
၄. Changes လုပ်ပါ
```bash
git add .
git commit -m "Fix bug in login"
```
၅. Push to your fork
```bash
git push origin fix-bug
```
၆. GitHub တွင် Pull Request ဖန်တီးပါ

## .gitignore

Ignore လုပ်ချင်တဲ့ files များကို `.gitignore` file တွင် ထည့်ပါ:

```gitignore
# Dependencies
node_modules/
vendor/

# Environment variables
.env
.env.local

# Build outputs
dist/
build/
*.log

# IDE
.vscode/
.idea/
*.swp

# OS
.DS_Store
Thumbs.db

# Temporary files
*.tmp
*.temp
```

## Useful Commands

### Stash

Changes များကို temporary save လုပ်ခြင်း:

```bash
# Stash changes
git stash

# Stash with message
git stash save "Work in progress"

# Stash list
git stash list

# Apply stash
git stash apply
git stash pop  # Apply and remove

# Drop stash
git stash drop
```

### Tags

Releases တွေအတွက် tags:

```bash
# Tag ဖန်တီးခြင်း
git tag v1.0.0

# Annotated tag
git tag -a v1.0.0 -m "Release version 1.0.0"

# Tag list
git tag

# Push tags
git push origin v1.0.0
git push origin --tags

# Tag delete
git tag -d v1.0.0
git push origin :refs/tags/v1.0.0
```

### Cherry-pick

Specific commit ကို အခြား branch သို့ ယူခြင်း:

```bash
git cherry-pick commit-hash
```

### Rebase

```bash
# Feature branch ကို main ပေါ်တွင် rebase
git checkout feature-branch
git rebase main

# Interactive rebase
git rebase -i HEAD~3
```

## Git Aliases

Shortcuts များ ဖန်တီးခြင်း:

```bash
# Aliases သတ်မှတ်ခြင်း
git config --global alias.co checkout
git config --global alias.br branch
git config --global alias.ci commit
git config --global alias.st status
git config --global alias.unstage 'reset HEAD --'
git config --global alias.last 'log -1 HEAD'
git config --global alias.lg "log --graph --oneline --all"

# အသုံးပြုပုံ
git co main
git br
git st
```

## Best Practices

၁. **Commit messages** - Clear and descriptive ဖြစ်အောင် ရေးပါ
```
Good: "Add user authentication feature"
Bad: "Update files"
```

၂. **Commit often** - Small, logical commits လုပ်ပါ

၃. **Branch naming** - Meaningful names အသုံးပြုပါ
```
feature/user-login
bugfix/payment-error
hotfix/security-patch
```

၄. **Pull before push** - Conflicts ရှောင်ရန် pull လုပ်ပြီး push လုပ်ပါ

၅. **.gitignore** - Sensitive files များ မပါစေပါနဲ့

၆. **Review changes** - Commit မလုပ်ခင် `git diff` ကြည့်ပါ

## Common Issues

### Merge Conflicts

```bash
# Conflict files ကို edit လုပ်ပါ
# <<<<<<< HEAD
# Your changes
# =======
# Their changes
# >>>>>>> branch-name

# Resolve လုပ်ပြီးရင်
git add resolved-file.txt
git commit -m "Resolve merge conflicts"
```

### Wrong Commit Message

```bash
# Last commit message ပြင်ခြင်း
git commit --amend -m "Correct message"
```

### Pushed Wrong Files

```bash
# File remove from git but keep locally
git rm --cached filename

# Commit and push
git commit -m "Remove file from repo"
git push
```

## နိဂုံး

Git နှင့် GitHub သည် modern software development အတွက် မရှိမဖြစ် tools များဖြစ်ပါတယ်။ Version control က team collaboration ကို လွယ်ကူစေပြီး၊ code history ကို track လုပ်နိုင်စေပါတယ်။ ဒီ commands များကို လေ့ကျင့်အသုံးပြုပြီး Git workflow ကို ကျွမ်းကျင်စေပါ။
