<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "mydb";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$nom = isset($_POST['nom']) ? $_POST['nom'] : '';
$prenom = isset($_POST['prénom']) ? $_POST['prénom'] : '';
$institution = isset($_POST['institution']) ? $_POST['institution'] : '';
$anneU = isset($_POST['anneeUniversitaire']) ? $_POST['anneeUniversitaire'] : '';
$nv_stage = isset($_POST['Niveau_de_Stage']) ? $_POST['Niveau_de_Stage'] : '';
$sp_U = isset($_POST['specialite']) ? $_POST['specialite'] : '';
$date_db = isset($_POST['dateDebut']) ? $_POST['dateDebut'] : '';
$date_fn = isset($_POST['dateFin']) ? $_POST['dateFin'] : '';
$avec_bn = isset($_POST['binome']) ? $_POST['binome'] : '';
$cin = isset($_POST['cin']) ? $_POST['cin'] : '';
$tele = isset($_POST['telephone']) ? $_POST['telephone'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$papierA = isset($_POST['papiers_apportés']) ? $_POST['papiers_apportés'] : '';
$copy_CIN = isset($_POST['copie_cin_apportée']) ? $_POST['copie_cin_apportée'] : '';
$type_S = isset($_POST['type_de_stage']) ? $_POST['type_de_stage'] : '';

$sql = "SELECT * FROM stagiaires WHERE cin='" . mysqli_real_escape_string($conn, $cin) . "';";
$test = mysqli_query($conn, $sql);

if (mysqli_num_rows($test) != 0) {
    ?>
    <script>
        alert("Le stagiaire existe déjà.");
        window.location.href = "../php_page1.php";
    </script>
    <?php
} else {
    $sql = "INSERT INTO stagiaires 
        (prenom, nom, institution, annee_universitaire, niveau_de_stage, specialite_universitaire, avec_binome, date_de_debut, date_de_fin, cin, telephone, email, papiers_apportes, copie_cin_apportee, type_de_stage) 
        VALUES (
            '" . mysqli_real_escape_string($conn, $prenom) . "',
            '" . mysqli_real_escape_string($conn, $nom) . "',
            '" . mysqli_real_escape_string($conn, $institution) . "',
            '" . mysqli_real_escape_string($conn, $anneU) . "',
            '" . mysqli_real_escape_string($conn, $nv_stage) . "',
            '" . mysqli_real_escape_string($conn, $sp_U) . "',
            '" . mysqli_real_escape_string($conn, $avec_bn) . "',
            '" . mysqli_real_escape_string($conn, $date_db) . "',
            '" . mysqli_real_escape_string($conn, $date_fn) . "',
            '" . mysqli_real_escape_string($conn, $cin) . "',
            '" . mysqli_real_escape_string($conn, $tele) . "',
            '" . mysqli_real_escape_string($conn, $email) . "',
            '" . mysqli_real_escape_string($conn, $papierA) . "',
            '" . mysqli_real_escape_string($conn, $copy_CIN) . "',
            '" . mysqli_real_escape_string($conn, $type_S) . "'
        );";
    $file_name = $_FILES['image']['name'];
    $tempname = $_FILES['image']['tmp_name']; // Utilisez 'tmp_name'
    $folder = 'Images/' . $file_name;
    $query = mysqli_query($conn, "INSERT INTO photo_de_profile VALUES ('$cin','$file_name')");
    $res = mysqli_query($conn, $sql);
    if ($res and move_uploaded_file($tempname, $folder)) {
        ?>
        <script>
            choix = confirm("voulez vous ajouter ce stagiaire ? ");
            if (choix) {
                alert("Stagiaire ajouté avec succès");
                window.location.href = "../php_page1.php";
            } else {
                alert("Stagiaire non ajouté");
                window.location.href = "../php_page1.php";
            }
        </script>
        <?php
        
        
    } else {
        echo "Erreur d'enregistrement : " . mysqli_error($conn);
    }
}

$conn->close();
?>
