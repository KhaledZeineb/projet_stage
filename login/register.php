<?php 
$servername = "localhost";
$username = "root";
$password = "";
$database = "mydb";

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $database);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialiser les variables
$username = "";
$email = "";
$username_error = "";
$email_error = "";
$password_error = "";
$confirm_password_error = "";
$error = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Valider les champs
    if (empty($username)) {
        $username_error = "Le champ nom ne peut pas être vide.";
        $error = true;
    }
    if (empty($email)) {
        $email_error = "Le champ email ne peut pas être vide.";
        $error = true;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "Email invalide.";
        $error = true;
    }
    if (strlen($password) < 8) {
        $password_error = "Mot de passe doît être > à 8 caractères.";
        $error = true;
    }
    if ($password != $confirm_password) {
        $confirm_password_error = "Les mots de passe ne correspondent pas.";
        $error = true;
    }

    // Si aucune erreur, vérifier dans la base de données
    if (!$error) {
        // Échapper les données pour éviter les injections SQL
        $username = mysqli_real_escape_string($conn, $username);
        $email = mysqli_real_escape_string($conn, $email);
        $password =password_hash(mysqli_real_escape_string($conn, $password), PASSWORD_DEFAULT);

        // Vérifier si l'email existe déjà
        $sql = "SELECT id FROM administrateur WHERE email = '$email'";
        $test = mysqli_query($conn, $sql);
        if (mysqli_num_rows($test) != 0) {
            echo "L'administrateur existe déjà.";
        } else {
            // Insérer l'utilisateur dans la base de données
            $sql = "INSERT INTO administrateur (username, email, password) VALUES ('$username', '$email', '$password')";
            $res = mysqli_query($conn, $sql);
            if ($res) {
                $_SESSION["username"] = $username;
                $_SESSION["email"] = $email;
                header("Location: ../php_page1.php");
                exit;
            } else {
                echo "Erreur: " . $conn->error;
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Compte</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-purple-100 to-blue-100 p-6">
    <div class="bg-white max-w-sm w-full p-6 rounded-lg shadow-lg">
        <header class="text-center text-2xl font-semibold text-black-700 mb-6">Créer un Compte</header>
        <form  method="POST">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom d'utilisateur</label>
                <input type="text" name="name" value="<?= $username ?>" id="name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"  placeholder="Entrez un nom pour l'utilise  ">
                <span class="text-red-600 font-bold "><?= $username_error ?></span>

            </div>
            
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Adresse e-mail</label>
                <input type="email" name="email" value="<?= $email ?>"  id="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Entrez votre e-mail">
                <span class="text-red-600 font-bold "><?= $email_error ?> </span>
            </div>

            <!-- Password Field -->
            <div class="mb-4 relative">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                <div class="relative">
    <input type="password" name="password" id="password" class="w-full pr-10 pl-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Créez un mot de passe">
    <span class="text-red-600 font-bold "><?= $password_error ?> </span>
    <button type="button" class="absolute right-0 top-0 h-full px-3 flex items-center justify-center" onclick="togglePassword('password', this)">
        <i class="fas fa-eye text-gray-500"></i>
    </button>
</div>

            </div>

            <!-- Confirm Password Field -->
            <div class="mb-4 relative">
                <label for="confirm-password" class="block text-sm font-medium text-gray-700 mb-1">Confirmer le mot de passe</label>
                <div class="relative">
    <input type="password" name="confirm_password" id="confirm-password" class="w-full pr-10 pl-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Confirmez votre mot de passe">
    <span class="text-red-600 font-bold "><?= $confirm_password_error ?> </span>
    <button type="button" class="absolute right-0 top-0 h-full px-3 flex items-center justify-center" onclick="togglePassword('confirm-password', this)">
        <i class="fas fa-eye text-gray-500"></i>
    </button>
</div>

            </div>

            <!-- Error Message -->
            <p id="error-message" class="text-red-500 text-sm hidden mb-4">Les mots de passe ne correspondent pas.</p>

            <button type="submit" class="w-full py-2 bg-purple-600 text-white font-medium rounded-md hover:bg-blue-700 transition duration-200">S'inscrire</button>
            
            <div class="text-center mt-4 text-sm text-gray-600">
                Déjà un compte? <a href="log_in.html" class="text-blue-500 hover:underline">Se connecter</a>
            </div>
        </form>
    </div>
    <script>
  function togglePassword(inputId, button) {
      const input = document.getElementById(inputId);
      const icon = button.querySelector("i");
      if (input.type === "password") {
          input.type = "text";
          icon.classList.remove("fa-eye");
          icon.classList.add("fa-eye-slash");
      } else {
          input.type = "password";
          icon.classList.remove("fa-eye-slash");
          icon.classList.add("fa-eye");
      }
  }
</script>

</body>
</html>