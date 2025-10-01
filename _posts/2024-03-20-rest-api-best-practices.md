---
layout: post
title: "REST API Design Best Practices - အကောင်းဆုံး ဒီဇိုင်းလုပ်နည်းများ"
date: 2024-03-20 10:00:00 +0630
categories: api webdev
---

# REST API Design Best Practices - အကောင်းဆုံး ဒီဇိုင်းလုပ်နည်းများ

REST API ကို ဒီဇိုင်းလုပ်တဲ့အခါ best practices များကို လိုက်နာခြင်းဖြင့် maintainable နှင့် scalable API တစ်ခု ဖန်တီးနိုင်ပါတယ်။

## RESTful Principles

REST (Representational State Transfer) သည် architectural style တစ်ခုဖြစ်ပြီး၊ အောက်ပါ principles များကို လိုက်နာပါတယ်:

၁. **Client-Server Architecture** - Frontend နှင့် Backend ခွဲထားခြင်း
၂. **Stateless** - Request တစ်ခုချင်းစီသည် independent ဖြစ်ခြင်း
၃. **Cacheable** - Response များကို cache လုပ်နိုင်ခြင်း
၄. **Uniform Interface** - Consistent endpoint structure
၅. **Layered System** - System layers များခွဲထားနိုင်ခြင်း

## URL Structure

### Resource Naming

```
# Good - Plural nouns, lowercase, hyphens
GET    /api/users
GET    /api/users/123
GET    /api/blog-posts
GET    /api/blog-posts/456/comments

# Bad - Verbs, mixed case, underscores
GET    /api/getUsers
GET    /api/User
GET    /api/blog_posts
```

### Hierarchical Resources

```
# Parent-child relationships
GET    /api/users/123/posts          # User ရဲ့ posts များ
GET    /api/posts/456/comments       # Post ရဲ့ comments များ
GET    /api/categories/789/products  # Category ရဲ့ products များ
```

## HTTP Methods

မှန်ကန်သော HTTP methods များကို အသုံးပြုပါ:

```
GET    /api/users           # List all users
GET    /api/users/123       # Get specific user
POST   /api/users           # Create new user
PUT    /api/users/123       # Update entire user
PATCH  /api/users/123       # Partial update user
DELETE /api/users/123       # Delete user
```

### Method Characteristics

- **GET** - Safe, Idempotent (data ပြောင်းမသွားဘူး)
- **POST** - Not safe, Not idempotent (data ပြောင်းတယ်)
- **PUT** - Not safe, Idempotent (အကြိမ်ကြိမ် run လို့ result တူတယ်)
- **PATCH** - Not safe, Not idempotent
- **DELETE** - Not safe, Idempotent

## HTTP Status Codes

မှန်ကန်သော status codes များကို return လုပ်ပါ:

### Success Codes (2xx)

```
200 OK              # GET, PUT, PATCH success
201 Created         # POST success
204 No Content      # DELETE success (no response body)
```

### Client Error Codes (4xx)

```
400 Bad Request     # Invalid request data
401 Unauthorized    # Authentication required
403 Forbidden       # Authenticated but not authorized
404 Not Found       # Resource doesn't exist
409 Conflict        # Resource conflict
422 Unprocessable   # Validation error
429 Too Many Requests  # Rate limit exceeded
```

### Server Error Codes (5xx)

```
500 Internal Server Error
502 Bad Gateway
503 Service Unavailable
```

## Request/Response Format

### Request Body (POST/PUT/PATCH)

```json
POST /api/users
Content-Type: application/json

{
  "name": "Khant Nyar",
  "email": "khant@example.com",
  "role": "developer"
}
```

### Success Response

```json
// 200 OK
{
  "data": {
    "id": 123,
    "name": "Khant Nyar",
    "email": "khant@example.com",
    "role": "developer",
    "created_at": "2024-03-20T10:00:00Z"
  }
}

// 201 Created
{
  "data": {
    "id": 123,
    "name": "Khant Nyar"
  },
  "message": "User created successfully"
}
```

### Error Response

```json
// 400 Bad Request
{
  "error": {
    "code": "VALIDATION_ERROR",
    "message": "Validation failed",
    "details": [
      {
        "field": "email",
        "message": "Email is required"
      },
      {
        "field": "name",
        "message": "Name must be at least 3 characters"
      }
    ]
  }
}

// 404 Not Found
{
  "error": {
    "code": "NOT_FOUND",
    "message": "User not found"
  }
}
```

## Pagination

Large datasets များအတွက် pagination လုပ်ပါ:

### Query Parameters

