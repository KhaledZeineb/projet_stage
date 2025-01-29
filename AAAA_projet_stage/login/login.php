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
$email = "";
$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (empty($email) || empty ($password)){
        $error = "Veuillez remplir tous les champs";
    }
    else{
        $email = mysqli_real_escape_string($conn, $email);
        $password2= mysqli_real_escape_string($conn, $password);
        $sql = "SELECT * FROM administrateur WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password2, $row['PASSWORD'])) {
                session_start();
                $_SESSION['email'] = $row['email'];
                $_SESSION['id'] = $row['id'];
                header("Location: ../php_page1.php");
            } else {
                $error = "Mot de passe incorrect";
            }
        } else {
            $error = "Email incorrect";
        }
    }
}



?>
<script src="https://cdn.tailwindcss.com"></script>
<body  class="flex items-center justify-center min-h-screen bg-gradient-to-br from-purple-100 to-blue-100 p-6">


    <div class="w-full max-w-sm p-6 bg-white rounded-lg shadow-md">
        <h1 class="mb-6 text-2xl font-bold text-center text-gray-800">Se connecter </h1>
        <?php if ($error) : ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Erreur!</strong>
                <span class="block sm:inline"><?= $error ?></span>
            </div>
        <?php endif; ?>
        <form method="POST">
            
            <div class="mb-4">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-600">Email</label>
                <input
                    type="email" 
                    id="email" 
                    name="email" 
                    value = "<?= $email ?>"
                    placeholder="Enter your email or Username" 
                    class="w-full px-4 py-2 text-sm border rounded-lg focus:ring focus:ring-blue-300 focus:outline-none focus:ring-opacity-50 border-gray-300">
            </div>

            
            <div class="mb-4">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-600">Mot de passe</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password"
                    placeholder="Enter your password" 
                    class="w-full px-4 py-2 text-sm border rounded-lg focus:ring focus:ring-blue-300 focus:outline-none focus:ring-opacity-50 border-gray-300">
            </div>

            <!-- Submit Button -->
            <button 
                type="submit" 
                class="w-full px-4 py-2 text-white bg-purple-600 rounded-lg hover:bg-blue-700 focus:ring focus:ring-blue-300 focus:outline-none focus:ring-opacity-50">
                Se connecter
            </button>
        </form>

        <!-- Additional Links -->
        <div class="mt-4 text-center">
            <a href="forget_pass.html" class="text-sm text-blue-600 hover:underline">Mot de passe oublier?</a>
            <a href="register.php" class="link">Creer un compte !</a>
        </div>
    </div>
</body>