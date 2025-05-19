<?php
/**
 * Template HTML pour l'affichage de la page troc. Le formulaire est inséré au via shortcode.
 * Template Name: Troc
 */
defined('ABSPATH') or die(':-)');

get_header();
?>
    <div id="page-troc-header">
        <div id="retour-accueil">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-retour-accueil">← Retour à l'accueil</a>
        </div>
        <div id="tuc-form-header">
            <div id="tuc-progress-ring">
                <svg width="70" height="70">
                    <circle class="cercle-gris" cx="35" cy="35" r="32"/>
                    <circle class="cercle-bleu" cx="35" cy="35" r="32" stroke-linecap="round" transform="rotate(-90 35 35)"/>
                </svg>
                <div id="indicateur-etape"></div>
            </div>
            <h1 id="texte-etape"></h1>
        </div>
    </div>
        
    <main>
        <?php the_content();?>
    </main><!-- #main -->

    <div class="tuc-form-navigation" id="navigation-formulaire">
        <div id="btn-commencer" class="tuc-bouton">
            <button type=""button class="btn-suivant">Commencer</button>
        </div>

        <div id="btns-navigation" class="tuc-bouton">
            <button type="button" class="btn-retour">Retour</button>
            <button type="button" class="btn-suivant">Suivant</button>
        </div>
        <div id="btns-submit" class="tuc-bouton">
            <button type="button" id="btn-modifier" class="btn-retour">Modifier</button>
            <button type="submit" id="btn-submit" form="formulaire-troc">Confirmer et envoyer</button>
        </div>
        <div id="btns-accueil" class="tuc-bouton">
            <a href="/" class="btn-accueil" id="bouton-accueil-resultat">Accueil</a>
            <a href="/" class="btn-accueil">Nouveau troc</a>
        </div>
    </div>
<?php
    wp_footer();
?>