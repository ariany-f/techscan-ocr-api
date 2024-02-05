<?php

/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

use Config\Config;
use Tecno\Lib\Session;
use src\Helper\UtilsHelper;

$ambient = Config::vars('service_mode');

$style = [];

$this->setCss(
    $style
);

$default_top = [
    'default_top'
];

$this->setJs(
    $default_top,
    'top'
);

$js_down = [];


$this->setJs(
    $js_down,
    'down'
);


$loader = 'img/loader.png';
$header = 'Header/public';
$footer = 'Footer/public';

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="<?= (isset($description)) ? $description : Config::vars('app_name'); ?>">
    <meta name="keywords" content="<?= (isset($keywords)) ? $keywords : Config::vars('app_name'); ?>">
    <title><?= (isset($title)) ? $title : Config::vars('app_name'); ?></title>
    <link href="<?= $this->webroot ?>img/favicon.png" rel="icon" type="image/png" />
    <!-- Load css -->
    <?= $this->load('css') ?>
    <!-- /Load css -->
    <!-- Load js vars -->
    <?= $this->load('element', 'System/vars_js') ?>
    <!-- /Load js var -->
    <!-- Load js top -->
    <?= $this->load('js', 'top') ?>
    <!-- /Load js top -->
</head>

<body class="<?= $this->controller . '-' . $this->action ?>" data-spy="scroll" data-target=".navbar-nav" data-offset="90" data-scroll-animation="true">
    <!-- Loader -->
    <div class="loader" id="loader-fade">
        <div class="loader-container">
            <ul class="loader-box">
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </div>
    </div>
    <!-- Loader ends -->

    <?= $this->load('element', $header) ?>
    <?= $this->load('template') ?>
    <?= $this->load('element', $footer) ?>

     
    <!--Animated Cursor-->
    <div id="animated-cursor">
        <div id="cursor">
            <div id="cursor-loader"></div>
        </div>
    </div>
    <!--Animated Cursor End-->


    <!-- Load js down -->
    <?= $this->load('js', 'down') ?>
    <!-- /Load js down -->
    <!-- Load js down_aux -->
    <?= $this->load('js', 'down_aux') ?>
    <!-- /Load js down_aux -->
    <!-- Load script after load -->
    <?= $this->load('element', 'System/script_after_load') ?>
    <!-- /Load script after load -->
    <?= UtilsHelper::readMessage(); ?>
    <?= UtilsHelper::readFormData(); ?>
    <?= $this->load('debug') ?>
    <div id="tela_size" class="tela-size<?= (config::vars('screen_size_show')) ? '' : ' hide' ?>"></div>
</body>

</html>