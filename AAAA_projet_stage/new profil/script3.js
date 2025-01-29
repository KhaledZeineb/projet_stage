document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('internshipForm');
    const sections = document.querySelectorAll('.form-section');
    const navButtons = document.querySelectorAll('.section-btn');
    const prevBtn = document.querySelector('.btn-prev');
    const nextBtn = document.querySelector('.btn-next');
    let currentSection = 0;

    function afficherSection(index) {
        // Afficher/masquer les sections
        sections.forEach((section, i) => {
            section.classList.toggle('hidden', i !== index);
        });

        // Activer/désactiver les boutons de navigation
        navButtons.forEach((btn, i) => {
            btn.classList.toggle('active', i === index);
        });

        // Gérer l'état des boutons "Précédent" et "Suivant"
        prevBtn.disabled = index === 0;

        if (index === sections.length - 1) {
            nextBtn.textContent = 'Soumettre';
            nextBtn.dataset.action = 'submit';
        } else {
            nextBtn.textContent = 'Suivant';
            nextBtn.dataset.action = 'next';
        }
    }

    // Navigation par boutons
    navButtons.forEach((button, index) => {
        button.addEventListener('click', () => {
            currentSection = index;
            afficherSection(currentSection);
        });
    });

    // Bouton "Précédent"
    prevBtn.addEventListener('click', () => {
        if (currentSection > 0) {
            currentSection--;
            afficherSection(currentSection);
        }
    });

    // Bouton "Suivant" ou "Soumettre"
    nextBtn.addEventListener('click', () => {
        const action = nextBtn.dataset.action;

        if (action === 'next' && currentSection < sections.length - 1) {
            currentSection++;
            afficherSection(currentSection);
        } else if (action === 'submit') {
            form.submit(); // Soumission manuelle du formulaire
        }
    });

    // Soumission du formulaire (uniquement depuis le bouton "Soumettre")
    form.addEventListener('submit', (e) => {
        e.preventDefault(); // Empêche la soumission par défaut
        if (currentSection === sections.length - 1) {
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());
            console.log('Formulaire soumis:', data);
            alert('Formulaire soumis avec succès!');
        }
    });

    // Initialiser la première section
    afficherSection(currentSection);
});
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