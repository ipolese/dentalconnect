<?php

function add_capabilities_laboratorio() {
    // Obtém o objeto WP_Roles
    $wp_roles = wp_roles();

    // Verifica se o papel "Laboratorio" já existe
    if ( ! isset( $wp_roles->roles['laboratorio'] ) ) {
        // Obtém as capacidades do papel "Editor"
        $editor_capabilities = $wp_roles->roles['editor']['capabilities'];
        $editor_capabilities['create_users'] = true;

        // Cria o novo papel "Laboratorio" com as mesmas capacidades do papel "Editor"
        $wp_roles->add_role( 'laboratorio', 'Laboratorio', $editor_capabilities );
    }
}
add_action( 'init', 'add_capabilities_laboratorio' );

function add_capabilities_func_laboratorio() {
    // Obtém o objeto WP_Roles
    $wp_roles = wp_roles();

    // Verifica se o papel "Funcionário Laboratório" já existe
    if ( ! isset( $wp_roles->roles['funcionario_lab'] ) ) {
        // Obtém as capacidades do papel "Editor"
        $editor_capabilities = $wp_roles->roles['editor']['capabilities'];
        $editor_capabilities['create_users'] = true;

        // Cria o novo papel "Funcionário Laboratório" com as mesmas capacidades do papel "Editor"
        $wp_roles->add_role( 'funcionario_lab', 'Funcionário Laboratório', $editor_capabilities );
    }
}
add_action( 'init', 'add_capabilities_func_laboratorio' );

function add_capabilities_clinica() {
    // Obtém o objeto WP_Roles
    $wp_roles = wp_roles();

    // Verifica se o papel "Clinica" já existe
    if ( ! isset( $wp_roles->roles['clinica'] ) ) {
        // Obtém as capacidades do papel "Editor"
        $editor_capabilities = $wp_roles->roles['editor']['capabilities'];
        $editor_capabilities['create_users'] = true;

        // Cria o novo papel "Clinica" com as mesmas capacidades do papel "Editor"
        $wp_roles->add_role( 'clinica', 'Clinica', $editor_capabilities );
    }
}
add_action( 'init', 'add_capabilities_clinica' );

function add_capabilities_radiologia() {
    // Obtém o objeto WP_Roles
    $wp_roles = wp_roles();

    // Verifica se o papel "Radiologia" já existe
    if ( ! isset( $wp_roles->roles['radiologia'] ) ) {
        // Obtém as capacidades do papel "Editor"
        $editor_capabilities = $wp_roles->roles['editor']['capabilities'];
        $editor_capabilities['create_users'] = true;

        // Cria o novo papel "Radiologia" com as mesmas capacidades do papel "Editor"
        $wp_roles->add_role( 'radiologia', 'Radiologia', $editor_capabilities );
    }
}
add_action( 'init', 'add_capabilities_radiologia' );

function add_capabilities_dentista() {
    // Obtém o objeto WP_Roles
    $wp_roles = wp_roles();

    // Verifica se o papel "Dentista" já existe
    if ( ! isset( $wp_roles->roles['dentista'] ) ) {
        // Obtém as capacidades do papel "Editor"
        $editor_capabilities = $wp_roles->roles['editor']['capabilities'];
        $editor_capabilities['create_users'] = true;

        // Cria o novo papel "Dentista" com as mesmas capacidades do papel "Editor"
        $wp_roles->add_role( 'dentista', 'Dentista', $editor_capabilities );
    }
}
add_action( 'init', 'add_capabilities_dentista' );

/** REMOVE CAPABILITES "INÚTEIS" */
function remove_capabilities_not_used() {
    $roles = array('ragiologia', 'employer', 'bbp_blocked', 'bbp_spectator', 'bbp_participant', 'bbp_moderator', 'bbp_keymaster');

    foreach ($roles as $role) {
        delete_role($role);
    }
}
register_deactivation_hook(__FILE__, 'remove_capabilities_not_used');

function delete_role($role_name) {
    $role = get_role($role_name);
    if (!$role) {
        return;
    }
    $users = get_users(['role' => $role_name]);
    foreach ($users as $user) {
        $user->remove_role($role_name);
    }
    remove_role($role_name);
}
/** FIM - REMOVE CAPABILITES "INÚTEIS" */
