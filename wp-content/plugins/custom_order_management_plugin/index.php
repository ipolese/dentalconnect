<?php
/*
Plugin Name: Custom Order Management Plugin
Description: Adds a custom order form that registers a custom post type "Ordens de Serviço" and uses Advanced Custom Fields to collect the data.
Version: 1.0
Author: Igor Polese
*/

require_once 'order_laboratorio_edit.php';
require_once 'order_laboratorio_register.php';
require_once 'order_radiologia_edit.php';
require_once 'order_radiologia_register.php';

// Enqueue plugin scripts and styles
function custom_order_management_enqueue_styles() {
    //wp_enqueue_style( 'alliance', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'custom_order_management_plugin_styles', plugins_url( 'css/styles.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'custom_order_management_enqueue_styles' );

function list_os_shortcode() {
    if (function_exists('adicionar_link_voltar')) {
        adicionar_link_voltar();
    }
    
    $current_user = wp_get_current_user();
    $usuario_pai = get_field('usuario_pai', 'user_' . $current_user->ID);

    if (in_array('administrator', $current_user->roles)) {
        $post_type = array('os_radiologia', 'os_laboratorio');
    } elseif (in_array('dentista', $current_user->roles) || in_array('radiologia', $current_user->roles)) {
        $post_type = 'os_radiologia';
    } elseif (in_array('clinica', $current_user->roles) || in_array('laboratorio', $current_user->roles) || in_array('funcionario_lab', $current_user->roles)) {
        $post_type = 'os_laboratorio';
    } 

    $args = array(
        'post_type' => $post_type,
        'posts_per_page' => -1,
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        $output = '<div style="width: 100%;"><table style="width: 100%; border-collapse: collapse; border: 1px solid #ccc;">';
        $output .= '<tr><th style="border: 1px solid #ccc; padding: 8px;">#</th><th style="border: 1px solid #ccc; padding: 8px;">Dentista</th><th style="border: 1px solid #ccc; padding: 8px;">Paciente</th><th style="border: 1px solid #ccc; padding: 8px;">Data de Criação</th><th style="border: 1px solid #ccc; padding: 8px;">Ações</th></tr>';

        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            $nome_do_dentista = get_field('nome_do_dentista', $post_id);
            $nome = get_field('nome', $post_id);
            $criado_por = get_field('criado_por', $post_id);
            $atribuido_para = get_field('atribuido_para', $post_id);
            $concluida = get_field('concluida', $post_id);
                
            if($post_type == 'os_laboratorio'){
                $user_valor = get_field('laboratorio', $post_id);
            } elseif ($post_type == 'os_radiologia'){
                $user_valor = get_field('radiologia', $post_id);
            }

            if(in_array('administrator', $current_user->roles) || 
                in_array('funcionario_lab', $current_user->roles) || 
                $current_user->ID == $criado_por ||  
                $current_user->ID == $user_valor){
                
                if(!$concluida){

                    $output .= '<tr>';
                    $output .= '<td style="border: 1px solid #ccc; padding: 8px; text-align: center">' . esc_html(get_the_title()) . '</td>';
                    $output .= '<td style="border: 1px solid #ccc; padding: 8px; text-align: center">' . $nome_do_dentista . '</td>';
                    $output .= '<td style="border: 1px solid #ccc; padding: 8px; text-align: center">' . $nome . '</td>';
                    $output .= '<td style="border: 1px solid #ccc; padding: 8px; text-align: center">' . get_the_date('d/m/Y') . '</td>';
                    $output .= '<td style="border: 1px solid #ccc; padding: 8px; text-align: center">';

                    $output .= '<a href="' . esc_url(get_permalink(get_page_by_path('ver-os'))) . '?id=' . $post_id . '">Ver</a>';
                    $output .= ' | ';
                    $output .= '<a href="' . esc_url(add_query_arg('id', get_the_ID(), site_url('/gerar-pdf-os'))) . '" target="_blank">Gerar PDF</a>';

                    if ((($user_valor != '') && ($user_valor == $usuario_pai) || (in_array('funcionario_lab', $current_user->roles)))) {
                        $output .= ' | ';
                        $output .= '<a href="' . esc_url(get_permalink(get_page_by_path('editar-os'))) . '?id=' . $post_id . '">Editar</a>';
                    } 
                    if (($user_valor != '') && ($user_valor == $usuario_pai)) {
                        $output .= ' | ';
                        $output .= '<a href="' . esc_url(add_query_arg(array('action' => 'delete_post', 'post_id' => $post_id))) . '" onclick="return confirm(\'Tem certeza que deseja excluir esta OS?\')">Excluir</a>';
                    } 
                    if(in_array('funcionario_lab', $current_user->roles)){

                        if (($atribuido_para) == 1 || ($atribuido_para == '')) {
                            $output .= ' | ';
                            $output .= '<a href="' . esc_url(add_query_arg(array('action' => 'assigned', 'assigned' => $current_user->ID, 'id' => $post_id))) . '">Atribuir para mim</a>';
                        }
                        
                        if ($atribuido_para == $current_user->ID) {
                            $output .= ' | ';
                            $output .= '<a href="' . esc_url(add_query_arg(array('action' => 'assigned', 'assigned' => 1, 'id' => $post_id))) . '">Remover Atribuição</a>';
                        }

                        if (($atribuido_para == $current_user->ID) || (($user_valor == $current_user->ID))) {
                            $output .= ' | ';
                            $output .= '<a href="' . esc_url(add_query_arg(array('action' => 'complete', 'complete' => 'true', 'id' => $post_id))) . '">Concluir</a>';
                        }
                    }
                    else{
                        if (($user_valor == $current_user->ID)) {
                            $output .= ' | ';
                            $output .= '<a href="' . esc_url(add_query_arg(array('action' => 'complete', 'complete' => 'true', 'id' => $post_id))) . '">Concluir</a>';
                        }
                    }

                    $output .= '</td>';
                    $output .= '</tr>';

                }
            }
        }

        $output .= '</table></div>';
        wp_reset_postdata();
    } else {
        $output = '<span style="margin-top: 20px;">Nenhuma OS encontrada</span>';
    }

    return $output;
}
add_shortcode('list_os', 'list_os_shortcode');

