<?php

/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

$this->setCss([
    'mobile/index/pink_october',
    '_ext/swiper/swiper-bundle.min',
    'health/select2/select2.min',
    'health/select2/select2-bootstrap4.min',
    'health/search',
]);

$this->setJs(
    [
        '_ext/select2/select2.full.min',
        '_ext/select2/i18n/pt-BR',
        '_ext/jquery/jquery.mask.min',
        '_ext/jquery/jquery.validate.min',
        'client/promo',
        'https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js',
        '_ext/swiper/swiper-bundle.min',
        'index/depositions-clients',


    ],
    'down_aux'
);


?>
<?= $this->load('element', 'Index/pinkOctober/top') ?>
<?= $this->load('element', 'Index/pinkOctober/pinkOctober') ?>
<?= $this->load('element', 'Health/Index/Search') ?>
