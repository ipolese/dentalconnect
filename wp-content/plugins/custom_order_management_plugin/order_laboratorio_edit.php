<?php

function edit_os_clinicas($view) {
    require_once ABSPATH . 'wp-admin/includes/image.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';
    
    ob_start();

    $disabled = '';

    if($view){
        $disabled = 'disabled';
    }

    if (isset($_GET['id'])) {
        $post_id = intval($_GET['id']);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtenha os dados do formulário
        $nome_do_dentista = sanitize_text_field($_POST['nome_do_dentista']);
        $nome = sanitize_text_field($_POST['nome']);
        $idade = sanitize_text_field($_POST['idade']);
        $sexo = sanitize_text_field($_POST['sexo']);
        $telefone = sanitize_text_field($_POST['telefone']);
        $data_inicio = sanitize_text_field($_POST['data_inicio']);
        $data_entrega = sanitize_text_field($_POST['data_entrega']);
        $cor_dominante = sanitize_text_field($_POST['cor_dominante']);
        $escala_de_cor = sanitize_text_field($_POST['escala_de_cor']);
        $cervical = sanitize_text_field($_POST['cervical']);
        $terco_medio = sanitize_text_field($_POST['terco_medio']);
        $marca = sanitize_text_field($_POST['marca']);
        $modelo = sanitize_text_field($_POST['modelo']);
        $plataforma = sanitize_text_field($_POST['plataforma']);
        $scanbody = sanitize_text_field($_POST['scanbody']);
        $observacoes = sanitize_text_field($_POST['observacoes']);

        // Atualize os campos da OS
        if (isset($post_id)) {

            update_field('nome_do_dentista', $nome_do_dentista, $post_id);
            update_field('nome', $nome, $post_id);
            update_field('idade', $idade, $post_id);
            update_field('sexo', $sexo, $post_id);
            update_field('telefone', $telefone, $post_id);
            update_field('data_inicio', $data_inicio, $post_id);
            update_field('data_entrega', $data_entrega, $post_id);

            $levantamento_periapical = '';
            $levantamento_periapical01 = $_POST['levantamento_periapical01'];
            $levantamento_periapical02 = $_POST['levantamento_periapical02'];
            $levantamento_periapical03 = $_POST['levantamento_periapical03'];
            $levantamento_periapical04 = $_POST['levantamento_periapical04'];

            $levantamento_periapical = '';

            $levantamento_periapical01 = isset($_POST['levantamento_periapical01']) ? $_POST['levantamento_periapical01'] : array();
            $levantamento_periapical02 = isset($_POST['levantamento_periapical02']) ? $_POST['levantamento_periapical02'] : array();
            $levantamento_periapical03 = isset($_POST['levantamento_periapical03']) ? $_POST['levantamento_periapical03'] : array();
            $levantamento_periapical04 = isset($_POST['levantamento_periapical04']) ? $_POST['levantamento_periapical04'] : array();

            $levantamento_periapical_arrays = array(
                $levantamento_periapical01,
                $levantamento_periapical02,
                $levantamento_periapical03,
                $levantamento_periapical04
            );

            foreach ($levantamento_periapical_arrays as $array) {
                if (!empty($array)) {
                    $levantamento_periapical .= !empty($levantamento_periapical) ? ', ' : '';
                    $levantamento_periapical .= implode(', ', $array);
                }
            }

            update_field('levantamento_periapical', $levantamento_periapical, $post_id);

            update_field('cor_dominante', $cor_dominante, $post_id);
            update_field('escala_de_cor', $escala_de_cor, $post_id);
            update_field('cervical', $cervical, $post_id);
            update_field('terco_medio', $terco_medio, $post_id);
            update_field('marca', $marca, $post_id);
            update_field('modelo', $modelo, $post_id);
            update_field('plataforma', $plataforma, $post_id);
            update_field('scanbody', $scanbody, $post_id);
            update_field('observacoes', $observacoes, $post_id);

            if (!empty($_FILES['file']['name'][0])) {
                $uploaded_files = $_FILES['file'];
                $uploaded_file_ids = array();
    
                foreach ($uploaded_files['name'] as $key => $value) {
                    if ($uploaded_files['error'][$key] === UPLOAD_ERR_OK) {
                        // Salvar o arquivo na biblioteca de mídia
                        $upload_file = wp_upload_bits($uploaded_files['name'][$key], null, file_get_contents($uploaded_files['tmp_name'][$key]));
    
                        if (!$upload_file['error']) {
                            $file_name = basename($upload_file['file']);
                            $file_type = wp_check_filetype($file_name, null);
    
                            $attachment = array(
                                'post_mime_type' => $file_type['type'],
                                'post_title' => preg_replace('/\.[^.]+$/', '', $file_name),
                                'post_content' => '',
                                'post_status' => 'inherit'
                            );
    
                            $attachment_id = wp_insert_attachment($attachment, $upload_file['file']);
    
                            if (!is_wp_error($attachment_id)) {
                                // Gerar metadados para o anexo e atualizar
                                $attachment_data = wp_generate_attachment_metadata($attachment_id, $upload_file['file']);
                                wp_update_attachment_metadata($attachment_id, $attachment_data);
    
                                $uploaded_file_ids[] = $attachment_id;
                            }
                        }
                    }
                }

                $existing_attachments = get_post_meta($post_id, 'arquivos', true);
                if (!is_array($existing_attachments)) {
                    $existing_attachments = array();
                }
                $combined_attachments = array_merge($existing_attachments, $uploaded_file_ids);
                update_post_meta($post_id, 'arquivos', $combined_attachments);
            }
        }

        // Redirecione após a atualização
        wp_redirect(home_url('/ordens-de-servico/'));
        exit;
    }

    ?>
    <form id="user-edit-form" method="post" enctype="multipart/form-data">  
        
        <div class="input-group">
            <div class="row">
                <div class="full-width">
                    <label for="nome_do_dentista">Nome do Dentista</label>
                    <input type="text" class="input_line_bottom" name="nome_do_dentista" value="<?php echo esc_attr(get_post_meta($post_id, 'nome_do_dentista', true)); ?>" required <?php echo $disabled; ?>>
                </div>
            </div>

            <div class="row">
                <div class="full-width">
                    <label for="nome">Nome do Paciente</label>
                    <input type="text" class="input_line_bottom" name="nome" value="<?php echo esc_attr(get_post_meta($post_id, 'nome', true)); ?>" required <?php echo $disabled; ?>>
                </div>
            </div>
            
            <div class="row">
                <div class="one-third-width">
                    <label for="idade">Idade do Paciente</label>
                    <input type="text" class="input_line_bottom" name="idade" value="<?php echo esc_attr(get_post_meta($post_id, 'idade', true)); ?>" required <?php echo $disabled; ?>>
                </div>

                <div class="one-third-width">
                    <label for="sexo">Sexo</label>
                    <?php
                        if($view){
                            $sexo_options = array('Masculino', 'Feminino', 'Outro');
                            $selected_sexo = get_post_meta($post_id, 'sexo', true);
                            $selected_value = '';

                            foreach ($sexo_options as $opcao) {
                                if ($selected_sexo === $opcao) {
                                    $selected_value = $opcao;
                                    break;
                                }
                            }
                    ?>
                            <input type="text" class="input_line_bottom"  name="sexo" value="<?php echo esc_attr($selected_value); ?>" readonly <?php echo $disabled; ?>>
                    <?php } else { ?>
                        <select name="sexo" required class="input_line_bottom" <?php echo $disabled; ?>>
                            <?php
                                $sexo_options = array('Masculino', 'Feminino', 'Outro');
                                $selected_sexo = get_post_meta($post_id, 'sexo', true);
                                foreach ($sexo_options as $opcao) {
                                    $selected = $selected_sexo === $opcao ? 'selected' : '';
                                    echo '<option value="' . esc_attr($opcao) . '" ' . $selected . '>' . esc_html($opcao) . '</option>';
                                }
                            ?>
                        </select>
                    <?php } ?>
                </div>

                <div class="one-third-width">
                    <label for="telefone">Telefone</label>
                    <input type="text" class="input_line_bottom" name="telefone" value="<?php echo esc_attr(get_post_meta($post_id, 'telefone', true)); ?>" required <?php echo $disabled; ?>>
                </div>
            </div>

            <div class="row">
                <div class="half-width">
                    <label for="data_inicio">Data de início</label>
                    <input type="date" class="input_line_bottom" name="data_inicio" value="<?php echo esc_attr(get_post_meta($post_id, 'data_inicio', true)); ?>" required <?php echo $disabled; ?>>
                </div>

                <div class="half-width">
                    <label for="data_entrega">Data de entrega</label>
                    <input type="date" class="input_line_bottom" name="data_entrega" value="<?php echo esc_attr(get_post_meta($post_id, 'data_entrega', true)); ?>" required <?php echo $disabled; ?>>
                </div>
            </div>
        </div>

        <div class="input-group">
            <label for="levantamento_periapical" class="label_in_border">Levantamento Periapical</label>
            <div class="row_inline">
                <div class="group">
                    <?php
                        $levantamento_periapical_01 = array('18', '17', '16', '15', '14', '13', '12', '11');
                        $levantamento_periapical_02 = array('21', '22', '23', '24', '25', '26', '27', '28');
                        $levantamento_periapical_03 = array('48', '47', '46', '45', '44', '43', '42', '41');
                        $levantamento_periapical_04 = array('31', '32', '33', '34', '35', '36', '37', '38');

                        $levantamento_periapical = get_post_meta($post_id, 'levantamento_periapical', true);
                        $levantamento_periapical = explode(', ', $levantamento_periapical);

                        function is_value_checked($value, $selected_values) {
                            return in_array($value, $selected_values) ? 'checked' : '';
                        }

                        foreach ($levantamento_periapical_01 as $choice_01) {
                            $checked = in_array($choice_01, $levantamento_periapical) ? 'checked' : '';
                            echo '<label><input type="checkbox" name="levantamento_periapical01[]" value="' . esc_attr($choice_01) . '" ' . $checked . ' ' . $disabled . '> ' . esc_html($choice_01) . '</label>';
                        }

                        echo '<span class="divisor">|</span>';

                        foreach ($levantamento_periapical_02 as $choice_02) {
                            $checked = in_array($choice_02, $levantamento_periapical) ? 'checked' : '';
                            echo '<label><input type="checkbox" name="levantamento_periapical02[]" value="' . esc_attr($choice_02) . '" ' . $checked . ' ' . $disabled . '> ' . esc_html($choice_02) . '</label>';
                        }
                        
                        echo '<hr style="margin: 1px 5% !important; width: 90%;">';

                        foreach ($levantamento_periapical_03 as $choice_03) {
                            $checked = in_array($choice_03, $levantamento_periapical) ? 'checked' : '';
                            echo '<label><input type="checkbox" name="levantamento_periapical03[]" value="' . esc_attr($choice_03) . '" ' . $checked . ' ' . $disabled . '> ' . esc_html($choice_03) . '</label>';
                        }

                        echo '<span class="divisor">|</span>';

                        foreach ($levantamento_periapical_04 as $choice_04) {
                            $checked = in_array($choice_04, $levantamento_periapical) ? 'checked' : '';
                            echo '<label><input type="checkbox" name="levantamento_periapical04[]" value="' . esc_attr($choice_04) . '" ' . $checked . ' ' . $disabled . '> ' . esc_html($choice_04) . '</label>';
                        }
                    ?>
                </div>
            </div>
        </div>

        <div class="input-group">
            <div class="row">
                <div class="half-width">
                    <label for="cor_dominante">Cor Dominante</label>
                    <input type="text" class="input_line_bottom" name="cor_dominante" value="<?php echo esc_attr(get_post_meta($post_id, 'cor_dominante', true)); ?>" required <?php echo $disabled; ?>>
                </div>

                <div class="half-width">
                    <label for="escala_de_cor">Escala de Cor</label>
                    <input type="text" class="input_line_bottom" name="escala_de_cor" value="<?php echo esc_attr(get_post_meta($post_id, 'escala_de_cor', true)); ?>" required <?php echo $disabled; ?>>
                </div>
            </div>

            <div class="row">
                <div class="half-width">
                    <label for="cervical">Cervical</label>
                    <input type="text" class="input_line_bottom" name="cervical" value="<?php echo esc_attr(get_post_meta($post_id, 'cervical', true)); ?>" required <?php echo $disabled; ?>>
                </div>

                <div class="half-width">
                    <label for="terco_medio">Terço Médio</label>
                    <input type="text" class="input_line_bottom" name="terco_medio" value="<?php echo esc_attr(get_post_meta($post_id, 'terco_medio', true)); ?>" required <?php echo $disabled; ?>>
                </div>
            </div>
        </div>

        <div class="input-group">
            <label for="implantes" class="label_in_border">Implantes</label>

            <div class="row">
                <div class="half-width">
                    <label for="marca">Marca</label>
                    <input type="text" class="input_line_bottom" name="marca" value="<?php echo esc_attr(get_post_meta($post_id, 'marca', true)); ?>" required <?php echo $disabled; ?>>
                </div>

                <div class="half-width">
                    <label for="modelo">Modelo</label>
                    <input type="text" class="input_line_bottom" name="modelo" value="<?php echo esc_attr(get_post_meta($post_id, 'modelo', true)); ?>" required <?php echo $disabled; ?>>
                </div>

            </div>  

            <div class="row">
                <div class="half-width">
                    <label for="plataforma">Plataforma</label>
                    <input type="text" class="input_line_bottom" name="plataforma" value="<?php echo esc_attr(get_post_meta($post_id, 'plataforma', true)); ?>" required <?php echo $disabled; ?>>
                </div>

                <div class="half-width">
                    <label for="scanbody">Scanbody</label>
                    <input type="text" class="input_line_bottom" name="scanbody" value="<?php echo esc_attr(get_post_meta($post_id, 'scanbody', true)); ?>" required <?php echo $disabled; ?>>
                </div>
            </div>
        </div>

        <div class="input-group">
            <label for="observacoes" class="label_in_border">Observações</label>
            <div class="row">
                <div class="full-width">
                    <textarea name="observacoes" class="input_line_bottom" rows="4" <?php echo $disabled; ?>><?php echo esc_textarea(get_post_meta($post_id, 'observacoes', true)); ?></textarea>
                </div>
            </div>
        </div>

        <div class="input-group">
            <label for="arquivos" class="label_in_border">Arquivos</label>
            <div class="row">
                <div class="full-width">
                    <?php
                        $attachments = get_post_meta($post_id, 'arquivos', true);

                        if (!empty($attachments)) {
                            echo '<div class="arquivos">';
                            foreach ($attachments as $attachment_id) {
                                $attachment_url = wp_get_attachment_url($attachment_id);
                                echo '<a href="' . esc_url($attachment_url) . '" target="download">';
                                $attachment_mime_type = get_post_mime_type($attachment_id);
                        
                                $file_extension = pathinfo($attachment_url, PATHINFO_EXTENSION);
                                if (strpos($attachment_mime_type, 'image') !== false) {
                                    echo wp_get_attachment_image($attachment_id, 'thumbnail');
                                } elseif ($file_extension === 'stl') {
                                    echo wp_get_attachment_image(9511, 'thumbnail');
                                }
                                echo '</a>';
                            }
                            echo '</div>';
                        }                        
                    ?>

                    <div class="row">
                        <div class="one-third-width">
                            <div class="custom-file-input">
                                <input type="file" name="file[]" multiple accept=".pdf, .doc, .docx, .jpg, .jpeg, .png, .mp4, .stl">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if(!$view){ ?>
            <div style="display: flex;">
                <input type="submit" value="Atualizar OS" style="margin-top: 30px;">
                <input type="button" value="Cancelar" onclick="voltarPagina()" style="background: #fb04ab; margin-top: 30px; margin-left: 20px; width: auto;">
            </div>
        <?php } ?>
        
    </form>
    <?php
}
add_shortcode('edit_os_clinicas', 'edit_os_clinicas');
