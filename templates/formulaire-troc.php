<?php
/**
 * Template HTML du formulaire de troc en 8 étapes
 */
 defined('ABSPATH') or die(':-)');
?>

<!-- Formulaire HTML en 8 étapes -->
 <form  method="post" enctype="multipart/form-data" id="formulaire-troc" novalidate>

    <!-- 1. Commencer -->
    <div class="etape" data-etape="1" id="tuc-etape-commencer">
        <div>
            <img id="tuc-dessin-troc" src="<?php echo esc_url($url_dessin ?? ''); ?>" alt="">
        </div>
        <div id="tuc-description-dessin">
            <h4><?php echo esc_html($nom_dessin); ?></h4>
            <p><?php echo wp_kses_post($description_dessin); ?></p>
        </div>
    </div>
    
    <!-- 2. Type de troc -->
    <div class="etape" data-etape="2" id="tuc-etape-type-troc">
        <p class="consigne" data-for="type-troc">Choisir un type de troc :</p>
            <input class="tuc-radio-input" type="radio" name="type-troc" id="type-troc-objet" value="troc-objet" required>
            <label class="tuc-radio-label large" for="type-troc-objet" class="">
                <i class="bi bi-box-seam"></i>
                <span>Je propose un objet</span>
            </label>
            <input class="tuc-radio-input" type="radio" name="type-troc" id="type-troc-service" value="troc-service" required>
            <label class="tuc-radio-label large" for="type-troc-service" class="">
                <i class="bi bi-gear"></i>
                <span>Je propose un service</span>
            </label>
    </div>


    <!-- 3. Catégorie de service/objet générer par JS -->
    <div class="etape" data-etape="3" id="tuc-etape-categorie"></div>

    <!-- 4. Ajout photos -->
    <div class="etape" data-etape="" id="tuc-etape-photo">
        <p class="consigne" data-for="photos[]">Ajouter une photo :</p>
        <label for="ajouter-photos" id="bouton-ajouter-photo"><i class="bi bi-file-earmark-arrow-up"></i>Sélectionner un fichier</label>
        <input type="file" name="photos[]" multiple id="ajouter-photos" accept="image/*" hidden>
        <div id="tuc-apercu"></div>
    </div>

    <!-- 5. Description -->
    <div class="etape" data-etape="" id="tuc-etape-description">
        <label class="consigne" data-for="description" for="description">Décrivez votre objet :</label>
        <textarea name="description" id="description" required></textarea>
    </div>

    <!-- 6. Informations de contact -->
    <div class="etape" data-etape="6" id="tuc-etape-contact">
        <p class="consigne" data-for="global"></p>

        <div id="tuc-container-contact-inputs">
            <label class="consigne" data-for="nom" for="nom"></label>
            <input class="tuc-contact-inputs" value="" type="text" name="nom" id="nom" required>
    
            <label class="consigne" data-for="email" value="wahlencome@gmail.com" for="email"></label>
            <input class="tuc-contact-inputs" value="" type="email" name="email" id="email" required> 
    
            <label class="consigne" data-for="tel" for="tel"></label>
            <input class="tuc-contact-inputs" value="" type="tel" name="tel" id="tel" required> 
        </div>
    </div>

    <!-- 7. Récapitulatif et validation -->
    <div class="etape" data-etape="7" id="tuc-etape-resume">
        <div class="tuc-resume-troc">
            <p class="tuc-resume-textes">Vous proposez de troquer :</p>
            <div class="tuc-resume-troc-elements">
                <p class="tuc-resume-labels">Type de troc :</p>
                <p class="tuc-resume-inputs" id="tuc-input-type"></p>

                <p class="tuc-resume-labels">Catégorie</p>
                <p class="tuc-resume-inputs" id="tuc-input-categorie"></p>

                <p class="tuc-resume-labels">Description :</p>
                <p class="tuc-resume-inputs" id="tuc-input-description"></p>

                <p class="tuc-resume-labels">Photos :</p>
                <div class="tuc-resume-inputs" id="tuc-input-photos"></div>
            </div>
        </div>

        <div class="tuc-resume-troc">
            <p class="tuc-resume-textes">Contre :</p>
            <div class="tuc-resume-troc-elements" id="tuc-resume-dessin">
                <img class="tuc-resume-labels" id="tuc-input-dessin-img" />
                <p class="tuc-resume-labels" id="tuc-input-dessin-titre"></p>
            </div>
        </div>

        <div class="tuc-resume-troc">
            <p class="tuc-resume-textes">Vos informations de contact :</p>
            <div class="tuc-resume-troc-elements">
                <p class="tuc-resume-labels">Prénom Nom :</p>
                <p class="tuc-resume-inputs" id="tuc-input-nom"></p>

                <p class="tuc-resume-labels">E-mail :</p>
                <p class="tuc-resume-inputs" id="tuc-input-email"></p>

                <p class="tuc-resume-labels">Téléphone :</p>
                <p class="tuc-resume-inputs" id="tuc-input-tel"></p>
            </div>
        </div>
    </div>

    <!-- 8. Confirmation -->
    <div class="etape" data-etape="8" id="tuc-etape-finale">
        <div id="tuc-etape-resultat-succes" class="tuc-etape-resultat-container">
            <p>Un e-mail de confirmation vous a été envoyé.</p>
            <p>Votre proposition sera sérieusement étudiée dans les prochaines heures.</p>
            <p>À très vite !</p>
        </div>
        <div id="tuc-etape-resultat-echec" class="tuc-etape-resultat-container">
            <p>Il semble que quelque chose ait empêché le bon fonctionnement du programme informatique.</p>
            <p>C'est certainement mal codé. Je vous invite à réessayer maintenant ou bientôt !</p>
        </div>
    </div>
 </form>