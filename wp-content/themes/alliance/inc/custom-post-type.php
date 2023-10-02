<?php

    /*add_action('admin_menu', 'add_menu_leads');
    function add_menu_leads() {
        $user = wp_get_current_user();
        $menu_slug = 'menu-leads.php';

        if ((in_array('administrator', $user->roles, true)) || (in_array('leads_mkt', $user->roles, true))) {
            add_menu_page( 'Leads', 'Leads', 'manage_options', $menu_slug, 'menu-leads', 'dashicons-groups', '6' );
            add_submenu_page( $menu_slug, 'Adicionar lead', 'Adicionar lead', 'manage_options','post-new.php?post_type=leads');
        }
    }

    add_action( 'init', 'register_leads_post_type' );
    function register_leads_post_type() {
        $labels = array(
            'name' => __( 'Leads' ),
            'singular_name' => __( 'Lead' ),
            'menu_name' => __( 'Leads' ),
            'all_items' => __( 'Leads' ),
            'add_new_item' => __( 'Adicionar novo lead' ),
            'not_found' => __( 'Nenhum lead encontrado' ),
            'not_found_in_trash' => __( 'Nenhum lead encontrado na lixeira' )
        );
    
        $args = array(
            'labels' => $labels,
            'public' => true,
            'show_in_rest' => true,
            'show_ui' => true, 
            'show_in_menu' => 'menu-leads.php',
            'has_archive'   => true,
            'menu_icon' => 'dashicons-groups',
            'supports' => array('title'),
        );
    
        register_post_type( 'leads', $args );
    }*/

    add_action( 'init', 'register_ordens_servico_radiologia_post_type' );
    function register_ordens_servico_radiologia_post_type() {
        $labels = array(
            'name' => __( 'OS - Radiologia' ),
            'singular_name' => __( 'OS - Radiologia' ),
            'menu_name' => __( 'OS - Radiologia' ),
            'all_items' => __( 'OS - Radiologia' ),
            'add_new_item' => __( 'Adicionar OS - Radiologia' ),
            'not_found' => __( 'Nenhuma OS - Radiologia encontrada' ),
            'not_found_in_trash' => __( 'Nenhuma OS - Radiologia encontrada na lixeira' )
        );
    
        $args = array(
            'labels' => $labels,
            'public' => true,
            'show_in_rest' => true,
            'menu_position' => 7,
            'has_archive'   => true,
            'menu_icon' => 'dashicons-clipboard',
            'supports' => array('title'),
        );
    
        register_post_type( 'os_radiologia', $args );
    }

    add_action( 'init', 'register_ordens_servico_laboratorio_post_type' );
    function register_ordens_servico_laboratorio_post_type() {
        $labels = array(
            'name' => __( 'OS - Laboratório' ),
            'singular_name' => __( 'OS - Laboratório' ),
            'menu_name' => __( 'OS - Laboratório' ),
            'all_items' => __( 'OS - Laboratório' ),
            'add_new_item' => __( 'Adicionar OS - Laboratório' ),
            'not_found' => __( 'Nenhuma OS - Laboratório encontrada' ),
            'not_found_in_trash' => __( 'Nenhuma OS - Laboratório encontrada na lixeira' )
        );
    
        $args = array(
            'labels' => $labels,
            'public' => true,
            'show_in_rest' => true,
            'menu_position' => 7,
            'has_archive'   => true,
            'menu_icon' => 'dashicons-clipboard',
            'supports' => array('title'),
        );
    
        register_post_type( 'os_laboratorio', $args );
    }
?>