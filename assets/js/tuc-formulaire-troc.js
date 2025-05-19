

const formulaireTroc = document.getElementById('formulaire-troc');
let donnees = {};
let photosUtilisateurs = [];
let etapeCourante = 0;

// Lancement
document.addEventListener('DOMContentLoaded', () => {
    initialiserFormulaireTroc();
    initialiserNavigation();
    enregistrerLesDonneesUtilisateur();
    chargerCategoriesJson();
})

// Initialiser le formulaire
function initialiserFormulaireTroc() {
    formulaireTroc.addEventListener('submit', soumettreLeFormulaire);

    // Empecher la soumission avec enter
    formulaireTroc.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' && e.target.tagName !== 'TEXTAREA') {
            e.preventDefault();
        }
    })

    afficherEtape(etapeCourante);
    afficherTexteEtape(etapeCourante);
    afficherLesBoutons(etapeCourante);
}

// Navigation
function initialiserNavigation() {
    const boutonsSuivant = document.querySelectorAll('.btn-suivant');
    const boutonPrecedent = document.querySelectorAll('.btn-retour');
    
    boutonsSuivant.forEach(bouton=> {
        bouton.addEventListener('click', () => {
            
            if (!validationChampsObligatoires()) {
                return;
            }
        
            if (etapeCourante === 1) {
                formaterForumulaireSelonTypeTroc(donnees);
                afficherCategories(donnees);
            } else if (etapeCourante === 5) {
                afficherLeResume();
                console.log("appel resume");
                
            }
    
        
            etapeCourante++;
            
            afficherEtape(etapeCourante);
            afficherTexteEtape(etapeCourante);
            afficherLesBoutons(etapeCourante);
            progressRing.setStep(etapeCourante + 1);
        })
        
    });
    
    boutonPrecedent.forEach(bouton => {
        bouton.addEventListener('click', () =>{
            etapeCourante--;
        
            afficherEtape(etapeCourante);
            afficherTexteEtape(etapeCourante);
            afficherLesBoutons(etapeCourante);
            resetLesErreurs();
            progressRing.setStep(etapeCourante + 1);
        });
    });
}

// Enregistrer les données utilisateur au fur et a mesure 
function enregistrerLesDonneesUtilisateur(params) {
    document.querySelectorAll('input, textarea').forEach(champ => {
        champ.addEventListener('change', () => {
            donnees[champ.name] = champ.value;    
        })
    });
}

// Récupérer data JSON
function chargerCategoriesJson() {
    fetch(tuc_data.jsonUrl)
        .then(response => response.json())
        .then(data => {
            dataCategoriesTroc = data;   
        });
}










