<?php
/**
 *  Création d'un CPT pour les propositions de troc
 */

 defined('ABSPATH') or die(':-)');

 function register_troc_post_type() {
   $args = [
      'labels' => [
         'name' => 'Propostions de troc'

      ],

      'public' => false,
      'show_ui' => true,
      'show_in_menu' => true,
      'label' => 'Propositions de troc',
      'supports' => ['title', 'editor', 'thumbnail'],
   ];
   
   register_post_type('troc', $args);
 }
 add_action('init', 'register_troc_post_type');

 // Ajouter une meta box pour l'affichage des données supplémentaires
 add_action('add_meta_boxes', function() {
   add_meta_box(
       'proposition_troc',
       'Proposition de troc',
       'afficher_proposition_troc_meta_box',
       'troc',
       'normal',
       'default'
   );
});

// Afficher les champs des metadonnées
function afficher_proposition_troc_meta_box($post) {
   $dessin = get_post_meta($post->ID, 'Dessin', true);
   $type = get_post_meta($post->ID, 'Type de troc', true);
   $categorie = get_post_meta($post->ID, 'Catégorie', true);
   $auteur = get_post_meta($post->ID, 'Auteur', true);
   $email = get_post_meta($post->ID, 'E-mail', true);
   $tel = get_post_meta($post->ID, 'Téléphone', true);
   $photos = get_attached_media('image', $post->ID);
   $descritpion = get_post_field('post_content', $post->ID);
   
   echo '<p><strong>Pour : </strong>' . esc_html($dessin) . '</p>';
   echo '<p><strong>Type de troc : </strong>' . esc_html($type) . '</p>';
   echo '<p><strong>Catégorie : </strong>' . esc_html($categorie) . '</p>';
   echo '<p><strong>Description : </strong>' . esc_html($descritpion) . '</p>';
   echo '<p><strong>Auteur : </strong>' . esc_html($auteur) . '</p>';
   echo '<p><strong>E-mail : </strong>' . esc_html($email) . '</p>';
   echo '<p><strong>Téléphone : </strong>' . esc_html($tel) . '</p>';
   
   if ($photos) {
      echo '<div>';
      foreach ($photos as $photo) {
         echo '<div>';
         echo wp_get_attachment_image($photo->ID, 'medium');
         echo '</div>';
      }
      echo '</div>';
   } else {
      echo '<p>Pas de photos</p>';
   }
}

// Supprimer les champs WP par défaut
function supprimer_champs_wp() {
   // Supprimer le titre
   remove_post_type_support('troc', 'title');
   remove_post_type_support('troc', 'editor');
   remove_meta_box('categorydiv', 'troc', 'side');
   remove_meta_box('tagsdiv-post_tag', 'troc', 'side');
   remove_meta_box('postexcerpt', 'troc', 'normal');
   remove_meta_box('commentstatusdiv', 'troc', 'normal');
   remove_meta_box('revisionsdiv', 'troc', 'normal');
   remove_meta_box('authordiv', 'troc', 'normal');
}
add_action('add_meta_boxes', 'supprimer_champs_wp', 99);
?>