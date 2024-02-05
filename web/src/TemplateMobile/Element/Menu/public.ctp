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
Menu public <a href="<?= $this->webroot; ?>"><?= __('Home') ?></a> |
<?= __('Language') ?>:
<a href="<?= Utils::urlFull() ?>?lang=pt_BR"><?= __('Portuguese') ?></a>,
<a href="<?= Utils::urlFull() ?>?lang=en_US"><?= __('English') ?></a> |
<a href="<?= $this->webroot; ?>client/signin"><?= __('Login') ?></a>
<hr>
<br>