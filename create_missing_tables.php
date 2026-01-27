<?php
// create_missing_tables.php - Create missing tables from SQL backup

$servername = "localhost";
$username = "your_live_db_username";  // Replace with your actual database username
$password = "your_live_db_password";  // Replace with your actual database password
$dbname = "u105084344_matrimony";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

echo "🔌 Connected to database: $dbname<br><br>";

// Disable foreign key checks for table creation
$conn->query("SET FOREIGN_KEY_CHECKS = 0");

// Check if funds table exists
$result = $conn->query("SHOW TABLES LIKE 'funds'");
if ($result && $result->num_rows == 0) {
    echo "📝 Creating funds table...<br>";

    $createFundsTable = "
    CREATE TABLE `funds` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `user_id` int(11) unsigned DEFAULT NULL,
      `plan_id` bigint(111) DEFAULT NULL,
      `gateway_id` int(11) unsigned DEFAULT NULL,
      `gateway_currency` varchar(191) DEFAULT NULL,
      `amount` decimal(18,8) NOT NULL DEFAULT 0.00000000,
      `charge` decimal(18,8) NOT NULL DEFAULT 0.00000000,
      `rate` decimal(18,8) NOT NULL DEFAULT 0.00000000,
      `final_amount` decimal(18,8) NOT NULL DEFAULT 0.00000000,
      `btc_amount` decimal(18,8) DEFAULT NULL,
      `btc_wallet` varchar(191) DEFAULT NULL,
      `transaction` varchar(191) DEFAULT NULL,
      `status` tinyint(1) NOT NULL DEFAULT 0,
      `payment_status` tinyint(1) NOT NULL DEFAULT 0,
      `payment_type` varchar(50) DEFAULT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL,
      PRIMARY KEY (`id`),
      KEY `funds_user_id_foreign` (`user_id`),
      KEY `funds_gateway_id_foreign` (`gateway_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

    if ($conn->query($createFundsTable)) {
        echo "✅ Funds table created successfully!<br>";
    } else {
        echo "❌ Error creating funds table: " . $conn->error . "<br>";
    }
} else {
    echo "✅ Funds table already exists<br>";
}

// Check for other potentially missing tables
$otherTables = [
    'user_fund_logs' => "
    CREATE TABLE `user_fund_logs` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `user_id` int(11) unsigned NOT NULL,
      `amount` decimal(18,8) NOT NULL DEFAULT 0.00000000,
      `charge` decimal(18,8) NOT NULL DEFAULT 0.00000000,
      `post_balance` decimal(18,8) NOT NULL DEFAULT 0.00000000,
      `trx_type` varchar(40) DEFAULT NULL,
      `trx_id` varchar(191) DEFAULT NULL,
      `remarks` varchar(191) DEFAULT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    'user_transactions' => "
    CREATE TABLE `user_transactions` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `user_id` int(11) unsigned NOT NULL,
      `amount` decimal(18,8) NOT NULL DEFAULT 0.00000000,
      `charge` decimal(18,8) NOT NULL DEFAULT 0.00000000,
      `trx_type` varchar(40) DEFAULT NULL,
      `trx_id` varchar(191) DEFAULT NULL,
      `remarks` varchar(191) DEFAULT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    'user_withdrawals' => "
    CREATE TABLE `user_withdrawals` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `user_id` int(11) unsigned NOT NULL,
      `method_id` int(11) unsigned NOT NULL,
      `amount` decimal(18,8) NOT NULL DEFAULT 0.00000000,
      `charge` decimal(18,8) NOT NULL DEFAULT 0.00000000,
      `rate` decimal(18,8) NOT NULL DEFAULT 0.00000000,
      `final_amount` decimal(18,8) NOT NULL DEFAULT 0.00000000,
      `after_charge` decimal(18,8) NOT NULL DEFAULT 0.00000000,
      `trx` varchar(191) DEFAULT NULL,
      `status` tinyint(1) NOT NULL DEFAULT 0,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
];

foreach ($otherTables as $tableName => $createSQL) {
    $result = $conn->query("SHOW TABLES LIKE '$tableName'");
    if ($result && $result->num_rows == 0) {
        echo "📝 Creating $tableName table...<br>";
        if ($conn->query($createSQL)) {
            echo "✅ $tableName table created successfully!<br>";
        } else {
            echo "❌ Error creating $tableName table: " . $conn->error . "<br>";
        }
    } else {
        echo "✅ $tableName table already exists<br>";
    }
}

// Re-enable foreign key checks
$conn->query("SET FOREIGN_KEY_CHECKS = 1");

echo "<br>🎉 Table creation completed!<br>";
echo "🔍 Now test your admin panel:<br>";
echo "🌐 https://sindhumatri.com/admin/login<br>";
echo "👤 Username: SPMO<br>";
echo "🔒 Password: admin123<br><br>";

echo "⚠️  Delete this file after testing!<br>";

$conn->close();
?>




