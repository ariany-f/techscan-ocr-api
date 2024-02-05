<?php
/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

namespace src\Model\Camera {

    use Exception;
    use Src\App;
    use Tecno\Database\Db;

    class CameraModel extends App {

        private $db;

        /**
         * CameraModel constructor.
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
         * Salva as cameras
         * @param array $params
         * @throws Exception
         */
        public function save(array $params)
        {
            return $this->db->insert('cameras', $params);
        }

        /**
         * Altera câmera
         * @param array $params
         * @throws Exception
         */
        public function update(array $params)
        {
            $columns = [];

            if(isset($params['direction']))
            {
                $columns['direction'] = $params['direction'];
            }
            if(isset($params['name']))
            {
                $columns['name'] = $params['name'];
            }
            if(isset($params['position']))
            {
                $columns['position'] = $params['position'];
            }
            if(isset($params['representative_img_id']))
            {
                $columns['representative_img_id'] = $params['representative_img_id'];
            }

            $update_data = [
                'table' => 'cameras',
                'id' => [
                      'id' => $params['id']
                ],
                'columns' => $columns
            ];
            return $this->db->update($update_data);
        }

        /**
         * Pega a camera por nome
         * @throws Exception
         */
        public function findIdByName($name)
        {
            try {
                return $this->db->query('SELECT id FROM cameras WHERE name = :name', [
                    ':name' => $name
                ]);

            } catch (Exception $e) {
                Utils::saveLogFile('catchh error.log', [
                    'error' => $e->getMessage()
                ]);
            }
        }

        /**
         * Pega a camera por external_id
         * @throws Exception
         */
        public function findIdByExternalId($external_id)
        {
            try {
                return $this->db->query('SELECT id FROM cameras WHERE external_id = :external_id', [
                    ':external_id' => $external_id
                ]);

            } catch (Exception $e) {
                Utils::saveLogFile('catch error.log', [
                    'errors' => $e->getMessage()
                ]);
            }
        }

        /**
         * Pega as cameras
         * @throws Exception
         */
        public function get()
        {
            try {
                return $this->db->query('SELECT * FROM cameras');

            } catch (Exception $e) {
                Utils::saveLogFile('catch error.log', [
                    'errors' => $e->getMessage()
                ]);
            }
        }

        /**
         * Pega as imagens representativas de visão de camera
         * @throws Exception
         */
        public function getImagensRepresentativas()
        {
            try {
                return $this->db->query('SELECT * FROM representative_img');

            } catch (Exception $e) {
                Utils::saveLogFile('catch error.log', [
                    'errors' => $e->getMessage()
                ]);
            }
        }

        /**
         * Direções da Camera
         * @throws Exception
         */
        public function getDirecoes()
        {
            try {
                return $this->db->query('SELECT * FROM directions');

            } catch (Exception $e) {
                Utils::saveLogFile('catch error.log', [
                    'errors' => $e->getMessage()
                ]);
            }
        }
    }
}