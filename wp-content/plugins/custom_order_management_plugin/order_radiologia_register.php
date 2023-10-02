<?php

function form_os_dentistas() {
    require_once ABSPATH . 'wp-admin/includes/image.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';

    $user_id = get_current_user_id();
    $usuario_pai = get_field('usuario_pai', 'user_' . $user_id);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome'])) {
        $titulo = '#OS_' . $_POST['nome'];

        $post_data = array(
            'post_title'    => $titulo,
            'post_type'     => 'os_radiologia',
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

            update_field('doc_ortodontica_basica', $_POST['doc_ortodontica_basica'], $post_id);
            update_field('doc_ortodontica_completa', $_POST['doc_ortodontica_completa'], $post_id);
            update_field('doc_para_implante', $_POST['doc_para_implante'], $post_id);
            update_field('periapicais', $_POST['periapicais'], $post_id);
            
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

            update_field('panoramica_normal', $_POST['panoramica_normal'], $post_id);
            update_field('panoramica_p_implante_c_pontos_anatomicos', $_POST['panoramica_p_implante_c_pontos_anatomicos'], $post_id);
            
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

            update_field('mao_e_punho_idade_ossea', $_POST['mao_e_punho_idade_ossea'], $post_id);
            update_field('analise_das_vias_aereas_adenoide', $_POST['analise_das_vias_aereas_adenoide'], $post_id);

            $atm_transcraniana = isset($_POST['atm_transcraniana']) ? $_POST['atm_transcraniana'] : array();
            $atm_transcraniana = array_filter($atm_transcraniana);
            $atm_transcraniana = implode(', ', $atm_transcraniana);
            update_field('atm_transcraniana', $atm_transcraniana, $post_id);

            update_field('panoramica_de_atm', $_POST['panoramica_de_atm'], $post_id);
            update_field('observacoes', $_POST['observacoes'], $post_id);
            update_field('modelo_de_estudo', $_POST['modelo_de_estudo'], $post_id);
            update_field('modelo_de_trabalho', $_POST['modelo_de_trabalho'], $post_id);
            update_field('modelo_digital', $_POST['modelo_digital'], $post_id);

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

            update_field('observacoes_requisicao_exame', $_POST['observacoes_requisicao_exame'], $post_id);
            update_field('com_afastamento_labial', $_POST['com_afastamento_labial'], $post_id);
            update_field('maxila', $_POST['maxila'], $post_id);
            update_field('mandibula', $_POST['mandibula'], $post_id);
            update_field('1_ou_2_elementos', $_POST['1_ou_2_elementos'], $post_id);
            update_field('max_d', $_POST['max_d'], $post_id);
            update_field('max_a', $_POST['max_a'], $post_id);
            update_field('max_e', $_POST['max_e'], $post_id);
            update_field('man_d', $_POST['man_d'], $post_id);
            update_field('man_a', $_POST['man_a'], $post_id);
            update_field('man_e', $_POST['man_e'], $post_id);

            $atm = isset($_POST['atm']) ? $_POST['atm'] : array();
            $atm = array_filter($atm);
            $atm = implode(', ', $atm);
            update_field('atm', $atm, $post_id);

            update_field('tecnica_de_localizacao', $_POST['tecnica_de_localizacao'], $post_id);

            $tomografia_para_guia_cirurgico = isset($_POST['tomografia_para_guia_cirurgico']) ? $_POST['tomografia_para_guia_cirurgico'] : array();
            $tomografia_para_guia_cirurgico = array_filter($tomografia_para_guia_cirurgico);
            $tomografia_para_guia_cirurgico = implode(', ', $tomografia_para_guia_cirurgico);
            update_field('tomografia_para_guia_cirurgico', $tomografia_para_guia_cirurgico, $post_id);

            update_field('cd', $_POST['cd'], $post_id);
            update_field('impressao_em_filme', $_POST['impressao_em_filme'], $post_id);
            update_field('dicom', $_POST['dicom'], $post_id);
            update_field('entregar_no_consultorio', $_POST['entregar_no_consultorio'], $post_id);
            update_field('urgente_entregar_na_hora_sem_laudo', $_POST['urgente_entregar_na_hora_sem_laudo'], $post_id);
            update_field('favor_enviar_mais_requisicoes', $_POST['favor_enviar_mais_requisicoes'], $post_id);

            update_field('criado_por', $user_id, $post_id);
            update_field('radiologia', $usuario_pai, $post_id);

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
            <label for="documentacao_odontologica" class="label_in_border">Documentação Odontológica</label>
            <div class="row">
                <div class="full-width">
                    <label class="checkbox"><input type="checkbox" name="doc_ortodontica_basica" value="1">Doc. Ortodôntica Básica<br />
                    <span class="docs">Panorâmica, Tele-radiografia d e Perfil, Periapicais Anteriores, Modelos, (09) Fots, Traçados Cefalométricos</span></label>
                </div>
            </div>
            
            <div class="row">
                <div class="full-width">
                    <label class="checkbox"><input type="checkbox" name="doc_ortodontica_completa" value="1">Doc. Ortodôntica Completa<br />
                    <span class="docs">Panorâmica, Tele-radiografia d e Perfil, 2 Periapicais Anteriores, (09) Fotos, Mão e Punho (Idade Ósea,) Análise das Vias Aéreas 
                        (Adenóide), Previsão de uprçãorI dos 3°M,esarol Modelos (Acn/álise e xerox) eTraçados Cefalométricos</span></label>
                </div>
            </div>
            
            <div class="row">
                <div class="full-width">
                    <label class="checkbox"><input type="checkbox" name="doc_para_implante" value="1">Doc. para Implante<br />
                    <span class="docs">Panorâmica, Periapicais Milimetradas, Oclusal na Região od Implante, Modelos, (09)Fotos e Traçado com pontos anatômicos</span></label>
                </div>
            </div>
        </div>

        <div class="input-group">
            <label for="radiografias_intrabucais" class="label_in_border">Radiografias Intrabucais</label>
            <div class="row">
                <div class="full-width">
                    <label class="checkbox"><input type="checkbox" name="periapicais" value="1">Periapicais</label>
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

            <div class="row_inline_simple">
                <label for="interproximal">Interproximal</label><br />
                <div class="group">
                    <label><input type="checkbox" name="interproximal[]" value="Molares Dir.">Molares Dir.</label>
                    <label><input type="checkbox" name="interproximal[]" value="Molares Esq.">Molares Esq.</label>
                    <label><input type="checkbox" name="interproximal[]" value="Pré-molares Dir.">Pré-molares Dir.</label>
                    <label><input type="checkbox" name="interproximal[]" value="Pré-molares Esq.">Pré-molares Esq.</label>
                    <label><input type="checkbox" name="interproximal[]" value="Anteriores">Anteriores</label>
                </div>
            </div>

            <div class="row_inline_simple">
                <label for="oclusal">Oclusal</label><br />
                <div class="group">
                    <label><input type="checkbox" name="oclusal[]" value="Superior">Superior</label>
                    <label><input type="checkbox" name="oclusal[]" value="Inferior">Inferior</label>
                    <label><input type="checkbox" name="oclusal[]" value="Total">Total</label>
                    <label><input type="checkbox" name="oclusal[]" value="Parcial">Parcial</label>
                    <label><input type="checkbox" name="oclusal[]" value="À Direita">À Direita</label>
                    <label><input type="checkbox" name="oclusal[]" value="À Esquerda">À Esquerda</label>
                </div>
            </div>
        </div>
        
        <div class="input-group">
            <label for="radiografias_extrabucais" class="label_in_border">Radiografias Extrabucais</label>
            <div class="row">
                <div class="half-width">
                    <label class="checkbox"><input type="checkbox" name="panoramica_normal" value="1">Panorâmica Normal</label>
                </div>

                <div class="half-width">
                    <label class="checkbox"><input type="checkbox" name="panoramica_p_implante_c_pontos_anatomicos" value="1">Panorâmica p/ Implante c/ Pontos Anatômicos</label>
                </div>
            </div>

            <div class="row_inline_simple">
                <label for="tele_radiografia">Tele-radiografia</label><br />
                <div class="group">
                    <label><input type="checkbox" name="tele_radiografia[]" value="Sem Traçado">Sem Traçado</label>
                    <label><input type="checkbox" name="tele_radiografia[]" value="Com Cefalometria">Com Cefalometria</label>
                </div>
            </div>

            <div class="row_inline_simple">
                <label for="tele_radiografia_frontal_pa">Tele-radiografia Frontal (PA)</label><br />
                <div class="group">
                    <label><input type="checkbox" name="tele_radiografia_frontal_pa[]" value="Boca aberta">Boca aberta</label>
                    <label><input type="checkbox" name="tele_radiografia_frontal_pa[]" value="Boca fechada">Boca fechada</label>
                </div>
            </div>

            <div class="row_inline_simple">
                <label for="seios_da_face">Seios da Face</label><br />
                <div class="group">
                    <label><input type="checkbox" name="seios_da_face[]" value="Seios Esfenoidais">Seios Esfenoidais</label>
                    <label><input type="checkbox" name="seios_da_face[]" value="Seios Etmoidais">Seios Etmoidais</label>
                    <label><input type="checkbox" name="seios_da_face[]" value="Seios Maxilares (Waters)">Seios Maxilares (Waters)</label>
                    <label><input type="checkbox" name="seios_da_face[]" value="Seios Frontais (Calddwell)">Seios Frontais (Calddwell)</label>
                </div>
            </div>

            <div class="row">
                <div class="half-width">
                    <label class="checkbox"><input type="checkbox" name="mao_e_punho_idade_ossea" value="1">Mão e Punho (Idade Óssea)</label>
                </div>
                
                <div class="half-width">
                    <label class="checkbox"><input type="checkbox" name="analise_das_vias_aereas_adenoide" value="1">Análise das Vias Aéreas (Adenóide)</label>
                </div>
            </div>

            <div class="row_inline_simple">
                <label for="atm_transcraniana">ATM (Transcraniana)</label><br />
                <div class="group">
                    <label><input type="checkbox" name="atm_transcraniana[]" value="4 posições">4 posições</label>
                    <label><input type="checkbox" name="atm_transcraniana[]" value="6 posições">6 posições</label>
                </div>
            </div>
            
            <div class="row">
                <div class="full-width">
                    <label class="checkbox"><input type="checkbox" name="panoramica_de_atm" value="1">Panorâmica de ATM</label>
                </div>
            </div>
        </div>

        <div class="input-group">
            <label for="observacoes" class="label_in_border">Observações</label>
            <textarea name="observacoes" class="input_line_bottom" rows="4"></textarea>
        </div>
        
        <div class="input-group">
            <label for="servicos" class="label_in_border">Serviços</label>
            <div class="row">
                <div class="one-third-width">
                    <label class="checkbox"><input type="checkbox" name="modelo_de_estudo" value="1">Modelo de Estudo</label>
                </div>
                
                <div class="one-third-width">
                    <label class="checkbox"><input type="checkbox" name="modelo_de_trabalho" value="1">Modelo de Trabalho</label>
                </div>
                
                <div class="one-third-width">
                    <label class="checkbox"><input type="checkbox" name="modelo_digital" value="1">Modelo Digital</label>
                </div>
            </div> 

            <div class="row_inline_simple">
                <label for="modelo_digital_para_alinhadores">Modelo Digital para Alinhadores</label><br />
                <div class="group">
                    <label><input type="checkbox" name="modelo_digital_para_alinhadores[]" value="Easy Solution">Easy Solution</label>
                    <label><input type="checkbox" name="modelo_digital_para_alinhadores[]" value="Invisalign">Invisalign</label>
                    <label><input type="checkbox" name="modelo_digital_para_alinhadores[]" value="Outros">Outros</label>
                </div>
            </div> 

            <div class="row_inline_simple">
                <label for="fotografias">Fotografias</label><br />
                <div class="group">
                    <label><input type="checkbox" name="fotografias[]" value="2 Fotos (Frente e Perfil)">2 Fotos (Frente e Perfil)</label>
                    <label><input type="checkbox" name="fotografias[]" value="3 Fotos (Intrabucais)">3 Fotos (Intrabucais)</label>
                    <label><input type="checkbox" name="fotografias[]" value="2 Fotos (Oclusais)">2 Fotos (Oclusais)</label>
                    <label><input type="checkbox" name="fotografias[]" value="1 Foto (Sorriso)">1 Foto (Sorriso)</label>
                    <label><input type="checkbox" name="fotografias[]" value="Overjet">Overjet</label>
                </div>
            </div> 
        </div>
        
        <div class="input-group">
            <label for="requiscao_exame" class="label_in_border">Requisição de Exame Tomográfico Computadorizado</label>
            <div class="row_inline_simple">
                <label for="indicacao_do_exame_informacoes_principais_e_auxiliares_para_o_radiologista">Indicação do exame /Informações principais e auxiliares para o radiologista</label><br />
                <div class="group">
                    <label><input type="checkbox" name="indicacao_do_exame_informacoes_principais_e_auxiliares_para_o_radiologista[]" value="Implantodontia">Implantodontia</label>
                    <label><input type="checkbox" name="indicacao_do_exame_informacoes_principais_e_auxiliares_para_o_radiologista[]" value="Dentística">Dentística</label>
                    <label><input type="checkbox" name="indicacao_do_exame_informacoes_principais_e_auxiliares_para_o_radiologista[]" value="Prótese">Prótese</label>
                    <label><input type="checkbox" name="indicacao_do_exame_informacoes_principais_e_auxiliares_para_o_radiologista[]" value="Cirurgia Buco-Maxilio-Facial">Cirurgia Buco-Maxilio-Facial</label>
                    <label><input type="checkbox" name="indicacao_do_exame_informacoes_principais_e_auxiliares_para_o_radiologista[]" value="Endodontia">Endodontia</label>
                    <label><input type="checkbox" name="indicacao_do_exame_informacoes_principais_e_auxiliares_para_o_radiologista[]" value="Traumatismo">Traumatismo</label>
                    <label><input type="checkbox" name="indicacao_do_exame_informacoes_principais_e_auxiliares_para_o_radiologista[]" value="Ortodontia">Ortodontia</label>
                    <label><input type="checkbox" name="indicacao_do_exame_informacoes_principais_e_auxiliares_para_o_radiologista[]" value="Lesões">Lesões</label>
                    <label><input type="checkbox" name="indicacao_do_exame_informacoes_principais_e_auxiliares_para_o_radiologista[]" value="Cirurgia Ortognática">Cirurgia Ortognática</label>
                    <label><input type="checkbox" name="indicacao_do_exame_informacoes_principais_e_auxiliares_para_o_radiologista[]" value="Periodontia">Periodontia</label>
                    <label><input type="checkbox" name="indicacao_do_exame_informacoes_principais_e_auxiliares_para_o_radiologista[]" value="DTM">DTM</label>
                    <label><input type="checkbox" name="indicacao_do_exame_informacoes_principais_e_auxiliares_para_o_radiologista[]" value="Outros">Outros</label>
                </div>
            </div> 

            <div class="row" style="margin-top: 35px;">
                <label for="observacoes_requisicao_exame" class="label_in_border">Obs.:</label>
                <textarea name="observacoes_requisicao_exame" class="input_line_bottom" rows="1" style="min-height: auto;"></textarea>
            </div>
        </div>
        
        <div class="input-group">
            <label for="aquiscao_imagem" class="label_in_border">Aquisição de Imagem Tomográfica</label>
            <div class="row">
                <div class="one-third-width">
                    <label class="checkbox"><input type="checkbox" name="com_afastamento_labial" value="1">Com Afastamento Labial</label>
                </div>

                <div class="one-third-width">
                    <label class="checkbox"><input type="checkbox" name="maxila" value="1">Maxila</label>
                </div>

                <div class="one-third-width">
                    <label class="checkbox"><input type="checkbox" name="mandibula" value="1">Mandíbula</label>
                </div>
            </div>

            <div class="row">
                <div class="full-width">
                    <label class="checkbox"><input type="checkbox" name="1_ou_2_elementos" value="1">1 ou 2 Elementos (endodontia - diagnóstico)</label>
                </div>
            </div> 

            <div class="row">
                <div class="one-third-width">
                    <label class="checkbox"><input type="checkbox" name="max_d" value="1">Max-D</label>
                </div>

                <div class="one-third-width">
                    <label class="checkbox"><input type="checkbox" name="max_a" value="1">Max-A</label>
                </div>

                <div class="one-third-width">
                    <label class="checkbox"><input type="checkbox" name="max_e" value="1">Max-E</label>
                </div>
            </div>
            
            <div class="row">
                <div class="one-third-width">
                    <label class="checkbox"><input type="checkbox" name="man_d" value="1">Man-D</label>
                </div>

                <div class="one-third-width">
                    <label class="checkbox"><input type="checkbox" name="man_a" value="1">Man-A</label>
                </div>

                <div class="one-third-width">
                    <label class="checkbox"><input type="checkbox" name="man_e" value="1">Man-E</label>
                </div>
            </div>

            <div class="row_inline_simple">
                <label for="atm">ATM</label><br />
                <div class="group">
                    <label><input type="checkbox" name="atm[]" value="Boca Fechada">Boca Fechada</label>
                    <label><input type="checkbox" name="atm[]" value="Boca Aberta">Boca Aberta</label>
                </div>
            </div> 

            <div class="row">
                <div class="full-width">
                    <label class="checkbox"><input type="checkbox" name="tecnica_de_localizacao" value="1">Técnica de Localização (1 ou 2 elementos)</label>
                </div>
            </div> 

            <div class="row_inline_simple">
                <label for="tomografia_para_guia_cirurgico">Tomografia para Guia Cirúrgico</label><br />
                <div class="group">
                    <label><input type="checkbox" name="tomografia_para_guia_cirurgico[]" value="Guia para Implante">Guia para Implante</label>
                    <label><input type="checkbox" name="tomografia_para_guia_cirurgico[]" value="Guia Periodontal">Guia Periodontal</label>
                    <label><input type="checkbox" name="tomografia_para_guia_cirurgico[]" value="Guia Endoguide">Guia Endoguide</label>
                </div>
            </div>
            
            <div class="row">
                <div class="full-width">
                    <label class="checkbox"><input type="checkbox" name="cd" value="1">CD - Software de Visualização Denta Slice</label>
                </div>
            </div>

            <div class="row">
                <div class="half-width">
                    <label class="checkbox"><input type="checkbox" name="impressao_em_filme" value="1">Impressão em Filme</label>
                </div>

                <div class="half-width">
                    <label class="checkbox"><input type="checkbox" name="dicom" value="1">Dicom</label>
                </div>
            </div>
        </div>
        
        <div class="input-group">
            <div class="row">
                <div class="full-width">
                    <label class="checkbox"><input type="checkbox" name="entregar_no_consultorio" value="1">Entregar no Consultório</label>
                </div>
            </div>

            <div class="row">
                <div class="full-width">
                    <label class="checkbox"><input type="checkbox" name="urgente_entregar_na_hora_sem_laudo" value="1">Urgente (Entregar na Hora sem Laudo)</label>
                </div>
            </div>

            <div class="row">
                <div class="full-width">
                    <label class="checkbox"><input type="checkbox" name="favor_enviar_mais_requisicoes" value="1">Favor Enviar mais Requisições</label>
                </div>
            </div>
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
add_shortcode('form_os_dentistas', 'form_os_dentistas');