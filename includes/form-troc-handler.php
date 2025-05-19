<?php
/**
 *  Traite les formulaire de troc, crée un troc post type
 */

 defined('ABSPATH') or die(':-)');

 //Appeller la fonciton de traitement lors de la soumission du formulaire
 add_action('wp_ajax_traitement_formulaire_troc', 'traitement_formulaire');
 add_action('wp_ajax_nopriv_traitement_formulaire_troc', 'traitement_formulaire');

 function traitement_formulaire() {

    //Contrôler les champs requis
    $champ_requis = ['type-troc', 'categorie', 'description', 'nom', 'email', 'tel'];

    foreach ($champ_requis as $champ) {
        if (empty($_POST[$champ])) {
            wp_send_json_error( "$champ est obligatoire");
        }
    }

    // Nettoyer les données
    $type_troc = sanitize_text_field($_POST['type-troc']);
    $categorie = sanitize_text_field($_POST['categorie']);
    $nom = sanitize_text_field($_POST['nom']);
    $description = sanitize_textarea_field($_POST['description']);
    $email = sanitize_email($_POST['email']);
    $tel = sanitize_text_field($_POST['tel']);
    $titre_dessin = sanitize_text_field($_POST['titre_dessin']);


    // Création du troc post type
    $post_id = wp_insert_post([
        'post_type' => 'troc',
        'post_title' => $nom,
        'post_content' => $description,
        'post_status' => 'private',
    ]);

    // Contrôle des erreurs WP
    if (is_wp_error($post_id)) {
        wp_send_json_error('erreur enregistrement');
    }

    // Stockage des autres champs en metadonnées
    update_post_meta($post_id, 'Dessin', $titre_dessin);
    update_post_meta($post_id, 'Type de troc', $type_troc);
    update_post_meta($post_id, 'Catégorie', $categorie);
    update_post_meta($post_id, 'Auteur', $nom);
    update_post_meta($post_id, 'E-mail', $email);
    update_post_meta($post_id, 'Téléphone', $tel);

    // Gestion des photos
    // Pour chaque photos si il n'y pas d'erreur d'upload. Traiter l'enregistrement
    if (!empty($_FILES['photos']['name'][0])) {

        error_log(print_r($_FILES['photos'], true));


        foreach ($_FILES['photos']['name'] as $key => $file_name) {
            if ($_FILES['photos']['error'][$key] === UPLOAD_ERR_OK) {
                
                // Préparer le fichier
                $file = [
                    'name' => $file_name,
                    'type' => $_FILES['photos']['type'][$key],
                    'tmp_name' => $_FILES['photos']['tmp_name'][$key],
                    'error' => $_FILES['photos']['error'][$key],
                    'size' => $_FILES['photos']['size'][$key],
                ];

                // Enregistrer la photo dans wp
                $upload = wp_handle_upload($file, ['test_form' => false]);

                // Si le fichier est upload correctement créer un attachement
                if (isset($upload['file'])) {
                    $attachement = [
                        'post_mime_type' => $upload['type'],
                        'post_title' => sanitize_file_name($file['name']),
                        'post_content' => '',
                        'post_status' => 'inherit',
                    ];

                // Insérer l'attachement dans la bibliotheque de media
                $attachement_id = wp_insert_attachment($attachement, $upload['file'], $post_id);

                // Générer les metadonnées avec une fonction wp
                require_once(ABSPATH . 'wp-admin/includes/image.php');
                $attachement_metadata = wp_generate_attachment_metadata($attachement_id, $upload['file']);
                wp_update_attachment_metadata($attachement_id, $attachement_metadata);
                }
            }
        }
    }

    // Envoyer emails

    // Destinataire
    $nom_complet = trim($nom);
    $parties_nom = explode(' ', $nom_complet);
    $prenom = $parties_nom[0];

    // Mail HTML depuis la template 
    ob_start();
    include plugin_dir_path(__FILE__) . '../templates/mail-confirmation.php';
    $message = ob_get_clean();

    // Envoi du mail
    $sujet = "$prenom, merci pour votre proposition de troc !";
    $headers = ['Content-Type: text/html; charset=UTF-8'];
    
    wp_mail($email, $sujet, $message, $headers);

    // mail admin
    $sujet_mail_admin = "$nom à proposé un troc.";

    wp_mail($email, $sujet_mail_admin, $description, $headers);

    // Réponse JSON
    wp_send_json_success('succès traitement');
 }
?>