<?php
/*
    Ce script créer une page wordpress pour la plateforme de troc
    lors de l'activation du plugin. Il supprime la page en cas de désactivation.
*/

defined('ABSPATH') or die(':-)');

class tuc_activator {

    //Créer la page
    public static function activer(){
        $slug = 'troc';

        //Vérifie si une page avec ce slug existe déjà
        $page = get_page_by_path($slug); //déclare $page et la cherche dans la bd
        if(!$page) { //si la page n'existe pas
            //créer la page
            $page_id = wp_insert_post([
                'post_title' => 'Troque un côme',
                'post_name' =>$slug,
                'post_type' => 'page',
                'post_status' => 'publish',
                'post_content' => '[formulaire_troc]',
                'page_template' => plugin_dir_path(__FILE__) . '../templates/page-troc.php'
            ]);
        }
    }
    
    //Supprimer la page
    public static function desactiver(){
        $slug = 'troc';
        $page = get_page_by_path($slug);

        if ($page) {
            wp_delete_post($page->ID, true);
        }

    }
}
?>