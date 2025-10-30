# ARKFleet - Equipment Fleet Management System

![Laravel](https://img.shields.io/badge/Laravel-10.x-red.svg)
![PHP](https://img.shields.io/badge/PHP-8.1+-blue.svg)
![License](https://img.shields.io/badge/license-MIT-green.svg)

> **Version**: 10.0  
> **Status**: Production  
> **Purpose**: Comprehensive fleet management system for heavy equipment and construction machinery

---

## 📋 Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Technology Stack](#technology-stack)
- [System Requirements](#system-requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Database Setup](#database-setup)
- [Usage Guide](#usage-guide)
- [Documentation](#documentation)
- [Development](#development)
- [Testing](#testing)
- [Deployment](#deployment)
- [Troubleshooting](#troubleshooting)
- [Contributing](#contributing)
- [License](#license)

---

## 🎯 Overview

**ARKFleet** is an enterprise-grade Equipment Fleet Management System designed for companies managing heavy equipment, construction machinery, and vehicles across multiple project sites. The system provides comprehensive tracking of equipment lifecycle, inter-project transfers (IPA - Internal Property Assignment), document compliance monitoring, and extensive reporting capabilities.

### Key Capabilities

- ✅ **Equipment Lifecycle Management** - Track equipment from acquisition to disposal
- ✅ **Multi-Project Equipment Allocation** - Manage equipment distribution across project sites
- ✅ **Document Compliance Monitoring** - Track expiring licenses, insurance, and permits
- ✅ **Inter-Project Transfers (IPA)** - Cart-based equipment transfer system between projects
- ✅ **Fleet Reporting** - Comprehensive reports on equipment status, utilization, and movements
- ✅ **Role-Based Access Control** - Granular permissions using Spatie Permission package
- ✅ **Photo Documentation** - Equipment photo galleries and visual documentation
- ✅ **Excel/PDF Export** - Professional export capabilities for all reports

---

## 🚀 Features

### Equipment Management
- **Comprehensive Equipment Registry** with unit numbers, serial numbers, specifications
- **Equipment Categorization** by Plant Type, Plant Group, Asset Category
- **Status Tracking** (Active, Inactive, Under Repair, Disposed)
- **Project Assignment** - Track current location and project assignment
- **Photo Gallery** - Upload and manage equipment photos
- **Equipment Details** - Serial number, chassis number, engine model, fuel type, etc.
- **Unit Number History** - Track equipment numbering changes over time
- **RFU (Ready For Use) & BD (Break Down)** status updates

### Document Management
- **Document Type Support**: BPKB, STNK, Insurance Policies, Purchase Orders
- **Expiration Monitoring** - Dashboard alerts for expiring/expired documents
- **Document Renewal Tracking** - Linked renewal chain with history
- **Cost Tracking** - Document processing costs and supplier information
- **File Attachments** - Store document scans and files
- **Soft Deletes** - Compliance-friendly document retention

### Transfer Management (IPA)
- **Inter-Project Equipment Assignment** - Transfer equipment between project sites
- **Cart-Based Selection** - Add multiple equipment to transfer cart
- **Transfer Documentation** - PDF generation for transfer records
- **Transfer History** - Complete audit trail of equipment movements
- **Project Tracking** - Equipment movement from source to destination projects

### Reporting & Analytics
- **Equipment by Projects** - Distribution of equipment across projects
- **Equipment Activation by Month** - New equipment trends
- **Active Status Reports** - Current equipment status by project
- **Document Expiry Reports** - Upcoming and overdue documents
- **Summary IPA** - Transfer summary reports
- **Excel Export** - Export all reports to Excel format

### User Management
- **User CRUD Operations** - Manage system users
- **Role Management** - Admin, Manager, User roles
- **Permission System** - Granular permission assignments
- **User Activation/Deactivation** - Control user access
- **Activity Logging** - Track user actions system-wide
- **Audit Trail** - Automatic creator and updater tracking

### Master Data Management
- **Projects** - Project sites with locations and clients
- **Plant Types** - Equipment type categories (Digger, Hauler, etc.)
- **Plant Groups** - Sub-categories (Lighting Tower, Welding, etc.)
- **Manufactures** - Equipment manufacturers
- **Unit Models** - Equipment models with specifications
- **Unit Status** - Equipment operational statuses
- **Suppliers** - Vendors and service providers
- **Asset Categories** - Major/Minor classification
- **Document Types** - Types of compliance documents
- **Departments** - Organizational units

---

## 🛠 Technology Stack

### Backend
- **Framework**: Laravel 10.x
- **Language**: PHP 8.1+
- **Database**: MySQL 5.7+
- **Authentication**: Laravel Sanctum + Session-based auth
- **Authorization**: Spatie Laravel Permission 5.9
- **DataTables**: Yajra Laravel DataTables 9.0
- **Excel Export**: Maatwebsite Excel 3.1
- **Notifications**: RealRashid Sweet Alert 6.0

### Frontend
- **Admin Template**: AdminLTE 3.x
- **CSS Framework**: Bootstrap 4/5
- **JavaScript**: jQuery
- **DataTables**: jQuery DataTables with AJAX
- **Icons**: Font Awesome 5

### Development Tools
- **Testing**: PHPUnit 10.0
- **Code Quality**: Laravel Pint
- **Debugging**: Laravel Telescope (optional)
- **Version Control**: Git

---

## 💻 System Requirements

### Server Requirements
- **PHP**: 8.1 or higher
- **Database**: MySQL 5.7+ or MariaDB 10.3+
- **Web Server**: Apache 2.4+ or Nginx 1.18+
- **Composer**: 2.x
- **Node.js**: 16.x+ (for asset compilation)
- **NPM**: 8.x+

### PHP Extensions Required
- BCMath
- Ctype
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO (with MySQL driver)
- Tokenizer
- XML
- GD or Imagick (for image processing)

### Recommended Server Specs
- **CPU**: 2+ cores
- **RAM**: 2GB minimum, 4GB recommended
- **Storage**: 10GB minimum
- **OS**: Ubuntu 20.04 LTS or Windows Server 2019+

---

## 📦 Installation

### 1. Clone Repository

```bash
git clone https://github.com/your-org/ark-fleet.git
cd ark-fleet
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node Dependencies (if needed)

```bash
npm install
```

### 4. Environment Configuration

```bash
# Copy example environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 5. Configure Environment

Edit `.env` file with your settings:

```env
APP_NAME=ARKFleet
APP_ENV=production
APP_DEBUG=false
APP_URL=http://your-domain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=arkfleet_db
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Timezone (per user preference)
APP_TIMEZONE=Asia/Singapore

# Mail Configuration (for document expiry notifications)
MAIL_MAILER=smtp
MAIL_HOST=your-mail-server
MAIL_PORT=587
MAIL_USERNAME=your-email@domain.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@arkfleet.com
MAIL_FROM_NAME="${APP_NAME}"
```

### 6. Database Setup

```bash
# Create database
mysql -u root -p
CREATE DATABASE arkfleet_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;

# Run migrations
php artisan migrate

# Seed initial data (if seeders exist)
php artisan db:seed
```

### 7. Storage Setup

```bash
# Create symbolic link for storage
php artisan storage:link

# Set permissions (Linux/Mac)
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 8. Optimize Application

```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache permissions (Spatie)
php artisan permission:cache-reset
```

### 9. Start Development Server

```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

---

## ⚙️ Configuration

### Database Configuration

**CRITICAL**: Ensure `.env` database name matches expected schema.

The application expects database name: `arkfleet_db`

If you see errors about missing tables (equipments, movings, documents), verify:
```bash
# Check current database connection
php artisan tinker
>>> DB::connection()->getDatabaseName();
```

Should return: `"arkfleet_db"`

If it returns different database name, update `.env` file and restart application.

### File Storage

Equipment photos and document attachments stored in:
```
storage/app/public/equipment_photos/
storage/app/public/documents/
```

Ensure symbolic link created: `php artisan storage:link`

### Timezone

Application configured for **Asia/Singapore** timezone. To change:

```env
# .env file
APP_TIMEZONE=Your/Timezone
```

Then clear config cache: `php artisan config:clear`

---

## 🗄️ Database Setup

### Initial Migrations

Application includes 26 migration files covering:
- Core tables (users, equipments, movings, documents, projects)
- Master data (manufactures, plant_types, suppliers, etc.)
- Spatie Permission tables (roles, permissions)
- Additional features (equipment_photos, loggers, activities)

Run all migrations:
```bash
php artisan migrate
```

### Required Seeders

**Note**: If seeders don't exist, you'll need to create them. Required data:

#### 1. Roles Seeder
```php
// Create basic roles
Role::create(['name' => 'admin']);
Role::create(['name' => 'manager']);
Role::create(['name' => 'user']);
```

#### 2. Unit Status Seeder
```php
// Equipment statuses
Unitstatus::create(['name' => 'Active']);
Unitstatus::create(['name' => 'Inactive']);
Unitstatus::create(['name' => 'Under Repair']);
Unitstatus::create(['name' => 'Disposed']);
```

#### 3. Asset Categories Seeder
```php
AssetCategory::create(['name' => 'Major']);
AssetCategory::create(['name' => 'Minor']);
```

#### 4. Document Types Seeder
```php
DocumentType::create(['name' => 'BPKB']);
DocumentType::create(['name' => 'STNK']);
DocumentType::create(['name' => 'Insurance Policy']);
DocumentType::create(['name' => 'Purchase Order']);
```

#### 5. Admin User Seeder
```php
$admin = User::create([
    'name' => 'Administrator',
    'email' => 'admin@arkfleet.com',
    'password' => Hash::make('password'),
    'is_active' => true,
]);
$admin->assignRole('admin');
```

### Run Seeders

```bash
php artisan db:seed
```

Or specific seeder:
```bash
php artisan db:seed --class=RoleSeeder
```

---

## 📖 Usage Guide

### Default Login Credentials

After seeding, use:
- **Email**: `admin@arkfleet.com`
- **Password**: `password`

**IMPORTANT**: Change default password immediately after first login!

### Quick Start Workflow

1. **Login** to system at `/login`
2. **Add Master Data**:
   - Create Project sites
   - Add Equipment Manufacturers
   - Create Equipment Models
   - Set up Plant Types and Groups
3. **Register Equipment**:
   - Navigate to Equipments → Create
   - Fill in equipment details
   - Upload equipment photos
4. **Add Documents**:
   - Open equipment detail page
   - Add BPKB, STNK, insurance documents
   - Set expiration dates
5. **Transfer Equipment** (IPA):
   - Navigate to Movings → Create
   - Select source and destination projects
   - Add equipment to cart
   - Submit transfer
6. **Generate Reports**:
   - Navigate to Reports
   - Select report type
   - Export to Excel if needed

### User Roles

- **Admin**: Full system access, user management
- **Manager**: Equipment management, reports, transfers
- **User**: View-only access, limited editing

Configure role permissions in: Users → Roles

---

## 📚 Documentation

Comprehensive documentation available in `/docs` directory:

### Core Documentation

| Document | Purpose | Audience |
|----------|---------|----------|
| **[docs/architecture.md](docs/architecture.md)** | System architecture, technology stack, database schema, data flows | Developers, System Architects |
| **[docs/decisions.md](docs/decisions.md)** | Technical decision records with rationale | Developers, Team Leads |
| **[MEMORY.md](MEMORY.md)** | Important discoveries, known issues, learnings | All Team Members |
| **[docs/todo.md](docs/todo.md)** | Current tasks, immediate priorities, blockers | Project Managers, Developers |
| **[docs/backlog.md](docs/backlog.md)** | Future features, improvement ideas | Product Owners, Stakeholders |

### Documentation Highlights

- **Architecture Documentation**: Complete system overview with Mermaid diagrams
- **Decision Records**: Why we chose specific technologies and patterns
- **Memory Entries**: 13+ documented learnings and critical issues
- **Known Issues**: Database configuration, cart concurrency, test coverage
- **Improvement Recommendations**: 25+ feature ideas and technical improvements

### For New Developers

1. Read `README.md` (this file) for overview
2. Read `docs/architecture.md` to understand system design
3. Read `docs/decisions.md` to understand architectural choices
4. Review `MEMORY.md` for known issues and patterns
5. Check `docs/todo.md` for current work items

---

## 👨‍💻 Development

### Local Development Setup

Using Laravel Sail (Docker):
```bash
# Start all services
./vendor/bin/sail up -d

# Run migrations
./vendor/bin/sail artisan migrate

# Access application
http://localhost
```

Traditional development:
```bash
# Start PHP development server
php artisan serve

# In another terminal, watch for asset changes (if using npm)
npm run dev
```

### Code Quality

Format code using Laravel Pint:
```bash
./vendor/bin/pint
```

### Database Management

Access Tinker REPL:
```bash
php artisan tinker
```

Query database directly (if MySQL MCP configured):
- "How many equipments are in the database?"
- "Show me recent transfers"
- "List documents expiring this month"

### Clear Caches

```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Clear permission cache
php artisan permission:cache-reset
```

### Generate IDE Helper (optional)

For better IDE autocomplete:
```bash
composer require --dev barryvdh/laravel-ide-helper
php artisan ide-helper:generate
php artisan ide-helper:models
```

---

## 🧪 Testing

### Run Tests

```bash
# Run all tests
php artisan test

# Or using PHPUnit directly
./vendor/bin/phpunit

# Run specific test
php artisan test --filter EquipmentTest
```

### Test Coverage

**Current Status**: Minimal test coverage (only example tests)

**Recommended Test Suite**:
- Feature tests for Equipment CRUD
- Feature tests for Moving/Transfer workflow
- Unit tests for Document expiry logic
- Unit tests for Model relationships

See `docs/backlog.md` for test suite development plan.

### Browser Testing

Using Cursor's Browser Automation at `http://localhost:8000`:
```
1. Navigate to /login
2. Login with admin credentials
3. Test equipment creation workflow
4. Test transfer (IPA) workflow
5. Verify document expiry alerts
```

---

## 🚢 Deployment

### Production Checklist

- [ ] Set `APP_ENV=production` in `.env`
- [ ] Set `APP_DEBUG=false` in `.env`
- [ ] Generate new `APP_KEY` on production
- [ ] Configure production database credentials
- [ ] Set up mail server for notifications
- [ ] Configure web server (Apache/Nginx)
- [ ] Set proper file permissions (775 for storage, 755 for others)
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Set up automated database backups
- [ ] Configure SSL certificate (HTTPS)
- [ ] Set up monitoring and error tracking
- [ ] Test all critical workflows

### Web Server Configuration

#### Apache (.htaccess included)
Ensure `mod_rewrite` enabled and document root points to `/public` directory.

#### Nginx Configuration Example
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/arkfleet/public;

    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### Automated Backups

Set up daily database backups:
```bash
# Add to crontab
0 2 * * * mysqldump -u username -p password arkfleet_db | gzip > /backups/arkfleet_$(date +\%Y\%m\%d).sql.gz
```

Or use Laravel Backup package (Spatie):
```bash
composer require spatie/laravel-backup
```

---

## 🔧 Troubleshooting

### Common Issues

#### 1. Database Connection Error

**Error**: `SQLSTATE[HY000] [1049] Unknown database 'arkfleet_db'`

**Solution**:
```bash
# Create database
mysql -u root -p
CREATE DATABASE arkfleet_db;
EXIT;

# Verify .env configuration
DB_DATABASE=arkfleet_db
```

#### 2. Application Connected to Wrong Database

**Error**: Tables like `equipments`, `movings`, `documents` not found

**Diagnosis**: Check current database connection:
```bash
php artisan tinker
>>> DB::connection()->getDatabaseName();
```

**Solution**: Update `.env` file and restart server.

See `MEMORY.md` Entry #001 for detailed information on this critical issue.

#### 3. Storage Link Not Working

**Error**: Equipment photos/documents not loading

**Solution**:
```bash
php artisan storage:link
```

#### 4. Permission Denied on storage/logs

**Solution** (Linux/Mac):
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

#### 5. 419 Page Expired (CSRF Token Mismatch)

**Cause**: Session expired or cache issue

**Solution**:
```bash
php artisan cache:clear
php artisan config:clear
```

Refresh browser (Ctrl+F5)

#### 6. DataTables Not Loading

**Symptoms**: Equipment/document lists show "Processing..." indefinitely

**Solution**:
- Check browser console for JavaScript errors
- Verify route exists: `route('equipments.index.data')`
- Check server logs for PHP errors

#### 7. Excel Export Fails

**Error**: Memory limit exceeded during export

**Solution**: Increase PHP memory limit in `php.ini`:
```ini
memory_limit = 512M
```

Or in `.htaccess`:
```apache
php_value memory_limit 512M
```

---

## 🤝 Contributing

### Development Workflow

1. Create feature branch from `main`
2. Make changes following Laravel coding standards
3. Write tests for new functionality
4. Run code quality checks: `./vendor/bin/pint`
5. Submit pull request with description

### Coding Standards

- Follow PSR-12 coding style
- Use meaningful variable and method names
- Comment complex business logic
- Follow Laravel best practices
- Update documentation for architectural changes

### Documentation Requirements

When making significant changes, update:
- `docs/architecture.md` - if system structure changes
- `docs/decisions.md` - if making architectural decisions
- `MEMORY.md` - if discovering important issues or patterns
- `docs/todo.md` - if adding new tasks
- `docs/backlog.md` - if planning future features

See `.cursorrules` file for complete documentation guidelines.

---

## 🐛 Known Issues

### Critical Issues

1. **Database Configuration Mismatch** (🔴 P0)
   - Application expects `arkfleet_db` but may be connected to `genaf_db`
   - See `MEMORY.md` Entry #001 for details
   - **Action Required**: Verify and fix database configuration

### Medium Priority Issues

2. **Cart Concurrency Safety** (⚠️ P2)
   - Equipment cart for transfers has no user isolation
   - Risk of interference if multiple users create transfers simultaneously
   - See `docs/todo.md` P2 tasks for remediation plan

3. **Manual Activity Logging** (⚠️ P2)
   - Activity logging done manually in controllers
   - Risk of missing log entries
   - See `docs/backlog.md` for automated logging proposal

### Low Priority Issues

4. **Minimal Test Coverage** (⚠️ P2)
   - Only example tests exist
   - No regression protection
   - See `docs/backlog.md` for test suite plan

For complete list of known issues, see `MEMORY.md` section "Technical Debt & Known Issues"

---

## 📄 License

This project is licensed under the MIT License.

```
MIT License

Copyright (c) 2024 ARKFleet

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

---

## 📞 Support

For questions, issues, or feature requests:

- **Documentation**: Check `/docs` directory
- **Known Issues**: See `MEMORY.md`
- **Planned Features**: See `docs/backlog.md`
- **Technical Decisions**: See `docs/decisions.md`

---

## 🙏 Acknowledgments

### Technologies Used

- [Laravel](https://laravel.com) - The PHP Framework for Web Artisans
- [AdminLTE](https://adminlte.io) - Premium Admin Control Panel Theme
- [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission) - Role & Permission Management
- [Yajra DataTables](https://yajrabox.com/docs/laravel-datatables) - jQuery DataTables API for Laravel
- [Maatwebsite Excel](https://laravel-excel.com) - Excel Export for Laravel
- [SweetAlert](https://sweetalert2.github.io) - Beautiful Alert Messages

### Development Team

- **Architecture & Development**: ARKFleet Team
- **Documentation**: Comprehensive project documentation system
- **Version**: 10.0 (Production)

---

## 🗺️ Project Roadmap

### Current Version (v10.0) - Production
- ✅ Equipment Management
- ✅ Document Tracking
- ✅ Inter-Project Transfers (IPA)
- ✅ Reporting & Analytics
- ✅ Role-Based Access Control

### Planned Features (See `docs/backlog.md`)
- 📧 Email Notifications for Document Expiry
- 🔧 Equipment Maintenance Tracking Module
- 📱 Mobile Application for Field Workers
- 📊 Advanced Analytics Dashboard
- 🗺️ GPS Tracking Integration
- 📋 Equipment Reservation System

For complete roadmap and prioritization, see `docs/backlog.md`

---

**ARKFleet v10.0** - Professional Equipment Fleet Management System

*Built with ❤️ using Laravel*
