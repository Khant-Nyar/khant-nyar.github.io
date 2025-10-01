---
layout: post
title: "Laravel Eloquent Relationships - အဆက်အသွယ်များကို စီမံခန့်ခွဲခြင်း"
date: 2024-02-01 11:00:00 +0630
categories: laravel eloquent
---

# Laravel Eloquent Relationships - အဆက်အသွယ်များကို စီမံခန့်ခွဲခြင်း

Database tables များအကြား relationship များကို Laravel Eloquent က အလွန်လွယ်ကူစွာ စီမံခန့်ခွဲနိုင်စေပါတယ်။ ဒီဆောင်းပါးမှာ အဓိက relationship types များကို လေ့လာကြမှာဖြစ်ပါတယ်။

## One to One Relationship

တစ်ခုနဲ့ တစ်ခု ဆက်စပ်မှု - ဥပမာ User တစ်ဦးမှာ Profile တစ်ခုသာ ရှိနိုင်ပါတယ်။

```php
// User Model
class User extends Model
{
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
}

// Profile Model
class Profile extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

// အသုံးပြုပုံ
$user = User::find(1);
echo $user->profile->bio;
```

## One to Many Relationship

တစ်ခုနဲ့ အများ ဆက်စပ်မှု - ဥပမာ User တစ်ဦးမှာ Posts အများကြီး ရှိနိုင်ပါတယ်။

```php
// User Model
class User extends Model
{
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}

// Post Model
class Post extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

// အသုံးပြုပုံ
$user = User::find(1);
foreach($user->posts as $post) {
    echo $post->title;
}
```

## Many to Many Relationship

အများနဲ့ အများ ဆက်စပ်မှု - ဥပမာ User များမှာ Role များ ရှိနိုင်ပြီး၊ Role တစ်ခုမှာလည်း User များ ရှိနိုင်ပါတယ်။

```php
// User Model
class User extends Model
{
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}

// Role Model
class Role extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}

// အသုံးပြုပုံ
$user = User::find(1);
foreach($user->roles as $role) {
    echo $role->name;
}

// Role ချိတ်ဆက်ခြင်း
$user->roles()->attach($roleId);

// Role ဖြုတ်ခြင်း
$user->roles()->detach($roleId);

// Roles အားလုံးကို sync လုပ်ခြင်း
$user->roles()->sync([1, 2, 3]);
```

## Has Many Through

သုံးထပ် ဆက်စပ်မှု - ဥပမာ Country -> User -> Post

```php
// Country Model
class Country extends Model
{
    public function posts()
    {
        return $this->hasManyThrough(Post::class, User::class);
    }
}

// အသုံးပြုပုံ
$country = Country::find(1);
$posts = $country->posts;
```

## Polymorphic Relationships

ယေဘုယျ ဆက်စပ်မှု - တစ်ခု model က အခြား models များနဲ့ ဆက်စပ်နိုင်ခြင်း။

```php
// Comment Model
class Comment extends Model
{
    public function commentable()
    {
        return $this->morphTo();
    }
}

// Post Model
class Post extends Model
{
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}

// Video Model
class Video extends Model
{
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}

// အသုံးပြုပုံ
$post = Post::find(1);
foreach($post->comments as $comment) {
    echo $comment->body;
}
```

## Eager Loading

N+1 query problem ကို ရှောင်ရှားရန် eager loading အသုံးပြုပါ:

```php
// Without eager loading (N+1 problem)
$users = User::all();
foreach($users as $user) {
    echo $user->profile->bio;  // အပိုတိုင်း query run မယ်
}

// With eager loading (Better)
$users = User::with('profile')->get();
foreach($users as $user) {
    echo $user->profile->bio;  // Query တစ်ခုတည်း
}

// Multiple relationships
$users = User::with(['posts', 'profile'])->get();

// Nested relationships
$users = User::with('posts.comments')->get();
```

## Relationship Methods များ

```php
// Existence queries
$users = User::has('posts')->get();  // Posts ရှိတဲ့ users များ
$users = User::has('posts', '>=', 3)->get();  // Posts 3 ခုနှင့်အထက် ရှိတဲ့ users များ

// Wherehas
$users = User::whereHas('posts', function($query) {
    $query->where('published', true);
})->get();

// Counting relationships
$users = User::withCount('posts')->get();
echo $users[0]->posts_count;
```

## အသုံးဝင်သော Tips များ

၁. **Eager Loading ကို အသုံးပြုပါ** - Performance ကောင်းစေရန်
၂. **Proper indexing** - Foreign keys များတွင် index ထည့်ပါ
၃. **Lazy loading သတိထားပါ** - N+1 problem ရှောင်ပါ
၄. **withCount() အသုံးပြုပါ** - Count လုပ်ရန်အတွက်

## နိဂုံး

Laravel Eloquent Relationships သည် database relationships များကို အလွန်လွယ်ကူစွာ စီမံခန့်ခွဲနိုင်စေပါတယ်။ မှန်ကန်စွာ အသုံးပြုပါက code ရှင်းလင်းပြီး maintain လုပ်ရလွယ်ကူမှာ ဖြစ်ပါတယ်။
