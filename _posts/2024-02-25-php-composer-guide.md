---
layout: post
title: "PHP Composer - Dependency Management အကြောင်း"
date: 2024-02-25 09:00:00 +0630
categories: php composer
---

# PHP Composer - Dependency Management အကြောင်း

Composer သည် PHP အတွက် dependency management tool တစ်ခုဖြစ်ပြီး၊ PHP libraries များကို လွယ်ကူစွာ install လုပ်ပြီး manage လုပ်နိုင်စေပါတယ်။

## Composer ကို Install လုပ်ခြင်း

### Linux/Mac
```bash
# Download installer
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"

# Install globally
php composer-setup.php --install-dir=/usr/local/bin --filename=composer

# Remove installer
php -r "unlink('composer-setup.php');"

# Check installation
composer --version
```

### Windows
Composer-Setup.exe ကို download လုပ်ပြီး install လုပ်နိုင်ပါတယ်။

## composer.json File

Project ၏ dependencies များကို `composer.json` file တွင် သတ်မှတ်ပါတယ်:

```json
{
    "name": "khant/my-project",
    "description": "My awesome PHP project",
    "type": "project",
    "license": "MIT",
    "authors": [
        {
            "name": "Khant Nyar",
            "email": "khant@example.com"
        }
    ],
    "require": {
        "php": "^8.0",
        "monolog/monolog": "^2.0",
        "guzzlehttp/guzzle": "^7.0"
    },
    "require-dev": {
        "phpunit/phpunit": "^9.0"
    },
    "autoload": {
        "psr-4": {
            "App\\": "src/"
        }
    }
}
```

## Packages Install လုပ်ခြင်း

```bash
# composer.json အတိုင်း install လုပ်ခြင်း
composer install

# Package အသစ်ထည့်ခြင်း
composer require monolog/monolog

# Development package ထည့်ခြင်း
composer require --dev phpunit/phpunit

# Package ဖြုတ်ခြင်း
composer remove monolog/monolog

# Packages များကို update လုပ်ခြင်း
composer update
```

## Version Constraints

```json
{
    "require": {
        "vendor/package": "1.2.3",        // Exact version
        "vendor/package": ">=1.2.3",      // Greater than or equal
        "vendor/package": "<1.2.3",       // Less than
        "vendor/package": "^1.2.3",       // >=1.2.3 <2.0.0
        "vendor/package": "~1.2.3",       // >=1.2.3 <1.3.0
        "vendor/package": "1.*",          // >=1.0.0 <2.0.0
        "vendor/package": "dev-master"    // Development branch
    }
}
```

## Autoloading

Composer က autoloading ကို အလိုအလျောက် စီမံပေးပါတယ်:

```php
// Composer autoloader ကို load လုပ်ခြင်း
require __DIR__ . '/vendor/autoload.php';

// Classes များကို အသုံးပြုခြင်း
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$log = new Logger('name');
$log->pushHandler(new StreamHandler('app.log', Logger::WARNING));
$log->warning('ဒီသည် warning message တစ်ခုဖြစ်ပါတယ်');
```

### PSR-4 Autoloading

```json
{
    "autoload": {
        "psr-4": {
            "App\\": "src/",
            "App\\Models\\": "src/Models/",
            "App\\Controllers\\": "src/Controllers/"
        }
    }
}
```

```bash
# Autoload files ကို regenerate လုပ်ခြင်း
composer dump-autoload
```

## Scripts

Composer scripts များကို သတ်မှတ်နိုင်ပါတယ်:

```json
{
    "scripts": {
        "test": "phpunit",
        "start": "php -S localhost:8000",
        "post-install-cmd": [
            "php artisan clear-compiled",
            "php artisan optimize"
        ],
        "pre-update-cmd": [
            "echo 'Updating packages...'"
        ]
    }
}
```

```bash
# Script run လုပ်ခြင်း
composer test
composer start
```

## Optimization

```bash
# Autoloader optimization
composer dump-autoload --optimize

# Production install
composer install --no-dev --optimize-autoloader

# Class map generation
composer dump-autoload --classmap-authoritative
```

## composer.lock File

`composer.lock` file သည် installed packages ၏ exact versions များကို သိမ်းဆည်းထားပါတယ်။

```bash
# composer.lock အတိုင်း install လုပ်ခြင်း
composer install

# composer.json အတိုင်း update လုပ်ပြီး composer.lock ကို update လုပ်ခြင်း
composer update
```

**အရေးကြီး:** `composer.lock` ကို version control (Git) တွင် ထည့်ပါ။ `vendor/` folder ကို မထည့်ပါနဲ့။

## Useful Commands

```bash
# Outdated packages ကြည့်ခြင်း
composer outdated

# Package information
composer show vendor/package

# Package search လုပ်ခြင်း
composer search monolog

# Validate composer.json
composer validate

# Diagnose problems
composer diagnose

# Self update
composer self-update

# Clear cache
composer clear-cache
```

## Private Repositories

Private repositories များကို အသုံးပြုခြင်း:

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/company/private-repo"
        }
    ]
}
```

## Packagist

Packagist.org သည် Composer ၏ main repository ဖြစ်ပြီး၊ public packages များကို တွေ့နိုင်ပါတယ်။

### ကိုယ့် Package ကို Publish လုပ်ခြင်း

၁. GitHub repository တစ်ခု ဖန်တီးပါ
၂. composer.json file ဖန်တီးပါ
၃. Packagist.org တွင် submit လုပ်ပါ
၄. GitHub webhook setup လုပ်ပါ

## Best Practices

၁. **composer.lock ကို commit လုပ်ပါ** - Consistent installations အတွက်
၂. **Semantic Versioning အသုံးပြုပါ** - Version constraints မှန်ကန်စွာ သတ်မှတ်ပါ
၃. **vendor/ ကို .gitignore တွင် ထည့်ပါ** - Repository size လျှော့ပါ
၄. **composer install အသုံးပြုပါ** - Production တွင် update မလုပ်ပါနဲ့
၅. **Security updates ကို follow လုပ်ပါ** - composer outdated ကို regular စစ်ဆေးပါ

## နိဂုံး

Composer သည် modern PHP development အတွက် မရှိမဖြစ် tool တစ်ခု ဖြစ်ပါတယ်။ Dependencies များကို လွယ်ကူစွာ စီမံခန့်ခွဲနိုင်ပြီး၊ autoloading နှင့် package management အတွက် အကောင်းဆုံး solution ဖြစ်ပါတယ်။