add_action('init', 'assigned_action');
function assigned_action() {
    if (isset($_GET['action']) && $_GET['action'] === 'assigned' && $_GET['assigned'] && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        update_field('atribuido_para', $_GET['assigned'], $id);

        wp_safe_redirect(wp_get_referer());
        exit;
    }
}

add_action('init', 'complete_action');
function complete_action() {
    if (isset($_GET['action']) && $_GET['action'] === 'complete' && $_GET['complete'] === 'true' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        update_field('concluida', true, $id);

        wp_safe_redirect(wp_get_referer());
        exit;
    }
}

function list_os_complete_shortcode() {
    $current_user = wp_get_current_user();
    $usuario_pai = get_field('usuario_pai', 'user_' . $current_user->ID);

    if (in_array('administrator', $current_user->roles)) {
        $post_type = array('os_radiologia', 'os_laboratorio');
    } elseif (in_array('dentista', $current_user->roles) || in_array('radiologia', $current_user->roles)) {
        $post_type = 'os_radiologia';
    } elseif (in_array('clinica', $current_user->roles) || in_array('laboratorio', $current_user->roles) || in_array('funcionario_lab', $current_user->roles)) {
        $post_type = 'os_laboratorio';
    } 

    $args = array(
        'post_type' => $post_type,
        'posts_per_page' => -1,
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        $output = '<div style="width: 100%;"><table style="width: 100%; border-collapse: collapse; border: 1px solid #ccc;">';
        $output .= '<tr><th style="border: 1px solid #ccc; padding: 8px;">#</th><th style="border: 1px solid #ccc; padding: 8px;">Dentista</th><th style="border: 1px solid #ccc; padding: 8px;">Paciente</th><th style="border: 1px solid #ccc; padding: 8px;">Data de Criação</th><th style="border: 1px solid #ccc; padding: 8px;">Ações</th></tr>';

        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            $nome_do_dentista = get_field('nome_do_dentista', $post_id);
            $nome = get_field('nome', $post_id);
            $criado_por = get_field('criado_por', $post_id);
            $atribuido_para = get_field('atribuido_para', $post_id);
            $concluida = get_field('concluida', $post_id);
                
            if($post_type == 'os_laboratorio'){
                $user_valor = get_field('laboratorio', $post_id);
            } elseif ($post_type == 'os_radiologia'){
                $user_valor = get_field('radiologia', $post_id);
            }

            if(in_array('administrator', $current_user->roles) || 
                in_array('funcionario_lab', $current_user->roles) || 
                $current_user->ID == $criado_por || 
                $current_user->ID == $user_valor){

                if($concluida){

                    $output .= '<tr>';
                    $output .= '<td style="border: 1px solid #ccc; padding: 8px; text-align: center">' . esc_html(get_the_title()) . '</td>';
                    $output .= '<td style="border: 1px solid #ccc; padding: 8px; text-align: center">' . $nome_do_dentista . '</td>';
                    $output .= '<td style="border: 1px solid #ccc; padding: 8px; text-align: center">' . $nome . '</td>';
                    $output .= '<td style="border: 1px solid #ccc; padding: 8px; text-align: center">' . get_the_date('d/m/Y') . '</td>';
                    $output .= '<td style="border: 1px solid #ccc; padding: 8px; text-align: center">';

                    $output .= '<a href="' . esc_url(get_permalink(get_page_by_path('ver-os'))) . '?id=' . $post_id . '">Ver</a>';
                    $output .= ' | ';
                    $output .= '<a href="' . esc_url(add_query_arg('id', get_the_ID(), site_url('/gerar-pdf-os'))) . '" target="_blank">Gerar PDF</a>';

                    if(in_array('funcionario_lab', $current_user->roles)){
                        if (($atribuido_para == $current_user->ID) && (($user_valor == $current_user->ID))) {
                            $output .= ' | ';
                            $output .= '<a href="' . esc_url(add_query_arg(array('action' => 'complete', 'complete' => 'false', 'id' => $post_id))) . '">Reabrir</a>';
                        }
                    }
                    else{
                        if (($user_valor == $current_user->ID)) {
                            $output .= ' | ';
                            $output .= '<a href="' . esc_url(add_query_arg(array('action' => 'complete', 'complete' => 'false', 'id' => $post_id))) . '">Reabrir</a>';
                        }
                    }

                    $output .= '</td>';
                    $output .= '</tr>';
                }
            }
        }

        $output .= '</table></div>';
        wp_reset_postdata();
    } else {
        $output = '<span style="margin-top: 20px;">Nenhuma OS Concluída</span>';
    }

    return $output;
}
add_shortcode('list_os_complete', 'list_os_complete_shortcode');

