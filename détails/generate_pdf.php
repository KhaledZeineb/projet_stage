<?php
require '../vendor/autoload.php';

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$database = "mydb";
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Vérification si le paramètre CIN est présent
if (isset($_GET['cin'])) {
    $cin = $conn->real_escape_string($_GET['cin']);
    $query = "SELECT s.* FROM stagiaires s WHERE s.cin = '$cin'";
    $result = mysqli_query($conn, $query);
    $res = mysqli_query($conn, "SELECT * FROM photo_de_profile WHERE cin = '$cin'");

    if (mysqli_num_rows($result) > 0) {
        $stagiaire = mysqli_fetch_assoc($result);
        $photo = '';
        if (mysqli_num_rows($res) > 0) {
            $photoInfo = mysqli_fetch_assoc($res);
            $photo = $photoInfo['photo'];
        }
    } else {
        echo "Aucun stagiaire trouvé avec ce CIN.";
        exit;
    }
} else {
    echo "CIN manquant.";
    exit;
}

// Vérification de l'existence de la photo
$photoPath = '../new profil/Images/' . $photo;
if (!file_exists($photoPath) || empty($photo)) {
    $photoPath = '../new profil/Images/default.jpg';
}

// Création d'une instance TCPDF
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);


// Définition des informations du document
$pdf->SetCreator('Système de Gestion des Stagiaires');
$pdf->SetAuthor('Votre Nom');
$pdf->SetTitle('Profil du Stagiaire');
$pdf->SetSubject('Profil du Stagiaire');
$pdf->SetKeywords('Stagiaire, Profil, PDF');

// Suppression d'en-tête et pied de page par défaut
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Définition des marges (gauche, haut, droite)
$pdf->SetMargins(20, 20, 20);

// Définition de la police
$pdf->SetFont('helvetica', '', 10);

// Ajouter une page
$pdf->AddPage();

// Début du contenu
$html = '
<style>
    h1 {
        font-size: 18pt;
        font-weight: bold;
        color: #2D3748;
        margin: 0;
        padding: 0;
    }
    h2 {
        font-size: 14pt;
        font-weight: bold;
        color: #3182CE;
        border-bottom: 1px solid #3182CE;
        padding: 0;
        margin: 15px 0 10px 0;
    }
    .institution {
        font-size: 12pt;
        color: #2D3748;
        font-weight: bold;
        margin: 0;
        padding: 0;
    }
    .academic-year {
        font-size: 11pt;
        color: #4A5568;
        margin: 0;
        padding: 0;
        font-style: italic;
    }
    .info-label {
        font-size: 10pt;
        color: #718096;
        margin: 0;
        padding: 0;
    }
    .info-value {
        font-size: 11pt;
        font-weight: bold;
        color: #2D3748;
        margin: 0;
        padding: 0;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    td {
        padding: 5px 0;
        vertical-align: top;
    }
    .photo-container {
        text-align: center;
        padding-right: 25px;
    }
    .header-info {
        padding-left: 25px;
    }
    .section-spacer {
        height: 10px;
    }
</style>

<table>
    <tr>
        <td width="25%" class="photo-container">
            <!-- Photo placeholder - will be replaced with circular image -->
        </td>
        <td width="75%" class="header-info">
            <h1>' . htmlspecialchars($stagiaire['prenom'] . " " . $stagiaire['nom']) . '</h1>
            <p class="institution">' . htmlspecialchars($stagiaire['institution']) . '</p>
            <p class="academic-year">Année Universitaire : ' . htmlspecialchars($stagiaire['annee_universitaire']) . '</p>
        </td>
    </tr>
</table>

<div class="section-spacer"></div>
<div class="section-spacer"></div>

<h2>Informations personnelles</h2>
<table>
    <tr>
        <td width="50%">
            <p class="info-label">Prénom</p>
            <p class="info-value">' . htmlspecialchars($stagiaire['prenom']) . '</p>
        </td>
        <td width="50%">
            <p class="info-label">Nom</p>
            <p class="info-value">' . htmlspecialchars($stagiaire['nom']) . '</p>
        </td>
    </tr>
    <tr>
        <td>
            <p class="info-label">Institution</p>
            <p class="info-value">' . htmlspecialchars($stagiaire['institution']) . '</p>
        </td>
        <td>
            <p class="info-label">Téléphone</p>
            <p class="info-value">' . htmlspecialchars($stagiaire['telephone']) . '</p>
        </td>
    </tr>
    <tr>
        <td>
            <p class="info-label">Email</p>
            <p class="info-value">' . htmlspecialchars($stagiaire['email']) . '</p>
        </td>
        <td>
            <p class="info-label">CIN</p>
            <p class="info-value">' . htmlspecialchars($stagiaire['cin']) . '</p>
        </td>
    </tr>
</table>

<div class="section-spacer"></div>

<h2>Informations sur le Stage</h2>
<table>
    <tr>
        <td width="50%">
            <p class="info-label">Spécialité Universitaire</p>
            <p class="info-value">' . htmlspecialchars($stagiaire['specialite_universitaire']) . '</p>
        </td>
        <td width="50%">
            <p class="info-label">Niveau de Stage</p>
            <p class="info-value">' . htmlspecialchars($stagiaire['niveau_de_stage']) . '</p>
        </td>
    </tr>
    <tr>
        <td>
            <p class="info-label">Date de Début</p>
            <p class="info-value">' . htmlspecialchars($stagiaire['date_de_debut']) . '</p>
        </td>
        <td>
            <p class="info-label">Date de Fin</p>
            <p class="info-value">' . htmlspecialchars($stagiaire['date_de_fin']) . '</p>
        </td>
    </tr>
    <tr>
        <td>
            <p class="info-label">Avec Binôme</p>
            <p class="info-value">' . htmlspecialchars($stagiaire['avec_binome']) . '</p>
        </td>
        <td>
            <p class="info-label">Type de Stage</p>
            <p class="info-value">' . htmlspecialchars($stagiaire['type_de_stage']) . '</p>
        </td>
    </tr>
    <tr>
        <td>
            <p class="info-label">Papiers Apportés</p>
            <p class="info-value">' . htmlspecialchars($stagiaire['papiers_apportes']) . '</p>
        </td>
        <td>
            <p class="info-label">Copie CIN Apportée</p>
            <p class="info-value">' . htmlspecialchars($stagiaire['copie_cin_apportee']) . '</p>
        </td>
    </tr>
</table>
';

// Ajouter le contenu HTML
$pdf->writeHTML($html, true, false, true, false, '');

// Ajout de l'image en cercle
// Pour créer une image circulaire, nous devons la traiter avant de l'insérer
// Nous utiliserons les méthodes de TCPDF pour dessiner un cercle et y placer l'image
$x = 30;  // Position X du centre du cercle
$y = 40;  // Position Y du centre du cercle
$radius = 20;  // Rayon du cercle


// Ajouter l'image au-dessus
$pdf->Image($photoPath, $x - $radius, $y - $radius, $radius * 2, $radius * 2, '', '', '', false, 300, '', false, false, 0, false, false, false);




// Fermer et sortir le document PDF
$pdf->Output('profil_stagiaire.pdf', 'D');
$conn->close();
?>