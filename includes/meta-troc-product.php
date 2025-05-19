<?php
/**
 * Ajouter la meta donnée isTroc au produit woocommerce.
 * Gère l'affichage du post it "troqué" et "vendu".
 */
defined('ABSPATH') or die(':-)');


// Ajouter une checkbox à l'admin WordPress WooCommerce
add_action('woocommerce_product_options_general_product_data', 'ajouter_champ_is_troc');
function ajouter_champ_is_troc() {
    woocommerce_wp_checkbox([
        'id' => '_is_troc',
        'label' => 'Ce dessin a été troqué',
    ]);
}

add_action('woocommerce_process_product_meta', 'sauvegarder_champ_is_troc');
function sauvegarder_champ_is_troc($post_id) {
    $is_troc = isset($_POST['_is_troc']) ? 'yes' : 'no';
    update_post_meta($post_id, '_is_troc', $is_troc);
}

// Ajouter post-it "troqué" ou vendu

function ajouter_postit_troc() {
    global $product;
    $is_troc = get_post_meta($product->get_id(), '_is_troc', true);
    if ($is_troc === 'yes') {
        $logo_url = plugin_dir_url(__FILE__) . '../assets/img/postit-troque.png';
        echo '<img src="' . esc_url($logo_url) . '" class="sold-out-badge" alt="Dessin troqué">';
    
    } else if ( ! $product->is_in_stock()) {
        $logo_url = plugin_dir_url(__FILE__) . '../assets/img/postit-vendu.png';
        echo '<img src="' . esc_url($logo_url) . '" class="sold-out-badge" alt="Dessin troqué">';

    }
}
add_action( 'woocommerce_before_shop_loop_item_title', 'ajouter_postit_troc', 20 );
?>