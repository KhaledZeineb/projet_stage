document.addEventListener('DOMContentLoaded', function () {
    const sections = document.querySelectorAll('.form-section');
    const prevBtn = document.querySelector('.btn-prev');
    const nextBtn = document.querySelector('.btn-next');
    const submitBtn = document.querySelector('.btn-submit');
    const navButtons = document.querySelectorAll('[data-section]'); // Boutons avec l'attribut data-section
    let currentSection = 0;

    // Fonction pour afficher une section
    function showSection(index) {
        sections.forEach((section, idx) => {
            section.classList.toggle('hidden', idx !== index);
        });

        // Met à jour les états des boutons de navigation
        navButtons.forEach((btn, idx) => {
            btn.classList.toggle('bg-indigo-800', idx === index); // Met en surbrillance le bouton actif
        });

        // Gère l'affichage des boutons Précédent, Suivant et Soumettre
        prevBtn.disabled = index === 0;
        nextBtn.classList.toggle('hidden', index === sections.length - 1);
        submitBtn.classList.toggle('hidden', index !== sections.length - 1);
    }

    // Gestion des clics sur les boutons de navigation
    navButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const sectionIndex = parseInt(button.getAttribute('data-section'), 10);
            currentSection = sectionIndex;
            showSection(currentSection);
        });
    });

    // Gestion des clics sur le bouton "Précédent"
    prevBtn.addEventListener('click', () => {
        if (currentSection > 0) currentSection--;
        showSection(currentSection);
    });

    // Gestion des clics sur le bouton "Suivant"
    nextBtn.addEventListener('click', () => {
        if (currentSection < sections.length - 1) currentSection++;
        showSection(currentSection);
    });

    // Affiche la première section au chargement
    showSection(currentSection);
});
//for test
function valid(){

// Event listener for form submission

  // Input elements
  const prenom = document.getElementById("prenom");
  const nom = document.getElementById("nom");
  const institution = document.getElementById("institution");
  const anneeUniversitaire = document.getElementById("anneeUniversitaire");
  const niveauStage = document.getElementById("niveauStage");
  const spun = document.getElementById("spun");
  const email = document.getElementById("email");
  const telephone = document.getElementById("telephone");
  const cin = document.getElementById("cin");

  // Error messages
  const prenomError = document.getElementById("prenomError");
  const nomError = document.getElementById("nomError");
  const niveauStageError = document.getElementById("niveauStageError");
  const emailError = document.getElementById("emailError");
  const telephoneError = document.getElementById("telephoneError");

  let isValid = true;

  // Validation logic
  if (prenom.value.trim() === "") {
    alert("completer tout les  champs")
    return false;
    
  } 
  if (spun.value.trim() === "") {
    alert("completer tout les  champs")
    return false;
  } 
  if (nom.value.trim() === "") {
    alert("completer tout les  champs")
    return false;
  } 

  if (niveauStage.value === "") {
    alert("completer tout les  champs")
    return false;
  }

  if (!email.value.includes("@") || !email.value.includes(".")) {
    alert("completer tout les  champs")
    return false;
  } 
  

  if (telephone.value.length !=8  && Number(telephone) ) {
    alert("completer tout les  champs")
    return false;
  }
  if (cin.value.length !=8  && Number(cin) ) {
    alert("completer tout les  champs")
    return false;
  }
  return true

}