<?php

function display_product_actions($product_id) {
    if (current_user_can('laboratorio') || current_user_can('radiologia')) {
        echo '<a href="#" class="edit-product" data-product-id="' . $product_id . '">Editar</a>';
        echo '<a href="#" class="delete-product" data-product-id="' . $product_id . '">Excluir</a>';
    }
}

function list_all_woocommerce_products_with_actions_in_table() {
    if (function_exists('adicionar_link_voltar')) {
        adicionar_link_voltar();
    }

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC'
    );

    $products_query = new WP_Query($args);

    if ($products_query->have_posts()) {
        $output = '<div style="width: 100%;"><table style="width: 100%; border-collapse: collapse; border: 1px solid #ccc;">';
        $output .= '<thead><tr><th style="border: 1px solid #ccc; padding: 8px;">Nome</th><th style="border: 1px solid #ccc; padding: 8px;">Valor</th><th style="border: 1px solid #ccc; padding: 8px;">Ações</th></tr></thead>';
        $output .= '<tbody>';

        while ($products_query->have_posts()) {
            $products_query->the_post();
            $product_id = get_the_ID();
            $product = wc_get_product($product_id);
        
            if ($product) {
                $product_value = $product->get_regular_price(); 
                $product_url = get_permalink($product_id);

                if (is_numeric($product_value)) {
                    $product_value_formatado = number_format($product_value, 2, ',', '.');
                }

                $add_to_cart_url = $product->add_to_cart_url();
            } 
            else {
                $product_value = 'N/A';
                $product_url = '#';
                $add_to_cart_url = '#';
            }

            $output .= '<tr>';
            $output .= '<td style="border: 1px solid #ccc; padding: 8px;">' . get_the_title() . '</td>';
            $output .= '<td style="border: 1px solid #ccc; padding: 8px; text-align: center">R$ ' . $product_value_formatado . '</td>';
            $output .= '<td style="border: 1px solid #ccc; padding: 8px; text-align: center;">';
            $output .= '<a href="' . $product_url . '">Ver</a>';

            if (in_array('clinica', wp_get_current_user()->roles) || in_array('dentista', wp_get_current_user()->roles)) {
                $output .= ' | ';
                $output .= '<a href="' . $add_to_cart_url . '">Orçar</a>';
            }

            if (current_user_can('administrator') || in_array('laboratorio', wp_get_current_user()->roles) || in_array('radiologia', wp_get_current_user()->roles)) {
                $output .= ' | ';
                $output .= '<a href="' . esc_url(get_permalink(get_page_by_path('editar-produto'))) . '?id=' . $product_id . '">Editar</a>';
                $output .= ' | ';
                $output .= '<a href="' . esc_url(add_query_arg(array('action' => 'delete_post', 'id' => $product_id))) . '" onclick="return confirm(\'Tem certeza que deseja excluir este Produto?\')">Excluir</a>'; // Adiciona confirmação de exclusão
            }

            $output .= '</td>';
            $output .= '</tr>';
        }

        $output .= '</tbody></table></div>';
    } else {
        $output = 'Nenhum produto encontrado.';
    }

    wp_reset_postdata();
    return $output;
}
add_shortcode('list_products_with_actions', 'list_all_woocommerce_products_with_actions_in_table');


add_action('init', 'handle_product_deletion');
function handle_product_deletion() {
    if (isset($_GET['action']) && $_GET['action'] === 'delete_post' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        wp_delete_post($id, true);
        wp_redirect(home_url('/produtos/'));
        exit;
    }
}