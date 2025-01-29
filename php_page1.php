<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    
</head>
<body class="flex flex-col min-h-screen bg-gradient-to-br from-gray-200 via-gray-100 to-gray-300 bg-cover font-roboto">
    <!-- Fond flou -->
    <div class="absolute inset-0 z-[-1] bg-cover bg-center filter blur-md" style="background-image: url('img1.jpg');"></div>
    <header class="bg-gray-800 py-6 px-8 flex items-center justify-between shadow-md sticky top-0 z-50">
    
    <div class="absolute left-1/2 transform -translate-x-1/2 h-20 w-20 rounded-full bg-white flex items-center justify-center shadow-lg">
        <img src="logo.png" alt="Logo Itqan" class="w-16 h-16 object-contain p-1">
    </div>

    
    <form action="login/logout.php" method="POST" class="ml-auto">
        <button type="submit" 
            class="bg-red-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-red-600 transition">
            Déconnexion
        </button>
    </form>
</header>

    
<main class="flex-1 flex flex-col items-center justify-center bg-white/90 p-10 shadow-lg rounded-lg m-5">
 <h1 class="text-2xl font-bold mb-5 text-gray-800">Bienvenue sur Itqan</h1>
        <p class="text-gray-600 mb-10 text-center">
            Gérez vos profils de manière efficace avec des commandes simples et intuitives. 
            Commencez par modifier ou ajouter un profil. Profitez d'une expérience fluide et moderne.
        </p>

    <table id="stagiairesTable" class="w-full mt-8 mb-5 border border-collapse border-gray-300">
            <thead>
                <tr>
                    <th class="bg-gray-800 text-white py-3 px-4 border border-gray-300">CIN</th>
                    <th class="bg-gray-800 text-white py-3 px-4 border border-gray-300">Nom Complet</th>
                    <th class="bg-gray-800 text-white py-3 px-4 border border-gray-300">Université</th>
                    <th class="bg-gray-800 text-white py-3 px-4 border border-gray-300">Date de début</th>
                    <th class="bg-gray-800 text-white py-3 px-4 border border-gray-300">Date de fin</th>
                    <th class="bg-gray-800 text-white py-3 px-4 border border-gray-300">Type de stage</th>
                    <th class="bg-gray-800 text-white py-3 px-4 border border-gray-300 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
    <?php
    session_start();
    $servername = "localhost"; // Database host (usually localhost)
    $username = "root"; // Database username
    $password = ""; // Database password
    $database = "mydb"; // Database name
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql="SELECT* FROM stagiaires ;";
    $MYSQL=mysqli_query($conn,$sql);
    if(mysqli_num_rows($MYSQL)>0){
        
        while($mysq=mysqli_fetch_assoc($MYSQL)){
            echo"<tr>";
            echo "<td class='py-3 px-4 border border-gray-300 text-center'>{$mysq["cin"] }</td>";
            echo "<td class='py-3 px-4 border border-gray-300 text-center'>{$mysq["nom"] } {$mysq["prenom"]} </td>";
            echo "<td class='py-3 px-4 border border-gray-300 text-center'>{$mysq["institution"] }</td>";
            echo "<td class='py-3 px-4 border border-gray-300 text-center'>{$mysq["date_de_debut"] }  </td>";
            echo "<td class='py-3 px-4 border border-gray-300 text-center'>{$mysq["date_de_fin"] } </td>";
            echo "<td class='py-3 px-4 border border-gray-300 text-center'>{$mysq["type_de_stage"] } </td>";
            echo "<td class='py-3 px-4 border border-gray-300 text-center'>
            <a href='modifier/modifier.php?cin=$mysq[cin]'><button class='bg-blue-500 text-white p-2 rounded-full hover:bg-blue-600'>
                <i class='fas fa-edit'></i>
            </button></a>
            <a href='détails/essai.php?cin=$mysq[cin]'><button class='bg-green-500 text-white p-2 rounded-full hover:bg-green-600 mx-2'>
                <i class='fas fa-eye'></i>
            </button></a>
            <a href='suprimer.php?cin=$mysq[cin]'<button class='bg-blue-500 text-white p-2 rounded-full hover:bg-blue-600'>
                <i class='fas fa-trash'></i>
            </button>
            </td>";
            echo"</tr>";
        }


    }?>
    <tbody>
    </table>
    <div class="buttons flex space-x-4">
            <a href="new profil/new profile.html"><button class="bg-blue-500 text-white py-3 px-8 rounded-lg hover:bg-blue-600 transition-shadow">
                <i class="fas fa-plus"></i> Ajouter un profil
            </button></a>
        </div>

</main>
<!-- Footer -->
<footer class="bg-gray-800 text-white text-center py-3 px-5 text-sm">
        &copy; 2025 Itqan. Tous droits réservés.
    </footer>
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="scripts.js"></script>


</body>
</html>
