<?php
/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

$this->setCss([
        'error'
]);

$this->setJs([
        'error'
    ],
    'down'
);

?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Framework Error</title>
        <?= $this->load('css') ?>
        <?= $this->load('element', 'System/vars_js') ?>
        <?= $this->load('js_top') ?>
        <?= $this->load('element', 'Measurer/providers') ?>
        <?= $this->load('element', 'Support/chat') ?>
    </head>
    <body>
        <table class="table-error">
            <tr>
                <td>
                    <?= $this->load('template') ?>
                </td>
            </tr>
        </table>
        <?= $this->load('js_down') ?>
    </body>
</html>