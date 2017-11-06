<!DOCTYPE html>
<html>
<body bgcolor = "#ffdab9">

<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);


echo "<table style='border: solid 2px black;'>";
echo "<tr><th>id</th><th>email</th><th>fname</th><th>lname</th><th>phone</th><th>birthday</th><th>gender</th><th>password</th></th></tr>";

class TableRows extends RecursiveIteratorIterator {
    function __construct($it) {
        parent::__construct($it, self::LEAVES_ONLY);
    }

    function current() {
        return "<td style='width: 150px; border: 1px solid black;'>" . parent::current(). "</td>";
    }

    function beginChildren() {
        echo "<tr>";
    }

    function endChildren() {
        echo "</tr>" . "\n";
    }
}

$servername = "sql2.njit.edu";
$username = "ci38";
$password = "chhavi12345";
$dbname = "ci38";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<h1>Connected Successfully</h1><br>";

    $count = $conn->prepare("SELECT count(id) FROM accounts WHERE id < 6");
    $count->execute();
    $result1 = $count->Fetch(PDO::FETCH_NUM);
    $resultcount = $result1[0];
    echo "No. of records in the result are" . "   $resultcount<br><br>";

    echo "<b>HTML Table for the result is below</b><br><br>";
    $stmt = $conn->prepare("SELECT id, email, fname, lname, phone, birthday, gender, password FROM accounts WHERE id < 6");
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    foreach (new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k => $v) {
        echo $v;
    }

}
catch(PDOException $e) {
    echo "Connection Failed<br>" . $e->getMessage();
}

$conn = null;
echo "</table>";
?>

</body>
</html>