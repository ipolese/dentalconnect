<?php
/*
Template Name: Template PDF
*/

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once 'inc/pdf/styles.php';

function logo(){
    $custom_logo_id = get_theme_mod( 'custom_logo' );
    $logo_url = wp_get_attachment_image_src( $custom_logo_id, 'full' );

    return $logo_url;
}

function url(){
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $uri = $_SERVER['REQUEST_URI'];

    $current_url = $protocol . '://' . $host . $uri;

    return $current_url;
}

require_once get_template_directory() . '/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

$logo = logo();
$url = url();

$options_qrcode = new QROptions([
    'version' => 5,
    'scale'   => 2,
]);

$qrcodeInstance = new QRCode($options_qrcode);
$qrcode = $qrcodeInstance->render($url);

$options = new Options();
$options->set('isRemoteEnabled', true);

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$post_type = get_post_type($id);

if($post_type == "os_laboratorio"){
    require_once 'inc/pdf/pdf-os-laboratorio.php';
}
elseif($post_type == "os_radiologia"){
    require_once 'inc/pdf/pdf-os-radiologia.php';
}

$post_title = get_the_title($id);
$nome = get_field('nome', $id);

$dompdf = new Dompdf($options);

$style_css = style();
$content = content($id, $logo, $qrcode);

$html = '
    <!DOCTYPE html>
    <html>
        <head>
            <title>OS_' . $post_title . '</title>
            <style>'. $style_css . '</style>
        </head>
        <body>
            '. $content . '
        </body>
    </html>
';

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream('OS_' . $nome . '.pdf', array('Attachment' => false));
?>
