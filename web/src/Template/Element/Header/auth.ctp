<?php

/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

use Config\Config;
use src\Helper\UtilsHelper;
use Tecno\Lib\Utils;
use src\Helper\HtmlHelper;

?>
<header class="cursor-light">
    <nav class="navbar navbar-top-default navbar-expand-lg nav-three-circles black bottom-nav nav-box-shadow no-animation">
        <div class="container-fluid">
            <a class="logo ml-lg-1" href="<?= $this->webroot ?>">
                <img src="<?= HtmlHelper::logo() ?>" alt="logo" title="Logo" class="logo-default">
                <img src="<?= HtmlHelper::logo() ?>" alt="logo" title="Logo" class="logo-scrolled">
            </a>
            <div class="collapse navbar-collapse d-none d-lg-block">
                <?= $this->load('element', 'Menu/auth') ?>
            </div>
            <a href="javascript:void(0)" class="btn-setting btn-hvr-up btn-hvr-whatsapp color-black mr-lg-3 d-none d-lg-block"><i class="fab fa-whatsapp"></i> +1 631 112 1134</a>
            <!-- side menu open button -->
            <a class="menu_bars d-inline-block menu-bars-setting animated-wrap sidemenu_toggle d-block d-lg-none">
                <div class="menu-lines animated-element">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </a>
            <!-- Side Menu -->
        </div>
    </nav>
    <!-- side menu open button -->
    <a class="menu_bars menu-bars-setting animated-wrap sidemenu_toggle d-lg-inline-block d-none">
        <div class="menu-lines animated-element">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </a>
    <!-- Side Menu -->
    <div class="side-menu center">
        <div class="quarter-circle">
            <div class="menu_bars2 active" id="btn_sideNavClose">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <div class="inner-wrapper justify-content-center">
            <div class="col-md-12 text-center">
                <a href="javascript:void(0)" class="logo-full mb-4"><img src="<?= HtmlHelper::logo() ?>" alt=""></a>
            </div>
            <nav class="side-nav m-0">
                <?= $this->load('element', 'Menu/auth') ?>
            </nav>

            <div class="side-footer text-white w-100">
                <ul class="social-icons-simple">
                    <li class="side-menu-icons"><a href="javascript:void(0)"><i class="fab fa-facebook-f color-white"></i> </a> </li>
                    <li class="side-menu-icons"><a href="javascript:void(0)"><i class="fab fa-instagram color-white"></i> </a> </li>
                    <li class="side-menu-icons"><a href="javascript:void(0)"><i class="fab fa-twitter color-white"></i> </a> </li>
                </ul>
                <p class="text-white">&copy; 2020 MegaOne. Made With Love by Themesindustry</p>
            </div>
        </div>
    </div>
    <a id="close_side_menu" href="javascript:void(0);"></a>
    <!--Side Menu-->
</header>