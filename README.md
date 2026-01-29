# 🗳️ Poll Platform

A modern, full-featured polling application built with Laravel 11 and Vite, featuring real-time results, IP-based vote tracking, and comprehensive admin controls.

## ✨ Features

### 🔐 User Features
- **Authentication System** - Secure user registration and login powered by Laravel Breeze
- **Poll Voting** - Vote on active polls with a clean, intuitive interface
- **Real-time Results** - View live poll results with dynamic updates
- **IP-based Restriction** - One vote per IP address to prevent duplicate voting
- **User Dashboard** - Personal dashboard to view and participate in polls

### 👨‍💼 Admin Features
- **Admin Dashboard** - Comprehensive overview of all polls and voting activity
- **Poll Creation** - Create new polls with multiple options
- **Vote History** - View detailed voting history including IP addresses and timestamps
- **IP Management** - Release IP addresses to allow revoting if needed
- **Poll Status Control** - Activate or deactivate polls

## 🛠️ Technology Stack

- **Backend**: Laravel 11.31 (PHP 8.2+)
- **Frontend**: Vite 6.0 + Alpine.js 3.4 + TailwindCSS 3.1
- **Database**: SQLite (configurable to MySQL/PostgreSQL)
- **Authentication**: Laravel Breeze
- **Styling**: TailwindCSS with custom forms plugin

## 📋 Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js & NPM
- SQLite (or MySQL/PostgreSQL if preferred)

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone <repository-url>
cd Poll--Platfrom
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node Dependencies

```bash
npm install
```

### 4. Environment Configuration

```bash
# Copy the example environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 5. Database Setup

The application uses SQLite by default. The database file will be created automatically.

```bash
# Run migrations to create tables
php artisan migrate
```

> **Note**: To use MySQL or PostgreSQL, update the `DB_CONNECTION` and related settings in your `.env` file.

### 6. Create Admin User

After running migrations, you'll need to manually set a user as admin in the database:

```bash
php artisan tinker
```

Then run:
```php
$user = User::find(1); // Replace 1 with your user ID
$user->is_admin = true;
$user->save();
```

## 🎮 Running the Application

### Option 1: Separate Commands (Recommended for Development)

```bash
# Terminal 1 - Start Laravel backend
php artisan serve

# Terminal 2 - Start Vite frontend dev server
npm run dev
```

The application will be available at:
- **Frontend**: http://localhost:5173
- **Backend**: http://127.0.0.1:8000

### Option 2: Concurrently (All-in-One)

```bash
composer run dev
```

This runs the backend server, queue listener, logs, and Vite dev server concurrently.

## 📁 Project Structure

```
Poll--Platfrom/
├── app/
│   ├── Http/Controllers/
│   │   └── PollController.php      # Main poll logic
│   ├── Models/
│   │   ├── Poll.php                # Poll model
│   │   ├── PollOption.php          # Poll options model
│   │   ├── Vote.php                # Vote model
│   │   └── User.php                # User model
│   └── Services/
│       └── CoreVotingLogic.php     # Core voting logic with raw SQL
├── database/
│   └── migrations/
│       ├── create_polls_table.php
│       ├── create_poll_options_table.php
│       ├── create_votes_table.php
│       └── add_is_admin_to_users_table.php
├── resources/
│   ├── views/                      # Blade templates
│   ├── css/                        # Stylesheets
│   └── js/                         # JavaScript files
└── routes/
    └── web.php                     # Application routes

```

## 🔑 Key Routes

### Public Routes
- `GET /` - Welcome page
- `GET /login` - Login page
- `GET /register` - Registration page

### Authenticated User Routes
- `GET /dashboard` - User dashboard
- `GET /polls` - List all active polls
- `GET /polls/{id}` - View specific poll
- `POST /polls/vote` - Submit a vote
- `GET /polls/{id}/results` - Get poll results (JSON)

### Admin Routes
- `GET /admin` - Admin dashboard
- `GET /polls/create` - Create new poll form
- `POST /polls` - Store new poll
- `GET /polls/{id}/admin` - Admin view for specific poll
- `POST /polls/{id}/release` - Release IP address for revoting

## 🗄️ Database Schema

### Polls Table
- `id` - Primary key
- `question` - Poll question text
- `status` - Enum: `active` or `inactive`
- `timestamps` - Created at, Updated at

### Poll Options Table
- `id` - Primary key
- `poll_id` - Foreign key to polls
- `option_text` - Option text
- `timestamps`

### Votes Table
- `id` - Primary key
- `poll_id` - Foreign key to polls
- `option_id` - Foreign key to poll_options
- `ip_address` - IP address of voter
- `user_id` - Foreign key to users (nullable)
- `status` - Enum: `active` or `released`
- `released_at` - Timestamp when IP was released
- `timestamps`

### Users Table
- `id` - Primary key
- `name` - User name
- `email` - User email (unique)
- `password` - Hashed password
- `is_admin` - Boolean flag for admin privileges
- `timestamps`

## 🔒 Core Voting Logic

The application uses a custom `CoreVotingLogic` service that implements voting functionality using raw PDO queries:

- **IP Validation**: Checks if an IP has already voted on a poll
- **Vote Casting**: Records votes with IP tracking
- **IP Release**: Allows admins to release IPs for revoting
- **Vote History**: Retrieves detailed voting records

## 🎨 Frontend Features

- **Alpine.js**: For reactive components and dynamic interactions
- **TailwindCSS**: Modern, utility-first CSS framework
- **Vite**: Fast build tool with hot module replacement
- **Live Results**: Real-time poll result updates

## 🛡️ Security Features

- **Authentication**: Required for all poll actions
- **IP Tracking**: Prevents duplicate voting from the same IP
- **CSRF Protection**: Laravel's built-in CSRF protection
- **Admin Authorization**: Admin-only routes protected by middleware
- **SQL Injection Prevention**: Parameterized queries

## 🧪 Testing

```bash
# Run PHPUnit tests
php artisan test

# Or using vendor binary
./vendor/bin/phpunit
```

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 📧 Contact

For questions or support, please open an issue in the repository.

---

**Built with ❤️ using Laravel & Vite**
