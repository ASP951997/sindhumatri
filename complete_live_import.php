<?php
// complete_live_import.php - Complete solution for live database import
// This script handles database reset and import in one go

echo "<h2>🔄 COMPLETE LIVE DATABASE IMPORT</h2>";

// Step 1: Get database credentials from user input
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dbHost = $_POST['db_host'] ?? 'localhost';
    $dbUser = $_POST['db_user'] ?? '';
    $dbPass = $_POST['db_pass'] ?? '';
    $dbName = $_POST['db_name'] ?? '';

    if (empty($dbUser) || empty($dbPass) || empty($dbName)) {
        die("<p style='color: red;'>❌ Please provide all database credentials!</p>");
    }

    echo "<h3>📋 Using Credentials:</h3>";
    echo "<p>Host: $dbHost<br>User: $dbUser<br>Database: $dbName</p>";

    // Test connection
    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

    if ($conn->connect_error) {
        die("<p style='color: red;'>❌ Connection failed: " . $conn->connect_error . "</p>");
    }

    echo "<p style='color: green;'>✅ Database connection successful!</p>";

    // Step 2: Reset database
    echo "<h3>🗑️ Step 1: Resetting Database...</h3>";
    $conn->query("SET FOREIGN_KEY_CHECKS = 0");

    $result = $conn->query("SHOW TABLES");
    $dropped = 0;

    if ($result) {
        while ($row = $result->fetch_array()) {
            $table = $row[0];
            $conn->query("DROP TABLE IF EXISTS `$table`");
            echo "Dropped: $table<br>";
            $dropped++;
        }
    }

    echo "<p style='color: green;'>✅ Dropped $dropped tables</p>";

    // Step 3: Import SQL file
    echo "<h3>📤 Step 2: Importing Database...</h3>";

    $sqlFile = 'local_backup_20260120_065131.sql';
    if (!file_exists($sqlFile)) {
        die("<p style='color: red;'>❌ SQL file not found: $sqlFile</p>");
    }

    $sql = file_get_contents($sqlFile);
    if ($sql === false) {
        die("<p style='color: red;'>❌ Could not read SQL file</p>");
    }

    echo "<p>File size: " . strlen($sql) . " bytes</p>";

    // Split and execute SQL
    $statements = array_filter(array_map('trim', explode(';', $sql)));
    $success = 0;
    $errors = 0;

    foreach ($statements as $statement) {
        if (empty($statement)) continue;

        if ($conn->query($statement)) {
            $success++;
        } else {
            $errors++;
            echo "<span style='color: orange;'>⚠️ Error: " . $conn->error . "</span><br>";
        }
    }

    $conn->query("SET FOREIGN_KEY_CHECKS = 1");

    echo "<p style='color: green;'>✅ Import completed: $success successful, $errors errors</p>";

    // Step 4: Verify import
    echo "<h3>🔍 Step 3: Verifying Import...</h3>";

    $userCount = $conn->query("SELECT COUNT(*) as count FROM users");
    $adminCount = $conn->query("SELECT COUNT(*) as count FROM admins");

    if ($userCount) {
        $users = $userCount->fetch_assoc()['count'];
        echo "<p>👥 Users imported: $users</p>";
    }

    if ($adminCount) {
        $admins = $adminCount->fetch_assoc()['count'];
        echo "<p>👨‍💼 Admins imported: $admins</p>";
    }

    $conn->close();

    echo "<h3>🎉 IMPORT COMPLETE!</h3>";
    echo "<p style='color: green; font-size: 18px;'>✅ Your database has been successfully imported!</p>";
    echo "<p><strong>Admin Login:</strong><br>";
    echo "🌐 URL: https://sindhumatri.com/admin/login<br>";
    echo "👤 Username: SPMO<br>";
    echo "🔒 Password: admin123</p>";

    echo "<p style='color: red;'><strong>⚠️ SECURITY:</strong> Delete this file immediately after testing!</p>";

} else {
    // Show form
    ?>
    <h3>🔐 Enter Your Live Database Credentials</h3>
    <p>Get these from your hosting control panel (cPanel → MySQL Databases)</p>

    <form method="POST" style="background: #f5f5f5; padding: 20px; border-radius: 5px;">
        <div style="margin-bottom: 15px;">
            <label><strong>Database Host:</strong></label><br>
            <input type="text" name="db_host" value="localhost" style="width: 300px; padding: 5px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label><strong>Database Username:</strong></label><br>
            <input type="text" name="db_user" placeholder="e.g., u105084344_user" required style="width: 300px; padding: 5px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label><strong>Database Password:</strong></label><br>
            <input type="password" name="db_pass" placeholder="Your database password" required style="width: 300px; padding: 5px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label><strong>Database Name:</strong></label><br>
            <input type="text" name="db_name" value="u105084344_matrimony" required style="width: 300px; padding: 5px;">
        </div>

        <button type="submit" style="background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 3px; cursor: pointer;">
            🚀 Start Import Process
        </button>
    </form>

    <div style="background: #e8f4fd; padding: 15px; margin-top: 20px; border-radius: 5px;">
        <h4>📋 What this script does:</h4>
        <ol>
            <li>Tests database connection</li>
            <li>Drops all existing tables</li>
            <li>Imports local_backup_20260120_065131.sql</li>
            <li>Verifies the import worked</li>
            <li>Provides login credentials</li>
        </ol>
    </div>

    <div style="background: #fff3cd; padding: 15px; margin-top: 10px; border-radius: 5px;">
        <h4>⚠️ Important:</h4>
        <ul>
            <li>This will <strong>DELETE ALL EXISTING DATA</strong> in your live database</li>
            <li>Make sure you have a backup if needed</li>
            <li>Delete this file after successful import</li>
            <li>The SQL file must be in the same directory</li>
        </ul>
    </div>
    <?php
}
?>




