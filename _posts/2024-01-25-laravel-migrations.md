---
title: "Laravel Migration နှင့် Database စီမံခန့်ခွဲမှု"
author: khantnyar
date: 2024-01-20 09:30:00 +0630
categories: [Laravel, php]
tags: [laravel]
---
# Laravel Migration နှင့် Database စီမံခန့်ခွဲမှု

Laravel Migration သည် database schema ကို version control လုပ်နိုင်စေသော အရေးကြီงသော feature တစ်ခုဖြစ်ပါတယ်။ Migration များကို အသုံးပြုပြီး database structure ကို အလွယ်တကူ ပြောင်းလဲနိုင်ပါတယ်။

## Migration ဆိုတာဘာလဲ?

Migration သည် database schema ကို ဖန်တီးခြင်း၊ ပြုပြင်ခြင်း၊ ဖျက်ခြင်းတို့ကို PHP code ဖြင့် စီမံခန့်ခွဲနိုင်စေသော နည်းလမ်းတစ်ခုဖြစ်ပါတယ်။

## Migration ဖန်တီးခြင်း

```bash
# Users table အတွက် migration ဖန်တီးခြင်း
php artisan make:migration create_users_table

# Existing table တွင် column အသစ်ထည့်ရန်
php artisan make:migration add_phone_to_users_table --table=users
```

## Migration File ရေးသားခြင်း

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
```

## Migration လုပ်ဆောင်ခြင်း

```bash
# Migrations များအားလုံး run လုပ်ခြင်း
php artisan migrate

# နောက်ဆုံး migration batch ကို rollback လုပ်ခြင်း
php artisan migrate:rollback

# Migrations အားလုံးကို rollback လုပ်ပြီး ပြန် run ခြင်း
php artisan migrate:refresh

# Migration status ကြည့်ခြင်း
php artisan migrate:status
```

## Column Types များ

Laravel တွင် အသုံးပြုနိုင်သော column types အများကြီးရှိပါတယ်:

```php
$table->id();                          // Auto-increment ID
$table->string('name', 100);           // VARCHAR
$table->text('description');           // TEXT
$table->integer('votes');              // INTEGER
$table->decimal('amount', 8, 2);       // DECIMAL
$table->boolean('confirmed');          // BOOLEAN
$table->date('created_date');          // DATE
$table->dateTime('created_at');        // DATETIME
$table->timestamp('updated_at');       // TIMESTAMP
$table->json('options');               // JSON
```

## Foreign Key Constraints

```php
Schema::create('posts', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('title');
    $table->text('content');
    $table->timestamps();
});
```

## Indexes

```php
// Unique index
$table->string('email')->unique();

// Normal index
$table->index('user_id');

// Composite index
$table->index(['user_id', 'created_at']);
```

## အသုံးဝင်သော Tips များ

၁. Migration files များကို version control (Git) တွင် ထည့်သွင်းထားပါ
၂. Production database တွင် migration လုပ်ခြင်းမတိုင်မီ backup ယူထားပါ
၃. Rollback လုပ်နိုင်ရန် `down()` method ကို မမေ့ပဲ ရေးသားပါ
၄. Database structure ပြောင်းလဲတိုင်း migration အသစ်ဖန်တီးပါ

## နိဂုံး

Laravel Migration သည် database version control နှင့် team collaboration အတွက် အလွန်အရေးကြီးသော tool တစ်ခုဖြစ်ပါတယ်။ မှန်ကန်စွာ အသုံးပြုပါက database schema management အလွယ်တကူ လုပ်ဆောင်နိုင်မှာ ဖြစ်ပါတယ်။