add_action('init', 'incomplete_action');
function incomplete_action() {
    if (isset($_GET['action']) && $_GET['action'] === 'complete'  && $_GET['complete'] === 'false' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        update_field('concluida', false, $id);

        wp_safe_redirect(wp_get_referer());
        exit;
    }
}

function delete_post_by_id($post_id) {
    if (current_user_can('delete_post', $post_id)) {
        wp_delete_post($post_id, true);
    }
}

add_action('init', 'handle_post_deletion');
function handle_post_deletion() {
    if (isset($_GET['action']) && $_GET['action'] === 'delete_post' && isset($_GET['post_id'])) {
        $post_id = intval($_GET['post_id']);
        delete_post_by_id($post_id);
        wp_redirect(home_url('/ordens-de-servico/'));
        exit;
    }
}

// Function to display the custom order form
function custom_order_plugin_display_order_form() {
    if (function_exists('adicionar_link_voltar')) {
        adicionar_link_voltar();
    }
    
    ob_start();
    ?>

    <!-- Custom order form -->
    <div class="order-form-container">
        <?php
            $current_user = wp_get_current_user();

            if (in_array('dentista', $current_user->roles)) {
                form_os_dentistas();
            } elseif ((in_array('clinica', $current_user->roles)) || (in_array('funcionario_lab', $current_user->roles))) {
                form_os_clinicas();
            }
        ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'custom_order_form', 'custom_order_plugin_display_order_form' );

// Function to display the edit order form
function edit_order_plugin_display_order_form() {
    if (function_exists('adicionar_link_voltar')) {
        adicionar_link_voltar();
    }
    
    ob_start();
    ?>

    <!-- Custom order form -->
    <div class="order-form-container">
        <?php
            $current_user = wp_get_current_user();
            $view = false;

            if (in_array('dentista', $current_user->roles)) {
                edit_os_dentistas($view);
            } elseif ((in_array('clinica', $current_user->roles)) || (in_array('funcionario_lab', $current_user->roles))) {
                edit_os_clinicas($view);
            }
        ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'edit_order_form', 'edit_order_plugin_display_order_form' );

// Function to display the edit order form
function view_order_plugin_display_order_form() {
    if (function_exists('adicionar_link_voltar')) {
        adicionar_link_voltar();
    }
    
    ob_start();
    ?>

    <!-- Custom order form -->
    <div class="order-form-container" id="order-form-container">
        <?php
            $current_user = wp_get_current_user();
            $view = true;

            $allowed_roles_dentista = array('administrator', 'radiologia', 'dentista');
            $allowed_roles_clinica = array('administrator', 'funcionario_lab', 'laboratorio', 'clinica');

            if (array_intersect($allowed_roles_dentista, $current_user->roles)) {
                edit_os_dentistas($view);
            } elseif (array_intersect($allowed_roles_clinica, $current_user->roles)) {
                edit_os_clinicas($view);
            }
        ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'view_order_form', 'view_order_plugin_display_order_form' );