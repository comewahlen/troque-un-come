
function validationChampsObligatoires() {
    const etapeAvalider = document.getElementById(etapesFormulaire[etapeCourante].dom); 
    const champsObligatoires = etapeAvalider.querySelectorAll('[required]');
 
    let estValide = true;
    
    champsObligatoires.forEach(champ => {
        const inputs = document.querySelector(`[id="${champ.id}"]`);

        // RADIOS
        if (champ.type === 'radio') {
            const consigne = etapeAvalider.querySelector('.consigne');
            
            // FALSE
            if (!document.querySelector(`input[name="${champ.name}"]:checked`)) {
                estValide = false;
                consigne.classList.add('tuc-champs-obligatoires-consigne');
                afficherLesErreurs(etapeCourante, consigne);
                
                // TRUE
            } else {
                consigne.classList.remove('tuc-champs-obligatoires-consigne');
                
            }
            
            // PHOTOS
        } else if (champ.type === 'file') {
            const consigne = etapeAvalider.querySelector('.consigne');
            
            // FALSE
            if (photosUtilisateurs.length === 0) {
                estValide = false;
                consigne.classList.add('tuc-champs-obligatoires-consigne');
                afficherLesErreurs(etapeCourante, consigne);


            // TRUE    
            } else {
                consigne.classList.remove('tuc-champs-obligatoires-consigne');

            }

        // TEXTAREA / TEXT / EMAIL
        } else {
            const consigne = document.querySelector(`.consigne[data-for="${champ.id}"]`);

            // EMAIL
            if (champ.type === 'email') {

                // FALSE
                if (!verifierEmail(champ.value)){
                    estValide = false;
                    inputs.classList.add('tuc-champs-obligatoires-box');
                    consigne.classList.add('tuc-champs-obligatoires-consigne');
                    afficherLesErreurs(etapeCourante, consigne, champ.id);


                // TRUE    
                } else {
                    inputs.classList.remove('tuc-champs-obligatoires-box');
                    consigne.classList.remove('tuc-champs-obligatoires-consigne');
                }

            // FALSE    
            } else if (!champ.value.trim()) {
                estValide = false;
                inputs.classList.add('tuc-champs-obligatoires-box');
                consigne.classList.add('tuc-champs-obligatoires-consigne');
                afficherLesErreurs(etapeCourante, consigne, champ.id);


            // TRUE
            } else {
                inputs.classList.remove('tuc-champs-obligatoires-box');
                consigne.classList.remove('tuc-champs-obligatoires-consigne');
            }
        }
    })

    return estValide;
}

// Vérifier les emails
function verifierEmail(email) {
    const regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    return regex.test(email);
}