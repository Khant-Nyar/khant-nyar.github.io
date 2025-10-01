---
layout: post
title: "PHP 8 ၏ အသစ်ထွက်ရှိလာသော Features များ"
date: 2024-02-10 14:00:00 +0630
categories: php programming
---

# PHP 8 ၏ အသစ်ထွက်ရှိလာသော Features များ

PHP 8 သည် PHP ဘာသာစကား၏ အကြီးမားဆုံး update တစ်ခုဖြစ်ပြီး၊ အသစ်သော features အများအပြားနှင့် performance improvements များ ပါဝင်ပါတယ်။

## JIT Compiler (Just In Time)

PHP 8 တွင် JIT compiler ပါဝင်လာပြီး performance သိသိသာသာ တိုးတက်လာပါတယ်။

```php
// JIT က automatically optimize လုပ်ပေးမှာဖြစ်ပါတယ်
function fibonacci($n) {
    if ($n <= 1) return $n;
    return fibonacci($n - 1) + fibonacci($n - 2);
}
```

## Named Arguments

Function parameters များကို name ဖြင့် ခေါ်နိုင်ပါပြီ:

```php
// အရင်ကျသော်
function createUser($name, $email, $active = true, $role = 'user') {
    // ...
}
createUser('Khant', 'khant@example.com', true, 'admin');

// PHP 8 မှာ
createUser(
    name: 'Khant',
    email: 'khant@example.com',
    role: 'admin'  // $active ကို ကျော်နိုင်ပါပြီ
);
```

## Union Types

Variable တစ်ခုမှာ type အများကြီး ရှိနိုင်ကြောင်း ဖော်ပြနိုင်ပါပြီ:

```php
class User {
    private int|float $id;
    private string|null $name;
    
    public function setId(int|float $id): void {
        $this->id = $id;
    }
    
    public function getId(): int|float {
        return $this->id;
    }
}
```

## Match Expression

`switch` ထက် ပိုကောင်းတဲ့ `match` expression:

```php
// switch (အရင်က)
switch ($status) {
    case 'pending':
        $message = 'အတည်ပြုစောင့်ဆိုင်းဆဲ';
        break;
    case 'approved':
        $message = 'အတည်ပြုပြီး';
        break;
    case 'rejected':
        $message = 'ပယ်ချခဲ့သည်';
        break;
    default:
        $message = 'အခြေအနေမသိ';
}

// match (PHP 8)
$message = match($status) {
    'pending' => 'အတည်ပြုစောင့်ဆိုင်းဆဲ',
    'approved' => 'အတည်ပြုပြီး',
    'rejected' => 'ပယ်ချခဲ့သည်',
    default => 'အခြေအနေမသိ',
};
```

## Constructor Property Promotion

Class constructor တွင် properties များကို တိုတောင်းစွာ declare လုပ်နိုင်ပါပြီ:

```php
// အရင်က
class User {
    private string $name;
    private string $email;
    private int $age;
    
    public function __construct(string $name, string $email, int $age) {
        $this->name = $name;
        $this->email = $email;
        $this->age = $age;
    }
}

// PHP 8
class User {
    public function __construct(
        private string $name,
        private string $email,
        private int $age
    ) {}
}
```

## Nullsafe Operator

Null checking ကို လွယ်ကူစေသော operator:

```php
// အရင်က
$country = null;
if ($session !== null) {
    $user = $session->user;
    if ($user !== null) {
        $address = $user->address;
        if ($address !== null) {
            $country = $address->country;
        }
    }
}

// PHP 8
$country = $session?->user?->address?->country;
```

## Attributes (Annotations)

PHP 8 တွင် native attributes support ပါဝင်လာပါပြီ:

```php
#[Route('/api/users', methods: ['GET'])]
class UserController {
    #[Required]
    #[Email]
    private string $email;
    
    #[Deprecated('Use getFullName() instead')]
    public function getName(): string {
        return $this->name;
    }
}
```

## Weak Maps

Memory leaks ရှောင်ရှားရန် weak references များအတွက်:

```php
$map = new WeakMap();
$obj = new stdClass();
$map[$obj] = 'some data';

// $obj က garbage collected ဖြစ်သွားရင် map entry လည်း ပျောက်သွားမယ်
```

## Throw Expression

`throw` ကို expression အဖြစ် အသုံးပြုနိုင်ပါပြီ:

```php
// Ternary operator နဲ့
$value = $input ?? throw new InvalidArgumentException('Input required');

// Arrow function နဲ့
$callback = fn() => throw new Exception('Not implemented');

// Null coalescing operator နဲ့
$name = $data['name'] ?? throw new InvalidArgumentException('Name required');
```

## String Functions Improvements

```php
// str_contains()
if (str_contains('Hello World', 'World')) {
    echo 'Found!';
}

// str_starts_with()
if (str_starts_with('Laravel Framework', 'Laravel')) {
    echo 'Starts with Laravel!';
}

// str_ends_with()
if (str_ends_with('file.php', '.php')) {
    echo 'PHP file!';
}
```

## Mixed Type

Any type ကို accept လုပ်နိုင်တဲ့ `mixed` type:

```php
function processValue(mixed $value): mixed {
    // $value သည် မည်သည့် type မဆို ဖြစ်နိုင်ပါတယ်
    return $value;
}
```

## နိဂုံး

PHP 8 သည် modern programming language တစ်ခုအနေဖြင့် အရည်အသွေးမြင့်မားလာပါပြီ။ ဒီ features အသစ်များက code ကို ပို၍ ရှင်းလင်းစေပြီး၊ maintain လုပ်ရလွယ်ကူစေပါတယ်။ PHP developer များအနေနဲ့ ဒီ features များကို လေ့လာအသုံးပြုသင့်ပါတယ်။
