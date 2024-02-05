<?php
/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

use src\Helper\UtilsHelper;

$this->setCss([
    'index/orienta',
    'mobile/index/orienta',
    '_ext/swiper/swiper-bundle.min'
]);

$this->setJs([
    'telemedicine/index',
    '_ext/swiper/swiper-bundle.min'
    ],
    'down_aux'
);
?>
<?= $this->load('element', 'Index/Orienta/Top') ?>
<?= $this->load('element', 'Index/Orienta/Info') ?>
<?= $this->load('element', 'Index/Orienta/Steps') ?>
