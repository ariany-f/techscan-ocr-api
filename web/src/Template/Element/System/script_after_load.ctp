<?php
/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

use src\Helper\UtilsHelper;

?>
<div id="scripts"></div>
<script>
    window.onload = function() {
        let scripts = $('#scripts'),
            load = '';

        setTimeout(function () {
            $.ajax({
                type: 'POST',
                headers: {
                    'Referrer-Policy': 'strict-origin'
                },
                url: WEBROOT + '/js-help/modules',
                data: {
                    chat: '<?= $chat ?>'
                },
                beforeSend: function (xhr) {
                    // Sem efeito visual
                }
            })
                .done(function (response) {

                    if (response.chat !== '') {
                        let script = document.createElement("script");
                        script.innerHTML = response.chat;
                        document.body.appendChild(script)
                    }

                    scripts.html(load);
                })
                .fail(function (e) {

                })
                .always(function (e) {

                });
        }, 10000);
    };
</script>