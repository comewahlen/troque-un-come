

function soumettreLeFormulaire(e) {
    e.preventDefault();
    soumissionProgress();

    const formData = new FormData(formulaireTroc);

    formData.append('action', 'traitement_formulaire_troc');
    formData.append('titre_dessin', dataDessin.titreDessin);

    // Ajout des photos utilisateur au formData
    photosUtilisateurs.forEach((photo) => {
        formData.append(`photos[]`, photo);
    })

    // Transmettre à php
    fetch(tuc_ajax.ajax_url, {
        method: "POST",
        body: formData
    })

        .then(response => response.json())
        .then(result => {

            // Traitement réponse
            if (result.success) {
                etapeCourante++;
                
                afficherEtapeResultat('succes');
                afficherLesBoutons(etapeCourante);
                afficherTexteEtape(etapeCourante, 'succes');
                progressRing.setStep(etapeCourante + 1, 'succes');

            } else {      
                etapeCourante++;
                
                afficherEtapeResultat('echec');
                afficherLesBoutons(etapeCourante);
                afficherTexteEtape(etapeCourante, 'echec');
                progressRing.setStep(etapeCourante + 1, 'echec');
            }
        })
        .catch(error => console.error('erreur ajax : ', error));

}