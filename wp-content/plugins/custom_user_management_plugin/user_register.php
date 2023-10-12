<?php

function display_user_registration_form() {
    if (function_exists('adicionar_link_voltar')) {
        adicionar_link_voltar();
    }
    
    ob_start();
    $current_user = wp_get_current_user();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $first_name = sanitize_user($_POST['username']);
        $words = explode(' ', $first_name);
        $username = strtolower($words[0]);
        $email = sanitize_email($_POST['email']);

        if (email_exists($email)) {
            echo '<script>alert("Este email já está em uso. Por favor, escolha outro.");</script>';
        } else {

            $telefone = sanitize_text_field($_POST['telefone']);
            $celular = sanitize_text_field($_POST['celular']);
            $cep = sanitize_text_field($_POST['cep']);
            $rua = sanitize_text_field($_POST['rua']);
            $numero = sanitize_text_field($_POST['numero']);
            $cidade = sanitize_text_field($_POST['cidade']);
            $bairro = sanitize_text_field($_POST['bairro']);
            $estado = sanitize_text_field($_POST['estado']);
            $pais = sanitize_text_field($_POST['pais']);
            $complemento = sanitize_text_field($_POST['complemento']);
            //$password = wp_generate_password();
            $password = wp_generate_password(6, false, '0123456789');

            $user_role = '';
            $usuario_pai = get_current_user_id(); 

            if (in_array('laboratorio', $current_user->roles)) {
                $user_role = 'clinica';
            } elseif (in_array('radiologia', $current_user->roles)) {
                $user_role = 'dentista';
            }

            $user_id = wp_create_user($username, $password, $email);

            if (is_wp_error($user_id)) {
            } else {
                wp_update_user(array('ID' => $user_id, 'first_name' => $first_name));

                if ($user_role) {
                    wp_update_user(array('ID' => $user_id, 'role' => $user_role));
                }

                update_field('usuario_pai', $usuario_pai, 'user_' . $user_id);

                update_field('telefone', $telefone, 'user_' . $user_id);
                update_field('celular', $celular, 'user_' . $user_id);
                update_field('cep', $cep, 'user_' . $user_id);
                update_field('rua', $rua, 'user_' . $user_id);
                update_field('numero', $numero, 'user_' . $user_id);
                update_field('cidade', $cidade, 'user_' . $user_id);
                update_field('bairro', $bairro, 'user_' . $user_id);
                update_field('estado', $estado, 'user_' . $user_id);
                update_field('pais', $pais, 'user_' . $user_id);
                update_field('complemento', $complemento, 'user_' . $user_id);
                update_field('visivel', true, 'user_' . $user_id);
                update_field('bloqueado', false, 'user_' . $user_id);

                // Send email with login and password
                $subject = 'Seus dados de acesso';
                $message = 'Olá, seus dados de acesso a nossa plataforma são:<br /><br />Login: ' . $username . '<br />Senha: ' . $password;
                wp_mail($email, $subject, $message);

                wp_redirect(home_url('/clientes/'));
                exit;
            }
        }
    }
    ?>

    <div class="user-registration-form-container">
        <form id="user-registration-form" method="post">
            <div class="row">
                <div class="half-width">
                    <label for="username">Nome</label>
                    <input type="text" name="username" required>
                </div>

                <div class="half-width">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" required>
                </div>
            </div>

            <div class="row">
                <div class="half-width">
                    <label for="telefone">Telefone</label>
                    <input type="text" name="telefone" required>
                </div>

                <div class="half-width">
                    <label for="celular">Celular</label>
                    <input type="text" name="celular" required>
                </div>
            </div>

            <label for="cep">CEP</label>
            <input type="text" name="cep" required>

            <div class="row">
                <div class="two-thirds-width">
                    <label for="rua">Rua</label>
                    <input type="text" name="rua" required>
                </div>

                <div class="one-third-width">
                    <label for="numero">Número</label>
                    <input type="text" name="numero" required>
                </div>
            </div>

            <div class="row">
                <div class="half-width">
                    <label for="bairro">Bairro</label>
                    <input type="text" name="bairro" required>
                </div>

                <div class="half-width">
                    <label for="cidade">Cidade</label>
                    <input type="text" name="cidade" required>
                </div>
            </div>  

            <div class="row">
                <div class="half-width">
                    <label for="estado">Estado</label>
                    <input type="text" name="estado" required>
                </div>

                <div class="half-width">
                    <label for="pais">País</label>
                    <input type="text" name="pais" required>
                </div>
            </div>  

            <label for="complemento">Complemento</label>
            <input type="text" name="complemento">

            <div style="display: flex;">
                <input type="submit" value="Cadastrar Cliente" style="margin-top: 30px;">
                <input type="button" value="Cancelar" onclick="voltarPagina()" style="background: #fb04ab; margin-top: 30px; margin-left: 20px; width: auto;">
            </div>
        </form>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'user_registration_form', 'display_user_registration_form' );