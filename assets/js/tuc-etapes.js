const etapeCommencer = {
    dom: 'tuc-etape-commencer',
    titre: "Vous êtes sur le point de proposer un troc.",
    bouton: "btn-commencer"
}
const etapeTypeTroc = {
    dom: 'tuc-etape-type-troc',
    titre: "Nous sommes tous riches de quelque chose.",
    consigne: "Quel type de troc poposez-vous ?",
    erreur: "Veuillez sélectionner un type de troc.",
    bouton: "btns-navigation"
}
const etapeCategorie = {
    dom: 'tuc-etape-categorie',
    titre: ["Dites m'en plus... Quel type d'objet proposez-vous ?", "Dites m'en plus... Quel type de service proposez-vous ?"],
    consigne: ["À quelle catégorie appartient votre objet ?", "À quelle catégorie appartient votre service ?"],
    erreur: ["Veuillez sélectionner une catégorie d'objet.", "Veuillez sélectionner une catégorie de service."],
    bouton: "btns-navigation"
}
const etapePhoto = {
    dom: 'tuc-etape-photo',
    titre: "Intéressant, une photo ?",
    consigne: ["Ajoutez une photo de votre objet :", "Ajoutez une photo liée à votre service :"],
    erreur: "Veuillez joindre une photo pour continuer.",
    bouton: "btns-navigation"
}
const etapeDescription = {
    dom: 'tuc-etape-description',
    titre: "Il me faut quelques précisions.",
    consigne: ["Décrivez votre objet :", "Décrivez votre service :"],
    erreur: "Votre description manque de détails !",
    bouton: "btns-navigation"
}
const etapeContact = {
    dom: 'tuc-etape-contact',
    titre: "Excellent ! Comment vous recontacter ?",
    consigne: {
        global: "Entrez vos informations de contact :",
        nom: "Prénom Nom",
        email: "E-mail",
        tel: "Téléphone"
    },
    erreur: {
        nom: "Veuillez indiquer votre nom",
        email: "Cet e-mail n'est pas valide",
        tel: "Veuillez indiquer un numéo de téléphone"
    },
    bouton: "btns-navigation"
}
const etapeResume = {
    dom: 'tuc-etape-resume',
    titre: "Résumons...",
    bouton: "btns-submit"
}
const etapeFinale = {
    dom: 'tuc-etape-finale',
    titre: ["Merci, votre proposition a bien été reçue !", "Il y'a un problème"],
    bouton: "btns-accueil"
}


let etapesFormulaire = [etapeCommencer, etapeTypeTroc, etapeCategorie]


// Formater le formulaire en fonction du type de troc choisi
function formaterForumulaireSelonTypeTroc() {
    ordreEtapesSelontTypeTroc();
    textesEtapesSelonTypeTroc();
    champsRequisSelonTypeTroc();
}

// Changer l'ordre des étapes en fonction du type de troc choisi
function ordreEtapesSelontTypeTroc() {
    if (donnees['type-troc'] === 'troc-objet') {
        etapesFormulaire = [etapeCommencer, etapeTypeTroc, etapeCategorie, etapePhoto, etapeDescription, etapeContact, etapeResume, etapeFinale];
    } else if (donnees['type-troc'] === 'troc-service') {
        etapesFormulaire = [etapeCommencer, etapeTypeTroc, etapeCategorie, etapeDescription, etapePhoto, etapeContact, etapeResume, etapeFinale];
    } else {
        console.log('Problème type formulaire');    
    }
}

// Changer les textes en fonction du type de troc choisi
function textesEtapesSelonTypeTroc () {
    if (donnees['type-troc'] === 'troc-objet') {
        etapeCategorie.texte = etapeCategorie.texteObjet;
    } else if (donnees['type-troc'] === 'troc-service') {
        etapeCategorie.texte = etapeCategorie.texteService;
    } else {
        console.log('Problème type formulaire');    
    }
}

// Changer les champs requis en fonction du type de troc choisi
function champsRequisSelonTypeTroc () {

    const champPhotos = document.getElementById('ajouter-photos');

    if (donnees['type-troc'] === 'troc-objet') {
        champPhotos.required = true;
    } else if (donnees['type-troc'] === 'troc-service') {
        champPhotos.required = false;
    } else {
        console.log('Problème type formulaire');    
    }
} 