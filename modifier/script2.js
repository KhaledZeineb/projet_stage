document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('internshipForm');
    const sections = document.querySelectorAll('.form-section');
    const navButtons = document.querySelectorAll('.section-btn');
    const prevBtn = document.querySelector('.btn-prev');
    const nextBtn = document.querySelector('.btn-next');
    let currentSection = 0;

    // Fonction de validation pour chaque section
    function validateSection(sectionIndex) {
        const section = sections[sectionIndex];
        const inputs = section.querySelectorAll('input, select');
        let isValid = true;
        let errorMessage = "Veuillez remplir les champs suivants:\n";

        inputs.forEach(input => {
            if (input.hasAttribute('required') && !input.value.trim()) {
                isValid = false;
                errorMessage += `- ${input.previousElementSibling.textContent}\n`;
            }

            // Validations spécifiques
            if (input.id === 'email' && input.value) {
                if (!input.value.includes('@') || !input.value.includes('.')) {
                    isValid = false;
                    errorMessage += "- Format d'email invalide\n";
                }
            }
            if (input.id === 'telephone' && input.value) {
                if (input.value.length !== 8 || isNaN(input.value)) {
                    isValid = false;
                    errorMessage += "- Le numéro de téléphone doit contenir 8 chiffres\n";
                }
            }
            if (input.id === 'cin' && input.value) {
                if (input.value.length !== 8 || isNaN(input.value)) {
                    isValid = false;
                    errorMessage += "- Le numéro CIN doit contenir 8 chiffres\n";
                }
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
            btn.classList.toggle('active', i === index);
        });

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
            if (validateSection(currentSection)) {
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

    // Bouton "Suivant" ou "Soumettre"
    nextBtn.addEventListener('click', () => {
        const action = nextBtn.dataset.action;

        if (action === 'next') {
            if (validateSection(currentSection) && currentSection < sections.length - 1) {
                currentSection++;
                afficherSection(currentSection);
            }
        } else if (action === 'submit') {
            if (validateSection(currentSection)) {
                form.submit();
            }
        }
    });

    // Soumission du formulaire
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        if (!validateSection(currentSection)) {
            return;
        }
        
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        console.log('Formulaire soumis:', data);
        
        // Ici vous pouvez ajouter votre logique de soumission
        form.submit();
    });

    // Initialiser la première section
    afficherSection(currentSection);
});