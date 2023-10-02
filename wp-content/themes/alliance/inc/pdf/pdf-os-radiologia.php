<?php

function content($id, $logo, $qrcode){
    // Obtém os campos ACF
    $nome_do_dentista = get_field('nome_do_dentista', $id);
    $nome = get_field('nome', $id);
    $idade = get_field('idade', $id);
    $sexo = get_field('sexo', $id);
    $telefone = get_field('telefone', $id);
    $data_inicio = get_field('data_inicio', $id);
    $data_entrega = get_field('data_entrega', $id);

    $doc_ortodontica_basica_checked = (get_post_meta($id, 'doc_ortodontica_basica', true) == 1) ? 'checked' : '';
    $doc_ortodontica_completa_checked = (get_post_meta($id, 'doc_ortodontica_completa', true) == 1) ? 'checked' : '';
    $doc_para_implante_checked = (get_post_meta($id, 'doc_para_implante', true) == 1) ? 'checked' : '';
    $periapicais_checked = (get_post_meta($id, 'periapicais', true) == 1) ? 'checked' : '';

    $panoramica_normal_checked = (get_post_meta($id, 'panoramica_normal', true) == 1) ? 'checked' : '';
    $panoramica_p_implante_c_pontos_anatomicos_checked = (get_post_meta($id, 'panoramica_p_implante_c_pontos_anatomicos', true) == 1) ? 'checked' : '';
    $mao_e_punho_idade_ossea_checked = (get_post_meta($id, 'mao_e_punho_idade_ossea', true) == 1) ? 'checked' : '';
    $analise_das_vias_aereas_adenoide_checked = (get_post_meta($id, 'analise_das_vias_aereas_adenoide', true) == 1) ? 'checked' : '';
    $panoramica_de_atm_checked = (get_post_meta($id, 'panoramica_de_atm', true) == 1) ? 'checked' : '';

    $observacoes = get_field('observacoes', $id);
    
    $modelo_de_estudo_checked = (get_post_meta($id, 'modelo_de_estudo', true) == 1) ? 'checked' : '';
    $modelo_de_trabalho_checked = (get_post_meta($id, 'modelo_de_trabalho', true) == 1) ? 'checked' : '';
    $modelo_digital_checked = (get_post_meta($id, 'modelo_digital', true) == 1) ? 'checked' : '';

    $observacoes_requisicao_exame = get_field('observacoes_requisicao_exame', $id);

    $com_afastamento_labial_checked = (get_post_meta($id, 'com_afastamento_labial', true) == 1) ? 'checked' : '';
    $maxila_checked = (get_post_meta($id, 'maxila', true) == 1) ? 'checked' : '';
    $mandibula_checked = (get_post_meta($id, 'mandibula', true) == 1) ? 'checked' : '';
    $_1_ou_2_elementos_checked = (get_post_meta($id, '1_ou_2_elementos', true) == 1) ? 'checked' : '';
    $max_d_checked = (get_post_meta($id, 'max_d', true) == 1) ? 'checked' : '';
    $max_a_checked = (get_post_meta($id, 'max_a', true) == 1) ? 'checked' : '';
    $max_e_checked = (get_post_meta($id, 'max_e', true) == 1) ? 'checked' : '';
    $man_d_checked = (get_post_meta($id, 'man_d', true) == 1) ? 'checked' : '';
    $man_a_checked = (get_post_meta($id, 'man_a', true) == 1) ? 'checked' : '';
    $man_e_checked = (get_post_meta($id, 'man_e', true) == 1) ? 'checked' : '';
    $tecnica_de_localizacao_checked = (get_post_meta($id, 'tecnica_de_localizacao', true) == 1) ? 'checked' : '';
    $cd_checked = (get_post_meta($id, 'cd', true) == 1) ? 'checked' : '';
    $impressao_em_filme_checked = (get_post_meta($id, 'impressao_em_filme', true) == 1) ? 'checked' : '';
    $dicom_checked = (get_post_meta($id, 'dicom', true) == 1) ? 'checked' : '';

    $entregar_no_consultorio_checked = (get_post_meta($id, 'entregar_no_consultorio', true) == 1) ? 'checked' : '';
    $urgente_entregar_na_hora_sem_laudo_checked = (get_post_meta($id, 'urgente_entregar_na_hora_sem_laudo', true) == 1) ? 'checked' : '';
    $favor_enviar_mais_requisicoes_checked = (get_post_meta($id, 'favor_enviar_mais_requisicoes', true) == 1) ? 'checked' : '';

    $attachments = get_post_meta($id, 'arquivos', true);

    $html = '
        <div class="content">
            <div class="row">
                <div class="one-four-width">
                    <div class="logo-container">
                        <img src="' . esc_url( $logo[0] ) . '" width="100" alt="Logo" />
                    </div>
                </div>

                <div class="half-width" style="text-align: center">
                    <h1 class="title">#OS_' . $nome . '</h1>
                </div>

                <div class="one-four-width">
                    <div class="code-container">
                        <img src="' . $qrcode . '" alt="QR Code" />
                    </div>
                </div>
            </div>

            <hr>

            <div class="order-form-container" id="order-form-container">
                <div class="group">
                    <div class="row">
                        <div class="full-width">
                            <label class="label" for="nome_do_dentista">Nome do Dentista</label><br />
                            <input type="text" class="input_view" name="nome_do_dentista" value="' . $nome_do_dentista . '">
                        </div>
                    </div>

                    <div class="row">
                        <div class="full-width">
                            <label class="label" for="nome">Nome do Paciente</label><br />
                            <input type="text" class="input_view" name="nome" value="' . $nome . '">
                        </div>
                    </div>

                    <div class="row">
                        <div class="one-third-width">
                            <label class="label" for="idade">Idade do Paciente</label><br />
                            <input type="text" class="input_view" name="idade" value="' . $idade . '">
                        </div>

                        <div class="one-third-width">
                            <label class="label" for="sexo">Sexo</label><br />
                            <input type="text" class="input_view"  name="sexo" value="' . $sexo . '">
                        </div>

                        <div class="one-third-width">
                            <label class="label" for="telefone">Telefone</label><br />
                            <input type="text" class="input_view" name="telefone" value="' . $telefone . '">
                        </div>
                    </div>

                    <div class="row">
                        <div class="half-width">
                            <label class="label" for="data_inicio">Data de início</label><br />
                            <input type="text" class="input_view" name="data_inicio" value="' . $data_inicio . '">
                        </div>

                        <div class="half-width">
                            <label class="label" for="data_entrega">Data de entrega</label><br />
                            <input type="text" class="input_view" name="data_entrega" value="' . $data_entrega . '">
                        </div>
                    </div>
                </div>

                <div class="group">
                    <label for="documentacao_odontologica" class="label_in_border">Documentação Odontológica</label>
                    <div class="row">
                        <div class="full-width">
                            <label><input type="checkbox" class="checkbox_label" name="doc_ortodontica_basica" value="1" ' . $doc_ortodontica_basica_checked . '>Doc. Ortodôntica Básica<br />
                            <span class="docs">Panorâmica, Tele-radiografia d e Perfil, Periapicais Anteriores, Modelos, (09) Fots, Traçados Cefalométricos</span></label>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="full-width">
                            <label><input type="checkbox" class="checkbox_label" name="doc_ortodontica_completa" value="1" ' . $doc_ortodontica_completa_checked . '>Doc. Ortodôntica Completa<br />
                            <span class="docs">Panorâmica, Tele-radiografia d e Perfil, 2 Periapicais Anteriores, (09) Fotos, Mão e Punho (Idade Ósea,) Análise das Vias Aéreas 
                                (Adenóide), Previsão de uprçãorI dos 3°M,esarol Modelos (Acn/álise e xerox) eTraçados Cefalométricos</span></label>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="full-width">
                            <label><input type="checkbox" class="checkbox_label" name="doc_para_implante" value="1" ' . $doc_para_implante_checked . '>Doc. para Implante<br />
                            <span class="docs">Panorâmica, Periapicais Milimetradas, Oclusal na Região od Implante, Modelos, (09)Fotos e Traçado com pontos anatômicos</span></label>
                        </div>
                    </div>
                </div>

                <div class="group">
                    <label for="radiografias_intrabucais" class="label_in_border">Radiografias Intrabucais</label>
                    <div class="row">
                        <div class="full-width">
                            <label><input type="checkbox" class="checkbox_label"  name="periapicais" value="1" ' . $periapicais_checked . '>Periapicais</label>
                        </div>
                    </div>

                    <div class="row">
                        <label>Levantamento Periapical</label><br />
                        <div class="levantamento_periapical_group">
                            ';

                            $levantamento_periapical_01 = array('18', '17', '16', '15', '14', '13', '12', '11');
                            $levantamento_periapical_02 = array('21', '22', '23', '24', '25', '26', '27', '28');
                            $levantamento_periapical_03 = array('48', '47', '46', '45', '44', '43', '42', '41');
                            $levantamento_periapical_04 = array('31', '32', '33', '34', '35', '36', '37', '38');
                        
                            $levantamento_periapical = get_post_meta($id, 'levantamento_periapical', true);
                            $levantamento_periapical = explode(', ', $levantamento_periapical);
                        
                            function is_value_checked($value, $selected_values) {
                                return in_array($value, $selected_values) ? 'checked' : '';
                            }
                        
                            foreach ($levantamento_periapical_01 as $choice_01) {
                                $checked = in_array($choice_01, $levantamento_periapical) ? 'checked' : '';
                                $html .= '<label><input type="checkbox" class="checkbox_label" name="levantamento_periapical01[]" value="' . esc_attr($choice_01) . '" ' . $checked . '> ' . esc_html($choice_01) . '</label>';
                            }
                        
                            $html .= '<span class="divisor">|</span>';
                        
                            foreach ($levantamento_periapical_02 as $choice_02) {
                                $checked = in_array($choice_02, $levantamento_periapical) ? 'checked' : '';
                                $html .= '<label><input type="checkbox" class="checkbox_label" name="levantamento_periapical02[]" value="' . esc_attr($choice_02) . '" ' . $checked . '> ' . esc_html($choice_02) . '</label>';
                            }
                            
                            $html .= '<hr style="margin: 1px 1% !important; width: 98%; border: none !important; border-bottom: 1px solid #4b4b4b !important;">';
                        
                            foreach ($levantamento_periapical_03 as $choice_03) {
                                $checked = in_array($choice_03, $levantamento_periapical) ? 'checked' : '';
                                $html .= '<label><input type="checkbox" class="checkbox_label" name="levantamento_periapical03[]" value="' . esc_attr($choice_03) . '" ' . $checked . '> ' . esc_html($choice_03) . '</label>';
                            }
                        
                            $html .= '<span class="divisor">|</span>';
                        
                            foreach ($levantamento_periapical_04 as $choice_04) {
                                $checked = in_array($choice_04, $levantamento_periapical) ? 'checked' : '';
                                $html .= '<label><input type="checkbox" class="checkbox_label" name="levantamento_periapical04[]" value="' . esc_attr($choice_04) . '" ' . $checked . '> ' . esc_html($choice_04) . '</label>';
                            }
                        
                            $html .= '
                        </div>
                    </div>

                    <div class="row_inline_simple">
                        <label for="interproximal">Interproximal</label><br />';
                        $interproximal_values = get_field('interproximal', $id);
                        $interproximal_options = array(
                            'Molares Dir.',
                            'Molares Esq.',
                            'Pré-molares Dir.',
                            'Pré-molares Esq.',
                            'Anteriores'
                        );

                        foreach ($interproximal_options as $option) {
                            $checked = in_array($option, $interproximal_values) ? 'checked' : '';
                            $html .= '<label><input type="checkbox" class="checkbox_label" name="interproximal[]" value="' . esc_attr($option) . '" ' . $checked . '>' . esc_html($option) . '</label>';
                        }
                        $html .= '
                    </div>

                    <div class="row_inline_simple">
                        <label for="oclusal">Oclusal</label><br />';
                        $oclusal_values = get_field('oclusal', $id);
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
                            $html .= '<label><input type="checkbox" class="checkbox_label" name="oclusal[]" value="' . esc_attr($option) . '" ' . $checked . '>' . esc_html($option) . '</label>';
                        }
                        $html .= '
                    </div>
                </div>

                <div class="group">
                    <label for="radiografias_extrabucais" class="label_in_border">Radiografias Extrabucais</label>
                    <div class="row">
                        <div class="half-width">
                            <label><input type="checkbox" class="checkbox_label" name="panoramica_normal" value="1" ' . $panoramica_normal_checked . '>Panorâmica Normal</label>
                        </div>

                        <div class="half-width">
                            <label><input type="checkbox" class="checkbox_label" name="panoramica_p_implante_c_pontos_anatomicos" value="1" ' . $panoramica_p_implante_c_pontos_anatomicos_checked . '>Panorâmica p/ Implante c/ Pontos Anatômicos</label>
                        </div>
                    </div>

                    <div class="row_inline_simple">
                        <label for="tele_radiografia">Tele-radiografia</label><br />';
                        $tele_radiografia_values = get_field('tele_radiografia', $id);
                        $tele_radiografia_options = array(
                            'Sem Traçado',
                            'Com Cefalometria'
                        );

                        foreach ($tele_radiografia_options as $option) {
                            $checked = in_array($option, $tele_radiografia_values) ? 'checked' : '';
                            $html .= '<label><input type="checkbox" class="checkbox_label" name="tele_radiografia[]" value="' . esc_attr($option) . '" ' . $checked . '>' . esc_html($option) . '</label>';
                        }
                        $html .= '
                    </div>

                    <div class="row_inline_simple">
                        <label for="tele_radiografia_frontal_pa">Tele-radiografia Frontal (PA)</label><br />';
                        $tele_radiografia_frontal_pa_values = get_field('tele_radiografia_frontal_pa', $id);
                        $tele_radiografia_frontal_pa_options = array(
                            'Boca aberta',
                            'Boca fechada'
                        );

                        foreach ($tele_radiografia_frontal_pa_options as $option) {
                            $checked = in_array($option, $tele_radiografia_frontal_pa_values) ? 'checked' : '';
                            $html .= '<label><input type="checkbox" class="checkbox_label" name="tele_radiografia_frontal_pa[]" value="' . esc_attr($option) . '" ' . $checked . '>' . esc_html($option) . '</label>';
                        }
                        $html .= '
                    </div>

                    <div class="row_inline_simple">
                        <label for="seios_da_face">Seios da Face</label><br />';
                        $seios_da_face_values = get_field('seios_da_face', $id);
                        $seios_da_face_options = array(
                            'Seios Esfenoidais',
                            'Seios Etmoidais',
                            'Seios Maxilares (Waters)',
                            'Seios Frontais (Calddwell)'
                        );

                        foreach ($seios_da_face_options as $option) {
                            $checked = in_array($option, $seios_da_face_values) ? 'checked' : '';
                            $html .= '<label><input type="checkbox" class="checkbox_label" name="seios_da_face[]" value="' . esc_attr($option) . '" ' . $checked . '>' . esc_html($option) . '</label>';
                        }
                        $html .= '
                    </div>

                    <div class="row">
                        <div class="half-width">
                            <label><input type="checkbox" name="mao_e_punho_idade_ossea" class="checkbox_label" value="1" ' . $mao_e_punho_idade_ossea_checked . '>Mão e Punho (Idade Óssea)</label>
                        </div>
                        
                        <div class="half-width">
                            <label><input type="checkbox" name="analise_das_vias_aereas_adenoide" class="checkbox_label" value="1" ' . $analise_das_vias_aereas_adenoide_checked . '>Análise das Vias Aéreas (Adenóide)</label>
                        </div>
                    </div>

                    <div class="row_inline_simple">
                        <label for="atm_transcraniana">ATM (Transcraniana)</label><br />';
                        $atm_transcraniana_values = get_field('atm_transcraniana', $id);
                        $atm_transcraniana_options = array(
                            '4 posições',
                            '6 posições'
                        );

                        foreach ($atm_transcraniana_options as $option) {
                            $checked = in_array($option, $atm_transcraniana_values) ? 'checked' : '';
                            $html .= '<label><input type="checkbox" class="checkbox_label" name="atm_transcraniana[]" value="' . esc_attr($option) . '" ' . $checked . '>' . esc_html($option) . '</label>';
                        }
                        $html .= '
                    </div>
                    
                    <div class="row">
                        <div class="full-width">
                            <label><input type="checkbox" class="checkbox_label" name="panoramica_de_atm" value="1" ' . $panoramica_de_atm_checked . '>Panorâmica de ATM</label>
                        </div>
                    </div>
                </div>

                <div class="group">
                    <label class="label_in_border" for="observacoes">Observações</label>
                    <div class="row">
                        <div class="full-width">
                            <textarea name="observacoes" class="input_view" rows="6">' . $observacoes . '</textarea>
                        </div>
                    </div>
                </div>

                <div class="group">
                    <label for="servicos" class="label_in_border">Serviços</label>
                    <div class="row">
                        <div class="one-third-width">
                            <label><input type="checkbox" class="checkbox_label" name="modelo_de_estudo" value="1" ' . $modelo_de_estudo_checked . '>Modelo de Estudo</label>
                        </div>
                        
                        <div class="one-third-width">
                            <label><input type="checkbox" class="checkbox_label" name="modelo_de_trabalho" value="1" ' . $modelo_de_trabalho_checked . '>Modelo de Trabalho</label>
                        </div>
                        
                        <div class="one-third-width">
                            <label><input type="checkbox" class="checkbox_label" name="modelo_digital" value="1" ' . $modelo_digital_checked . '>Modelo Digital</label>
                        </div>
                    </div> 

                    <div class="row_inline_simple">
                        <label for="modelo_digital_para_alinhadores">Modelo Digital para Alinhadores</label><br />';
                        $modelo_digital_para_alinhadores_values = get_field('modelo_digital_para_alinhadores', $id);
                        $modelo_digital_para_alinhadores_options = array(
                            'Easy Solution',
                            'Invisalign',
                            'Outros'
                        );

                        foreach ($modelo_digital_para_alinhadores_options as $option) {
                            $checked = in_array($option, $modelo_digital_para_alinhadores_values) ? 'checked' : '';
                            $html .= '<label><input type="checkbox" class="checkbox_label" name="modelo_digital_para_alinhadores[]" value="' . esc_attr($option) . '" ' . $checked . '>' . esc_html($option) . '</label>';
                        }
                        $html .= '
                    </div> 

                    <div class="row_inline_simple">
                        <label for="fotografias">Fotografias</label><br />';
                        $fotografias_values = get_field('fotografias', $id);
                        $fotografias_options = array(
                            '2 Fotos (Frente e Perfil)',
                            '3 Fotos (Intrabucais)',
                            '2 Fotos (Oclusais)',
                            '1 Foto (Sorriso)',
                            'Overjet'
                        );

                        foreach ($fotografias_options as $option) {
                            $checked = in_array($option, $fotografias_values) ? 'checked' : '';
                            $html .= '<label><input type="checkbox" class="checkbox_label" name="fotografias[]" value="' . esc_attr($option) . '" ' . $checked . '>' . esc_html($option) . '</label>';
                        }
                        $html .= '
                    </div> 
                </div>

                <div class="group">
                    <label for="requiscao_exame" class="label_in_border">Requisição de Exame Tomográfico Computadorizado</label>
                    <div class="row_inline_simple">
                        <label for="indicacao_do_exame_informacoes_principais_e_auxiliares_para_o_radiologista">Indicação do exame /Informações principais e auxiliares para o radiologista</label><br />';
                        $indicacao_do_exame_informacoes_principais_e_auxiliares_para_o_radiologista_values = get_field('indicacao_do_exame_informacoes_principais_e_auxiliares_para_o_radiologista', $id);
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
                            $html .= '<label><input type="checkbox" class="checkbox_label" name="indicacao_do_exame_informacoes_principais_e_auxiliares_para_o_radiologista[]" value="' . esc_attr($option) . '" ' . $checked . '>' . esc_html($option) . '</label>';
                        }
                        $html .= '
                    </div> 

                    <div class="row" style="margin-top: 35px;">
                        <label for="observacoes_requisicao_exame" class="label_in_border">Obs.:</label>
                        <textarea name="observacoes_requisicao_exame" class="input_view" rows="1" style="min-height: auto;">' . $observacoes_requisicao_exame . '</textarea>
                    </div>
                </div>

                <div class="group">
                    <label for="aquiscao_imagem" class="label_in_border">Aquisição de Imagem Tomográfica</label>
                    <div class="row">
                        <div class="one-third-width">
                            <label><input type="checkbox" class="checkbox_label" name="com_afastamento_labial" value="1" ' . $com_afastamento_labial_checked . '>Com Afastamento Labial</label>
                        </div>

                        <div class="one-third-width">
                            <label><input type="checkbox" class="checkbox_label" name="maxila" value="1" ' . $maxila_checked . '>Maxila</label>
                        </div>

                        <div class="one-third-width">
                            <label><input type="checkbox" class="checkbox_label" name="mandibula" value="1" ' . $mandibula_checked . '>Mandíbula</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="full-width">
                            <label><input type="checkbox" class="checkbox_label" name="1_ou_2_elementos" value="1" ' . $_1_ou_2_elementos_checked . '>1 ou 2 Elementos (endodontia - diagnóstico)</label>
                        </div>
                    </div> 

                    <div class="row">
                        <div class="one-third-width">
                            <label><input type="checkbox" class="checkbox_label" name="max_d" value="1" ' . $max_d_checked . '>Max-D</label>
                        </div>

                        <div class="one-third-width">
                            <label><input type="checkbox" class="checkbox_label" name="max_a" value="1" ' . $max_a_checked . '>Max-A</label>
                        </div>

                        <div class="one-third-width">
                            <label><input type="checkbox" class="checkbox_label" name="max_e" value="1" ' . $max_e_checked . '>Max-E</label>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="one-third-width">
                            <label><input type="checkbox" class="checkbox_label" name="man_d" value="1" ' . $man_d_checked . '>Man-D</label>
                        </div>

                        <div class="one-third-width">
                            <label><input type="checkbox" class="checkbox_label" name="man_a" value="1" ' . $man_a_checked . '>Man-A</label>
                        </div>

                        <div class="one-third-width">
                            <label><input type="checkbox" class="checkbox_label" name="man_e" value="1" ' . $man_e_checked . '>Man-E</label>
                        </div>
                    </div>

                    <div class="row_inline_simple">
                        <label for="atm">ATM</label><br />';
                        $atm_values = get_field('atm', $id);
                        $atm_options = array(
                            'Boca Fechada',
                            'Boca Aberta'
                        );

                        foreach ($atm_options as $option) {
                            $checked = in_array($option, $atm_values) ? 'checked' : '';
                            $html .= '<label><input type="checkbox" class="checkbox_label" name="atm[]" value="' . esc_attr($option) . '" ' . $checked . '>' . esc_html($option) . '</label>';
                        }
                        $html .= '
                    </div> 

                    <div class="row">
                        <div class="full-width">
                            <label><input type="checkbox" class="checkbox_label" name="tecnica_de_localizacao" value="1" ' . $tecnica_de_localizacao_checked . '>Técnica de Localização (1 ou 2 elementos)</label>
                        </div>
                    </div> 

                    <div class="row_inline_simple">
                        <label for="tomografia_para_guia_cirurgico">Tomografia para Guia Cirúrgico</label><br />';
                        $tomografia_para_guia_cirurgico_values = get_field('tomografia_para_guia_cirurgico', $id);
                        $tomografia_para_guia_cirurgico_options = array(
                            'Guia para Implante',
                            'Guia Periodontal',
                            'Guia Endoguide'
                        );

                        foreach ($tomografia_para_guia_cirurgico_options as $option) {
                            $checked = in_array($option, $tomografia_para_guia_cirurgico_values) ? 'checked' : '';
                            $html .= '<label><input type="checkbox" class="checkbox_label" name="tomografia_para_guia_cirurgico[]" value="' . esc_attr($option) . '" ' . $checked . '>' . esc_html($option) . '</label>';
                        }
                        $html .= '
                    </div>
                    
                    <div class="row">
                        <div class="full-width">
                            <label><input type="checkbox" class="checkbox_label" name="cd" value="1" ' . $cd_checked . '>CD - Software de Visualização Denta Slice</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="half-width">
                            <label><input type="checkbox" class="checkbox_label" name="impressao_em_filme" value="1" ' . $impressao_em_filme_checked . '>Impressão em Filme</label>
                        </div>

                        <div class="half-width">
                            <label><input type="checkbox" class="checkbox_label" name="dicom" value="1" ' . $dicom_checked . '>Dicom</label>
                        </div>
                    </div>
                </div>

                <div class="group">
                    <div class="row">
                        <div class="full-width">
                            <label><input type="checkbox" class="checkbox_label" name="entregar_no_consultorio" value="1" ' . $entregar_no_consultorio_checked . '>Entregar no Consultório</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="full-width">
                            <label><input type="checkbox" class="checkbox_label" name="urgente_entregar_na_hora_sem_laudo" value="1" ' . $urgente_entregar_na_hora_sem_laudo_checked . '>Urgente (Entregar na Hora sem Laudo)</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="full-width">
                            <label><input type="checkbox" class="checkbox_label" name="favor_enviar_mais_requisicoes" value="1" ' . $favor_enviar_mais_requisicoes_checked . '>Favor Enviar mais Requisições</label>
                        </div>
                    </div>
                </div>
    ';
    
    if (!empty($attachments)) {
        $html .= '
            <div class="group">
                <label class="label_in_border" for="arquivos">Arquivos</label>
                <div class="row">
                    <div class="full-width">
                        <div class="attachment-images">
        ';

        foreach ($attachments as $attachment_id) {
            $attachment_mime_type = get_post_mime_type($attachment_id);
            if (strpos($attachment_mime_type, 'image') !== false) {
                $html .= wp_get_attachment_image($attachment_id, 'thumbnail');
            }
        }

        $html .= '
                        </div>
                    </div>
                </div>
            </div>
        ';
    }

    $html .= '
            </div>
        </div>
    ';

    return $html;
}