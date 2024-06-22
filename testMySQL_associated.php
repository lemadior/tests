<?php

$dsn = 'mysql:host=localhost;dbname=testdb';

$user = <TYPE USER NANE HERE>;
$password = <TYPE PASSWORD HERE>;

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

$sqlQuery = '
    SELECT categories.c_name, products.p_name
    FROM associations
    JOIN products ON products.id = associations.p_id
    JOIN categories ON categories.id = associations.c_id
    ORDER BY c_name;
';

$filePath = './Data/data_db_associated.txt';

$data = [];

try {
    $dbConnection = new PDO($dsn, $user, $password, $options);

    $stmt = $dbConnection->prepare($sqlQuery);
    $stmt->execute();

    if ($stmt) {
        $data = $stmt->fetchAll();
    } else {
        throw new \RuntimeException('Error: SQL Query failed');
    }
} catch (PDOException $err) {
    throw new \RuntimeException( "Connection failed: " . $err->getMessage());
}

$fd = fopen($filePath, 'wb');

// Create header in CSV file
fwrite($fd,  "c_name, p_name" . PHP_EOL);

// Show header
echo "c_name\tp_name" . PHP_EOL;
echo "--------------" . PHP_EOL;

// Show the result of the SQL Query
foreach ($data as $row) {
    // Show data
    echo "{$row['c_name']}\t{$row['p_name']}" . PHP_EOL;

    // Write down data
    fputcsv($fd, $row);
}

fclose($fd);
