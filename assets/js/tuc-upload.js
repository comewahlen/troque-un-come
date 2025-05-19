
// Gestion des upload img utilisateur
const input = document.getElementById('ajouter-photos');
const apercu = document.getElementById('tuc-apercu');

input.addEventListener('change', function () {
    const photos = Array.from(this.files);
    
    photos.forEach(photo => {
        if (photosUtilisateurs.length < 10) {
            const lecteur = new FileReader();
            /* const index = photosTroc.push(photo) - 1; */
    
            lecteur.onload = function (e) {
                const img = document.createElement('img');
                img.src = e.target.result;

                photosUtilisateurs.push(photo);
                
                // Ajouter img au conteneur aperçu
                const imgContainer = document.createElement('div');
                imgContainer.className = "tuc-img-preview";
                imgContainer.appendChild(img);
    
                // Bouton de suppression
                const deleteBtn = document.createElement('i');

                deleteBtn.className = 'tuc-btn-supprimer-img bi bi-x-circle-fill';
                
                deleteBtn.addEventListener('click', () => {
                    photosUtilisateurs = photosUtilisateurs.filter(p => p !== photo);
                    imgContainer.remove();   
                });
    
                imgContainer.appendChild(deleteBtn);
                apercu.appendChild(imgContainer);
            };
    
            lecteur.readAsDataURL(photo);
        } else {
            alert('Maximum 10 photos !');
        }
    });
});
