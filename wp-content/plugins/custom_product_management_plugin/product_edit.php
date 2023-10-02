<?php

function custom_product_form_edit() {
    if (function_exists('adicionar_link_voltar')) {
        adicionar_link_voltar();
    }
    
    ob_start();

    $product_id = null;

    if (isset($_GET['id'])) {
        $product_id = intval($_GET['id']);
        $product = wc_get_product($product_id);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if ($product_id) {
            if ($product) {
                $product_title = sanitize_text_field($_POST['product_title']);
                $product_description = sanitize_text_field($_POST['product_description']);
                $product_price = floatval($_POST['product_price']);

                $product->set_name($product_title);
                $product->set_description($product_description);
                $product->set_regular_price($product_price);
                $product->save();

                wp_redirect(home_url('/clientes/'));
                exit;
            }
        }
    }

    $title = $product_id ? $product->get_name() : '';
    $description = $product_id ? $product->get_description() : '';
    $price = $product_id ? $product->get_regular_price() : '';

    ?>

    <div class="product-form-container">
        <form id="product-form" method="post" enctype="multipart/form-data">
            <label for="product_title">Título do Produto</label>
            <input type="hidden" name="id" value="<?php echo $product_id; ?>">
            <input type="text" name="product_title" required value="<?php echo esc_attr($title); ?>">

            <label for="product_description">Descrição do Produto</label>
            <textarea name="product_description" required><?php echo esc_textarea($description); ?></textarea>

            <label for="product_price">Valor do Produto</label>
            <input type="number" step="0.01" name="product_price" required value="<?php echo esc_attr($price); ?>">

            <label for="product_gallery">Galeria de Fotos do Produto</label>
            <input type="file" name="product_gallery[]" multiple accept="image/*">

            <div style="display: flex;">
                <input type="submit" value="Atualizar Produto" style="margin-top: 30px;">
                <input type="button" value="Cancelar" onclick="voltarPagina()" style="background: #fb04ab; margin-top: 30px; margin-left: 20px; width: auto;">
            </div>
        </form>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'custom_product_form_edit', 'custom_product_form_edit' );