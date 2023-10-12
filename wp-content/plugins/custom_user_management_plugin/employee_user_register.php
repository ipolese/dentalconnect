<?php

function display_employee_user_registration_form() {
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

            $setor = sanitize_text_field($_POST['setor']);
            $comissao = sanitize_text_field($_POST['comissao']);
            //$password = wp_generate_password();
            $password = wp_generate_password(6, false, '0123456789');

            $user_role = '';
            $usuario_pai = get_current_user_id(); 

            $user_role = 'funcionario_lab';
            $user_id = wp_create_user($username, $password, $email);

            if (is_wp_error($user_id)) {
            } else {
                wp_update_user(array('ID' => $user_id, 'first_name' => $first_name));

                if ($user_role) {
                    wp_update_user(array('ID' => $user_id, 'role' => $user_role));
                }

                update_field('usuario_pai', $usuario_pai, 'user_' . $user_id);

                update_field('setor', $setor, 'user_' . $user_id);
                update_field('comissao', $comissao, 'user_' . $user_id);
                update_field('visivel', true, 'user_' . $user_id);
                update_field('bloqueado', false, 'user_' . $user_id);

                // Send email with login and password
                $subject = 'Seus dados de acesso';
                $message = 'Olá, seus dados de acesso a nossa plataforma são:<br /><br />Login: ' . $username . '<br />Senha: ' . $password;
                wp_mail($email, $subject, $message);

                wp_redirect(home_url('/funcionarios/'));
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
                <div class="two-thirds-width">
                    <label for="setor">Setor</label>
                    <input type="text" name="setor" required>
                </div>

                <div class="one-third-width">
                    <label for="comissao">Comissão</label>
                    <input type="text" name="comissao" required>
                </div>
            </div>

            <div style="display: flex;">
                <input type="submit" value="Cadastrar Funcionário" style="margin-top: 30px;">
                <input type="button" value="Cancelar" onclick="voltarPagina()" style="background: #fb04ab; margin-top: 30px; margin-left: 20px; width: auto;">
            </div>
        </form>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'employee_user_registration_form', 'display_employee_user_registration_form' );