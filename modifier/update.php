<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "mydb";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Récupérer les données POST et vérifier les champs obligatoires
$cin = isset($_POST['cin']) ? mysqli_real_escape_string($conn, $_POST['cin']) : '';
if (empty($cin)) {
    echo "Le CIN est obligatoire pour effectuer la mise à jour.";
    exit;
}

$nom = isset($_POST['nom']) ? mysqli_real_escape_string($conn, $_POST['nom']) : '';
$prenom = isset($_POST['prénom']) ? mysqli_real_escape_string($conn, $_POST['prénom']) : '';
$institution = isset($_POST['institution']) ? mysqli_real_escape_string($conn, $_POST['institution']) : '';
$anneU = isset($_POST['anneeUniversitaire']) ? mysqli_real_escape_string($conn, $_POST['anneeUniversitaire']) : '';
$nv_stage = isset($_POST['Niveau_de_Stage']) ? mysqli_real_escape_string($conn, $_POST['Niveau_de_Stage']) : '';
$sp_U = isset($_POST['specialite']) ? mysqli_real_escape_string($conn, $_POST['specialite']) : '';
$date_db = isset($_POST['dateDebut']) ? mysqli_real_escape_string($conn, $_POST['dateDebut']) : '';
$date_fn = isset($_POST['dateFin']) ? mysqli_real_escape_string($conn, $_POST['dateFin']) : '';
$avec_bn = isset($_POST['binome']) ? mysqli_real_escape_string($conn, $_POST['binome']) : '';
//$cin = isset($_POST['cin']) ? mysqli_real_escape_string($conn, $_POST['cin']) : '';;
$tele = isset($_POST['telephone']) ? mysqli_real_escape_string($conn, $_POST['telephone']) : '';
$email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : '';
$papierA = isset($_POST['papiers_apportés']) ? mysqli_real_escape_string($conn, $_POST['papiers_apportés']) : '';
$copy_CIN = isset($_POST['copie_cin_apportée']) ? mysqli_real_escape_string($conn, $_POST['copie_cin_apportée']) : '';
$type_S = isset($_POST['type_de_stage']) ? mysqli_real_escape_string($conn, $_POST['type_de_stage']) : '';

// Vérification si le stagiaire existe
$sql = "SELECT * FROM stagiaires WHERE cin='$cin';";
$test = mysqli_query($conn, $sql);

if (mysqli_num_rows($test) == 0) {
    echo "Le stagiaire n'existe pas.";
} else {
    // Mise à jour des informations du stagiaire
    $sql = "UPDATE stagiaires SET 
        prenom='$prenom', 
        nom='$nom', 
        institution='$institution', 
        annee_universitaire='$anneU', 
        niveau_de_stage='$nv_stage', 
        specialite_universitaire='$sp_U', 
        avec_binome='$avec_bn', 
        date_de_debut='$date_db', 
        date_de_fin='$date_fn', 
        telephone='$tele', 
        email='$email', 
        papiers_apportes='$papierA', 
        copie_cin_apportee='$copy_CIN', 
        type_de_stage='$type_S' 
        WHERE cin='$cin';";

    $res = mysqli_query($conn, $sql);
    $file_name = $_FILES['image']['name'];
    $tempname = $_FILES['image']['tmp_name']; // Utilisez 'tmp_name'
    $folder = '../new profil/Images/' . $file_name;
    $query = mysqli_query($conn, "UPDATE photo_de_profile SET photo ='$file_name'  WHERE cin='$cin' ");
    if ($res and move_uploaded_file($tempname, $folder)) {
       ?><script>
        choix = confirm("voulez vous modifier ce stagiaire ? ");
        if(choix){
            alert("Stagiaire modifié avec succès");
            window.location.href = "../php_page1.php";
        }
        else{
            alert("Stagiaire non modifié");
            window.location.href = "../php_page1.php";
        }
       </script>
         <?php
    } else {
        echo "Erreur lors de la mise à jour : " . $conn->error;
    }
}

$conn->close();
?>