```
GET /api/users?page=2&limit=20
GET /api/posts?offset=40&limit=20
```

### Response Format

```json
{
  "data": [...],
  "pagination": {
    "page": 2,
    "limit": 20,
    "total": 150,
    "total_pages": 8,
    "has_next": true,
    "has_prev": true
  },
  "links": {
    "first": "/api/users?page=1&limit=20",
    "prev": "/api/users?page=1&limit=20",
    "next": "/api/users?page=3&limit=20",
    "last": "/api/users?page=8&limit=20"
  }
}
```

## Filtering, Sorting, and Searching

```
# Filtering
GET /api/users?role=admin&status=active

# Sorting
GET /api/posts?sort=created_at&order=desc
GET /api/products?sort=-price  # Descending

# Searching
GET /api/users?search=khant

# Multiple fields
GET /api/posts?search=laravel&category=tutorial&sort=-created_at
```

## Versioning

API versions များကို မှန်ကန်စွာ စီမံခန့်ခွဲပါ:

### URL Versioning (Recommended)

```
GET /api/v1/users
GET /api/v2/users
```

### Header Versioning

```
GET /api/users
Accept: application/vnd.myapi.v1+json
```

### Query Parameter

```
GET /api/users?version=1
```

## Authentication

### Bearer Token (JWT)

```
GET /api/users
Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...
```

### API Key

```
GET /api/users
X-API-Key: your-api-key-here
```

## Rate Limiting

Response headers တွင် rate limit information ထည့်ပါ:

```
X-RateLimit-Limit: 100
X-RateLimit-Remaining: 95
X-RateLimit-Reset: 1616161616
```

## CORS Headers

```
Access-Control-Allow-Origin: *
Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS
Access-Control-Allow-Headers: Content-Type, Authorization
```

## Documentation Example

```yaml
# OpenAPI/Swagger example
paths:
  /api/users:
    get:
      summary: List all users
      parameters:
        - name: page
          in: query
          type: integer
        - name: limit
          in: query
          type: integer
      responses:
        200:
          description: Success
          schema:
            $ref: '#/definitions/UserList'
        401:
          description: Unauthorized
```

## Security Best Practices

၁. **HTTPS အသုံးပြုပါ** - Data encryption အတွက်
၂. **Input validation** - အမြဲ validate လုပ်ပါ
၃. **Rate limiting** - API abuse ကာကွယ်ပါ
၄. **Authentication/Authorization** - မှန်ကန်စွာ implement လုပ်ပါ
၅. **Error messages** - Sensitive information မပါစေပါနဲ့
၆. **CORS** - မှန်ကန်စွာ configure လုပ်ပါ

## Implementation Example (Node.js/Express)

```javascript
const express = require('express');
const app = express();

app.use(express.json());

// GET - List users
app.get('/api/v1/users', async (req, res) => {
  try {
    const { page = 1, limit = 10 } = req.query;
    const users = await getUsersPaginated(page, limit);
    
    res.json({
      data: users,
      pagination: {
        page: parseInt(page),
        limit: parseInt(limit),
        total: users.total
      }
    });
  } catch (error) {
    res.status(500).json({
      error: {
        code: 'INTERNAL_ERROR',
        message: 'An error occurred'
      }
    });
  }
});

// POST - Create user
app.post('/api/v1/users', async (req, res) => {
  try {
    const { name, email } = req.body;
    
    // Validation
    if (!name || !email) {
      return res.status(400).json({
        error: {
          code: 'VALIDATION_ERROR',
          message: 'Name and email are required'
        }
      });
    }
    
    const user = await createUser({ name, email });
    
    res.status(201).json({
      data: user,
      message: 'User created successfully'
    });
  } catch (error) {
    res.status(500).json({
      error: {
        code: 'INTERNAL_ERROR',
        message: 'Failed to create user'
      }
    });
  }
});

app.listen(3000);
```

## Testing APIs

```bash
# Using curl
curl -X GET http://localhost:3000/api/v1/users
curl -X POST http://localhost:3000/api/v1/users \
  -H "Content-Type: application/json" \
  -d '{"name":"Khant","email":"khant@example.com"}'

# Using Postman or Insomnia
# API testing tools များကို အသုံးပြုနိုင်ပါတယ်
```

## နိဂုံး

REST API ကို ကောင်းမွန်စွာ ဒီဇိုင်းလုပ်ခြင်းက frontend developers များ၊ mobile app developers များနှင့် third-party integrations များအတွက် အလွန်အရေးကြီးပါတယ်။ ဒီ best practices များကို လိုက်နာပြီး consistent, maintainable API များ ဖန်တီးသင့်ပါတယ်။
