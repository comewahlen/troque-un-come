<?php
/*
    Ajout du bouton "troquer ce dessin"
    Le bouton redirige vers le formulaire de troc avec l'id dessin
*/

defined('ABSPATH') or die(':-)');

    // Créer le bouton "Troquer ce dessin"
    function ajouter_bouton_troc() {

        global $product; //accède au info Woocommerce du dessin affiché

        if ( ! $product->is_in_stock() ) {
        echo '<a href="#" class="button vendu troquer-dessin">Troquer ce dessin</a>';
        return;
}

        $dessin_id = $product->get_id(); //stock l'id du dessin dans $dessin_id
    
        $url_troc = add_query_arg(
            array('dessin_id' => $dessin_id),
            site_url('/troc')
        );
    
        echo '<a href="' . esc_url($url_troc) . '" class="button troquer-dessin">Troquer ce dessin</a>';
    }

    // Ajouter le bouton sur la page de la boutique (shop loop)
    add_action( 'woocommerce_after_shop_loop_item', 'ajouter_bouton_troc', 20 );

    // Ajouter le bouton sur la page produit individuelle
    add_action( 'woocommerce_single_product_summary', 'ajouter_bouton_troc', 35 );
?>