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

        public function getStatistics($id = null, $data_inicial = null, $data_final = null, $direcao = null){
            
            try {
                    $where = !empty($id) ? " WHERE passages.id = $id" : " WHERE 1 = 1";
                    $where .= (!empty($data_inicial)) ? " AND passages.datetime >= '$data_inicial'" : "";
                    $where .= (!empty($data_final)) ? " AND passages.datetime <= '$data_final'" : "";
                    $where .= (!empty($direcao)) ? " AND passages.direction = $direcao" : "";
                    $sql = "SELECT
                        cameras.position AS Camera,
                        IF(representative_img.url = 'placa', 'frente', representative_img.url) AS Posicao,
                        sum(case when ((updated_by IS NULL AND is_ok = 0) OR is_ok = 1) then 1 else 0 end) AS Acertos,
                        sum(case when (updated_by IS NOT NULL AND is_ok <> 1) then 1 else 0 end) AS Erros
                    FROM passages
                        INNER JOIN cameras ON cameras.id = passages.camera
                        INNER JOIN representative_img ON representative_img.id = cameras.representative_img_id
                    " . $where . "
                    GROUP BY Posicao";

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
        public function get($id = null, $data_inicial = null, $data_final = null, $direcao = null)
        {
            try {

                $where = !empty($id) ? " WHERE passage_bind.id = $id" : " WHERE 1 = 1";
                $where .= (!empty($data_inicial)) ? " AND passage_bind.created_at >= '$data_inicial'" : "";
                $where .= (!empty($data_final)) ? " AND ((passage_bind.updated_at IS NOT NULL AND passage_bind.updated_at <= '$data_final') OR passage_bind.created_at <= '$data_final')" : "";
                $where .= (!empty($direcao)) ? " AND passages.direction = $direcao" : "";
                $limit = ((!empty($where)) and $where !== ' WHERE 1 = 1') ? "" : "LIMIT 500";
                $sql = "
                    SELECT 
                        passage_bind.*, 
                        COALESCE(gates.name, 'Não encontrado') as gate,
                        CASE
                            WHEN passages.is_ok THEN
                                CASE
                                    WHEN users.name THEN 'Erro'
                                    ELSE 'Aprovada'
                                END
                            WHEN passages.updated_by IS NOT NULL THEN 'Erro'
                            ELSE 'Pendente'
                        END as status
                     FROM passage_bind
                        INNER JOIN passages ON passages.bind_id = passage_bind.id
                        LEFT JOIN users ON users.id = passages.updated_by
                        LEFT JOIN cameras ON cameras.id = passages.camera
                        LEFT JOIN gates ON gates.id = cameras.gate_id
                    ".$where." 
                    GROUP BY passage_bind.id
                    ORDER BY passage_bind.id DESC
                    $limit
                ";

                $passages = $this->db->query($sql);
                
                foreach($passages as $key => $passage) {
                    $passage_sql = "
                        SELECT 
                            p.id, 
                            p.is_ok, 
                            p.plate, 
                            p.datetime, 
                            p.bind_id, 
                            p.container, 
                            COALESCE(c.name, 'Não encontrada') as camera,
                            COALESCE(g.name, 'Não encontrado') as gate,
                            COALESCE(d.description, 'Não definida') as direction,
                            ri.url as position,
                            u.name AS updated_by,
                            CASE
                                WHEN p.is_ok AND u.name THEN 'Erro'
                                WHEN p.is_ok THEN 'Aprovada'
                                WHEN u.name THEN 'Erro'
                                ELSE 'Pendente'
                            END as status,
                            p.updated_at AS updated_at,
                            COALESCE(r.description, p.description_reason) as error_reason,
                            (SELECT GROUP_CONCAT(pi.url, '') FROM passage_images pi WHERE pi.active = 1 AND pi.passage_id = p.id) as images
                        FROM 
                            passages p
                        LEFT JOIN directions d ON d.id = p.direction
                        LEFT JOIN cameras c ON c.id = p.camera
                        LEFT JOIN representative_img ri ON c.representative_img_id = ri.id
                        LEFT JOIN gates g ON g.id = c.gate_id
                        LEFT JOIN users u ON u.id = p.updated_by
                        LEFT JOIN reasons r ON r.id = p.preset_reason 
                        WHERE p.bind_id = ".$passage['id']." AND p.status = 1
                        GROUP BY p.id
                        ORDER BY p.id DESC;
                    ";

                    $passages[$key]['itens'] = $this->db->query($passage_sql);
                }

                return $passages;

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
            $columns = [];

            if(isset($params['is_ok'])) {
                $columns['is_ok'] = $params['is_ok'];
            }
            if(isset($params['updated_by'])) {
                $columns['updated_by'] = $params['updated_by'];
            }
            if(isset($params['direction'])) {
                $columns['direction'] = $params['direction'];
            }
            if(isset($params['preset_reason'])) {
                $columns['preset_reason'] = $params['preset_reason'];
            }
            if(isset($params['description_reason'])) {
                $columns['description_reason'] = $params['description_reason'];
            }
            if(isset($params['direction_calculated'])) {
                $columns['direction_calculated'] = $params['direction_calculated'];
            }

            $update_data = [
                'table' => 'passages',
                'id' => [
                      'id' => $params['id']
                ],
                'columns' => $columns
            ];
            return $this->db->update($update_data);
        }
        
        /**
         * Altera passagem
         * @param array $params
         * @throws Exception
         */
        public function updateBind(array $params)
        {
            if($params['direction_calculated']) {
                $columns['direction_calculated'] = $params['direction_calculated'];
            }
            if($params['plate']) {
                $columns['plate'] = $params['plate'];
            }
            if($params['container']) {
                $columns['container'] = $params['container'];
            }
            if($params['bind_id']) {
                $columns['bind_id'] = $params['bind_id'];
            }
            $update_data = [
                'table' => 'passages',
                'id' => [
                      'id' => $params['id']
                ],
                'columns' => $columns
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
            $columns = [];

            if(isset($params['plate'])) {
                $columns['plate'] = $params['plate'];
            }
            if(isset($params['status'])) {
                $columns['status'] = $params['status'];
            }
            if(isset($params['container'])) {
                $columns['container'] = $params['container'];
            }
            if(isset($params['updated_by'])) {
                $columns['updated_by'] = $params['updated_by'];
            }
            if(isset($params['bind_id'])) {
                $columns['bind_id'] = $params['bind_id'];
                unset($columns['updated_by']);
            }

            $update_data = [
                'table' => 'passages',
                'id' => [
                    'id' => $params['id']
                ],
                'columns' => $columns
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
                    $sql = 'SELECT passages.id, passages.plate, passages.container, passages.bind_id FROM passages INNER JOIN cameras ON cameras.id = passages.camera WHERE datetime BETWEEN "'.$date_enter.'" AND "'.$date_leave.'" AND cameras.gate_id = '.current($gate)['gate_id'].' GROUP BY passages.id';
                    
                    return $this->db->query($sql);
                }
            } catch (Exception $e) {
                Utils::saveLogFile('catch error.log', [
                    'errors' => $e->getMessage()
                ]);
            }
        }

        
        public function getBindPassages($number)
        {  
            try {
                
                $sql = 'SELECT passages.id FROM passages WHERE bind_id = '.$number.' GROUP BY passages.id';
                    
                return $this->db->query($sql);

            } catch (Exception $e) {
                Utils::saveLogFile('catch error.log', [
                    'errors' => $e->getMessage()
                ]);
            }
        }
                
        public function getNotCalculatedDirectionPassages($date_enter, $date_leave)
        {  
            try {
                
                $sql = 'SELECT passages.id, passages.direction, passages.bind_id FROM passages WHERE datetime < "'.$date_enter.'" AND direction_calculated = 0 GROUP BY passages.id';
                    
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