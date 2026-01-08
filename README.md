# Laravel Sanctum API

A basic Laravel Sanctum backend providing token-based API authentication for SPAs, mobile applications, and simple token-based APIs.

## Features

- User registration with validation
- User login with token generation
- Token-based authentication
- User logout (token revocation)
- Get authenticated user details
- CORS configuration for frontend integration
- Password hashing with bcrypt

## Requirements

- PHP 8.1 or higher
- Composer
- MySQL 5.7+ or MariaDB 10.3+

## Installation

1. Clone the repository:
```bash
git clone https://github.com/itecassist/lara-sanctum.git
cd lara-sanctum
```

2. Install dependencies:
```bash
composer install
```

3. Copy the environment file:
```bash
cp .env.example .env
```

4. Generate application key:
```bash
php artisan key:generate
```

5. Configure your database in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lara_sanctum
DB_USERNAME=root
DB_PASSWORD=your_password
```

6. Run migrations:
```bash
php artisan migrate
```

7. Start the development server:
```bash
php artisan serve
```

The API will be available at `http://localhost:8000`

## API Endpoints

### Public Endpoints

#### Register User
```http
POST /api/register
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

Response (201 Created):
```json
{
  "message": "User registered successfully",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "created_at": "2024-01-08T03:30:00.000000Z",
    "updated_at": "2024-01-08T03:30:00.000000Z"
  },
  "access_token": "1|token...",
  "token_type": "Bearer"
}
```

#### Login
```http
POST /api/login
Content-Type: application/json

{
  "email": "john@example.com",
  "password": "password123"
}
```

Response (200 OK):
```json
{
  "message": "Login successful",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "created_at": "2024-01-08T03:30:00.000000Z",
    "updated_at": "2024-01-08T03:30:00.000000Z"
  },
  "access_token": "2|token...",
  "token_type": "Bearer"
}
```

### Protected Endpoints

All protected endpoints require the `Authorization` header with a Bearer token:
```
Authorization: Bearer {your_token}
```

#### Get User
```http
GET /api/user
Authorization: Bearer {your_token}
```

Response (200 OK):
```json
{
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "created_at": "2024-01-08T03:30:00.000000Z",
    "updated_at": "2024-01-08T03:30:00.000000Z"
  }
}
```

#### Logout
```http
POST /api/logout
Authorization: Bearer {your_token}
```

Response (200 OK):
```json
{
  "message": "Logged out successfully"
}
```

## Testing with cURL

### Register a new user:
```bash
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'
```

### Login:
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "email": "john@example.com",
    "password": "password123"
  }'
```

### Get authenticated user (replace TOKEN with actual token):
```bash
curl -X GET http://localhost:8000/api/user \
  -H "Authorization: Bearer TOKEN" \
  -H "Accept: application/json"
```

### Logout:
```bash
curl -X POST http://localhost:8000/api/logout \
  -H "Authorization: Bearer TOKEN" \
  -H "Accept: application/json"
```

## Configuration

### CORS
CORS is configured in `config/cors.php` to allow all origins by default. For production, update the `allowed_origins` to specific domains:

```php
'allowed_origins' => ['https://yourdomain.com'],
```

### Sanctum
Sanctum configuration is in `config/sanctum.php`. Key settings:
- `stateful`: Domains that will receive stateful authentication cookies
- `expiration`: Token expiration time (default: null - never expires)
- `guard`: Authentication guards to check

### Token Expiration
To set token expiration, add to your `.env`:
```env
SANCTUM_EXPIRATION=60
```

## Security Considerations

1. **HTTPS**: Always use HTTPS in production
2. **CORS**: Restrict allowed origins in production
3. **Token Storage**: Store tokens securely on the client side
4. **Environment Variables**: Never commit `.env` file
5. **Password Requirements**: Adjust password validation rules as needed in controllers

## Database Schema

### Users Table
- id: Primary key
- name: User's full name
- email: Unique email address
- password: Hashed password
- email_verified_at: Timestamp (nullable)
- remember_token: String (nullable)
- created_at: Timestamp
- updated_at: Timestamp

### Personal Access Tokens Table
- id: Primary key
- tokenable_type: Polymorphic type
- tokenable_id: Polymorphic ID
- name: Token name
- token: Hashed token
- abilities: JSON (nullable)
- last_used_at: Timestamp (nullable)
- expires_at: Timestamp (nullable)
- created_at: Timestamp
- updated_at: Timestamp

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
