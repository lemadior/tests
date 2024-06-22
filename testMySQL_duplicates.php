<?php

$dsn = 'mysql:host=localhost;dbname=testdb';

$user = <TYPE USER NANE HERE>;
$password = <TYPE PASSWORD HERE>;

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

// Create temporary table only with duplicated id
$sqlQuery1 = 'CREATE TABLE tmp_table SELECT max(id) AS duplicate_id FROM test_table GROUP BY `key` HAVING count(id) > 1';
// Delete records from test_table rely on duplicated id stored into the tmp_table
$sqlQuery2 = 'DELETE FROM test_table WHERE id IN (SELECT duplicate_id FROM tmp_table)';
// Remove tmp_table
$sqlQuery3 = 'DROP TABLE tmp_table';

try {
    $dbConnection = new PDO($dsn, $user, $password, $options);

    $stmt1 = $dbConnection->prepare($sqlQuery1);
    $stmt1->execute();

    $stmt2 = $dbConnection->prepare($sqlQuery2);
    $stmt2->execute();

    $stmt3 = $dbConnection->prepare($sqlQuery3);
    $stmt3->execute();

    echo "Removing duplicates complete";
} catch (PDOException $err) {
    throw new \RuntimeException( "Transaction failed: " . $err->getMessage());
}
