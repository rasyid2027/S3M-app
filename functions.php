<?php 

$host = 'localhost';
$user = 'root';
$pass = 'password';
$dbname = 's3m_app';

try
{
    $dbh = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
} catch( PDOExeption $e ) {
    die( $e->getMessage() );
}

//pagination
$amountData1Page = 5;
$pagin = $dbh->prepare("SELECT * FROM Santri");
$pagin->execute();
$rows = $pagin->fetchAll(PDO::FETCH_ASSOC);
$amoutnData = count( $rows );
$amountPage = ceil( $amoutnData / $amountData1Page );
$activePage = ( isset($_GET['pg']) ) ? $_GET['pg'] : 1;
$firstData = ( $amountData1Page * $activePage ) - $amountData1Page;

?>