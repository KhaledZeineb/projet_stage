<?php 
$servername = "localhost"; // Database host (usually localhost)
$username = "root"; // Database username
$password = ""; // Database password
$database = "mydb"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
if (isset($_GET['cin'])) {
    $cin = $_GET['cin']; // Récupération directe du paramètre

    // Requête SQL simple pour récupérer les données du stagiaire
    $query = "DELETE FROM stagiaires WHERE cin = '$cin'";
    $result = mysqli_query($conn, $query);
    $res = mysqli_query($conn, "DELETE FROM photo_de_profile WHERE cin = '$cin'");
    if($result and $res){
        ?><script>choix = confirm("voulez vous suprimer ce stagiaire ? ");
        if(choix){
            alert("Stagiaire suprimé avec succès");
            window.location.href = "php_page1.php";
        }
        else{
            alert("Stagiaire non suprimé");
            window.location.href = "php_page1.php";
        }

        
        </script>
        <?php
        } else {
        echo "Error: " . $query . "<br>" . $conn->error;
        }
}

?>