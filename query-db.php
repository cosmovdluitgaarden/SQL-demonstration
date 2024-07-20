<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

//Establish connection with the database, ran locally using MAMP & phpmyadmin
$mysqli = new mysqli("localhost", "root", "root", "sql-demonstration");


//Array with strings that I will query in SQL 
$queries = array(
    "SELECT * FROM user", //Selects all columns from the user records table
    "SELECT * FROM user WHERE `name` LIKE 'c%'", //Selects all user records that start with a 'c'
    "SELECT * FROM transactions", //Selects all columns from the transaction records table
    "SELECT * FROM transactions ORDER BY amount DESC LIMIT 3",  //Selects the top three transactions, ordered by amount from highest to lowest
    "SELECT * FROM transactions WHERE amount BETWEEN 30 AND 80", //Selects all transactions where the amount is between 30 and 80
    "SELECT transactions.id, transactions.sender_id, transactions.amount, transactions.recipient_id, transactions.transaction_date, 
    user.name AS `Sender name` FROM transactions INNER JOIN user ON transactions.sender_id = user.id", //Joins together useful information from both the transactions and user tables
    "INSERT INTO transactions (id, sender_id, amount, recipient_id, transaction_date) VALUES (null, 1, 20, 2, CURRENT_DATE)" //Inserts a transaction into the database (no output, refresh the page to see the effect in above tables)
);

//Loops through the array, executes all of the sql queries, and prints them
foreach ($queries as $query) {
    $results = $mysqli->query($query);
    echo "<h2>Query: " . $query . "</h2>";
    printResults($results); //Function that prints all of the results in a HTML table
}


//Function that prints all of the results in a HTML table
function printResults($result)
{
    if(!is_bool($result)){
    echo '<table style="border: 1px solid black;">';
    $columns = array();
    $resultset = array();
    
    while ($row = mysqli_fetch_assoc($result)) {
        if (empty($columns)) {
            $columns = array_keys($row);
            echo '<tr><th style="border: 1px solid black;">' . implode('</th><th style="border: 1px solid black;">', $columns) . '</th></tr>';
        }
        $resultset[] = $row;
        echo '<tr><td style="border: 1px solid black;">' . implode('</td><td style="border: 1px solid black;">', $row) . '</td></tr>';
    }
    echo '</table><br>';
}
}


