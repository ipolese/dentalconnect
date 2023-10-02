<?php

function form_os_clinicas() {
    require_once ABSPATH . 'wp-admin/includes/image.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';

    $user_id = get_current_user_id();
    $usuario_pai = get_field('usuario_pai', 'user_' . $user_id);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome'])) {
        $titulo = '#OS_' . $_POST['nome'];

        $post_data = array(
            'post_title'    => $titulo,
            'post_type'     => 'os_laboratorio',
            'post_status'   => 'publish'
        );

        $post_id = wp_insert_post($post_data);

        if ($post_id) {
            update_field('nome_do_dentista', $_POST['nome_do_dentista'], $post_id);
            update_field('nome', $_POST['nome'], $post_id);
            update_field('idade', $_POST['idade'], $post_id);
            update_field('sexo', $_POST['sexo'], $post_id);
            update_field('telefone', $_POST['telefone'], $post_id);
            update_field('data_inicio', $_POST['data_inicio'], $post_id);
            update_field('data_entrega', $_POST['data_entrega'], $post_id);
            
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

            update_field('cor_dominante', $_POST['cor_dominante'], $post_id);
            update_field('escala_de_cor', $_POST['escala_de_cor'], $post_id);
            update_field('cervical', $_POST['cervical'], $post_id);
            update_field('terco_medio', $_POST['terco_medio'], $post_id);
            update_field('marca', $_POST['marca'], $post_id);
            update_field('modelo', $_POST['modelo'], $post_id);
            update_field('plataforma', $_POST['plataforma'], $post_id);
            update_field('scanbody', $_POST['scanbody'], $post_id);
            update_field('observacoes', $_POST['observacoes'], $post_id);

            update_field('criado_por', $user_id, $post_id);
            update_field('laboratorio', $usuario_pai, $post_id);

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
    
                update_field('arquivos', $uploaded_file_ids, $post_id);
            }

            // Redirecione após o envio do formulário
            wp_redirect(home_url('/ordens-de-servico/'));
            exit;
        }
    }
    ?>
    <form id="user-edit-form" method="post" enctype="multipart/form-data">
        <div class="input-group">
            <div class="row">
                <div class="full-width">
                    <label for="nome_do_dentista">Nome do Dentista</label>
                    <input type="text" class="input_line_bottom" name="nome_do_dentista" required>
                </div>
            </div>
            
            <div class="row">
                <div class="full-width">
                    <label for="nome">Nome do Paciente</label>
                    <input type="text" class="input_line_bottom" name="nome" required>
                </div>
            </div>

            <div class="row">
                <div class="one-third-width">
                    <label for="idade">Idade do Paciente</label>
                    <input type="text" class="input_line_bottom" name="idade" required>
                </div>

                <div class="one-third-width">
                    <label for="sexo">Sexo</label>
                    <select name="sexo" class="input_line_bottom" required>
                        <?php
                            $sexo_options = array('Masculino', 'Feminino', 'Outro');
                            foreach ($sexo_options as $opcao) {
                                echo '<option value="' . esc_attr($opcao) . '">' . esc_html($opcao) . '</option>';
                            }
                        ?>
                    </select>
                </div>

                <div class="one-third-width">
                    <label for="telefone">Telefone</label>
                    <input type="text" class="input_line_bottom" name="telefone" required>
                </div>
            </div>  

            <div class="row">
                <div class="half-width">
                    <label for="data_inicio">Data de início</label>
                    <input type="date" class="input_line_bottom" name="data_inicio" required>
                </div>

                <div class="half-width">
                    <label for="data_entrega">Data de entrega</label>
                    <input type="date" class="input_line_bottom" name="data_entrega" required>
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

                        foreach ($levantamento_periapical_01 as $choice_01) {
                            echo '<label><input type="checkbox" name="levantamento_periapical01[]" value="' . esc_attr($choice_01) . '"> ' . esc_html($choice_01) . '</label>';
                        }

                        echo '<span class="divisor">|</span>';

                        foreach ($levantamento_periapical_02 as $choice_02) {
                            echo '<label><input type="checkbox" name="levantamento_periapical02[]" value="' . esc_attr($choice_02) . '"> ' . esc_html($choice_02) . '</label>';
                        }
                        
                        echo '<hr style="margin: 1px 5% !important; width: 90%;">';

                        foreach ($levantamento_periapical_03 as $choice_03) {
                            echo '<label><input type="checkbox" name="levantamento_periapical03[]" value="' . esc_attr($choice_03) . '"> ' . esc_html($choice_03) . '</label>';
                        }

                        echo '<span class="divisor">|</span>';

                        foreach ($levantamento_periapical_04 as $choice_04) {
                            echo '<label><input type="checkbox" name="levantamento_periapical04[]" value="' . esc_attr($choice_04) . '"> ' . esc_html($choice_04) . '</label>';
                        }
                    ?>
                </div>
            </div>
        </div>

        <div class="input-group">
            <div class="row">
                <div class="half-width">
                    <label for="cor_dominante">Cor Dominante</label>
                    <input type="text" class="input_line_bottom" name="cor_dominante" required>
                    <!--<select name="cor_dominante" required>
                        <?php
                            /*$cor_dominante_options = array('A1', 'A2', 'A4', 'A5', 'A6', 'A7', 'A8', 'A9', 'A10');
                            foreach ($cor_dominante_options as $opcao) {
                                echo '<option value="' . esc_attr($opcao) . '">' . esc_html($opcao) . '</option>';
                            }*/
                        ?>
                    </select>-->
                </div>

                <div class="half-width">
                    <label for="escala_de_cor">Escala de Cor</label>
                    <input type="text" class="input_line_bottom" name="escala_de_cor" required>
                    <!--<select name="escala_de_cor" required>
                        <?php
                            /*$escala_de_cor_options = array('A1', 'A2', 'A4', 'A5', 'A6', 'A7', 'A8', 'A9', 'A10');
                            foreach ($escala_de_cor_options as $opcao) {
                                echo '<option value="' . esc_attr($opcao) . '">' . esc_html($opcao) . '</option>';
                            }*/
                        ?>
                    </select>-->
                </div>
            </div>  

            <div class="row">
                <div class="half-width">
                    <label for="cervical">Cervical</label>
                    <input type="text" class="input_line_bottom" name="cervical" required>
                </div>

                <div class="half-width">
                    <label for="terco_medio">Terço Médio</label>
                    <input type="text" class="input_line_bottom" name="terco_medio" required>
                </div>
            </div> 
        </div>

        <div class="input-group"> 
            <label for="implantes" class="label_in_border">Implantes</label>

            <div class="row">
                <div class="half-width">
                    <label for="marca">Marca</label>
                    <input type="text" class="input_line_bottom" name="marca" required>
                </div>

                <div class="half-width">
                    <label for="modelo">Modelo</label>
                    <input type="text" class="input_line_bottom" name="modelo" required>
                </div>

            </div>  

            <div class="row">
                <div class="half-width">
                    <label for="plataforma">Plataforma</label>
                    <input type="text"class="input_line_bottom" name="plataforma" required>
                </div>

                <div class="half-width">
                    <label for="scanbody">Scanbody</label>
                    <input type="text" class="input_line_bottom" name="scanbody" required>
                </div>
            </div> 
        </div>

        <div class="input-group">
            <label for="observacoes" class="label_in_border">Observações</label>
            <textarea name="observacoes" class="input_line_bottom" rows="4"></textarea>
        </div>

        <div class="input-group">
            <label for="file" class="label_in_border">Arquivos</label>
            <div class="row">
                <div class="one-third-width">
                    <div class="custom-file-input">
                        <input type="file" name="file[]" multiple accept=".pdf, .doc, .docx, .jpg, .jpeg, .png, .mp4, .stl">
                    </div>
                </div>
            </div>
        </div>

        <div style="display: flex;">
            <input type="submit" value="Cadastrar OS" style="margin-top: 30px;">
            <input type="button" value="Cancelar" onclick="voltarPagina()" style="background: #fb04ab; margin-top: 30px; margin-left: 20px; width: auto;">
        </div>
    </form>
    <?php
}
add_shortcode('form_os_clinicas', 'form_os_clinicas');