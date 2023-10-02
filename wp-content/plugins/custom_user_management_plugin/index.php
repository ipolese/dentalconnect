<?php
/*
Plugin Name: Custom User Management Plugin
Description: Adds a custom users manipulation.
Version: 1.0
Author: Igor Polese
*/

require_once 'csv_user_import.php';
require_once 'edit_my_user.php';
require_once 'user_capabilities.php';
require_once 'user_edit.php';
require_once 'user_list.php';
require_once 'user_register.php';

// Enqueue plugin scripts and styles
function custom_user_management_enqueue_styles() {
    wp_enqueue_style( 'alliance', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'custom_user_management_plugin_styles', plugins_url( 'css/styles.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'custom_user_management_enqueue_styles' );

// Função para processar o formulário de cadastro de usuário
function process_user_registration_form() {
    if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm_password'])) {
        $username = sanitize_user($_POST['username']);
        $email = sanitize_email($_POST['email']);
        $cep = sanitize_text_field($_POST['cep']);
        $rua = sanitize_text_field($_POST['rua']);
        $numero = sanitize_text_field($_POST['numero']);
        $cidade = sanitize_text_field($_POST['cidade']);
        $bairro = sanitize_text_field($_POST['bairro']);
        $estado = sanitize_text_field($_POST['estado']);
        $pais = sanitize_text_field($_POST['pais']);
        $complemento = sanitize_text_field($_POST['complemento']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        $current_url = $_SERVER['REQUEST_URI'];
        $user_role = '';

        if (strpos($current_url, '/cadastro-de-clinica/') !== false) {
            $user_role = 'clinica';
        } elseif (strpos($current_url, '/cadastro-de-dentista/') !== false) {
            $user_role = 'dentista';
        }

        $user_id = wp_create_user($username, $password, $email);

        if (is_wp_error($user_id)) {
        } else {
            if ($user_role) {
                wp_update_user(array('ID' => $user_id, 'role' => $user_role));
            }

            update_field('usuario_pai', get_current_user_id(), 'user_' . $user_id);

            update_field('cep', $cep, 'user_' . $user_id);
            update_field('rua', $rua, 'user_' . $user_id);
            update_field('numero', $numero, 'user_' . $user_id);
            update_field('cidade', $cidade, 'user_' . $user_id);
            update_field('bairro', $bairro, 'user_' . $user_id);
            update_field('estado', $estado, 'user_' . $user_id);
            update_field('pais', $pais, 'user_' . $user_id);
            update_field('complemento', $complemento, 'user_' . $user_id);

            if (strpos($current_url, '/cadastro-de-clinica/') !== false) {
                wp_redirect(home_url('/clinicas/'));
            } elseif (strpos($current_url, '/cadastro-de-dentista/') !== false) {
                wp_redirect(home_url('/dentistas/'));
            } else {
                wp_redirect(home_url('/'));
            }
            exit;
        }
    }
}
add_action('init', 'process_user_registration_form');
 