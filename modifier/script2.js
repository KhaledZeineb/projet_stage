document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('stagiaireForm');
    const sections = document.querySelectorAll('.form-section');
    const navButtons = document.querySelectorAll('.section-btn');
    const prevBtn = document.querySelector('.btn-prev');
    const nextBtn = document.querySelector('.btn-next');
    const submitBtn = document.querySelector('.btn-submit');
    let currentSection = 0;

    function validateSection(sectionIndex) {
        const section = sections[sectionIndex];
        const inputs = section.querySelectorAll('input:not([type="hidden"]):not([type="file"]), select');
        let isValid = true;
        let errorMessage = "Veuillez remplir les champs suivants:\n";

        inputs.forEach(input => {
            if (input.hasAttribute('required') && !input.value.trim()) {
                isValid = false;
                const label = input.previousElementSibling?.textContent || input.name;
                errorMessage += `- ${label}\n`;
            }
        });

        if (!isValid) {
            alert(errorMessage);
        }
        return isValid;
    }

    function afficherSection(index) {
        sections.forEach((section, i) => {
            section.classList.toggle('hidden', i !== index);
        });

        navButtons.forEach((btn, i) => {
            if (i === index) {
                btn.classList.add('active');
                btn.classList.remove('inactive');
            } else {
                btn.classList.add('inactive');
                btn.classList.remove('active');
            }
        });

        prevBtn.disabled = index === 0;

        // Gestion du bouton suivant/soumettre
        if (index === sections.length - 1) {
            nextBtn.classList.add('hidden');
            submitBtn.classList.remove('hidden');
        } else {
            submitBtn.classList.add('hidden');
            nextBtn.classList.remove('hidden');
        }
    }

    // Navigation par boutons
    navButtons.forEach((button, index) => {
        button.addEventListener('click', () => {
            if (validateSection(currentSection) || index < currentSection) {
                currentSection = index;
                afficherSection(currentSection);
            }
        });
    });

    // Bouton "Précédent"
    prevBtn.addEventListener('click', () => {
        if (currentSection > 0) {
            currentSection--;
            afficherSection(currentSection);
        }
    });

    // Bouton "Suivant"
    nextBtn.addEventListener('click', () => {
        if (validateSection(currentSection) && currentSection < sections.length - 1) {
            currentSection++;
            afficherSection(currentSection);
        }
    });

    // Gestion de la soumission du formulaire
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Valider toutes les sections
        let allValid = true;
        for (let i = 0; i < sections.length; i++) {
            if (!validateSection(i)) {
                allValid = false;
                currentSection = i;
                afficherSection(i);
                break;
            }
        }

        if (allValid) {
            this.submit();
        }
    });

    // Initialisation
    afficherSection(currentSection);
});