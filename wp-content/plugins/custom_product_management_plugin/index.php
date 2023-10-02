<?php
/*
Plugin Name: Custom Product Management Plugin
Description: Plugin para gestão de produtos
Version: 1.0
Author: Igor Polese
*/

require_once 'csv_product_import.php';
require_once 'product_created_by.php';
require_once 'product_edit.php';
require_once 'product_management.php';
require_once 'product_register.php';

// Adicione os scripts e estilos do tema Alliance na página de formulário
function custom_product_management_enqueue_styles() {
    wp_enqueue_style( 'alliance', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'custom_product_management_plugin_styles', plugins_url( 'css/styles.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'custom_product_management_enqueue_styles' );

// Função para salvar um arquivo enviado na biblioteca de mídia do WordPress
function save_uploaded_file_to_media_library($file_data) {
    if ($file_data['error'] === UPLOAD_ERR_OK) {
        $upload_dir = wp_upload_dir();
        $file_path = $upload_dir['path'] . '/' . $file_data['name'];
        
        if (move_uploaded_file($file_data['tmp_name'], $file_path)) {
            $file_type = wp_check_filetype($file_data['name'], null);
            
            $attachment_data = array(
                'post_mime_type' => $file_type['type'],
                'post_title' => sanitize_file_name($file_data['name']),
                'post_content' => '',
                'post_status' => 'inherit'
            );
            
            $attachment_id = wp_insert_attachment($attachment_data, $file_path);
            
            if (!is_wp_error($attachment_id)) {
                require_once ABSPATH . 'wp-admin/includes/image.php';
                $attachment_data = wp_generate_attachment_metadata($attachment_id, $file_path);
                wp_update_attachment_metadata($attachment_id, $attachment_data);
                return $attachment_id;
            }
        }
    }
    
    return false;
}

// Função para cadastrar o produto e definir a imagem de destaque
function process_product_form() {
    require_once ABSPATH . 'wp-admin/includes/media.php';

    if (isset($_POST['product_title']) && isset($_POST['product_description']) && isset($_POST['product_price'])) {
        $product_data = array(
            'post_title' => sanitize_text_field($_POST['product_title']),
            'post_content' => wp_kses_post($_POST['product_description']),
            'post_status' => 'publish',
            'post_type' => 'product',
        );

        // Se o campo "id" não estiver definido, cria um novo produto
        if (!isset($_POST['id'])) {
            $product_id = wp_insert_post($product_data);
        } else {
            $product_id = intval($_POST['id']); // ID do produto para edição
            $product_data['ID'] = $product_id; // Define o ID do produto para atualização
            wp_update_post($product_data); // Atualiza os dados do produto existente
        }

        if ($product_id) {
            update_post_meta($product_id, '_regular_price', sanitize_text_field($_POST['product_price']));
            update_post_meta($product_id, '_price', sanitize_text_field($_POST['product_price']));

            // Salvar as imagens enviadas na galeria do produto
            if (!empty($_FILES['product_gallery']['name'][0])) {
                $attachment_ids = array();

                foreach ($_FILES['product_gallery']['name'] as $key => $name) {
                    $file = array(
                        'name' => $name,
                        'type' => $_FILES['product_gallery']['type'][$key],
                        'tmp_name' => $_FILES['product_gallery']['tmp_name'][$key],
                        'error' => $_FILES['product_gallery']['error'][$key],
                        'size' => $_FILES['product_gallery']['size'][$key],
                    );

                    $attachment_id = save_uploaded_file_to_media_library($file);

                    if ($attachment_id) {
                        $attachment_ids[] = $attachment_id;
                    }
                }

                if (!empty($attachment_ids)) {
                    set_post_thumbnail($product_id, $attachment_ids[0]); // Define a primeira imagem como imagem de destaque
                    unset($attachment_ids[0]); // Remove a imagem de destaque das imagens da galeria
                    update_post_meta($product_id, '_product_image_gallery', implode(',', $attachment_ids));
                }
            }
        }

        // Redirecionar o usuário para a página de gestão de produtos
        wp_redirect(home_url('/produtos/'));
        exit;
    }
}
add_action('init', 'process_product_form');