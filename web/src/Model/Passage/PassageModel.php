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
    use Tecno\Lib\Utils;

    class PassageModel extends App {

        private $db;

        /**
         * PassageModel constructor.
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
         * Salva as Passagens
         * @param array $params
         * @throws Exception
         */
        public function save(array $params)
        {
            try
            {
                $result = $this->db->insert('passages', $params);
            } 
            catch(Exception $e)
            {
                Utils::saveLogFile('catch error.log', [
                    'errors' => $e->getMessage()
                ]);
            }
            return $result;
        }

        public function getStatistics($id = null, $data_inicial = null, $data_final = null){
            
            try {
                    $where = !empty($id) ? " WHERE passages.id = $id" : " WHERE 1 = 1";
                    $where .= (!empty($data_inicial)) ? " AND passages.datetime >= '$data_inicial'" : "";
                    $where .= (!empty($data_final)) ? " AND passages.datetime <= '$data_final'" : "";
                    $sql = "SELECT
                        cameras.position AS Camera,
                        representative_img.url AS Posicao,
                        sum(case when is_ok = 1 then 1 else 0 end) AS Acertos,
                        sum(case when is_ok = 0 then 1 else 0 end) AS Erros
                    FROM passages
                        INNER JOIN cameras ON cameras.id = passages.camera
                        INNER JOIN representative_img ON representative_img.id = cameras.representative_img_id
                    " . $where . "
                    GROUP BY representative_img.url";

                return $this->db->query($sql);
            } catch (Exception $e) {
                Utils::saveLogFile('catch error.log', [
                    'errors' => $e->getMessage()
                ]);
            }

        }

        public function getExternalApis($id = null)
        {
            try {
                $where = !empty($id) ? " WHERE external_apis.id = $id" : " WHERE 1 = 1";
                $sql = "SELECT * from external_apis " . $where;

                return $this->db->query($sql);
            } catch (Exception $e) {
                Utils::saveLogFile('catch error.log', [
                    'errors' => $e->getMessage()
                ]);
            }
        }

        /**
         * Pega as Passagens
         * @throws Exception
         */
        public function get($id = null, $data_inicial = null, $data_final = null)
        {
            try {

                $where = !empty($id) ? " WHERE passages.id = $id" : " WHERE 1 = 1";
                $where .= (!empty($data_inicial)) ? " AND passages.datetime >= '$data_inicial'" : "";
                $where .= (!empty($data_final)) ? " AND passages.datetime <= '$data_final'" : "";
                $sql = "
                SELECT 
                    GROUP_CONCAT(dt.id, ' ') as id,
                    GROUP_CONCAT(dt.updated_by, ' ') as updated_by,
                    GROUP_CONCAT(dt.updated_at, ' ') as updated_at,
                    GROUP_CONCAT(dt.is_ok, ' | ') as status,
                    GROUP_CONCAT(dt.error_reason, ' ') as error_reason,
                    GROUP_CONCAT(COALESCE(dt.plate, NULL), '') as plate,
                    GROUP_CONCAT(dt.datetime, ' | ') as datetime,
                    GROUP_CONCAT(dt.container, ' ') as container,
                    dt.direction,
                    dt.gate,
                    GROUP_CONCAT(dt.camera, ' ') as cameras,
                    GROUP_CONCAT(dt.images, ',') as images
            FROM
                (
                    SELECT 
                        passages.id, 
                        passages.is_ok, 
                        passages.plate, 
                        passages.datetime, 
                        passages.container, 
                        cameras.name as camera,
                        gates.name as gate,
                        directions.description as direction,
                        users.name AS updated_by,
                        passages.updated_at AS updated_at,
                        COALESCE(reasons.description, passages.description_reason) as error_reason,
                        GROUP_CONCAT(passage_images.url, ',') as images
                    FROM passages
                        INNER JOIN directions ON directions.id = passages.direction
                        LEFT JOIN passage_images ON passage_images.passage_id = passages.id
                        LEFT JOIN cameras ON cameras.id = passages.camera
                        LEFT JOIN gates ON gates.id = cameras.gate_id
                        LEFT JOIN users ON users.id = passages.updated_by
                        LEFT JOIN reasons ON reasons.id = passages.preset_reason 
                    ".$where." AND  passages.container IS NULL
                    GROUP BY passages.id
            UNION 
            
                    SELECT 
                        passages.id, 
                        passages.is_ok, 
                        passages.plate,
                        passages.datetime, 
                        passages.container, 
                        cameras.name as camera,
                        gates.name as gate,
                        directions.description as direction,
                        users.name AS updated_by,
                        passages.updated_at AS updated_at,
                        COALESCE(reasons.description, passages.description_reason) as error_reason,
                        GROUP_CONCAT(passage_images.url, ',') as images
                    FROM passages
                        INNER JOIN directions ON directions.id = passages.direction
                        LEFT JOIN passage_images ON passage_images.passage_id = passages.id
                        LEFT JOIN cameras ON cameras.id = passages.camera
                        LEFT JOIN gates ON gates.id = cameras.gate_id
                        LEFT JOIN users ON users.id = passages.updated_by
                        LEFT JOIN reasons ON reasons.id = passages.preset_reason 
                    ".$where." AND  passages.plate IS NULL
                    GROUP BY passages.id
                ) AS dt
            GROUP BY HOUR(dt.datetime), MINUTE(dt.datetime), CONCAT(LEFT(SECOND(dt.datetime), 1), 0), dt.direction, dt.gate
            ORDER BY dt.datetime DESC;";

                return $this->db->query($sql);

            } catch (Exception $e) {
                Utils::saveLogFile('catch error.log', [
                    'errors' => $e->getMessage()
                ]);
            }
        }

        /**
         * Altera passagem
         * @param array $params
         * @throws Exception
         */
        public function alterar(array $params)
        {
            $update_data = [
                'table' => 'passages',
                'id' => [
                      'id' => $params['id']
                ],
                'columns' => [
                      'is_ok' => $params['is_ok'],
                      'updated_by' => $params['updated_by'],
                      'preset_reason' => $params['preset_reason'],
                      'description_reason' => $params['description_reason']
                ]
            ];
            return $this->db->update($update_data);
        }
        
        /**
         * Altera passagem
         * @param array $params
         * @throws Exception
         */
        public function update(array $params)
        {
            $update_data = [
                'table' => 'passages',
                'id' => [
                      'id' => $params['id']
                ],
                'columns' => [
                      'plate' => $params['plate'],
                      'container' => $params['container']
                ]
            ];
            return $this->db->update($update_data);
        }
        

        /**
         * Altera status da passagem
         * @param array $params
         * @throws Exception
         */
        public function alterarStatus(array $params)
        {
            $update_data = [
                'table' => 'passages',
                'id' => [
                      'id' => $params['id']
                ],
                'columns' => [
                      'is_ok' => $params['is_ok']
                ]
            ];
            return $this->db->update($update_data);
        }

        public function bindPassage($number, $camera_id, $direction, $date_enter, $date_leave)
        {  
            try {

                $gate = $this->db->query('SELECT gate_id FROM cameras WHERE id = :camera_id', [
                    ':camera_id' => $camera_id
                ]);
                
                if(!empty($gate))
                {
                    $sql = 'SELECT * FROM passages INNER JOIN cameras ON cameras.id = passages.camera WHERE datetime BETWEEN "'.$date_enter.'" AND "'.$date_leave.'" AND cameras.gate_id = '.current($gate)['gate_id'].'';
                    
                    return $this->db->query($sql);
                }
            } catch (Exception $e) {
                Utils::saveLogFile('catch error.log', [
                    'errors' => $e->getMessage()
                ]);
            }
        }

        /**
         * Pega as Passagens
         * @throws Exception
         */
        public function exists($data_type, $datetime, $data, $camera)
        {
            try {
                if($data_type == 'plate')
                {
                    return $this->db->query('SELECT * FROM passages WHERE datetime = :datetime AND plate = :plate AND camera = :camera', [
                        ':plate' => $data,
                        ':datetime' => $datetime,
                        ':camera' => $camera
                    ]);
                }
                elseif($data_type == 'container')
                {
                    return $this->db->query('SELECT * FROM passages WHERE datetime = :datetime AND container = :container AND camera = :camera', [
                        ':container' => $data,
                        ':datetime' => $datetime,
                        ':camera' => $camera
                    ]);
                }
                else
                {
                    return $this->db->query('SELECT * FROM passages WHERE datetime = :datetime AND camera = :camera', [
                        ':datetime' => $datetime,
                        ':camera' => $camera
                    ]);
                }

            } catch (Exception $e) {
                Utils::saveLogFile('catch error.log', [
                    'errors' => $e->getMessage()
                ]);
            }
        }
    }
}