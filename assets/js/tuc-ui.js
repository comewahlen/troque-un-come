// Afficher les boutons
function afficherLesBoutons(index) {
    const boutons = document.querySelectorAll('.tuc-bouton');
    
    boutons.forEach(bouton => {
        if (bouton.id !== etapesFormulaire[index].bouton) {
            bouton.style.display = "none";
        } else if (index === 0) {
            bouton.style.display= "flex";
        } else {
            bouton.style.display = "flex";
        }
    })
}

// Afficher une étape
function afficherEtape(index) {
    const etapesDom = document.querySelectorAll('.etape');
    
    etapesDom.forEach(etapeDom => {
        if (etapeDom.id === etapesFormulaire[index].dom) {
           etapeDom.classList.add('active'); 
        } else {
            etapeDom.classList.remove('active');
        }
    })
}

// Afficher la dernière étape selon le résultat de soumission du formulaire
function afficherEtapeResultat(resultat) {
    const succes = document.getElementById('tuc-etape-resultat-succes');
    const echec = document.getElementById('tuc-etape-resultat-echec');

    console.log('resultat');
    

    if (resultat === 'succes') {
        succes.classList.add('active');
        echec.style.display = 'none';
    } else {
        echec.classList.add('active');
        succes.style.display = 'none';
    }

    afficherEtape(etapeCourante);
}

// Afficher les textes d'une étape 
function afficherTexteEtape(index, resultat) {

    const etape = etapesFormulaire[index];
    const etapeAffichee = document.getElementById(etapesFormulaire[index].dom);
    
    afficherLeTitre(etape, resultat);
    afficherLesConsignes(etape, etapeAffichee);
}

// Afficher le titre d'une étape selon le type de troc
function afficherLeTitre(etape, resultat) {
    const titreEtape = document.getElementById('texte-etape');
    const titresData = etape.titre;

    if (Array.isArray(titresData) && !resultat) {
        const texteTitre = donnees['type-troc'] === 'troc-objet'
            ? titresData[0]
            : titresData[1];
        
        titreEtape.textContent = texteTitre;
    } else if (Array.isArray(titresData) && resultat) {
        const texteTitre = resultat === 'succes'
            ? titresData[0]
            : titresData[1];
        titreEtape.textContent = texteTitre;
    } else {
        titreEtape.textContent = titresData;
    }

}

// Afficher les consignes selon type de troc et d'input
function afficherLesConsignes(etape, etapeDom) {
    
    const consignes = etapeDom.querySelectorAll('.consigne');
    const consigneData = etape.consigne;

    if (!consignes.length || !consigneData) return;

    if (Array.isArray(consigneData)) {
        const texeConsigne = donnees['type-troc'] === 'troc-objet'
            ? consigneData[0]
            : consigneData[1];

        consignes[0].textContent = texeConsigne;

    
    } else if (typeof consigneData === 'object' && !Array.isArray(consigneData)) {
        consignes.forEach(consigne => {
            const champ = consigne.dataset.for;
            consigne.textContent = consigneData[champ];
        })
    } else {
        consignes.forEach(consigne => consigne.textContent = consigneData);
    }

}

// Afficher les erreurs selon les champs invalides
function afficherLesErreurs(index, erreurs, champId) {
    const etape = etapesFormulaire[index];
    /* const etapeAffichee = document.getElementById(etape.dom); */
    /* const erreurs = etapeAffichee.querySelectorAll('.consigne'); */
    const erreursData = etape.erreur;

    if (Array.isArray(erreursData)) {
        const texteErreur = donnees['type-troc'] === 'troc-objet'
            ? erreursData[0]
            : erreursData[1];

        erreurs.textContent = texteErreur;

    } else if (typeof erreursData === 'string') {
        erreurs.textContent = erreursData;
    
    } else {
        erreurs.textContent = erreursData[champId];
    }
}

function resetLesErreurs() {
    const erreursTxt = document.querySelectorAll('.tuc-champs-obligatoires-consigne');
    const erreursChamp = document.querySelectorAll('.tuc-champs-obligatoires-box');
    erreursTxt.forEach(erreur => {erreur.classList.remove('tuc-champs-obligatoires-consigne')});
    erreursChamp.forEach(erreur => {erreur.classList.remove('tuc-champs-obligatoires-box')});
}
// Afficher les catégories à l'étape 3
function afficherCategories(donnees) {
 
    let categorie = donnees['type-troc'] === 'troc-objet' ? dataCategoriesTroc.objet : dataCategoriesTroc.service;
    const container = document.getElementById('tuc-etape-categorie');
    const consigne = document.createElement('p');

    container.innerHTML = "";

    consigne.innerText = categorie.consigne;
    consigne.className = "consigne";
    container.appendChild(consigne);

    categorie.options.forEach(option => {
        const wrapper = document.createElement('div');
        
        let id = option.value
        let name = "categorie";
        let placeholder = option.aide;
        
        wrapper.classList.add("elementCategorie");

        wrapper.innerHTML = `
            <input class="tuc-radio-input" type="radio" name="${name}" id="${id}" value="${id}" required>
            <label class="tuc-radio-label small" for="${id}">
                <i class="${option.icon}"></i>
                <span>${option.label}</span>
            </label>
        `;

        wrapper.querySelector('input').addEventListener ('change', modifierPlaceholder(placeholder));
        
        container.appendChild(wrapper);
    }) 
}

// Changer le texte du placeholder description en fonction du choix étape 3
function modifierPlaceholder(placeholder) {

    const description = document.getElementById('description');

    description.placeholder = "Par exemple : " + placeholder;
}