<?php
date_default_timezone_set("Asia/Kuala_Lumpur");
header('Content-Type: charset=UTF-8');

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';

$connection = new mysqli($dbhost, $dbuser, $dbpass);

if($connection->connect_error) die($connection->connection_error);

function createTable($name, $query)
{
    queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
}

function queryMysql($query)
{
    global $connection;
    $result = $connection->query($query);
    if(!$result) die($connection->error);
    return $result;
}
//Setup of Frogdatabase and tables.
$result = queryMysql("SHOW DATABASES LIKE 'FrogPond'");
$rows = $result->num_rows;
if ($rows == 0) {
    $result = queryMysql("CREATE DATABASE FrogPond");
    $result = queryMysql("USE FrogPond");

    createTable('data', '
        frogID BIGINT NOT NULL UNIQUE KEY,
        name VARCHAR(250) NOT NULL,
        gender CHAR NOT NULL,
        type VARCHAR(100) NOT NULL,
        environment VARCHAR(200) NOT NULL,
        birth VARCHAR(50) NOT NULL,
        death VARCHAR(50) NOT NULL
    ');

    createTable('type','
        typeID INT NOT NULL UNIQUE KEY,
        name VARCHAR(250) NOT NULL
    ');

    createTable('members', '
        Username varchar(50) NOT NULL UNIQUE KEY,
        Password varchar(10) NOT NULL
    ');
    
    $result = queryMysql("INSERT INTO members VALUES('admin','admin')");
    $result = queryMysql("INSERT INTO type VALUES(1,'Bufo Asper'),(2,'Bufo Divergens'),(3,'Megophrys nasuta'),(4,'Kaloula baleata'),(5,'Kalophyrnus pleurostigma'),(6,'Microhyla berdmorei'),(7,'Rana chalconota'),(8,'Rana baramica'),(9,'Rana glandulosa'),(10,'Rana erythrea'),(11,'Rana nigrovittata'),(12,'Limnonectes malesiana'),(13,'Nyctixalus pictus'),(14,'Polypedates colleti'),(15,'Polypedates macrotis'),(16,'Rhacophorus appendiculatus'),(17,'Rhacophorus reinwardti'),(18,'Rhacophorus nigropalmatus')");
} else {
    $result = queryMysql("USE FrogPond");
}

function destroySession()
{
    $_SESSION=array();

    if (session_id() != "" || isset($_COOKIE[session_name()]))
        setcookie(session_name(), '', time()-2592000, '/');
    
    session_destroy();
}

  function sanitizeString($var)
  {
    global $connection;
    $var = strip_tags($var);
    $var = htmlentities($var);
    $var = stripslashes($var);
    return $connection->real_escape_string($var);
  }
?>