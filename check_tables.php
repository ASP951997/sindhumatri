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

echo "Tables found: " . count($tables) . PHP_EOL;

if (in_array('languages', $tables)) {
    echo "✅ Languages table exists!" . PHP_EOL;
    $result = $conn->query("SELECT COUNT(*) FROM languages");
    if ($result) {
        $row = $result->fetch_array();
        echo "   Records: " . $row[0] . PHP_EOL;
    }
} else {
    echo "❌ Languages table NOT found" . PHP_EOL;
}

if (in_array('users', $tables)) {
    echo "✅ Users table exists!" . PHP_EOL;
    $result = $conn->query("SELECT COUNT(*) FROM users");
    if ($result) {
        $row = $result->fetch_array();
        echo "   Records: " . $row[0] . PHP_EOL;
    }
}

if (in_array('admins', $tables)) {
    echo "✅ Admins table exists!" . PHP_EOL;
}

$conn->close();
?>

