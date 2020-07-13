<?php 

require 'functions.php';

$id = $_GET['id'];

$query = "DELETE FROM Santri WHERE id = ?";
$stmt = $dbh->prepare($query);
$stmt->execute([$id]);

if( $stmt == true )
{
    echo "
            <script>
                alert('successfully deleted data')
                document.location.href = 'santri-data.php';
            </script>
        ";
} else {
    echo "
            <script>
                alert('failed to delete data')
                document.location.href = 'santri-data.php';
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