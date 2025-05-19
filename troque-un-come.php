<?php
/*
Plugin Name: Troque un côme
Plugin URI: https://troqueuncome.com
Description: Troque un côme ajoute une plateforme de troque à WooCommerce
Version: 1.0
Author: Côme Wahlen
Author URI: https://comewahlen.com
*/

defined('ABSPATH') or die(':-)'); // Interdit l'accès direct au code

// Forcer l'adresse email de l'expéditeur
add_filter('wp_mail_from', function($email) {
    return 'infos@troqueuncome.com';
});

// Forcer le nom de l'expéditeur
add_filter('wp_mail_from_name', function($name) {
    return 'Troque un Côme';
});

// Charger les fichiers nécessaires (includes)
require_once plugin_dir_path(__FILE__) . 'includes/activator.php';
require_once plugin_dir_path(__FILE__) . 'includes/bouton-troc.php';
require_once plugin_dir_path(__FILE__) . 'includes/shortcode-formulaire-troc.php';
require_once plugin_dir_path(__FILE__) . 'includes/troc-post-type.php';
require_once plugin_dir_path(__FILE__) . 'includes/form-troc-handler.php';
require_once plugin_dir_path(__FILE__) . 'includes/meta-troc-product.php';

// Appel la fonction tuc_initialiser au moment de l'activation du plugin
register_activation_hook(__FILE__, 'tuc_initialiser');
register_deactivation_hook(__FILE__, 'tuc_desactiver');

// Fonction pour initialiser le plugin -> crée la page troc
function tuc_initialiser() {
    tuc_activator::activer();
}

// Fonction pour supprimer la page troc lors de la désactivation
function tuc_desactiver() {
    tuc_activator::desactiver();
}

add_action('init', 'desactiver_bouton_ajouter_panier');

function desactiver_bouton_ajouter_panier() {
    // Supprime le bouton "Ajouter au panier" sur les pages boutique et archives
    remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
    
    // Supprime le bouton "Ajouter au panier" sur la page produit
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
}

// Ajouter les scripts, les styles et les les URLs + Google Icon
function tuc_ajouter_scripts_styles() {
    // Charger le script JS sur la page troc
    if (is_page('troc')) {
        wp_enqueue_style('tuc-style', plugin_dir_url(__FILE__) . 'assets/css/tuc-style.css');
        wp_enqueue_script('tuc-upload-files-js', plugin_dir_url(__FILE__) . 'assets/js/tuc-upload.js', array(), '1.0.0', true);
        wp_enqueue_script('tuc-validation-js', plugin_dir_url(__FILE__) . 'assets/js/tuc-validation.js', array(), '1.0.0', true);
        wp_enqueue_script('tuc-ui-js', plugin_dir_url(__FILE__) . 'assets/js/tuc-ui.js', array(), '1.0.0', true);
        wp_enqueue_script('tuc-etapes-troc-js', plugin_dir_url(__FILE__) . 'assets/js/tuc-etapes.js', array(), '1.0.0', true);
        wp_enqueue_script('tuc-resume-js', plugin_dir_url(__FILE__) . 'assets/js/tuc-resume.js', array(), '1.0.0', true);
        wp_enqueue_script('tuc-submit-js', plugin_dir_url(__FILE__) . 'assets/js/tuc-submit.js', array(), '1.0.0', true);
        wp_enqueue_script('tuc-formulaire-troc-js', plugin_dir_url(__FILE__) . 'assets/js/tuc-formulaire-troc.js', array(), '1.0.0', true);
        wp_enqueue_script('tuc-progress-ring-js', plugin_dir_url(__FILE__) . 'assets/js/tuc-progress-ring.js', array(), '1.0.0', true);
        wp_enqueue_style('bootstrap-icons', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css', false, null);
        
        // Passer l'url AJAX à JS
        wp_localize_script('tuc-formulaire-troc-js', 'tuc_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php')
        ));

        // Passer l'url JSON à JS
        wp_localize_script('tuc-formulaire-troc-js', 'tuc_data', [
            'jsonUrl' => plugin_dir_url(__FILE__) . 'data/categories-troc.json'
        ]);
    }    
}
add_action('wp_enqueue_scripts', 'tuc_ajouter_scripts_styles');

// charger le template pour la page 'troc'
add_filter('template_include', 'page_troc', 99);

function page_troc($template) {
    // Vérifie si on est sur la page "troc"
    if (is_page('troc')) {
        // Chemin du template personnalisé
        $nouveau_template = plugin_dir_path(__FILE__) . 'templates/page-troc.php';
        
        // Vérifie si le fichier existe
        if (file_exists($nouveau_template)) {
            return $nouveau_template;  // Retourne le template personnalisé
        }
    }
    return $template;  // Retourne le template par défaut si on n'est pas sur la page 'troc'
}

// Changer le logo sur la page de troc
add_filter('get_custom_logo', 'tuc_logo_form', 10);

function tuc_logo_form($html) {
    if (is_page('troc')) {
        $logo_url = plugin_dir_url(__FILE__) . 'assets/img/tuc-logo.png';
        $html = '<img src="' . $logo_url . '" class="tuc-logo-form" alt="Logo achète un côme">';
    }

    return $html;
}
?>