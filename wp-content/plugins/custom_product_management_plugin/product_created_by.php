<?php

function save_created_by_user_data($product_id) {
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;
    
    update_post_meta($product_id, '_created_by_user', $user_id);
}
add_action('woocommerce_new_product', 'save_created_by_user_data');

function show_created_by_user_on_product_edit() {
    global $post;
    
    $user_id = get_post_meta($post->ID, '_created_by_user', true);
    if ($user_id) {
        $user_info = get_userdata($user_id);
        echo '<p><strong>Criado por:</strong> ' . $user_info->display_name . '</p>';
    }
}
add_action('woocommerce_product_options_general_product_data', 'show_created_by_user_on_product_edit');

function show_created_by_user_on_product_list($column, $product_id) {
    if ($column === 'name_of_creator') {
        $user_id = get_post_meta($product_id, '_created_by_user', true);
        if ($user_id) {
            $user_info = get_userdata($user_id);
            echo $user_info->display_name;
        }
    }
}
add_action('manage_product_posts_custom_column', 'show_created_by_user_on_product_list', 10, 2);

function add_created_by_user_column($columns) {
    $columns['name_of_creator'] = 'Criado por';
    return $columns;
}
add_filter('manage_product_posts_columns', 'add_created_by_user_column');
