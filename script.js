$(document).ready(function() {
    // Initialiser DataTables
    $('#stagiairesTable').DataTable({
        "paging": true, // Activer la pagination
        "pageLength": 5, // Nombre de lignes par page
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.12.1/i18n/fr_fr.json" // URL pour les traductions en français
        }
    });

    // Gestion du bouton "Voir Détails"
    document.getElementById("voirDetails").addEventListener("click", function () {
        const ligneSelectionnée = document.querySelector('input[name="ligneSelectionnée"]:checked'); // Sélectionner la ligne cochée
        if (ligneSelectionnée) {
            const ligneId = ligneSelectionnée.value; // Récupérer l'ID de la ligne sélectionnée
            alert("Voir les détails de la ligne : " + ligneId); // Afficher une alerte avec l'ID de la ligne
            // Redirection ou action spécifique ici
        } else {
            alert("Veuillez sélectionner une ligne !"); // Alerte si aucune ligne n'est sélectionnée
        }
    });

    // Gestion du bouton "Modifier"
    document.getElementById("modifier").addEventListener("click", function () {
        const ligneSelectionnée = document.querySelector('input[name="ligneSelectionnée"]:checked'); // Sélectionner la ligne cochée
        if (ligneSelectionnée) {
            const ligneId = ligneSelectionnée.value; // Récupérer l'ID de la ligne sélectionnée
            alert("Modifier la ligne : " + ligneId); // Afficher une alerte avec l'ID de la ligne
            // Redirection ou action spécifique ici
        } else {
            alert("Veuillez sélectionner une ligne !"); // Alerte si aucune ligne n'est sélectionnée
        }
    });
});
