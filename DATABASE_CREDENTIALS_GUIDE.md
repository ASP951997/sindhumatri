# Database Credentials Update Guide

## Where to Update Live Database Credentials

### Primary Location: `.env` File

The **`.env`** file in the project root is where you need to update all database credentials for the live/production database.

**File Location**: `E:\RSL_Intern_T\Matrimony\.env`

### Database Configuration Variables

Update these variables in your `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=your_live_database_host
DB_PORT=3306
DB_DATABASE=your_live_database_name
DB_USERNAME=your_live_database_username
DB_PASSWORD=your_live_database_password
```

### Example for Live Database

```env
# Local/Development (Current)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=u105084344_matrimony
DB_USERNAME=root
DB_PASSWORD=

# Live/Production (Update these)
DB_CONNECTION=mysql
DB_HOST=your_live_server_ip_or_domain
DB_PORT=3306
DB_DATABASE=your_live_database_name
DB_USERNAME=your_live_database_user
DB_PASSWORD=your_live_database_password
```

## How Laravel Reads Database Credentials

1. **`.env` file** → Contains the actual credentials
2. **`config/database.php`** → Reads from `.env` using `env()` function
3. **Application** → Uses values from `config/database.php`

### Configuration Flow:
```
.env file 
  ↓
config/database.php (reads via env('DB_HOST'), env('DB_DATABASE'), etc.)
  ↓
Laravel Application
```

## Steps to Update for Live Database

### Step 1: Open `.env` File
- Navigate to: `E:\RSL_Intern_T\Matrimony\.env`
- Open with a text editor (Notepad++, VS Code, etc.)

### Step 2: Update Database Variables
Find and update these lines:

```env
DB_HOST=your_live_host          # e.g., 192.168.1.100 or db.example.com
DB_PORT=3306                    # Usually 3306 for MySQL
DB_DATABASE=your_live_db_name   # Your live database name
DB_USERNAME=your_live_db_user   # Your live database username
DB_PASSWORD=your_live_password  # Your live database password
```

### Step 3: Clear Configuration Cache (Important!)
After updating `.env`, run these commands:

```bash
php artisan config:clear
php artisan cache:clear
```

This ensures Laravel reads the new values from `.env`.

## Important Notes

### ⚠️ Security
- **NEVER** commit `.env` file to Git (it's in `.gitignore`)
- Keep `.env` file secure and private
- Use strong passwords for production database

### 📝 Backup
- Always backup your current `.env` file before making changes
- Test connection after updating credentials

### 🔄 Environment Files
- **`.env`** → Active configuration (used by application)
- **`.env.example`** → Template file (safe to commit, no real credentials)

## Testing Database Connection

After updating credentials, test the connection:

```bash
php artisan migrate:status
```

Or create a simple test script to verify connection.

## Additional Database Settings

If your live database requires SSL or special options, you can also update:

```env
MYSQL_ATTR_SSL_CA=/path/to/ca-cert.pem
```

## Quick Reference

| Variable | Description | Example |
|---------|-------------|---------|
| `DB_CONNECTION` | Database driver | `mysql` |
| `DB_HOST` | Database server address | `127.0.0.1` or `db.example.com` |
| `DB_PORT` | Database port | `3306` |
| `DB_DATABASE` | Database name | `u105084344_matrimony` |
| `DB_USERNAME` | Database username | `root` or `dbuser` |
| `DB_PASSWORD` | Database password | `your_password` |

## File Locations Summary

1. **`.env`** → `E:\RSL_Intern_T\Matrimony\.env` (UPDATE HERE)
2. **`config/database.php`** → Configuration file (reads from `.env`)
3. **`.env.example`** → Template file (for reference only)

---

**Remember**: Always update the **`.env`** file, not the `config/database.php` file directly!





































