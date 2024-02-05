<?php
/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

namespace src\Model\Gate {

    use Exception;
    use Src\App;
    use Tecno\Database\Db;

    class GateModel extends App {

        private $db;

        /**
         * GateModel constructor.
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
         * Salva as Gates
         * @param array $params
         * @throws Exception
         */
        public function save(array $params)
        {
            return $this->db->insert('gates', $params);
        }

        /**
         * Pega a Gate por nome
         * @throws Exception
         */
        public function findIdByName($name)
        {
            try {
                return $this->db->query('SELECT id FROM gates WHERE name = :name', [
                    ':name' => $name
                ]);

            } catch (Exception $e) {
                Utils::saveLogFile('catchh error.log', [
                    'error' => $e->getMessage()
                ]);
            }
        }

        /**
         * Pega a Gate por external_id
         * @throws Exception
         */
        public function findIdByExternalId($external_id)
        {
            try {
                return $this->db->query('SELECT id FROM gates WHERE external_id = :external_id', [
                    ':external_id' => $external_id
                ]);

            } catch (Exception $e) {
                Utils::saveLogFile('catch error.log', [
                    'errors' => $e->getMessage()
                ]);
            }
        }

        /**
         * Pega os Gates
         * @throws Exception
         */
        public function get()
        {
            try {
                return $this->db->query('SELECT * FROM gates');

            } catch (Exception $e) {
                Utils::saveLogFile('catch error.log', [
                    'errors' => $e->getMessage()
                ]);
            }
        }
    }
}