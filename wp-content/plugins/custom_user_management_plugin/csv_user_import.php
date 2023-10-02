<?php
function process_user_import() {
    $current_user = wp_get_current_user();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['user_csv']) && !empty($_FILES['user_csv']['tmp_name'])) {
        $user_role = '';

        if (in_array('laboratorio', $current_user->roles)) {
            $user_role = 'clinica';
        } elseif (in_array('radiologia', $current_user->roles)) {
            $user_role = 'dentista';
        }

        if (empty($user_role)) {
            return;
        }

        $file_path = $_FILES['user_csv']['tmp_name'];
        $file = fopen($file_path, 'r');

        while (($data = fgetcsv($file, 1000, ',')) !== false) {
            $username = sanitize_user($data[0]);
            $email = sanitize_email($data[1]);
            $cep = sanitize_email($data[2]);
            $rua = sanitize_email($data[3]);
            $numero = sanitize_email($data[4]);
            $bairro = sanitize_email($data[5]);
            $cidade = sanitize_email($data[6]);
            $estado = sanitize_email($data[7]);
            $pais = sanitize_email($data[8]);
            $complemento = sanitize_email($data[9]);
            //$password = wp_generate_password();
            $password = wp_generate_password(6, false, '0123456789');
            $user_id = wp_create_user($username, $password, $email);

            if (!is_wp_error($user_id)) {
                wp_update_user(array('ID' => $user_id, 'role' => $user_role));
                
                $usuario_pai = get_current_user_id();
                update_field('usuario_pai', $usuario_pai, 'user_' . $user_id);

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

        fclose($file);
    }
}
add_action('init', 'process_user_import');

function display_user_import_form() {
    if (function_exists('adicionar_link_voltar')) {
        adicionar_link_voltar();
    }
    
    ob_start();
    ?>

    <div class="user-import-form-container">
        <form id="user-import-form" method="post" enctype="multipart/form-data">
            <input type="file" name="user_csv" accept=".csv" required>

            <div style="display: flex;">
                <input type="submit" value="Importar Clientes" style="margin-top: 30px;">
                <input type="button" value="Cancelar" onclick="voltarPagina()" style="background: #fb04ab; margin-top: 30px; margin-left: 20px; width: auto;">
            </div>
        </form>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('user_import_form', 'display_user_import_form');