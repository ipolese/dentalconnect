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
    $cor_dominante = get_field('cor_dominante', $id);
    $escala_de_cor = get_field('escala_de_cor', $id);
    $cervical = get_field('cervical', $id);
    $terco_medio = get_field('terco_medio', $id);
    $marca = get_field('marca', $id);
    $modelo = get_field('modelo', $id);
    $plataforma = get_field('plataforma', $id);
    $scanbody = get_field('scanbody', $id);
    $observacoes = get_field('observacoes', $id);

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
                    <label class="label_in_border" for="levantamento_periapical">Levantamento Periapical</label>
                    <div class="row">
                        <div class="full-width">
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
                    </div>
                </div>

                <div class="group">
                    <div class="row">
                        <div class="half-width">
                            <label class="label" for="cor_dominante">Cor Dominante</label><br />
                            <input type="text" class="input_view"  name="cor_dominante" value="' . $cor_dominante . '">
                        </div>

                        <div class="half-width">
                            <label class="label" for="escala_de_cor">Escala de Cor</label><br />
                            <input type="text" class="input_view"  name="escala_de_cor" value="' . $escala_de_cor . '">
                        </div>
                    </div>

                    <div class="row">
                        <div class="half-width">
                            <label class="label" for="cervical">Cervical</label><br />
                            <input type="text" class="input_view" name="cervical" value="' . $cervical . '">
                        </div>

                        <div class="half-width">
                            <label class="label" for="terco_medio">Terço Médio</label><br />
                            <input type="text" class="input_view" name="terco_medio" value="' . $terco_medio . '">
                        </div>
                    </div>
                </div>

                <div class="group">
                    <label class="label_in_border" for="implantes">Implantes</label>

                    <div class="row">
                        <div class="half-width">
                            <label class="label" for="marca">Marca</label><br />
                            <input type="text" class="input_view" name="marca" value="' . $marca . '">
                        </div>

                        <div class="half-width">
                            <label class="label" for="modelo">Modelo</label><br />
                            <input type="text" class="input_view" name="modelo" value="' . $modelo . '">
                        </div>
                    </div>

                    <div class="row">
                        <div class="half-width">
                            <label class="label" for="plataforma">Plataforma</label><br />
                            <input type="text" class="input_view" name="plataforma" value="' . $plataforma . '">
                        </div>

                        <div class="half-width">
                            <label class="label" for="scanbody">Scanbody</label><br />
                            <input type="text" class="input_view" name="scanbody" value="' . $scanbody . '">
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