<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "mydb";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$utilisateur = isset($_POST['name']) ? $_POST['name'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

$sql = "SELECT * FROM administrateur WHERE utilisateur = '$utilisateur';";
$test = mysqli_query($conn, $sql);

if (mysqli_num_rows($test) != 0) {
    echo "L'administrateur existe déjà.";
} else {
    $sql = "INSERT INTO administrateur (utilisateur, email, mot_de_passe) VALUES ('$utilisateur', '$email', '$password');";
    $res = mysqli_query($conn, $sql);
    if ($res) {
        echo "Enregistrement fait avec succès.";
    } else {
        echo "Erreur: " . $conn->error;
    }
}

$conn->close();
?>
