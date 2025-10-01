---
layout: post
title: "PHP Security Best Practices - လုံခြုံရေး အကောင်းဆုံး အလေ့အကျင့်များ"
date: 2024-02-18 10:30:00 +0630
categories: php security
---

# PHP Security Best Practices - လုံခြုံရေး အကောင်းဆုံး အလေ့အကျင့်များ

Web application တစ်ခု ဖန်တီးရာတွင် security သည် အလွန်အရေးကြီးပါတယ်။ PHP application များတွင် သတိထားရမည့် security အချက်များကို ဒီဆောင်းပါးတွင် လေ့လာကြမှာ ဖြစ်ပါတယ်။

## SQL Injection ကာကွယ်ခြင်း

SQL Injection သည် အများဆုံး တွေ့ရသော security vulnerability တစ်ခုဖြစ်ပါတယ်။

### မလုံခြုံသော Code

```php
// ဘယ်သောအခါမှ မသုံးရပါ!
$user_id = $_GET['id'];
$query = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $query);
```

### လုံခြုံသော Code

```php
// Prepared Statements အသုံးပြုပါ
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// PDO နဲ့
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $user_id]);
$result = $stmt->fetchAll();
```

## XSS (Cross-Site Scripting) ကာကွယ်ခြင်း

User input ကို output လုပ်တဲ့အခါ escape လုပ်ပေးရပါမယ်။

```php
// မလုံခြုံ
echo $_POST['comment'];

// လုံခြုံ
echo htmlspecialchars($_POST['comment'], ENT_QUOTES, 'UTF-8');

// Laravel Blade မှာ
{{ $comment }}  // Auto-escaped
{!! $comment !!}  // Raw output (သတိထားပါ!)
```

## CSRF (Cross-Site Request Forgery) ကာကွယ်ခြင်း

CSRF tokens အသုံးပြုပြီး forms များကို ကာကွယ်ပါ:

```php
// Session မှာ token သိမ်းထားခြင်း
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Form မှာ token ထည့်ခြင်း
echo '<input type="hidden" name="csrf_token" value="' . $_SESSION['csrf_token'] . '">';

// Form submit လုပ်တဲ့အခါ စစ်ဆေးခြင်း
if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    die('CSRF token validation failed');
}

// Laravel မှာ
@csrf  // Blade directive က အလိုအလျောက် ထည့်ပေးမယ်
```

## Password Hashing

Password များကို မှန်ကန်စွာ hash လုပ်ပါ:

```php
// Password hash လုပ်ခြင်း
$password = 'user_password';
$hash = password_hash($password, PASSWORD_BCRYPT);

// Password verify လုပ်ခြင်း
if (password_verify($password, $hash)) {
    echo 'Password မှန်ကန်ပါတယ်!';
} else {
    echo 'Password မမှန်ကန်ပါ!';
}

// Laravel မှာ
use Illuminate\Support\Facades\Hash;

$hash = Hash::make('password');
if (Hash::check('password', $hash)) {
    // Password မှန်ကန်ပါတယ်
}
```

## File Upload Security

File upload လုပ်တဲ့အခါ သတိထားရမည့် အချက်များ:

```php
$allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
$max_size = 5 * 1024 * 1024; // 5MB

if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
    // File type စစ်ဆေးခြင်း
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $_FILES['file']['tmp_name']);
    finfo_close($finfo);
    
    if (!in_array($mime_type, $allowed_types)) {
        die('Invalid file type');
    }
    
    // File size စစ်ဆေးခြင်း
    if ($_FILES['file']['size'] > $max_size) {
        die('File too large');
    }
    
    // လုံခြုံသော file name ဖန်တီးခြင်း
    $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
    $new_filename = bin2hex(random_bytes(16)) . '.' . $extension;
    
    $upload_path = '/path/to/uploads/' . $new_filename;
    move_uploaded_file($_FILES['file']['tmp_name'], $upload_path);
}
```

## Session Security

```php
// Session သတ်မှတ်ချက်များ
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);  // HTTPS only
ini_set('session.cookie_samesite', 'Strict');
ini_set('session.use_strict_mode', 1);

// Session regenerate
session_start();
session_regenerate_id(true);
```

## Input Validation

```php
// Email validation
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die('Invalid email');
}

// URL validation
if (!filter_var($url, FILTER_VALIDATE_URL)) {
    die('Invalid URL');
}

// Integer validation
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id === false) {
    die('Invalid ID');
}

// Laravel မှာ
$validated = $request->validate([
    'email' => 'required|email',
    'age' => 'required|integer|min:18',
    'website' => 'required|url',
]);
```

## Error Handling

Production environment မှာ error messages များကို မပြပါနဲ့:

```php
// Development
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Production
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/error.log');
```

## HTTP Headers Security

```php
// XSS Protection
header('X-XSS-Protection: 1; mode=block');

// Content Type Options
header('X-Content-Type-Options: nosniff');

// Frame Options
header('X-Frame-Options: SAMEORIGIN');

// Content Security Policy
header("Content-Security-Policy: default-src 'self'");

// HTTPS Redirect
header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
```

## Environment Variables

Sensitive information များကို environment variables တွင် သိမ်းထားပါ:

```php
// .env file
DB_HOST=localhost
DB_USER=username
DB_PASS=password
API_KEY=your_secret_key

// PHP Code
$db_host = getenv('DB_HOST');
$db_user = getenv('DB_USER');

// Laravel မှာ
$api_key = env('API_KEY');
```

## အသုံးဝင်သော Security Checklist

✅ SQL Injection ကာကွယ်ထားပါသလား?
✅ XSS ကာကွယ်ထားပါသလား?
✅ CSRF protection ရှိပါသလား?
✅ Password ကို မှန်ကန်စွာ hash လုပ်ထားပါသလား?
✅ File upload ကို validate လုပ်ထားပါသလား?
✅ Session လုံခြုံစေထားပါသလား?
✅ HTTPS အသုံးပြုထားပါသလား?
✅ Input validation လုပ်ထားပါသလား?
✅ Error messages များကို production မှာ ဝှက်ထားပါသလား?
✅ Sensitive data များကို environment variables တွင် သိမ်းထားပါသလား?

## နိဂုံး

Security သည် one-time task မဟုတ်ပဲ continuous process တစ်ခု ဖြစ်ပါတယ်။ ဒီ best practices များကို လိုက်နာပြီး၊ regular security audits လုပ်ဆောင်သင့်ပါတယ်။ နောက်ဆုံးတွင် dependencies များကို up-to-date ထားရှိပြီး security patches များကို အမြန်ဆုံး apply လုပ်သင့်ပါတယ်။
