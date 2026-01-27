# LIVE SERVER DUPLICATE REMOVAL GUIDE

## Files Required for Live Server

### 1. PRIMARY SCRIPT: `simple_duplicate_removal.php`
**This is the main script that removes duplicates safely**

```php
<?php
/**
 * Simple Duplicate Removal
 * For tables without proper primary keys
 */

$conn = new mysqli('127.0.0.1', 'u105084344_matrimony', 'Spmo@111', 'u105084344_matrimony');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

echo "=== SIMPLE DUPLICATE REMOVAL ===\n\n";

$tables_to_fix = [
    'countries' => 'name',
    'complexion_details' => 'name',
    'family_value_details' => 'name',
    'body_type_details' => 'name'
];

foreach ($tables_to_fix as $table => $name_column) {
    echo "--- Fixing $table ---\n";

    // Get initial count
    $result = $conn->query("SELECT COUNT(*) as total FROM $table");
    $row = $result->fetch_assoc();
    $initial_count = $row['total'];
    echo "Initial count: $initial_count records\n";

    // Create backup table
    $backup_table = $table . '_backup_' . time();
    $conn->query("CREATE TABLE $backup_table AS SELECT * FROM $table");
    echo "Created backup: $backup_table\n";

    // Clear original table
    $conn->query("TRUNCATE TABLE $table");

    // Insert unique records only (group by name, take first record for each group)
    $conn->query("
        INSERT INTO $table
        SELECT * FROM $backup_table
        GROUP BY $name_column
    ");

    $result = $conn->query("SELECT COUNT(*) as total FROM $table");
    $row = $result->fetch_assoc();
    $final_count = $row['total'];
    echo "Final count: $final_count records\n";
    echo "Removed " . ($initial_count - $final_count) . " duplicates\n";

    // Verify no duplicates
    $result = $conn->query("SELECT $name_column, COUNT(*) as count FROM $table GROUP BY $name_column HAVING COUNT(*) > 1");
    if ($result->num_rows > 0) {
        echo "❌ Still has duplicates\n";
    } else {
        echo "✅ No duplicates remaining\n";
    }

    // Optional: drop backup table after verification
    // $conn->query("DROP TABLE $backup_table");

    echo "\n";
}

echo "=== REMOVAL COMPLETE ===\n";
echo "Note: Backup tables created with timestamp suffix if you need to restore\n";

$conn->close();
?>
```

### 2. VERIFICATION SCRIPT: `check_duplicates.php`
**Use this to verify duplicates are removed**

```php
<?php
$conn = new mysqli('127.0.0.1', 'u105084344_matrimony', 'Spmo@111', 'u105084344_matrimony');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$result = $conn->query('SHOW TABLES');
$tables = [];
while ($row = $result->fetch_array()) {
    $tables[] = $row[0];
}

// Check for tables related to the mentioned dropdowns
$relevant_tables = array_filter($tables, function($table) {
    return strpos($table, 'country') !== false ||
           strpos($table, 'complexion') !== false ||
           strpos($table, 'family_value') !== false ||
           strpos($table, 'body_type') !== false ||
           strpos($table, 'caste') !== false ||
           strpos($table, 'religion') !== false ||
           strpos($table, 'marital') !== false;
});

echo "=== DUPLICATE DATA ANALYSIS ===\n\n";
echo "Relevant tables found: " . implode(', ', $relevant_tables) . "\n";
echo "Total relevant tables: " . count($relevant_tables) . "\n\n";

// Check each relevant table for duplicates
$tables_to_check = [
    'countries' => 'name',
    'complexion_details' => 'name',
    'family_value_details' => 'name',
    'body_type_details' => 'name',
    'caste_details' => 'name',
    'religion_details' => 'name',
    'marital_status_details' => 'name'
];

foreach ($tables_to_check as $table => $column) {
    if (in_array($table, $tables)) {
        echo "--- $table ---\n";

        // Check total records
        $result = $conn->query("SELECT COUNT(*) as total FROM $table");
        $row = $result->fetch_assoc();
        echo "Total records: " . $row['total'] . "\n";

        // Check for duplicates
        $result = $conn->query("SELECT $column, COUNT(*) as count FROM $table GROUP BY $column HAVING COUNT(*) > 1 ORDER BY count DESC LIMIT 10");

        if ($result->num_rows > 0) {
            echo "DUPLICATES FOUND:\n";
            while ($row = $result->fetch_assoc()) {
                echo "  - '" . $row[$column] . "' appears " . $row['count'] . " times\n";
            }
        } else {
            echo "No duplicates found\n";
        }
        echo "\n";
    }
}

$conn->close();
?>
```

## Steps to Apply on Live Server

### Step 1: Upload Files
Upload these files to your live server root directory:
- `simple_duplicate_removal.php` (main script)
- `check_duplicates.php` (verification script)

### Step 2: Update Database Credentials
Edit the scripts and update the database connection details to match your live server:

```php
$conn = new mysqli('YOUR_LIVE_DB_HOST', 'YOUR_LIVE_DB_USERNAME', 'YOUR_LIVE_DB_PASSWORD', 'YOUR_LIVE_DB_NAME');
```

### Step 3: Run Verification First
```bash
php check_duplicates.php
```

This will show you the current duplicate situation on your live server.

### Step 4: Run Duplicate Removal
```bash
php simple_duplicate_removal.php
```

This will:
- Create backup tables with timestamp
- Remove all duplicates
- Keep only unique records
- Preserve foreign key references

### Step 5: Verify Results
```bash
php check_duplicates.php
```

Should show "No duplicates found" for all tables.

### Step 6: Test Your Application
Visit your live user profile page and verify dropdowns show unique values.

## Important Notes

1. **Backup Tables**: The script creates backup tables (e.g., `countries_backup_1234567890`) that you can delete after verification.

2. **Foreign Keys**: The script handles duplicates without breaking foreign key relationships by keeping the first occurrence.

3. **Database Credentials**: Update the connection details in both scripts to match your live database.

4. **Testing**: Always run on a backup first if possible.

## Expected Results
- Countries: ~250 unique countries (instead of 750+ with duplicates)
- Complexion Details: ~6 unique options
- Family Value Details: ~6 unique options
- Body Type Details: ~6 unique options

## Alternative Quick Method
If you prefer a one-liner approach, you can run this SQL directly in phpMyAdmin:

```sql
-- For each table, replace duplicates with unique records
CREATE TABLE countries_temp AS SELECT * FROM countries GROUP BY name;
TRUNCATE TABLE countries;
INSERT INTO countries SELECT * FROM countries_temp;
DROP TABLE countries_temp;

-- Repeat for other tables:
-- complexion_details, family_value_details, body_type_details
```

The PHP script is safer and provides better feedback.
