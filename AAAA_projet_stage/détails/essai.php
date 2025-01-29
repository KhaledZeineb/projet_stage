<?php
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
    // Vérification si le paramètre CIN est présent
    if (isset($_GET['cin'])) {
        $cin = $_GET['cin']; // Récupération directe du paramètre

        // Requête SQL simple pour récupérer les données du stagiaire
        $query = "SELECT * FROM stagiaires WHERE cin = '$cin'";
        $result = mysqli_query($conn, $query);
        $res = mysqli_query($conn, "SELECT * FROM photo_de_profile WHERE cin = '$cin'");

        // Vérification si un résultat a été trouvé
        if (mysqli_num_rows($result) > 0) {
            $stagiaire = mysqli_fetch_assoc($result); // Récupération des données
        } else {
            echo "Aucun stagiaire trouvé avec ce CIN.";
            exit;
        }
    } 
    else {
        exit;
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil du Stagiaire</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-purple-100 to-blue-100 p-6 flex flex-col items-center justify-center">
  <!-- Header -->
  <header class="bg-gray-800 py-5 px-8 flex items-center justify-center shadow-md fixed top-0 z-50 w-full">
        <div class="h-20 w-20 rounded-full bg-white flex items-center justify-center shadow-lg">
            <img src="../logo.png" alt="Logo Itqan" class="object-contain w-16 h-16">
        </div>
        <form action="../login/logout.php" method="POST" class="ml-auto">
        <button type="submit" 
            class="bg-red-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-red-600 transition">
            Déconnexion
        </button>
    </form>

    </header>

<!-- Profile Card -->
<div class="relative max-w-3xl w-full p-8 bg-white rounded-xl shadow-lg border mt-32">
    <!-- Photo et Header -->
    <div class="flex items-center space-x-6 border-b pb-6">
      <div class="w-32 h-32 border-4 border-blue-500 rounded-full overflow-hidden shadow-md">
        <?php while ($row = mysqli_fetch_assoc($res)) { ?>
            <img class="w-full h-full object-cover" src="../new profil/Images/<?php echo $row['photo']; ?>">
        <?php } ?>
      </div>
      <div>
        <h1 class="text-3xl font-bold text-gray-800"> <?php echo htmlspecialchars($stagiaire['prenom'] . " " . $stagiaire['nom']); ?></h1>
        <p class="text-lg text-gray-600"> <?php echo htmlspecialchars($stagiaire['institution']); ?></p>
        <p class="text-sm text-gray-500 italic">Année Universitaire : <?php echo htmlspecialchars($stagiaire['annee_universitaire']); ?></p>
      </div>
    </div>

    <!-- Informations Personnelles -->
    <div class="mt-6">
      <h2 class="text-xl font-semibold text-blue-700 mb-4">Informations personnelles</h2>
      <div class="grid grid-cols-2 gap-6">
        <div>
          <p class="text-sm text-gray-500">Prénom</p>
          <p class="text-lg font-medium text-gray-800"> <?php echo htmlspecialchars($stagiaire['prenom']); ?></p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Nom</p>
          <p class="text-lg font-medium text-gray-800"><?php echo htmlspecialchars($stagiaire['nom']); ?></p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Institution</p>
          <p class="text-lg font-medium text-gray-800"><?php echo htmlspecialchars($stagiaire['institution']); ?></p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Téléphone</p>
          <p class="text-lg font-medium text-gray-800"><?php echo htmlspecialchars($stagiaire['telephone']); ?></p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Email</p>
          <p class="text-lg font-medium text-gray-800"> <?php echo htmlspecialchars($stagiaire['email']); ?></p>
        </div>
        <div>
          <p class="text-sm text-gray-500">CIN</p>
          <p class="text-lg font-medium text-gray-800"><?php echo htmlspecialchars($stagiaire['cin']); ?></p>
        </div>
      </div>
    </div>

    <!-- Informations de Stage -->
    <div class="mt-6">
      <h2 class="text-xl font-semibold text-blue-700 mb-4">Informations sur le Stage</h2>
      <div class="grid grid-cols-2 gap-6">
        <div>
          <p class="text-sm text-gray-500">Spécialité Universitaire</p>
          <p class="text-lg font-medium text-gray-800"> <?php echo htmlspecialchars($stagiaire['specialite_universitaire']); ?></p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Niveau de Stage</p>
          <p class="text-lg font-medium text-gray-800"> <?php echo htmlspecialchars($stagiaire['niveau_de_stage']); ?></p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Date de Début</p>
          <p class="text-lg font-medium text-gray-800"> <?php echo htmlspecialchars($stagiaire['date_de_debut']); ?></p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Date de Fin</p>
          <p class="text-lg font-medium text-gray-800"> <?php echo htmlspecialchars($stagiaire['date_de_fin']); ?></p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Avec Binôme</p>
          <p class="text-lg font-medium text-gray-800"> <?php echo htmlspecialchars($stagiaire['avec_binome']); ?></p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Type de Stage</p>
          <p class="text-lg font-medium text-gray-800"> <?php echo htmlspecialchars($stagiaire['type_de_stage']); ?></p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Papiers Apportés</p>
          <p class="text-lg font-medium text-gray-800"> <?php echo htmlspecialchars($stagiaire['papiers_apportes']); ?></p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Copie CIN Apportée</p>
          <p class="text-lg font-medium text-gray-800"> <?php echo htmlspecialchars($stagiaire['copie_cin_apportee']); ?></p>
        </div>
      </div>
    </div>

    <!-- Boutons d'Actions -->
    <div class="mt-6 flex justify-end space-x-4">
      <a href="../php_page1.php" class="flex justify-center items-center py-2 px-4 rounded-full border-none bg-gray-100 text-gray-600 hover:bg-gray-200 transition">
        &#8592; Retour à l'accueil
      </a>
    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-gray-800 text-white text-center py-3 px-5 text-sm mt-6 w-full">
      &copy; 2025 Itqan. Tous droits réservés.
  </footer>
</body>
</html>