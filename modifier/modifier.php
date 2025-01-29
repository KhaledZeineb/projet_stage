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
        $query = "SELECT * FROM stagiaires WHERE cin = '$cin';";
        $result = mysqli_query($conn, $query);

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
    $res = mysqli_query($conn, "SELECT * FROM photo_de_profile WHERE cin = '$cin'");
    
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Stagiaire</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="itaqn logo.webp">
    <style>
        .section-btn.active {
            background-color: #6b46c1; /* Couleur de fond active (purple-600) */
            color: #ffffff; /* Texte blanc */
        }

        .section-btn.inactive {
            background-color: #ffffff; /* Fond blanc */
            color: #6b46c1; /* Texte purple-600 */
        }

        .section-btn:hover {
            transform: scale(1.05);
        }

        .btn-next, .btn-prev {
            transition: background-color 0.3s, transform 0.3s;
        }

        .btn-next:hover:not(:disabled),
        .btn-prev:hover:not(:disabled) {
            transform: scale(1.05);
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-purple-100 to-blue-100 p-6 flex flex-col items-center justify-center">
    <!-- ... -->
    <header class="bg-gray-800 py-6 px-8 flex items-center justify-between shadow-md fixed top-0 z-50 w-full">
        <!-- Logo centré -->
        <div class="absolute left-1/2 transform -translate-x-1/2 h-20 w-20 rounded-full bg-white flex items-center justify-center shadow-lg">
            <img src="../logo.png" alt="Logo Itqan" class="w-16 h-16 object-contain p-1" />
        </div>

        <!-- Formulaire de déconnexion à droite -->
        <form action="../login/logout.php" method="POST" class="ml-auto">
            <button type="submit" 
                class="bg-red-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-red-600 transition">
                Déconnexion
            </button>
        </form>
    </header>
    <form action="update.php" method="POST" enctype="multipart/form-data" class="pt-32" >
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg mb-12">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-purple-600 to-blue-600 text-white text-center py-6 rounded-t-lg">
            <h1 class="text-2xl font-bold mb-4">Modifier les Informations du Stagiaire</h1>
            <div class="flex flex-wrap justify-center gap-4">
                <button type="button" class="section-btn flex items-center gap-2 px-4 py-2 rounded-full bg-white text-purple-600 hover:scale-105 shadow-md transition" data-section="0">
                    <span>Informations Personnelles</span>
                </button>
                <button type="button" class="section-btn flex items-center gap-2 px-4 py-2 rounded-full bg-white text-purple-600 hover:scale-105 shadow-md transition" data-section="1">
                    <span>Informations Académiques</span>
                </button>
                <button type="button" class="section-btn flex items-center gap-2 px-4 py-2 rounded-full bg-white text-purple-600 hover:scale-105 shadow-md transition" data-section="2">
                    <span>Détails du Stage</span>
                </button>
                <button type="button" class="section-btn flex items-center gap-2 px-4 py-2 rounded-full bg-white text-purple-600 hover:scale-105 shadow-md transition" data-section="3">
                    <span>Informations de Contact</span>
                </button>
                <button type="button" class="section-btn flex items-center gap-2 px-4 py-2 rounded-full bg-white text-purple-600 hover:scale-105 shadow-md transition" data-section="4">
                    <span>Documents</span>
                </button>
                <button type="button" class="section-btn flex items-center gap-2 px-4 py-2 rounded-full bg-white text-purple-600 hover:scale-105 shadow-md transition" data-section="5">
                    <span>Type de Stage</span>
                </button>
                <button type="button" class="section-btn flex items-center gap-2 px-4 py-2 rounded-full bg-white text-purple-600 hover:scale-105 shadow-md transition" data-section="6">
                    <span>photo de profil</span>
                </button>
                                
            </div>
            <a href="../php_page1.php" class="inline-block mt-4 text-white underline">&larr; Retour à l'accueil</a>
        </div>

        <!-- Card Content -->
        <div class="p-6">
            <form id="stagiaireForm">
                <!-- Section 1: Personal Information -->
                <div class="form-section" data-section="0">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Prénom</label>
                            <input type="text" name="prénom" value="<?php echo htmlspecialchars($stagiaire['prenom']); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nom</label>
                            <input type="text" name="nom" value="<?php echo htmlspecialchars($stagiaire['nom']); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        </div>
                    </div>
                </div>


                <!-- Section 2: Academic Information -->
                <div class="form-section hidden" data-section="1">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Institution (Université)</label>
                            <input type="text" name="institution" value="<?php echo htmlspecialchars($stagiaire['institution']); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Année Universitaire</label>
                            <input type="text" name="anneeUniversitaire" value="<?php echo htmlspecialchars($stagiaire['annee_universitaire']); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Niveau de Stage</label>
                            <select name="Niveau_de_Stage" id="Niveau_de_Stage" class="block w-full px-2 py-1 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="<?php echo htmlspecialchars($stagiaire['niveau_de_stage']); ?>"><?php echo htmlspecialchars($stagiaire['niveau_de_stage']); ?></option>
                                <option value="1ère année licence">1ère année licence</option>
                                <option value="2ème année licence">2ème année licence</option>
                                <option value="3ème année licence">3ème année licence</option>
                                <option value="1ère année master">1ère année master</option>
                                <option value="2ème année master">2ème année master</option>
                                <option value="1ère année cycle d'ingénieur">1ère année cycle d'ingénieur</option>
                                <option value="2ème année cycle d'ingénieur">2ème année cycle d'ingénieur</option>
                                <option value="3ème année cycle d'ingénieur">3ème année cycle d'ingénieur</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Spécialité Universitaire</label>
                            <input type="text" name="specialite" value="<?php echo htmlspecialchars($stagiaire['specialite_universitaire']); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        </div>
                    </div>
                </div>

                <!-- Section 3: Internship Details -->
                <div class="form-section hidden" data-section="2">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date de Début</label>
                            <input type="date" name="dateDebut" vlaue="<?php echo htmlspecialchars($stagiaire['date_de_debut']); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date de Fin</label>
                            <input type="date" name="dateFin" value="<?php echo htmlspecialchars($stagiaire['date_de_fin']); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Avec Binôme (Nom / Prénom)</label>
                        <input type="text" name="binome" value="<?php echo htmlspecialchars($stagiaire['avec_binome']); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                    </div>
                </div>

                <!-- Section 4: Contact Information -->
                <div class="form-section hidden" data-section="3">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">CIN</label>
                            <input type="text" name="cin" value="<?php echo htmlspecialchars($stagiaire['cin']); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Téléphone</label>
                            <input type="tel" name="telephone" value="<?php echo htmlspecialchars($stagiaire['telephone']); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" value="<?php echo htmlspecialchars($stagiaire['email']); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        </div>
                    </div>
                </div>

                <!-- Section 5: Documents -->
                    <div class="form-section hidden" data-section="4">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Papiers apportés</label>
                                <select name="papiers_apportés" id="papiers_apportés">
                                    <option value="oui">oui</option>
                                    <option value="non">non</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Copie CIN apportée</label>
                                <select name="copie_cin_apportée" id="copie_cin_apportée">
                                    <option value="oui">oui</option>
                                    <option value="non">non</option>
                                </select>
                            </div>
                        </div>
                    </div>
                <!-- Section 6: Internship Type -->
                <div class="form-section hidden" data-section="5">
                    <div class="space-y-4">
                        <label class="block text-sm font-medium text-gray-700">type de stage</label>
                        <select name="type_de_stage" id="type_de_stage">
                            <option value="En présentiel">En présentiel</option>
                            <option value="A distance">A distance</option>
                        </select>
                    </div>
                   
                </div>
                <!-- Section 7: Profile Picture -->
                <div class="form-section hidden" data-section="6">
                    <div class="space-y-4">
                        <label class="block text-sm font-medium text-gray-700">Photo de profil</label>
                        <?php while ($row = mysqli_fetch_assoc($res)) { ?>
                        <img class="w-32 h-32 object-cover rounded-full border border-gray-300" src="../new profil/Images/<?php echo $row['photo']; ?>">
                        <?php } ?>
                        <label class="block text-sm font-medium text-gray-700 mt-4">Nouvelle photo de profil</label>
                        <input type="file" name="image" id="image" class="block w-full text-sm text-gray-500 border border-gray-300 rounded-md cursor-pointer focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex justify-between mt-8">
                    <button type="button" class="btn-prev px-4 py-2 bg-gray-400 text-white rounded-lg disabled:opacity-50 disabled:cursor-not-allowed" disabled>Précédent</button>
                    <button type="button" class="btn-next px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">Suivant</button>
                    <button type="submit" class="btn-submit px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 hidden">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
     <!-- Footer -->
  <footer class="bg-gray-800 text-white text-center py-3 px-5 text-sm w-full fixed bottom-0">
    &copy; 2025 Itqan. Tous droits réservés.
</footer>
    <script src="script2.js"></script>
    </form>
</body>
</html>
