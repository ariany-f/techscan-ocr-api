<?php
/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

namespace src\Model\Passage {

    use Exception;
    use Src\App;
    use Tecno\Database\Db;

    class PassageImageModel extends App {

        private $db;

        /**
         * PassageImageModel constructor.
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
         * Salva as Imagens de Passagens
         * @param array $params
         * @throws Exception
         */
        public function save(array $params)
        {
            try
            {
                $result = $this->db->insert('passage_images', $params);
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
         * Pega as Imagens de Passagens
         * @throws Exception
         */
        public function get()
        {
            try {
                return $this->db->query('SELECT * FROM passage_images');

            } catch (Exception $e) {
                Utils::saveLogFile('catch error.log', [
                    'errors' => $e->getMessage()
                ]);
            }
        }
    }
}