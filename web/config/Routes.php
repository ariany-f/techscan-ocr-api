<?php

/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

namespace Config {

    class Routes
    {

        /**
         * Configuracao de rotas
         * @var array
         */
        public static $routers = 
        [
            '/' => [
                'controller' => 'Index',
                'action' => 'index',
                'pass' => []
            ],
            'users/login' => [
                'controller' => 'Access',
                'action' => 'login',
                'pass' => []
            ],
            'users/logout' => [
                'controller' => 'Access',
                'action' => 'logout',
                'pass' => []
            ],
            'users/*' => [
                'controller' => 'Index',
                'action' => 'users',
                'pass' => []
            ],
            'cameras/*' => [
                'controller' => 'Index',
                'action' => 'cameras',
                'pass' => []
            ],
            'passagens/*' => [
                'controller' => 'Index',
                'action' => 'passagens',
                'pass' => []
            ],
            'estatisticas/*' => [
                'controller' => 'Index',
                'action' => 'estatisticas',
                'pass' => []
            ],
            'apis-externas/*' => [
                'controller' => 'Index',
                'action' => 'apis',
                'pass' => []
            ],
            'portoes/*' => [
                'controller' => 'Index',
                'action' => 'portoes',
                'pass' => []
            ],
            'direcoes/*' => [
                'controller' => 'Index',
                'action' => 'direcoes',
                'pass' => []
            ],
            'motivos/*' => [
                'controller' => 'Index',
                'action' => 'motivos',
                'pass' => []
            ],
            'imagens-representativas/*' => [
                'controller' => 'Index',
                'action' => 'imagens',
                'pass' => []
            ]
        ];
    }
}
