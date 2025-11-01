# Laravel Starter Template

[![CI](https://github.com/davidecardelli/laravel-starter/actions/workflows/ci.yml/badge.svg)](https://github.com/davidecardelli/laravel-starter/actions/workflows/ci.yml)
[![PHPStan Level 9](https://img.shields.io/badge/PHPStan-Level%209-brightgreen.svg)](https://phpstan.org/)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

> Production-ready Laravel 12 starter template with Action-Based Architecture, User Management, Roles & Permissions, and complete quality tooling.

## ✨ Features

### Core Features
- **Laravel 12** with latest features and improvements
- **Vue 3 + TypeScript + Inertia.js** for modern, type-safe frontend development
- **Spatie Permission** - Complete role and permission management
- **User Management CRUD** - Full example implementation with authorization
- **Laravel Fortify** - Authentication with 2FA support
- **Tailwind CSS 4** with shadcn/ui-inspired components

### Architecture & Code Quality
- **Action-Based Architecture** - Clean, testable business logic
- **PHPStan Level 9** - Maximum type safety
- **Deptrac** - Automated architecture enforcement
- **Laravel Pint** - Consistent PHP code style
- **ESLint + Prettier** - TypeScript/Vue code formatting
- **Git Hooks** - Pre-commit and pre-push quality checks

### Frontend Stack
- **Vite** - Lightning-fast HMR
- **TypeScript** - Type-safe JavaScript
- **Laravel Wayfinder** - Type-safe routes for TypeScript
- **Reka UI** - Headless UI components
- **Lucide Icons** - Beautiful icon library

## 🚀 Quick Start

### Option 1: Using Docker (Laravel Sail) - Recommended

**Prerequisites:**
- Docker Desktop
- Git

**Installation:**

```bash
# Clone the template
git clone https://github.com/davidecardelli/laravel-starter.git my-project
cd my-project

# Install dependencies
composer install

# Start Docker containers
./vendor/bin/sail up -d

# Setup application
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed

# Install frontend dependencies
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
```

Visit http://localhost and http://localhost:8025 (Mailpit) for email testing.

**Demo Users Created:**
- **Super Admin:** superadmin@example.com / password
- **Admin:** admin@example.com / password
- **Manager:** manager@example.com / password
- **User:** user@example.com / password

**Sail Services:**
- **App:** http://localhost (Laravel + Vite HMR)
- **Mailpit:** http://localhost:8025 (Email testing dashboard)
- **PostgreSQL:** localhost:5432
- **Redis:** localhost:6379

### Option 2: Native PHP Installation

**Prerequisites:**
- PHP 8.2+
- Composer
- Node.js 18+
- PostgreSQL

**Installation:**

```bash
# Clone the template
git clone https://github.com/davidecardelli/laravel-starter.git my-project
cd my-project

# Install and setup
composer setup

# Configure environment
cp .env.example .env
# Edit .env with your database credentials

# Run migrations and seed
php artisan migrate
php artisan db:seed

# Start development
composer dev
```

Visit http://localhost:8000 and login with one of the demo users:

**Demo Users Created:**
- **Super Admin:** superadmin@example.com / password
- **Admin:** admin@example.com / password
- **Manager:** manager@example.com / password
- **User:** user@example.com / password

## 🏗️ Architecture

### Action-Based Architecture

This template follows an **Action-Based Architecture** pattern, separating business logic into single-purpose action classes:

```
app/
├── Actions/         # Business logic (single-purpose classes)
│   └── User/
│       ├── CreateUser.php
│       ├── UpdateUser.php
│       ├── DeleteUser.php
│       ├── AssignRoleToUser.php
│       └── RemoveRoleFromUser.php
├── Http/
│   ├── Controllers/ # Thin orchestration layer
│   ├── Requests/    # Form validation
│   └── Middleware/
├── Models/          # Pure domain models
└── Policies/        # Authorization rules
```

**Benefits:**
- ✅ Single Responsibility Principle
- ✅ Easy to test in isolation
- ✅ Reusable across controllers, jobs, console commands
- ✅ Clear dependency flow enforced by Deptrac

### Architecture Rules (Deptrac)

```yaml
Models     → (no dependencies)
Policies   → Models only
Actions    → Models only
Controllers→ Actions, Models, Requests, Policies
Requests   → Models only
Jobs       → Actions, Models
Middleware → Models only
```

Run `composer deptrac` to validate architecture compliance.

## 👥 User Management Example

This template includes a complete User Management implementation as a reference:

### Backend
- **UserPolicy** - Authorization rules (`app/Policies/UserPolicy.php`)
- **Actions** - Business logic (`app/Actions/User/`)
- **Controller** - HTTP handling (`app/Http/Controllers/UserController.php`)
- **Requests** - Validation (`app/Http/Requests/`)

### Frontend
- **Index** - User list with search/filters (`resources/js/pages/admin/users/Index.vue`)
- **Create** - User creation form with role assignment
- **Edit** - User editing with role management

### Permissions
```php
'view users'   // Can view user list
'create users' // Can create new users
'edit users'   // Can edit existing users
'delete users' // Can delete users
'assign roles' // Can manage user roles
```

### Usage Example
```php
// In a controller
use App\Actions\User\CreateUser;

public function store(StoreUserRequest $request, CreateUser $createUser)
{
    $user = $createUser->execute($request->validated());

    // Assign roles
    $user->assignRole('admin');

    return redirect()->route('users.index');
}
```

## 🔒 Roles & Permissions

### Default Roles

- **super-admin** - Full system access (all permissions)
- **admin** - User management + content management
- **manager** - Content management only
- **user** - Basic content viewing

### Customization

Edit `database/seeders/RolePermissionSeeder.php` to customize roles and permissions for your application.

### Checking Permissions

```php
// In blade/vue
@can('edit users')
    <!-- Show edit button -->
@endcan

// In controllers (automatic via Policy)
$this->authorize('update', $user);

// In code
if ($user->can('delete users')) {
    // Allow action
}
```

## 🛠️ Development

### Available Commands

**With Docker (Sail):**

```bash
# Alias for convenience (add to ~/.bashrc or ~/.zshrc)
alias sail='./vendor/bin/sail'

# Start containers
sail up -d

# Run tests
sail artisan test
sail artisan test --parallel

# Code quality
sail composer analyse    # PHPStan Level 9
sail composer deptrac    # Architecture validation
sail composer format     # Format PHP code (Pint)
sail npm run lint        # Lint TypeScript/Vue
sail npm run type-check  # TypeScript validation

# Build for production
sail npm run build

# Stop containers
sail down
```

**Without Docker (Native PHP):**

```bash
# Start all dev servers (Laravel + Queue + Logs + Vite)
composer dev

# Run tests
composer test
composer test:parallel
composer test:coverage

# Code quality
composer analyse          # PHPStan Level 9
composer deptrac          # Architecture validation
composer format           # Format PHP code (Pint)
npm run lint             # Lint TypeScript/Vue
npm run type-check       # TypeScript validation

# Build for production
npm run build
```

### Git Hooks

**Pre-commit:**
- Laravel Pint (PHP formatting)
- Prettier (TS/Vue formatting)

**Pre-push:**
- TypeScript type checking
- ESLint
- PHPStan Level 9
- Deptrac architecture validation
- Pest tests

Hooks are installed automatically and enforce quality standards.

## 🔄 CI/CD

### GitHub Actions CI

Every push and pull request automatically runs:

**Quality Checks (runs in parallel):**
- ✅ **Tests** - Full test suite on PHP 8.2 & 8.3 with PostgreSQL 18
- ✅ **PHPStan Level 9** - Maximum type safety analysis
- ✅ **Deptrac** - Architecture layer validation
- ✅ **Laravel Pint** - Code style compliance
- ✅ **TypeScript** - Type checking
- ✅ **ESLint** - Code linting
- ✅ **Prettier** - Code formatting
- ✅ **Build** - Frontend compilation test

**Workflow:** `.github/workflows/ci.yml`

All checks must pass before merging pull requests. This ensures:
- Code quality is maintained across all contributions
- Breaking changes are caught immediately
- The codebase works on multiple PHP versions
- Architecture boundaries are enforced

### Dependabot

Automatic dependency updates run weekly (Mondays at 9:00 AM):

**Monitors:**
- 📦 **Composer** dependencies (Laravel, Spatie, etc.)
- 📦 **npm** dependencies (Vue, Vite, TypeScript, etc.)
- 🔧 **GitHub Actions** versions

**Features:**
- Automatically creates PRs for security patches and updates
- CI runs on every Dependabot PR to ensure compatibility
- Ignores major version updates for Vue and Vite (requires manual review)
- Limits to 10 concurrent PRs to avoid spam

**Configuration:** `.github/dependabot.yml`

### CI Badge

The README displays real-time CI status:

[![CI](https://github.com/davidecardelli/laravel-starter/actions/workflows/ci.yml/badge.svg)](https://github.com/davidecardelli/laravel-starter/actions/workflows/ci.yml)

- ✅ Green badge = All checks passing
- ❌ Red badge = One or more checks failing

## 📁 Project Structure

```
├── app/
│   ├── Actions/              # Business logic
│   ├── Http/
│   │   ├── Controllers/      # HTTP handlers
│   │   └── Requests/         # Form validation
│   ├── Models/               # Eloquent models
│   └── Policies/             # Authorization
├── database/
│   ├── migrations/           # Database schema
│   └── seeders/             # Data seeding
├── resources/
│   └── js/
│       ├── components/       # Vue components
│       ├── pages/           # Inertia pages
│       ├── routes/          # Wayfinder routes (generated)
│       └── types/           # TypeScript types
├── routes/
│   ├── web.php              # Web routes
│   └── settings.php         # Settings routes
├── tests/
│   ├── Feature/             # Feature tests
│   └── Unit/                # Unit tests
├── deptrac.yaml             # Architecture rules
├── phpstan.neon             # Static analysis config
└── package.json             # Frontend dependencies
```

## 📊 Logging & Monitoring

All Actions include comprehensive logging for monitoring and debugging:

### Real-time Log Monitoring

**With Sail:**
```bash
sail artisan pail
```

**Without Docker:**
```bash
php artisan pail
```

### What Gets Logged

Every Action logs:
- ✅ **Operation start** with context (user ID, parameters)
- ✅ **Operation success** with results
- ⚠️ **Warnings** for sensitive operations (user deletion)
- ❌ **Errors** with full context for troubleshooting

### Example Log Output

```
[INFO] Creating new user
  email: john@example.com
  first_name: John
  last_name: Doe
  phone: +39 333 1234567
  created_by: 1

[INFO] User created successfully
  user_id: 42
  email: john@example.com
  name: John Doe

[INFO] Assigning role to user
  user_id: 42
  role: admin
  assigned_by: 1

[INFO] Role assigned successfully
  user_id: 42
  role: admin
```

### Security

- 🔒 **Passwords never logged** - Only hashed values stored
- 🔒 **Sensitive data protected** - Tokens, API keys excluded
- 🔒 **Audit trail** - All operations include `created_by`/`updated_by`/`deleted_by`

## 🧪 Testing

```bash
# Run all tests
composer test

# Run tests in parallel
composer test:parallel

# Generate coverage report
composer test:coverage

# Profile slow tests
composer test:profile
```

## 📝 Adding New Features

### 1. Create a new Action

```php
// app/Actions/Post/CreatePost.php
namespace App\Actions\Post;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * Create Post Action
 *
 * Creates a new post with validated data.
 * Follows Action-Based Architecture pattern.
 */
class CreatePost
{
    /**
     * Execute the create post action.
     *
     * Creates a new post with the provided validated data
     * and logs the operation for monitoring and audit purposes.
     *
     * @param  array<string, mixed>  $data  The validated post data
     * @return \App\Models\Post  The newly created post instance
     */
    public function execute(array $data): Post
    {
        Log::info('Creating new post', [
            'title' => $data['title'],
            'created_by' => Auth::id(),
        ]);

        $post = Post::create($data);

        Log::info('Post created successfully', [
            'post_id' => $post->id,
            'title' => $post->title,
        ]);

        return $post;
    }
}
```

**Best Practices:**
- ✅ Add PHPDoc with description, @param, and @return
- ✅ Use type hints in method signature
- ✅ Include full class names in @param/@return
- ✅ Log operation start with relevant context
- ✅ Log success with identifiable information
- ✅ Use appropriate log levels (info, warning, error)
- ❌ Never log sensitive data (passwords, tokens, API keys)

### 2. Create a Controller

```php
// app/Http/Controllers/PostController.php
namespace App\Http\Controllers;

use App\Actions\Post\CreatePost;
use App\Http\Requests\StorePostRequest;
use Illuminate\Http\RedirectResponse;

class PostController extends Controller
{
    /**
     * Store a newly created post in storage.
     *
     * Creates a new post using the CreatePost action.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @param  \App\Actions\Post\CreatePost  $createPost
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StorePostRequest $request, CreatePost $createPost): RedirectResponse
    {
        $post = $createPost->execute($request->validated());

        return redirect()->route('posts.index');
    }
}
```

**Best Practices:**
- ✅ Add PHPDoc with description, @param, and @return
- ✅ Use type hints in method signature
- ✅ Document what the method does and why
- ✅ Include full class names in @param/@return

### 3. Create routes and Vue pages

```php
// routes/web.php
Route::resource('posts', PostController::class);
```

```bash
# Regenerate TypeScript routes
php artisan wayfinder:generate --with-form
```

### 4. Validate architecture

```bash
composer deptrac  # Ensures your new code follows architecture rules
```

## 🤝 Contributing

This is a template - feel free to fork and customize for your needs!

## 📄 License

MIT License - feel free to use this template for any project.

## 🙏 Credits

Built with:
- [Laravel](https://laravel.com)
- [Vue.js](https://vuejs.org)
- [Inertia.js](https://inertiajs.com)
- [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission)
- [Tailwind CSS](https://tailwindcss.com)
- [shadcn/ui](https://ui.shadcn.com) (design inspiration)

---

**Ready to build something amazing? 🚀**
