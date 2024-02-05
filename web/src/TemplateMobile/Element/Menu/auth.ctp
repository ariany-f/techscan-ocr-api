<?php
/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

use Tecno\Lib\Utils;

?>
<br>
<hr>
Menu auth <a href="<?= $this->webroot; ?>"><?= __('Home') ?></a> |
<a href="<?= $this->webroot; ?>client/dashboard"><?= __('Dashboard') ?></a> |
<a href="<?= $this->webroot; ?>client/support"><?= __('Support') ?></a> |
<?= __('Language') ?>:
<a href="<?= Utils::urlFull() ?>?lang=pt_BR"><?= __('Portuguese') ?></a>,
<a href="<?= Utils::urlFull() ?>?lang=en_US"><?= __('English') ?></a> |
<a href="<?= $this->webroot; ?>client/signout"><?= __('Logout') ?></a>
<hr>
<br>