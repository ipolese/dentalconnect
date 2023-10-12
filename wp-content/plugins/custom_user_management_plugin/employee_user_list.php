<?php

function display_filtered_employee_users() {
    if (function_exists('adicionar_link_voltar')) {
        adicionar_link_voltar();
    }
    
    $current_user = wp_get_current_user();
    $current_user_id = $current_user->ID;

    if (in_array('administrator', $current_user->roles)) {
        $args = array(
            'role__in' => array_keys(wp_roles()->roles),
        );

        $funcao = true;
        $th = '<tr><th style="border: 1px solid #ccc; padding: 8px;">Nome</th><th style="border: 1px solid #ccc; padding: 8px;">Função</th><th style="border: 1px solid #ccc; padding: 8px;">Email</th><th style="border: 1px solid #ccc; padding: 8px;">Data de Criação</th><th style="border: 1px solid #ccc; padding: 8px;">Ações</th></tr>';
    } else {
        $user_role = 'funcionario_lab';

        $args = array(
            'role'         => $user_role,
            'meta_key'     => 'usuario_pai',
            'meta_value'   => $current_user_id,
            'meta_compare' => '=',
        );

        $funcao = false;
        $th = '<tr><th style="border: 1px solid #ccc; padding: 8px;">Nome</th><th style="border: 1px solid #ccc; padding: 8px;">Email</th><th style="border: 1px solid #ccc; padding: 8px;">Data de Criação</th><th style="border: 1px solid #ccc; padding: 8px;">Ações</th></tr>';
    }

    $users = get_users($args);

    if (empty($users)) {
        return '<span style="margin-top: 20px;">Nenhum usuário cadastrado</span>';
    }

    $output = '<div style="width: 100%;"><table style="width: 100%; border-collapse: collapse; border: 1px solid #ccc;">';
    $output .= $th;
    
    foreach ($users as $user) {
        $registration_date = date('d/m/Y', strtotime($user->user_registered));
        $visivel = get_field('visivel', 'user_' . $user->ID);
        $bloqueado = get_field('bloqueado', 'user_' . $user->ID);

        if($visivel){
            if(!$bloqueado){
                $color = 'transparent';
            } else {
                $color = '#e7e7e7';
            }
            
            $output .= '<tr style="background: '. $color .';">';
            $output .= '<td style="border: 1px solid #ccc; padding: 8px;">' . esc_html($user->display_name) . '</td>';
            
            if ($funcao) {
                $user_data = get_userdata($user->ID);
                $user_roles = $user_data->roles;
                $role_names = implode(', ', $user_roles);
                $output .= '<td style="border: 1px solid #ccc; padding: 8px; text-align: center;">' . ucfirst(esc_html($role_names)) . '</td>';
            }

            $output .= '<td style="border: 1px solid #ccc; padding: 8px;">' . esc_html($user->user_email) . '</td>';
            $output .= '<td style="border: 1px solid #ccc; padding: 8px; text-align: center">' . $registration_date . '</td>';
            $output .= '<td style="border: 1px solid #ccc; padding: 8px; text-align: center">';
        
            // Adicionar link de edição com ícone
            $output .= '<a href="' . esc_url(get_permalink(get_page_by_path('editar-funcionario'))) . '?user_id=' . $user->ID . '">Editar</a>';
            
            // Adicionar link de exclusão com ícone
            $output .= ' | ';
            $output .= '<a href="' . esc_url(add_query_arg(array('action' => 'block_user', 'visibility' => 'false', 'user_id' => $user->ID))) . '">Excluir</a>';
            
            // Adicionar link para bloquear/desabilitar o usuário
            $output .= ' | ';
            
            if(!$bloqueado){
                $output .= '<a href="' . esc_url(add_query_arg(array('action' => 'block_user', 'blocked' => 'true', 'user_id' => $user->ID))) . '">Bloquear</a>';
            } else {
                $output .= '<a href="' . esc_url(add_query_arg(array('action' => 'unblock_user', 'blocked' => 'false', 'user_id' => $user->ID))) . '">Deloquear</a>';
            }

            $output .= '</td>';
            $output .= '</tr>';
        }
    }
    
    $output .= '</table></div>';
    
    return $output;
}

add_action('init', 'update_visibility_employee_action');
function update_visibility_employee_action() {
    if (isset($_GET['action']) && $_GET['action'] === 'block_user'  && $_GET['visibility'] === 'false' && isset($_GET['user_id'])) {
        $user_id = intval($_GET['user_id']);
        
        $user = get_user_by('ID', $user_id);
        $user_email = $user->user_email;
        $new_email = $user_email . '_DELETED';

        update_field('visivel', false, 'user_' . $user_id);
        wp_update_user(array('ID' => $user_id, 'user_email' => $new_email));

        wp_safe_redirect(wp_get_referer());
        exit;
    }
}

add_action('init', 'update_block_employee_action');
function update_block_employee_action() {
    if (isset($_GET['action']) && $_GET['action'] === 'block_user'  && $_GET['blocked'] === 'true' && isset($_GET['user_id'])) {
        $user_id = intval($_GET['user_id']);
        update_field('bloqueado', true, 'user_' . $user_id);

        wp_safe_redirect(wp_get_referer());
        exit;
    }
    
    if (isset($_GET['action']) && $_GET['action'] === 'unblock_user'  && $_GET['blocked'] === 'false' && isset($_GET['user_id'])) {
        $user_id = intval($_GET['user_id']);
        update_field('bloqueado', false, 'user_' . $user_id);

        wp_safe_redirect(wp_get_referer());
        exit;
    }
}

// Registrar o shortcode
add_shortcode('list_all_employee_users', 'display_filtered_employee_users');