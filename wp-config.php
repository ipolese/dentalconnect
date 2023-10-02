<?php
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa usar o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do banco de dados
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Configurações do banco de dados - Você pode pegar estas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define( 'DB_NAME', 'dentalconnect' );

/** Usuário do banco de dados MySQL */
define( 'DB_USER', 'dentalconnect' );

/** Senha do banco de dados MySQL */
define( 'DB_PASSWORD', 'Nwu}!DGoa}_Y' );

/** Nome do host do MySQL */
define( 'DB_HOST', 'localhost' );

/** Charset do banco de dados a ser usado na criação das tabelas. */
define( 'DB_CHARSET', 'utf8mb4' );

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define( 'DB_COLLATE', '' );

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para invalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'uQqTde?J/L##MDUN&<96(Yu[(+MB]oGa.[_COuF^$4+p(03h_mqy)y?{R6dZ+?qq' );
define( 'SECURE_AUTH_KEY',  '*g$0_}n_=JPa&IMit(=NcgZ#{z4mrfe:=9W P`2Iota=k=Cbf~./j,K3m}Gx*pJ ' );
define( 'LOGGED_IN_KEY',    '7MJM09;cCQn,k-(B1TKIB5X_S)[05U$sz>*[}*2wZIGd1_*Use@IT>+ZDGpF$ZFi' );
define( 'NONCE_KEY',        '(Sa3v6kT5hkPoWQ+quiEx$`0[4;MBA%]@8IRH:YUcft/e6@v/Y{}G#8~NV|G@*I,' );
define( 'AUTH_SALT',        'zu%-,W ^$qh>F1;K{rkEZ2m:i[juYgQM!fu{glgqA[ff_<S7=cZLV k.p/rqPLLc' );
define( 'SECURE_AUTH_SALT', '}x|m ,EX%kZ+v#As]fv60;]15kmJ2hkqk2Zhl[M<cnuG8OzTNoLZkoP/^1}IU0BI' );
define( 'LOGGED_IN_SALT',   '*4QzRw-%-%9G _mAN3Y[i6:<h2>zfQKP/Vv`jKlaB`YCN,>uIF;H#dJ&(iJxGnv1' );
define( 'NONCE_SALT',       ',JAu}4X(tJVzalBQ[88;:).OUt#cIyQ{]@d?G:thO86(3S/p|+^efS717KssOA}G' );
define( 'WP_MEMORY_LIMIT', '256M');
/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * um prefixo único para cada um. Somente números, letras e sublinhados!
 */
$table_prefix = 'wp_';

/**
 * Para desenvolvedores: Modo de debug do WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( isset( $_GET['debug'] ) && 'true' == $_GET['debug'] ) {
	define( 'WP_DEBUG', true );   
	define('WP_DEBUG_LOG', true);
} else {
	ini_set('display_errors', 'Off');
	ini_set('error_reporting', E_ALL ^ E_DEPRECATED ^ E_NOTICE);
}

define( 'FS_METHOD', 'direct' );

/* Adicione valores personalizados entre esta linha até "Isto é tudo". */

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Configura as variáveis e arquivos do WordPress. */
require_once ABSPATH . 'wp-settings.php';
