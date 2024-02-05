<?php
/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

use Tecno\Lib\Session;

/**
 * Tem cart na session
 */
$cart_session = Session::read('healthCart');
$cart_session = ($cart_session) ? $cart_session : [];
?>
<script>
	var WEBROOT = '' + window.location.protocol + '//' + window.location.host + '<?= $this->webroot ?>';<?= "\n" ?>
	var cart_session = JSON.parse('<?= json_encode($cart_session) ?>');
	var LOGGED = <?= (Session::read('Auth')) ? 1 : 0 ?>
</script>