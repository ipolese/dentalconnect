<?php

function edit_os_dentistas($view) {
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
        
        $observacoes = sanitize_text_field($_POST['observacoes']);
        $observacoes_requisicao_exame = sanitize_text_field($_POST['observacoes_requisicao_exame']);

        // Atualize os campos da OS
        if (isset($post_id)) {

            update_field('nome_do_dentista', $nome_do_dentista, $post_id);
            update_field('nome', $nome, $post_id);
            update_field('idade', $idade, $post_id);
            update_field('sexo', $sexo, $post_id);
            update_field('telefone', $telefone, $post_id);
            update_field('data_inicio', $data_inicio, $post_id);
            update_field('data_entrega', $data_entrega, $post_id);

            update_field('doc_ortodontica_basica', sanitize_text_field($_POST['doc_ortodontica_basica'] ?? ''), $post_id);
            update_field('doc_ortodontica_completa', sanitize_text_field($_POST['doc_ortodontica_completa'] ?? ''), $post_id);
            update_field('doc_para_implante', sanitize_text_field($_POST['doc_para_implante'] ?? ''), $post_id);
            update_field('periapicais', sanitize_text_field($_POST['periapicais'] ?? ''), $post_id);

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

            $interproximal = isset($_POST['interproximal']) ? $_POST['interproximal'] : array();
            $interproximal = array_filter($interproximal);
            $interproximal = implode(', ', $interproximal);
            update_field('interproximal', $interproximal, $post_id);

            $oclusal = isset($_POST['oclusal']) ? $_POST['oclusal'] : array();
            $oclusal = array_filter($oclusal);
            $oclusal = implode(', ', $oclusal);
            update_field('oclusal', $oclusal, $post_id);

            update_field('panoramica_normal', sanitize_text_field($_POST['panoramica_normal'] ?? ''), $post_id);
            update_field('panoramica_p_implante_c_pontos_anatomicos', sanitize_text_field($_POST['panoramica_p_implante_c_pontos_anatomicos'] ?? ''), $post_id);
            
            $tele_radiografia = isset($_POST['tele_radiografia']) ? $_POST['tele_radiografia'] : array();
            $tele_radiografia = array_filter($tele_radiografia);
            $tele_radiografia = implode(', ', $tele_radiografia);
            update_field('tele_radiografia', $tele_radiografia, $post_id);

            $tele_radiografia_frontal_pa = isset($_POST['tele_radiografia_frontal_pa']) ? $_POST['tele_radiografia_frontal_pa'] : array();
            $tele_radiografia_frontal_pa = array_filter($tele_radiografia_frontal_pa);
            $tele_radiografia_frontal_pa = implode(', ', $tele_radiografia_frontal_pa);
            update_field('tele_radiografia_frontal_pa', $tele_radiografia_frontal_pa, $post_id);

            $seios_da_face = isset($_POST['seios_da_face']) ? $_POST['seios_da_face'] : array();
            $seios_da_face = array_filter($seios_da_face);
            $seios_da_face = implode(', ', $seios_da_face);
            update_field('seios_da_face', $seios_da_face, $post_id);

            update_field('mao_e_punho_idade_ossea', sanitize_text_field($_POST['mao_e_punho_idade_ossea'] ?? ''), $post_id);
            update_field('analise_das_vias_aereas_adenoide', sanitize_text_field($_POST['analise_das_vias_aereas_adenoide'] ?? ''), $post_id);

            $atm_transcraniana = isset($_POST['atm_transcraniana']) ? $_POST['atm_transcraniana'] : array();
            $atm_transcraniana = array_filter($atm_transcraniana);
            $atm_transcraniana = implode(', ', $atm_transcraniana);
            update_field('atm_transcraniana', $atm_transcraniana, $post_id);

            update_field('panoramica_de_atm', sanitize_text_field($_POST['panoramica_de_atm'] ?? ''), $post_id);
            update_field('observacoes', $observacoes, $post_id);
            update_field('modelo_de_estudo', sanitize_text_field($_POST['modelo_de_estudo'] ?? ''), $post_id);
            update_field('modelo_de_trabalho', sanitize_text_field($_POST['modelo_de_trabalho'] ?? ''), $post_id);
            update_field('modelo_digital', sanitize_text_field($_POST['modelo_digital'] ?? ''), $post_id);

            $modelo_digital_para_alinhadores = isset($_POST['modelo_digital_para_alinhadores']) ? $_POST['modelo_digital_para_alinhadores'] : array();
            $modelo_digital_para_alinhadores = array_filter($modelo_digital_para_alinhadores);
            $modelo_digital_para_alinhadores = implode(', ', $modelo_digital_para_alinhadores);
            update_field('modelo_digital_para_alinhadores', $modelo_digital_para_alinhadores, $post_id);

            $fotografias = isset($_POST['fotografias']) ? $_POST['fotografias'] : array();
            $fotografias = array_filter($fotografias);
            $fotografias = implode(', ', $fotografias);
            update_field('fotografias', $fotografias, $post_id);

            $indicacao_do_exame_informacoes_principais_e_auxiliares_para_o_radiologista = isset($_POST['indicacao_do_exame_informacoes_principais_e_auxiliares_para_o_radiologista']) ? $_POST['indicacao_do_exame_informacoes_principais_e_auxiliares_para_o_radiologista'] : array();
            $indicacao_do_exame_informacoes_principais_e_auxiliares_para_o_radiologista = array_filter($indicacao_do_exame_informacoes_principais_e_auxiliares_para_o_radiologista);
            $indicacao_do_exame_informacoes_principais_e_auxiliares_para_o_radiologista = implode(', ', $indicacao_do_exame_informacoes_principais_e_auxiliares_para_o_radiologista);
            update_field('indicacao_do_exame_informacoes_principais_e_auxiliares_para_o_radiologista', $indicacao_do_exame_informacoes_principais_e_auxiliares_para_o_radiologista, $post_id);

            update_field('observacoes_requisicao_exame', $observacoes_requisicao_exame, $post_id);
            update_field('com_afastamento_labial', sanitize_text_field($_POST['com_afastamento_labial'] ?? ''), $post_id);
            update_field('maxila', sanitize_text_field($_POST['maxila'] ?? ''), $post_id);
            update_field('mandibula', sanitize_text_field($_POST['mandibula'] ?? ''), $post_id);
            update_field('1_ou_2_elementos', sanitize_text_field($_POST['1_ou_2_elementos'] ?? ''), $post_id);
            update_field('max_d', sanitize_text_field($_POST['max_d'] ?? ''), $post_id);
            update_field('max_a', sanitize_text_field($_POST['max_a'] ?? ''), $post_id);
            update_field('max_e', sanitize_text_field($_POST['max_e'] ?? ''), $post_id);
            update_field('man_d', sanitize_text_field($_POST['man_d'] ?? ''), $post_id);
            update_field('man_a', sanitize_text_field($_POST['man_a'] ?? ''), $post_id);
            update_field('man_e', sanitize_text_field($_POST['man_e'] ?? ''), $post_id);

            $atm = isset($_POST['atm']) ? $_POST['atm'] : array();
            $atm = array_filter($atm);
            $atm = implode(', ', $atm);
            update_field('atm', $atm, $post_id);

            update_field('tecnica_de_localizacao', sanitize_text_field($_POST['tecnica_de_localizacao'] ?? ''), $post_id);

            $tomografia_para_guia_cirurgico = isset($_POST['tomografia_para_guia_cirurgico']) ? $_POST['tomografia_para_guia_cirurgico'] : array();
            $tomografia_para_guia_cirurgico = array_filter($tomografia_para_guia_cirurgico);
            $tomografia_para_guia_cirurgico = implode(', ', $tomografia_para_guia_cirurgico);
            update_field('tomografia_para_guia_cirurgico', $tomografia_para_guia_cirurgico, $post_id);

            update_field('cd', sanitize_text_field($_POST['cd'] ?? ''), $post_id);
            update_field('impressao_em_filme', sanitize_text_field($_POST['impressao_em_filme'] ?? ''), $post_id);
            update_field('dicom', sanitize_text_field($_POST['dicom'] ?? ''), $post_id);
            update_field('entregar_no_consultorio', sanitize_text_field($_POST['entregar_no_consultorio'] ?? ''), $post_id);
            update_field('urgente_entregar_na_hora_sem_laudo', sanitize_text_field($_POST['urgente_entregar_na_hora_sem_laudo'] ?? ''), $post_id);
            update_field('favor_enviar_mais_requisicoes', sanitize_text_field($_POST['favor_enviar_mais_requisicoes'] ?? ''), $post_id);

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
            <label for="documentacao_odontologica" class="label_in_border">Documentação Odontológica</label>
            <div class="row">
                <div class="full-width">
                    <?php $checked = (get_post_meta($post_id, 'doc_ortodontica_basica', true) == 1) ? 'checked' : '';?>
                    <label class="checkbox"><input type="checkbox" name="doc_ortodontica_basica" value="1" <?php echo $checked; ?> <?php echo $disabled; ?>>Doc. Ortodôntica Básica<br />
                    <span class="docs">Panorâmica, Tele-radiografia d e Perfil, Periapicais Anteriores, Modelos, (09) Fots, Traçados Cefalométricos</span></label>
                </div>
            </div>
            
            <div class="row">
                <div class="full-width">
                    <?php $checked = (get_post_meta($post_id, 'doc_ortodontica_completa', true) == 1) ? 'checked' : '';?>
                    <label class="checkbox"><input type="checkbox" name="doc_ortodontica_completa" value="1" <?php echo $checked; ?> <?php echo $disabled; ?>>Doc. Ortodôntica Completa<br />
                    <span class="docs">Panorâmica, Tele-radiografia d e Perfil, 2 Periapicais Anteriores, (09) Fotos, Mão e Punho (Idade Ósea,) Análise das Vias Aéreas 
                        (Adenóide), Previsão de uprçãorI dos 3°M,esarol Modelos (Acn/álise e xerox) eTraçados Cefalométricos</span></label>
                </div>
            </div>
            
            <div class="row">
                <div class="full-width">
                    <?php $checked = (get_post_meta($post_id, 'doc_para_implante', true) == 1) ? 'checked' : '';?>
                    <label class="checkbox"><input type="checkbox" name="doc_para_implante" value="1" <?php echo $checked; ?> <?php echo $disabled; ?>>Doc. para Implante<br />
                    <span class="docs">Panorâmica, Periapicais Milimetradas, Oclusal na Região od Implante, Modelos, (09)Fotos e Traçado com pontos anatômicos</span></label>
                </div>
            </div>
        </div>

        <div class="input-group">
            <label for="radiografias_intrabucais" class="label_in_border">Radiografias Intrabucais</label>
            <div class="row">
                <div class="full-width">
                    <?php $checked = (get_post_meta($post_id, 'periapicais', true) == 1) ? 'checked' : '';?>
                    <label class="checkbox"><input type="checkbox" name="periapicais" value="1" <?php echo $checked; ?> <?php echo $disabled; ?>>Periapicais</label>
                </div>
            </div>

            <div class="row_inline">
                <label for="levantamento_periapical">Levantamento Periapical</label><br />
                <div class="group">
                    <?php
                        $levantamento_periapical_01 = array('18', '17', '16', '15', '14', '13', '12', '11');
                        $levantamento_periapical_02 = array('21', '22', '23', '24', '25', '26', '27', '28');
                        $levantamento_periapical_03 = array('48', '47', '46', '45', '44', '43', '42', '41');
                        $levantamento_periapical_04 = array('31', '32', '33', '34', '35', '36', '37', '38');

                        $levantamento_periapical = get_post_meta($post_id, 'levantamento_periapical', true);
                        $levantamento_periapical = explode(', ', $levantamento_periapical);

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

            <div class="row_inline_simple">
                <label for="interproximal">Interproximal</label><br />
                <div class="group">
                    <?php
                        $interproximal_values = get_field('interproximal', $post_id);
                        $interproximal_options = array(
                            'Molares Dir.',
                            'Molares Esq.',
                            'Pré-molares Dir.',
                            'Pré-molares Esq.',
                            'Anteriores'
                        );

                        foreach ($interproximal_options as $option) {
                            $checked = in_array($option, $interproximal_values) ? 'checked' : '';
                            echo '<label><input type="checkbox" name="interproximal[]" value="' . esc_attr($option) . '" ' . $checked . ' ' . $disabled . '>' . esc_html($option) . '</label>';
                        }
                    ?>
                </div>
            </div>

            <div class="row_inline_simple">
                <label for="oclusal">Oclusal</label><br />
                <div class="group">
                    <?php
                        $oclusal_values = get_field('oclusal', $post_id);
                        $oclusal_options = array(
                            'Superior',
                            'Inferior',
                            'Total',
                            'Parcial',
                            'À Direita',
                            'À Esquerda'
                        );

                        foreach ($oclusal_options as $option) {
                            $checked = in_array($option, $oclusal_values) ? 'checked' : '';
                            echo '<label><input type="checkbox" name="oclusal[]" value="' . esc_attr($option) . '" ' . $checked . ' ' . $disabled . '>' . esc_html($option) . '</label>';
                        }
                    ?>
                </div>
            </div>
        </div>
        
        <div class="input-group">
            <label for="radiografias_extrabucais" class="label_in_border">Radiografias Extrabucais</label>
            <div class="row">
                <div class="half-width">
                    <?php $checked = (get_post_meta($post_id, 'panoramica_normal', true) == 1) ? 'checked' : '';?>
                    <label class="checkbox"><input type="checkbox" name="panoramica_normal" value="1" <?php echo $checked; ?> <?php echo $disabled; ?>>Panorâmica Normal</label>
                </div>

                <div class="half-width">
                    <?php $checked = (get_post_meta($post_id, 'panoramica_p_implante_c_pontos_anatomicos', true) == 1) ? 'checked' : '';?>
                    <label class="checkbox"><input type="checkbox" name="panoramica_p_implante_c_pontos_anatomicos" value="1" <?php echo $checked; ?> <?php echo $disabled; ?>>Panorâmica p/ Implante c/ Pontos Anatômicos</label>
                </div>
            </div>

            <div class="row_inline_simple">
                <label for="tele_radiografia">Tele-radiografia</label><br />
                <div class="group">
                    <?php
                        $tele_radiografia_values = get_field('tele_radiografia', $post_id);
                        $tele_radiografia_options = array(
                            'Sem Traçado',
                            'Com Cefalometria'
                        );

                        foreach ($tele_radiografia_options as $option) {
                            $checked = in_array($option, $tele_radiografia_values) ? 'checked' : '';
                            echo '<label><input type="checkbox" name="tele_radiografia[]" value="' . esc_attr($option) . '" ' . $checked . ' ' . $disabled . '>' . esc_html($option) . '</label>';
                        }
                    ?>
                </div>
            </div>

            <div class="row_inline_simple">
                <label for="tele_radiografia_frontal_pa">Tele-radiografia Frontal (PA)</label><br />
                <div class="group">
                    <?php
                        $tele_radiografia_frontal_pa_values = get_field('tele_radiografia_frontal_pa', $post_id);
                        $tele_radiografia_frontal_pa_options = array(
                            'Boca aberta',
                            'Boca fechada'
                        );

                        foreach ($tele_radiografia_frontal_pa_options as $option) {
                            $checked = in_array($option, $tele_radiografia_frontal_pa_values) ? 'checked' : '';
                            echo '<label><input type="checkbox" name="tele_radiografia_frontal_pa[]" value="' . esc_attr($option) . '" ' . $checked . ' ' . $disabled . '>' . esc_html($option) . '</label>';
                        }
                    ?>
                </div>
            </div>

            <div class="row_inline_simple">
                <label for="seios_da_face">Seios da Face</label><br />
                <div class="group">
                    <?php
                        $seios_da_face_values = get_field('seios_da_face', $post_id);
                        $seios_da_face_options = array(
                            'Seios Esfenoidais',
                            'Seios Etmoidais',
                            'Seios Maxilares (Waters)',
                            'Seios Frontais (Calddwell)'
                        );

                        foreach ($seios_da_face_options as $option) {
                            $checked = in_array($option, $seios_da_face_values) ? 'checked' : '';
                            echo '<label><input type="checkbox" name="seios_da_face[]" value="' . esc_attr($option) . '" ' . $checked . ' ' . $disabled . '>' . esc_html($option) . '</label>';
                        }
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="half-width">
                    <?php $checked = (get_post_meta($post_id, 'mao_e_punho_idade_ossea', true) == 1) ? 'checked' : '';?>
                    <label class="checkbox"><input type="checkbox" name="mao_e_punho_idade_ossea" value="1" <?php echo $checked; ?> <?php echo $disabled; ?>>Mão e Punho (Idade Óssea)</label>
                </div>
                
                <div class="half-width">
                    <?php $checked = (get_post_meta($post_id, 'analise_das_vias_aereas_adenoide', true) == 1) ? 'checked' : '';?>
                    <label class="checkbox"><input type="checkbox" name="analise_das_vias_aereas_adenoide" value="1" <?php echo $checked; ?> <?php echo $disabled; ?>>Análise das Vias Aéreas (Adenóide)</label>
                </div>
            </div>

            <div class="row_inline_simple">
                <label for="atm_transcraniana">ATM (Transcraniana)</label><br />
                <div class="group">
                    <?php
                        $atm_transcraniana_values = get_field('atm_transcraniana', $post_id);
                        $atm_transcraniana_options = array(
                            '4 posições',
                            '6 posições'
                        );

                        foreach ($atm_transcraniana_options as $option) {
                            $checked = in_array($option, $atm_transcraniana_values) ? 'checked' : '';
                            echo '<label><input type="checkbox" name="atm_transcraniana[]" value="' . esc_attr($option) . '" ' . $checked . ' ' . $disabled . '>' . esc_html($option) . '</label>';
                        }
                    ?>
                </div>
            </div>
            
            <div class="row">
                <div class="full-width">
                    <?php $checked = (get_post_meta($post_id, 'panoramica_de_atm', true) == 1) ? 'checked' : '';?>
                    <label class="checkbox"><input type="checkbox" name="panoramica_de_atm" value="1" <?php echo $checked; ?> <?php echo $disabled; ?>>Panorâmica de ATM</label>
                </div>
            </div>
        </div>

        <div class="input-group">
            <label for="observacoes" class="label_in_border">Observações</label>
            <textarea name="observacoes" class="input_line_bottom" rows="4" <?php echo $disabled; ?>><?php echo esc_textarea(get_post_meta($post_id, 'observacoes', true)); ?></textarea>
        </div>
        
        <div class="input-group">
            <label for="servicos" class="label_in_border">Serviços</label>
            <div class="row">
                <div class="one-third-width">
                    <?php $checked = (get_post_meta($post_id, 'modelo_de_estudo', true) == 1) ? 'checked' : '';?>
                    <label class="checkbox"><input type="checkbox" name="modelo_de_estudo" value="1" <?php echo $checked; ?> <?php echo $disabled; ?>>Modelo de Estudo</label>
                </div>
                
                <div class="one-third-width">
                    <?php $checked = (get_post_meta($post_id, 'modelo_de_trabalho', true) == 1) ? 'checked' : '';?>
                    <label class="checkbox"><input type="checkbox" name="modelo_de_trabalho" value="1" <?php echo $checked; ?> <?php echo $disabled; ?>>Modelo de Trabalho</label>
                </div>
                
                <div class="one-third-width">
                    <?php $checked = (get_post_meta($post_id, 'modelo_digital', true) == 1) ? 'checked' : '';?>
                    <label class="checkbox"><input type="checkbox" name="modelo_digital" value="1" <?php echo $checked; ?> <?php echo $disabled; ?>>Modelo Digital</label>
                </div>
            </div> 

            <div class="row_inline_simple">
                <label for="modelo_digital_para_alinhadores">Modelo Digital para Alinhadores</label><br />
                <div class="group">
                    <?php
                        $modelo_digital_para_alinhadores_values = get_field('modelo_digital_para_alinhadores', $post_id);
                        $modelo_digital_para_alinhadores_options = array(
                            'Easy Solution',
                            'Invisalign',
                            'Outros'
                        );

                        foreach ($modelo_digital_para_alinhadores_options as $option) {
                            $checked = in_array($option, $modelo_digital_para_alinhadores_values) ? 'checked' : '';
                            echo '<label><input type="checkbox" name="modelo_digital_para_alinhadores[]" value="' . esc_attr($option) . '" ' . $checked . ' ' . $disabled . '>' . esc_html($option) . '</label>';
                        }
                    ?>
                </div>
            </div> 

            <div class="row_inline_simple">
                <label for="fotografias">Fotografias</label><br />
                <div class="group">
                    <?php
                        $fotografias_values = get_field('fotografias', $post_id);
                        $fotografias_options = array(
                            '2 Fotos (Frente e Perfil)',
                            '3 Fotos (Intrabucais)',
                            '2 Fotos (Oclusais)',
                            '1 Foto (Sorriso)',
                            'Overjet'
                        );

                        foreach ($fotografias_options as $option) {
                            $checked = in_array($option, $fotografias_values) ? 'checked' : '';
                            echo '<label><input type="checkbox" name="fotografias[]" value="' . esc_attr($option) . '" ' . $checked . ' ' . $disabled . '>' . esc_html($option) . '</label>';
                        }
                    ?>
                </div>
            </div> 
        </div>
        
        <div class="input-group">
            <label for="requiscao_exame" class="label_in_border">Requisição de Exame Tomográfico Computadorizado</label>
            <div class="row_inline_simple">
                <label for="indicacao_do_exame_informacoes_principais_e_auxiliares_para_o_radiologista">Indicação do exame /Informações principais e auxiliares para o radiologista</label><br />
                <div class="group">
                    <?php
                        $indicacao_do_exame_informacoes_principais_e_auxiliares_para_o_radiologista_values = get_field('indicacao_do_exame_informacoes_principais_e_auxiliares_para_o_radiologista', $post_id);
                        $indicacao_do_exame_informacoes_principais_e_auxiliares_para_o_radiologista_options = array(
                            'Implantodontia',
                            'Dentística',
                            'Prótese',
                            'Cirurgia Buco-Maxilio-Facial',
                            'Endodontia',
                            'Traumatismo',
                            'Ortodontia',
                            'Lesões',
                            'Cirurgia Ortognática',
                            'Periodontia',
                            'DTM',
                            'Outros'
                        );

                        foreach ($indicacao_do_exame_informacoes_principais_e_auxiliares_para_o_radiologista_options as $option) {
                            $checked = in_array($option, $indicacao_do_exame_informacoes_principais_e_auxiliares_para_o_radiologista_values) ? 'checked' : '';
                            echo '<label><input type="checkbox" name="indicacao_do_exame_informacoes_principais_e_auxiliares_para_o_radiologista[]" value="' . esc_attr($option) . '" ' . $checked . ' ' . $disabled . '>' . esc_html($option) . '</label>';
                        }
                    ?>
                </div>
            </div> 

            <div class="row" style="margin-top: 35px;">
                <label for="observacoes_requisicao_exame" class="label_in_border">Obs.:</label>
                <textarea name="observacoes_requisicao_exame" class="input_line_bottom" rows="1" style="min-height: auto;"<?php echo $disabled; ?>><?php echo esc_textarea(get_post_meta($post_id, 'observacoes_requisicao_exame', true)); ?></textarea>
            </div>
        </div>
        
        <div class="input-group">
            <label for="aquiscao_imagem" class="label_in_border">Aquisição de Imagem Tomográfica</label>
            <div class="row">
                <div class="one-third-width">
                    <?php $checked = (get_post_meta($post_id, 'com_afastamento_labial', true) == 1) ? 'checked' : '';?>
                    <label class="checkbox"><input type="checkbox" name="com_afastamento_labial" value="1" <?php echo $checked; ?> <?php echo $disabled; ?>>Com Afastamento Labial</label>
                </div>

                <div class="one-third-width">
                    <?php $checked = (get_post_meta($post_id, 'maxila', true) == 1) ? 'checked' : '';?>
                    <label class="checkbox"><input type="checkbox" name="maxila" value="1" <?php echo $checked; ?> <?php echo $disabled; ?>>Maxila</label>
                </div>

                <div class="one-third-width">
                    <?php $checked = (get_post_meta($post_id, 'mandibula', true) == 1) ? 'checked' : '';?>
                    <label class="checkbox"><input type="checkbox" name="mandibula" value="1" <?php echo $checked; ?> <?php echo $disabled; ?>>Mandíbula</label>
                </div>
            </div>

            <div class="row">
                <div class="full-width">
                    <?php $checked = (get_post_meta($post_id, '1_ou_2_elementos', true) == 1) ? 'checked' : '';?>
                    <label class="checkbox"><input type="checkbox" name="1_ou_2_elementos" value="1" <?php echo $checked; ?> <?php echo $disabled; ?>>1 ou 2 Elementos (endodontia - diagnóstico)</label>
                </div>
            </div> 

            <div class="row">
                <div class="one-third-width">
                    <?php $checked = (get_post_meta($post_id, 'max_d', true) == 1) ? 'checked' : '';?>
                    <label class="checkbox"><input type="checkbox" name="max_d" value="1" <?php echo $checked; ?> <?php echo $disabled; ?>>Max-D</label>
                </div>

                <div class="one-third-width">
                    <?php $checked = (get_post_meta($post_id, 'max_a', true) == 1) ? 'checked' : '';?>
                    <label class="checkbox"><input type="checkbox" name="max_a" value="1" <?php echo $checked; ?> <?php echo $disabled; ?>>Max-A</label>
                </div>

                <div class="one-third-width">
                    <?php $checked = (get_post_meta($post_id, 'max_e', true) == 1) ? 'checked' : '';?>
                    <label class="checkbox"><input type="checkbox" name="max_e" value="1" <?php echo $checked; ?> <?php echo $disabled; ?>>Max-E</label>
                </div>
            </div>
            
            <div class="row">
                <div class="one-third-width">
                    <?php $checked = (get_post_meta($post_id, 'man_d', true) == 1) ? 'checked' : '';?>
                    <label class="checkbox"><input type="checkbox" name="man_d" value="1" <?php echo $checked; ?> <?php echo $disabled; ?>>Man-D</label>
                </div>

                <div class="one-third-width">
                    <?php $checked = (get_post_meta($post_id, 'man_a', true) == 1) ? 'checked' : '';?>
                    <label class="checkbox"><input type="checkbox" name="man_a" value="1" <?php echo $checked; ?> <?php echo $disabled; ?>>Man-A</label>
                </div>

                <div class="one-third-width">
                    <?php $checked = (get_post_meta($post_id, 'man_e', true) == 1) ? 'checked' : '';?>
                    <label class="checkbox"><input type="checkbox" name="man_e" value="1" <?php echo $checked; ?> <?php echo $disabled; ?>>Man-E</label>
                </div>
            </div>

            <div class="row_inline_simple">
                <label for="atm">ATM</label><br />
                <div class="group">
                    <?php
                        $atm_values = get_field('atm', $post_id);
                        $atm_options = array(
                            'Boca Fechada',
                            'Boca Aberta'
                        );

                        foreach ($atm_options as $option) {
                            $checked = in_array($option, $atm_values) ? 'checked' : '';
                            echo '<label><input type="checkbox" name="atm[]" value="' . esc_attr($option) . '" ' . $checked . ' ' . $disabled . '>' . esc_html($option) . '</label>';
                        }
                    ?>
                </div>
            </div> 

            <div class="row">
                <div class="full-width">
                    <?php $checked = (get_post_meta($post_id, 'tecnica_de_localizacao', true) == 1) ? 'checked' : '';?>
                    <label class="checkbox"><input type="checkbox" name="tecnica_de_localizacao" value="1" <?php echo $checked; ?> <?php echo $disabled; ?>>Técnica de Localização (1 ou 2 elementos)</label>
                </div>
            </div> 

            <div class="row_inline_simple">
                <label for="tomografia_para_guia_cirurgico">Tomografia para Guia Cirúrgico</label><br />
                <div class="group">
                    <?php
                        $tomografia_para_guia_cirurgico_values = get_field('tomografia_para_guia_cirurgico', $post_id);
                        $tomografia_para_guia_cirurgico_options = array(
                            'Guia para Implante',
                            'Guia Periodontal',
                            'Guia Endoguide'
                        );

                        foreach ($tomografia_para_guia_cirurgico_options as $option) {
                            $checked = in_array($option, $tomografia_para_guia_cirurgico_values) ? 'checked' : '';
                            echo '<label><input type="checkbox" name="tomografia_para_guia_cirurgico[]" value="' . esc_attr($option) . '" ' . $checked . ' ' . $disabled . '>' . esc_html($option) . '</label>';
                        }
                    ?>
                </div>
            </div>
            
            <div class="row">
                <div class="full-width">
                    <?php $checked = (get_post_meta($post_id, 'cd', true) == 1) ? 'checked' : '';?>
                    <label class="checkbox"><input type="checkbox" name="cd" value="1" <?php echo $checked; ?> <?php echo $disabled; ?>>CD - Software de Visualização Denta Slice</label>
                </div>
            </div>

            <div class="row">
                <div class="half-width">
                    <?php $checked = (get_post_meta($post_id, 'impressao_em_filme', true) == 1) ? 'checked' : '';?>
                    <label class="checkbox"><input type="checkbox" name="impressao_em_filme" value="1" <?php echo $checked; ?> <?php echo $disabled; ?>>Impressão em Filme</label>
                </div>

                <div class="half-width">
                    <?php $checked = (get_post_meta($post_id, 'dicom', true) == 1) ? 'checked' : '';?>
                    <label class="checkbox"><input type="checkbox" name="dicom" value="1" <?php echo $checked; ?> <?php echo $disabled; ?>>Dicom</label>
                </div>
            </div>
        </div>
        
        <div class="input-group">
            <div class="row">
                <div class="full-width">
                    <?php $checked = (get_post_meta($post_id, 'entregar_no_consultorio', true) == 1) ? 'checked' : '';?>
                    <label class="checkbox"><input type="checkbox" name="entregar_no_consultorio" value="1" <?php echo $checked; ?> <?php echo $disabled; ?>>Entregar no Consultório</label>
                </div>
            </div>

            <div class="row">
                <div class="full-width">
                    <?php $checked = (get_post_meta($post_id, 'urgente_entregar_na_hora_sem_laudo', true) == 1) ? 'checked' : '';?>
                    <label class="checkbox"><input type="checkbox" name="urgente_entregar_na_hora_sem_laudo" value="1" <?php echo $checked; ?> <?php echo $disabled; ?>>Urgente (Entregar na Hora sem Laudo)</label>
                </div>
            </div>

            <div class="row">
                <div class="full-width">
                    <?php $checked = (get_post_meta($post_id, 'favor_enviar_mais_requisicoes', true) == 1) ? 'checked' : '';?>
                    <label class="checkbox"><input type="checkbox" name="favor_enviar_mais_requisicoes" value="1" <?php echo $checked; ?> <?php echo $disabled; ?>>Favor Enviar mais Requisições</label>
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
add_shortcode('edit_os_dentistas', 'edit_os_dentistas');