<?php

/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

$this->setCss([
    'mobile/index/pink_october',
    '_ext/swiper/swiper-bundle.min',
    'index/depositions'
]);

$this->setJs(
    [
        '_ext/jquery/jquery.mask.min',
        '_ext/jquery/jquery.validate.min',
        'client/promo',
        'https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js',
        '_ext/swiper/swiper-bundle.min',
        'index/depositions-clients',
        'index/depositions',

    ],
    'down_aux'
);


?>
<?= $this->load('element', 'Index/pinkOctober/top') ?>
<?= $this->load('element', 'Index/pinkOctober/pinkOctober') ?>
