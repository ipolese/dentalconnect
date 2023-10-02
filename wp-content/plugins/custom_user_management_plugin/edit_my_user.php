<?php

function display_my_user_edit_form() {
    if (function_exists('adicionar_link_voltar')) {
        adicionar_link_voltar();
    }
    
    ob_start();

    $current_user = wp_get_current_user();
    $first_name = $current_user->first_name;
    $last_name = $current_user->last_name;
    $user_login = $current_user->user_login;
    $email = $current_user->user_email;
    $cep = get_field('cep', 'user_' . $current_user->ID);
    $rua = get_field('rua', 'user_' . $current_user->ID);
    $numero = get_field('numero', 'user_' . $current_user->ID);
    $bairro = get_field('bairro', 'user_' . $current_user->ID);
    $cidade = get_field('cidade', 'user_' . $current_user->ID);
    $estado = get_field('estado', 'user_' . $current_user->ID);
    $pais = get_field('pais', 'user_' . $current_user->ID);
    $complemento = get_field('complemento', 'user_' . $current_user->ID);
    $instagram = get_field('instagram', 'user_' . $current_user->ID);
    $facebook = get_field('facebook', 'user_' . $current_user->ID);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $new_first_name = sanitize_text_field($_POST['first_name']);
        $new_last_name = sanitize_text_field($_POST['last_name']);
        $new_email = sanitize_email($_POST['email']);
        $new_cep = sanitize_text_field($_POST['cep']);
        $new_rua = sanitize_text_field($_POST['rua']);
        $new_numero = sanitize_text_field($_POST['numero']);
        $new_cidade = sanitize_text_field($_POST['cidade']);
        $new_bairro = sanitize_text_field($_POST['bairro']);
        $new_estado = sanitize_text_field($_POST['estado']);
        $new_pais = sanitize_text_field($_POST['pais']);
        $new_complemento = sanitize_text_field($_POST['complemento']);
        $new_instagram = sanitize_text_field($_POST['instagram']);
        $new_facebook = sanitize_text_field($_POST['facebook']);
        $new_password = $_POST['password'];

        wp_update_user(array(
            'ID' => $current_user->ID,
            'first_name' => $new_first_name,
            'last_name' => $new_last_name,
            'user_email' => $new_email,
        ));

        update_field('cep', $new_cep, 'user_' . $current_user->ID);
        update_field('rua', $new_rua, 'user_' . $current_user->ID);
        update_field('numero', $new_numero, 'user_' . $current_user->ID);
        update_field('cidade', $new_cidade, 'user_' . $current_user->ID);
        update_field('bairro', $new_bairro, 'user_' . $current_user->ID);
        update_field('estado', $new_estado, 'user_' . $current_user->ID);
        update_field('pais', $new_pais, 'user_' . $current_user->ID);
        update_field('complemento', $new_complemento, 'user_' . $current_user->ID);

        update_field('instagram', $new_instagram, 'user_' . $current_user->ID);
        update_field('facebook', $new_facebook, 'user_' . $current_user->ID);

        if (!empty($new_password)) {
            wp_set_password($new_password, $current_user->ID);
        }

        wp_redirect(home_url('/meu-perfil/'));
    }
    ?>
    
    <div class="user-edit-form-container">
        <form id="user-edit-form" method="post">
            <div class="row">
                <div class="half-width">
                    <label for="first_name">Nome</label>
                    <input type="text" name="first_name" value="<?php echo esc_attr($first_name); ?>" required>
                </div>

                <div class="half-width">
                    <label for="last_name">Sobrenome</label>
                    <input type="text" name="last_name" value="<?php echo esc_attr($last_name); ?>" required>
                </div>
            </div> 

            <div class="row">
                <div class="half-width">
                    <label for="username">Login</label>
                    <input type="text" name="username" value="<?php echo esc_attr($user_login); ?>" disabled>
                </div>

                <div class="half-width">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" value="<?php echo esc_attr($email); ?>" required>
                </div>
            </div>

            <label for="cep">CEP</label>
            <input type="text" name="cep" value="<?php echo esc_attr($cep); ?>" required>

            <div class="row">
                <div class="two-thirds-width">
                    <label for="rua">Rua</label>
                    <input type="text" name="rua" value="<?php echo esc_attr($rua); ?>" required>
                </div>

                <div class="one-third-width">
                    <label for="numero">Número</label>
                    <input type="text" name="numero" value="<?php echo esc_attr($numero); ?>" required>
                </div>
            </div>

            <div class="row">
                <div class="half-width">
                    <label for="bairro">Bairro</label>
                    <input type="text" name="bairro" value="<?php echo esc_attr($bairro); ?>" required>
                </div>

                <div class="half-width">
                    <label for="cidade">Cidade</label>
                    <input type="text" name="cidade" value="<?php echo esc_attr($cidade); ?>" required>
                </div>
            </div>  

            <div class="row">
                <div class="half-width">
                    <label for="estado">Estado</label>
                    <input type="text" name="estado" value="<?php echo esc_attr($estado); ?>" required>
                </div>

                <div class="half-width">
                    <label for="pais">País</label>
                    <input type="text" name="pais" value="<?php echo esc_attr($pais); ?>" required>
                </div>
            </div>  

            <label for="complemento">Complemento</label>
            <input type="text" name="complemento" value="<?php echo esc_attr($complemento); ?>">

            <label for="instagram">Instagram</label>
            <input type="text" name="instagram" value="<?php echo esc_attr($instagram); ?>">

            <label for="facebook">Facebook</label>
            <input type="text" name="facebook" value="<?php echo esc_attr($facebook); ?>"> 

            <div class="row">
                <div class="half-width">
                    <label for="password">Nova Senha</label>
                    <input type="password" name="password">
                </div>

                <div class="half-width">
                    <label for="confirm_password">Confirme a Nova Senha</label>
                    <input type="password" name="confirm_password">
                </div>
            </div>  

            <div style="display: flex;">
                <input type="submit" value="Atualizar Meu Perfil" style="margin-top: 30px;">
                <input type="button" value="Cancelar" onclick="voltarPagina()" style="background: #fb04ab; margin-top: 30px; margin-left: 20px; width: auto;">
            </div>
        </form>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'my_user_edit_form', 'display_my_user_edit_form' );