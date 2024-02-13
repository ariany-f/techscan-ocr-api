<?php
/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

namespace src\Model\Option {

    use Exception;
    use DateTime;
    use Src\App;
    use Tecno\Database\Db;

    class OptionModel extends App {

        private $db;

        /**
         * OptionModel constructor.
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
         * Salva a configuração
         * @param array $params
         * @throws Exception
         */
        public function save(array $params)
        {
            return $this->db->insert('Options', $params);
        }
        
        /**
         * Altera a configuração
         * @param array $params
         * @throws Exception
         */
        public function update(array $params)
        {
            $columns = [];

            if(isset($params['description']))
            {
                $columns['description'] = $params['description'];
            }
            if(isset($params['value']))
            {
                $columns['value'] = $params['value'];
            }

            $update_data = [
                'table' => 'options',
                'id' => [
                      'id' => $params['id']
                ],
                'columns' => $columns
            ];
            return $this->db->update($update_data);
        }

        /**
         * Pega a configuração
         * @throws Exception
         */
        public function get($description = null)
        {
            try {
                $where = (!empty($description)) ? " options.description = '$description'" : " AND 1 = 1";
                
                $sql = "SELECT * FROM options WHERE ". $where;

                return $this->db->query($sql);

            } catch (Exception $e) {
                Utils::saveLogFile('catchh error.log', [
                    'error' => $e->getMessage()
                ]);
            }
        }
    }
}