<?php 

session_start();

if( !isset($_SESSION['login']) )
{
    header('Location: auth-login.php');
    exit;
}

require 'functions.php';

$id = $_GET['id'];

$query = "DELETE FROM Skill WHERE sid = ?";
$stmt = $dbh->prepare($query);
$stmt->execute([$id]);

if( $stmt == true )
{
    echo "
            <script>
                alert('successfully deleted data')
                document.location.href = 'skill-data.php';
            </script>
        ";
} else {
    echo "
            <script>
                alert('failed to delete data')
                document.location.href = 'skill-data.php';
            </script>
        ";
}

// if( delete($id) == false )
// {
//     echo "
//             <script>
//                 alert('successfully deleted data')
//                 document.location.href = 'santri-data.php';
//             </script>
//         ";
// } else {
//     echo "
//             <script>
//                 alert('failed to delete data')
//                 document.location.href = 'santri-data.php';
//             </script>
//         ";
// }

?>