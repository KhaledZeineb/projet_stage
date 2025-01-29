$(document).ready(function() {
    // Initialiser DataTables
    $('#stagiairesTable').DataTable({
        "paging": true,
        "pageLength": 5,
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.12.1/i18n/fr_fr.json"
        }
    });

    // Gestion du bouton "Voir Détails"
    document.getElementById("voirDetails").addEventListener("click", function () {
        const ligneSelectionnée = document.querySelector('input[name="ligneSelectionnée"]:checked');
        if (ligneSelectionnée) {
            const ligneId = ligneSelectionnée.value;
            alert("Voir les détails de la ligne : " + ligneId);
            // Redirection ou action spécifique ici
        } else {
            alert("Veuillez sélectionner une ligne !");
        }
    });

    // Gestion du bouton "Modifier"
    document.getElementById("modifier").addEventListener("click", function () {
        const ligneSelectionnée = document.querySelector('input[name="ligneSelectionnée"]:checked');
        if (ligneSelectionnée) {
            const ligneId = ligneSelectionnée.value;
            alert("Modifier la ligne : " + ligneId);
            // Redirection ou action spécifique ici
        } else {
            alert("Veuillez sélectionner une ligne !");
        }
    });
});
