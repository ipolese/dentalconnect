<?php

function custom_product_form() {
    if (function_exists('adicionar_link_voltar')) {
        adicionar_link_voltar();
    }
    
    ob_start();
    ?>

    <div class="product-form-container">
        <form id="product-form" method="post" enctype="multipart/form-data">
            <label for="product_title">Título do Produto</label>
            <input type="text" name="product_title" required>

            <label for="product_description">Descrição do Produto</label>
            <textarea name="product_description" required></textarea>

            <label for="product_price">Valor do Produto</label>
            <input type="number" step="0.01" name="product_price" required>

            <label for="product_gallery">Galeria de Fotos do Produto</label>
            <input type="file" name="product_gallery[]" multiple accept="image/*">

            <div style="display: flex;">
                <input type="submit" value="Cadastrar Produto" style="margin-top: 30px;">
                <input type="button" value="Cancelar" onclick="voltarPagina()" style="background: #fb04ab; margin-top: 30px; margin-left: 20px; width: auto;">
            </div>
        </form>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'custom_product_form', 'custom_product_form' );