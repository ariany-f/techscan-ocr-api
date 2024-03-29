<?php
/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

namespace src\Model\Securos {

    use Exception;
    use Src\App;
    use Tecno\Database\Db;

    class WebsocketModel extends App {

        private $db;

        /**
         * WebsocketModel constructor.
         * @throws Exception
         */
        public function __construct()
        {
            /**
             * Load componentes
             * entre outros
             */
            $this->db = new Db('default');
        }

        /**
         * Salva as WebSockets
         * @param array $params
         * @throws Exception
         */
        public function save(array $params)
        {
            try
            {
                $result = $this->db->insert('securos_websocket', $params);
            } 
            catch(Exception $e)
            {
                Utils::saveLogFile('catch error.log', [
                    'errors' => $e->getMessage()
                ]);
            }
            return $result;
        }

        /**
         * Pega as WebSockets
         * @throws Exception
         */
        public function get()
        {
            try {
                return $this->db->query('SELECT id, request_json FROM securos_websocket');

            } catch (Exception $e) {
                Utils::saveLogFile('catch error.log', [
                    'errors' => $e->getMessage()
                ]);
            }
        }
    }
}