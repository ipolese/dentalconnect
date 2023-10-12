<?php

// Função para exibir o formulário de edição de usuário
function display_user_edit_form() {
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
        $telefone = sanitize_text_field($_POST['telefone']);
        $celular = sanitize_text_field($_POST['celular']);
        $cep = sanitize_text_field($_POST['cep']);
        $rua = sanitize_text_field($_POST['rua']);
        $numero = sanitize_text_field($_POST['numero']);
        $bairro = sanitize_text_field($_POST['bairro']);
        $cidade = sanitize_text_field($_POST['cidade']);
        $estado = sanitize_text_field($_POST['estado']);
        $pais = sanitize_text_field($_POST['pais']);
        $complemento = sanitize_text_field($_POST['complemento']);

        // Atualize os campos do usuário
        if (isset($user_data)) {
            wp_update_user(array(
                'ID' => $user_id,
                'first_name' => $first_name,
                'user_email' => $email,
            ));

            update_field('telefone', $telefone, 'user_' . $user_id);
            update_field('celular', $celular, 'user_' . $user_id);
            update_field('cep', $cep, 'user_' . $user_id);
            update_field('rua', $rua, 'user_' . $user_id);
            update_field('numero', $numero, 'user_' . $user_id);
            update_field('bairro', $bairro, 'user_' . $user_id);
            update_field('cidade', $cidade, 'user_' . $user_id);
            update_field('estado', $estado, 'user_' . $user_id);
            update_field('pais', $pais, 'user_' . $user_id);
            update_field('complemento', $complemento, 'user_' . $user_id);
        }

        // Redirecione após a atualização
        wp_redirect(home_url('/clientes/'));
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
                <div class="half-width">
                    <label for="telefone">Telefone</label>
                    <input type="text" name="telefone" value="<?php echo isset($user_data) ? esc_attr(get_field('telefone', 'user_' . $user_id)) : ''; ?>" required>
                </div>

                <div class="half-width">
                    <label for="celular">Celular</label>
                    <input type="text" name="celular" value="<?php echo isset($user_data) ? esc_attr(get_field('celular', 'user_' . $user_id)) : ''; ?>" required>
                </div>
            </div>  
            
            <label for="cep">CEP</label>
            <input type="text" name="cep" value="<?php echo isset($user_data) ? esc_attr(get_field('cep', 'user_' . $user_id)) : ''; ?>" required>

            <div class="row">
                <div class="two-thirds-width">
                    <label for="rua">Rua</label>
                    <input type="text" name="rua" value="<?php echo isset($user_data) ? esc_attr(get_field('rua', 'user_' . $user_id)) : ''; ?>" required>
                </div>

                <div class="one-third-width">
                    <label for="numero">Número</label>
                    <input type="text" name="numero" value="<?php echo isset($user_data) ? esc_attr(get_field('numero', 'user_' . $user_id)) : ''; ?>" required>
                </div>
            </div>

            <div class="row">
                <div class="half-width">
                    <label for="bairro">Bairro</label>
                    <input type="text" name="bairro" value="<?php echo isset($user_data) ? esc_attr(get_field('bairro', 'user_' . $user_id)) : ''; ?>" required>
                </div>

                <div class="half-width">
                    <label for="cidade">Cidade</label>
                    <input type="text" name="cidade" value="<?php echo isset($user_data) ? esc_attr(get_field('cidade', 'user_' . $user_id)) : ''; ?>" required>
                </div>
            </div>  

            <div class="row">
                <div class="half-width">
                    <label for="estado">Estado</label>
                    <input type="text" name="estado" value="<?php echo isset($user_data) ? esc_attr(get_field('estado', 'user_' . $user_id)) : ''; ?>" required>
                </div>

                <div class="half-width">
                    <label for="pais">País</label>
                    <input type="text" name="pais" value="<?php echo isset($user_data) ? esc_attr(get_field('pais', 'user_' . $user_id)) : ''; ?>" required>
                </div>
            </div>  

            <label for="complemento">Complemento</label>
            <input type="text" name="complemento" value="<?php echo isset($user_data) ? esc_attr(get_field('complemento', 'user_' . $user_id)) : ''; ?>">

            <div style="display: flex;">
                <input type="submit" value="Atualizar Cliente" style="margin-top: 30px;">
                <input type="button" value="Cancelar" onclick="voltarPagina()" style="background: #fb04ab; margin-top: 30px; margin-left: 20px; width: auto;">
            </div>

        </form>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'user_edit_form', 'display_user_edit_form' );