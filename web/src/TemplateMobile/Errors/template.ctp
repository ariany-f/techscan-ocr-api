<?php
/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */
use Config\Config;
use Tecno\Lib\Utils;
use Tecno\Lib\Mailer;

if (Config::vars('service_mode') != 'production') {

    if(Config::vars('php.shell'))
    {
        echo "Template $error " . __('not found');
    }
    else
    {
        echo "Template <b>$error</b> " . __('not found');
    }

} else {

    # Email para avisar a TI sobre o erro
    $mail = new Mailer();
    $error = [
        'subject' => "Erro 400 (site)",
        'to' => Config::vars('mail_listener')['errors'],
        'layout' => 'default',
        'template' => 'debug',
        'vars' => [
            'vars' => [
                'aviso' => 'Template ' . $error . ' não encontrado!'
            ]
        ]
    ];
    $mail->send($error);

    Utils::setMessage('error', '<strong style="font-size: 1.8rem;">Página não encontrada</strong><br>Ops! Não localizamos o endereço no servidor.');
    Utils::redirect(['url' => '/']);

}
?>