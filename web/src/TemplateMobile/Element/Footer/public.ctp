<?php
/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

use src\Helper\UtilsHelper;
use Tecno\Lib\Utils;
use Tecno\Lib\Session;

?>
<footer class="p-half bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 text-center">
                <ul class="footer-icons mb-4">
                    <li><a href="javascript:void(0)" class="wow fadeInUp facebook"><i class="fab fa-facebook-f"></i> </a> </li>
                    <li><a href="javascript:void(0)" class="wow fadeInDown twitter"><i class="fab fa-twitter"></i> </a> </li>
                    <li><a href="javascript:void(0)" class="wow fadeInUp google"><i class="fab fa-google"></i> </a> </li>
                    <li><a href="javascript:void(0)" class="wow fadeInDown linkedin"><i class="fab fa-linkedin-in"></i> </a> </li>
                    <li><a href="javascript:void(0)" class="wow fadeInUp instagram"><i class="fab fa-instagram"></i> </a> </li>
                    <li><a href="javascript:void(0)" class="wow fadeInDown pinterest"><i class="fab fa-pinterest-p"></i> </a> </li>
                </ul>
                <a href="<?= Utils::urlFull() ?>?lang=pt_BR"><?= __('Portuguese') ?></a>,
                <a href="<?= Utils::urlFull() ?>?lang=en_US"><?= __('English') ?></a>
                <p class="copyrights mt-2 mb-2">© 2020 MegaOne. Made with love by <a href="javascript:void(0)">themesindustry</a></p>
            </div>
        </div>
    </div>
</footer>