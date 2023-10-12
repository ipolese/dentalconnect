<?php

// Função para exibir o formulário de edição de usuário
function display_employee_user_edit_form() {
    if (function_exists('adicionar_link_voltar')) {
        adicionar_link_voltar();
    }
    
    ob_start();

    if (isset($_GET['user_id'])) {
        $user_id = intval($_GET['user_id']);
        $user_data = get_userdata($user_id);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtenha os dados do formulário
        $first_name = sanitize_user($_POST['first_name']);
        $email = sanitize_email($_POST['email']);
        $setor = sanitize_text_field($_POST['setor']);
        $comissao = sanitize_text_field($_POST['comissao']);

        // Atualize os campos do usuário
        if (isset($user_data)) {
            wp_update_user(array(
                'ID' => $user_id,
                'first_name' => $first_name,
                'user_email' => $email,
            ));

            update_field('setor', $setor, 'user_' . $user_id);
            update_field('comissao', $comissao, 'user_' . $user_id);
        }

        // Redirecione após a atualização
        wp_redirect(home_url('/funcionario/'));
        exit;
    }
    ?>

    <div class="user-edit-form-container">
        <form id="user-edit-form" method="post">
            <label for="first_name">Nome</label>
            <input type="text" name="first_name" value="<?php echo isset($user_data) ? esc_attr($user_data->first_name) : ''; ?>" required>

            <div class="row">
                <div class="half-width">
                    <label for="username">Login</label>
                    <input type="text" name="username" value="<?php echo isset($user_data) ? esc_attr($user_data->user_login) : ''; ?>" disabled>
                </div>

                <div class="half-width">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" value="<?php echo isset($user_data) ? esc_attr($user_data->user_email) : ''; ?>" required>
                </div>
            </div>  

            <div class="row">
                <div class="two-thirds-width">
                    <label for="setor">Setor</label>
                    <input type="text" name="setor" value="<?php echo isset($user_data) ? esc_attr(get_field('setor', 'user_' . $user_id)) : ''; ?>" required>
                </div>

                <div class="one-third-width">
                    <label for="comissao">Comissão</label>
                    <input type="text" name="comissao" value="<?php echo isset($user_data) ? esc_attr(get_field('comissao', 'user_' . $user_id)) : ''; ?>" required>
                </div>
            </div>

            <div style="display: flex;">
                <input type="submit" value="Atualizar Funcionário" style="margin-top: 30px;">
                <input type="button" value="Cancelar" onclick="voltarPagina()" style="background: #fb04ab; margin-top: 30px; margin-left: 20px; width: auto;">
            </div>

        </form>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'employee_user_edit_form', 'display_employee_user_edit_form' );