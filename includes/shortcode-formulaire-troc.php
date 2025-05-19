<?php
/*
    Formulaire de troc en fonction du dessin séléctionné
*/
defined('ABSPATH') or die(':-)');

//Shortcode pour afficher le formulaire
function formulaire_troc_shortcode() {
    //Récupérer l'id dessin si il existe. Si il n'existe pas retourner 0
    $dessin_id = isset($_GET['dessin_id']) ? intval($_GET['dessin_id']) : 0;

    if ($dessin_id > 0) {
        //Récupérer les infos produits si l'id est plus grand que 0
        $dessin = wc_get_product($dessin_id);
        $nom_dessin = $dessin->get_name();
        $url_dessin = wp_get_attachment_url($dessin->get_image_id());
        $description_dessin = $dessin->get_short_description();

        // Envoyer le data product à JS
        wp_localize_script('tuc-formulaire-troc-js', 'dataDessin', [
            'titreDessin' => $nom_dessin,
            'imgDessin' => $url_dessin
        ]);

    } else {
        $nom_dessin = 'Il faut choisir un dessin';
    }
    //Formulaire
    ob_start();
    include plugin_dir_path(__FILE__) . '../templates/formulaire-troc.php';
    return ob_get_clean();
}
add_shortcode('formulaire_troc', 'formulaire_troc_shortcode');
?>