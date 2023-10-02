<?php

function display_product_import_form() {
    if (function_exists('adicionar_link_voltar')) {
        adicionar_link_voltar();
    }
    
    ob_start();
    ?>

    <div class="product-import-form-container">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="file" name="file" accept=".csv, .xls, .xlsx" required>

            <div style="display: flex;">
                <input type="submit" name="import_products" value="Importar Produtos" style="margin-top: 30px;">
                <input type="button" value="Cancelar" onclick="voltarPagina()" style="background: #fb04ab; margin-top: 30px; margin-left: 20px; width: auto;">
            </div>
        </form>
    </div>
    <?php
    
    require_once get_template_directory() . '/vendor/autoload.php';

    if (isset($_POST['import_products'])) {
        if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $file_path = $_FILES['file']['tmp_name'];
            $file_extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

            if ($file_extension === 'csv') {
                $handle = fopen($file_path, 'r');
                if ($handle) {
                    while (($data = fgetcsv($handle)) !== false) {
                        $nome = $data[0];
                        $preco = $data[1];

                        create_product($nome, $preco);
                    }
                    fclose($handle);
                }
            } elseif ($file_extension === 'xls' || $file_extension === 'xlsx') {
                require_once ABSPATH . 'wp-admin/includes/file.php';
                require_once ABSPATH . 'wp-admin/includes/image.php';
                require_once ABSPATH . 'wp-admin/includes/media.php';

                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file_path);
                $worksheet = $spreadsheet->getActiveSheet();

                foreach ($worksheet->getRowIterator() as $row) {
                    $nome = $worksheet->getCellByColumnAndRow(1, $row->getRowIndex())->getValue();
                    $preco = $worksheet->getCellByColumnAndRow(2, $row->getRowIndex())->getValue();

                    create_product($nome, $preco);
                }
            } else {
                echo 'Tipo de arquivo inválido. Apenas arquivos CSV, XLS e XLSX são suportados.<br>';
            }
        } else {
            echo 'Erro ao fazer upload do arquivo.<br>';
        }
    }

    return ob_get_clean();
}
add_shortcode('product_import_form', 'display_product_import_form');

function create_product($nome, $preco) {
    $post_data = array(
        'post_title' => $nome,
        'post_content' => '',
        'post_status' => 'publish',
        'post_type' => 'product'
    );

    $product_id = wp_insert_post($post_data);

    if ($product_id) {
        update_post_meta($product_id, '_regular_price', $preco);
        update_post_meta($product_id, '_price', $preco);
        update_post_meta($product_id, '_manage_stock', 'no');
        echo "Produto '$nome' importado com sucesso!<br>";
    }
}