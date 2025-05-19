// Afficher le resume

function afficherLeResume () {
    console.log('resume');
    
    const formData = new FormData(formulaireTroc);
    
   const champs = {
    'type-troc': 'tuc-input-type',
    'categorie': 'tuc-input-categorie',
    'description': 'tuc-input-description',
    'nom': 'tuc-input-nom',
    'email': 'tuc-input-email',
    'tel': 'tuc-input-tel',
   }

   const champPhotos = document.getElementById('tuc-input-photos');

   const champDessinTitre = document.getElementById('tuc-input-dessin-titre');
   const champDessinImg = document.getElementById('tuc-input-dessin-img');

   // Vider les champs
   Object.values(champs).forEach(id => {
    const element = document.getElementById(id);
    element.textContent = '';
   })
   // Vider champ photos
   champPhotos.innerHTML = '';

   // Afficher les inputs
   Object.entries(champs).forEach(([label, id]) => {
    const element = document.getElementById(id); 
    let valeur = formData.get(label);

    element.textContent = valeur || 'Non renseigné';
   })
   
   // Afficher les photos
   photosUtilisateurs.slice(0, 3).forEach(photo => {
    const img = document.createElement('img');
    const lecteur = new FileReader();

    lecteur.onload = function (e) {
        img.src = e.target.result;
        champPhotos.appendChild(img);
    };
    
    lecteur.readAsDataURL(photo);
   });

   // Afficher le data dessin
   champDessinTitre.innerText = dataDessin.titreDessin;
   champDessinImg.src = dataDessin.imgDessin;
}