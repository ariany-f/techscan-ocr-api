<?php
/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

namespace src\Model\User {

    use Exception;
    use DateTime;
    use Src\App;
    use Tecno\Database\Db;

    class UserModel extends App {

        private $db;

        /**
         * UserModel constructor.
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
         * Salva os usuários
         * @param array $params
         * @throws Exception
         */
        public function save(array $params)
        {
            return $this->db->insert('users', $params);
        }

        /**
         * Login
         * @param array $params
         * @throws Exception
         */
        public function login(array $params)
        {
            $result = $this->db->query("SELECT id FROM users WHERE status = 1 AND email = '". $params['email'] . "'");

            if(empty($result))
            {
                return;
            }

            $password = $this->db->query("SELECT id FROM users WHERE status = 1 AND id = '". $result[0]['id'] . "' AND password = '". $params['password'] . "'");

            if(empty($password))
            {
                return;
            }

            $login['user_id'] = $result[0]['id'];

            $id = $this->db->insert('login', $login);

            $result_login = $this->db->query("SELECT users.id AS user_id, token, expires_at, users.name AS user_name, users.email AS user_email, permissions.name AS user_permission FROM login LEFT JOIN users ON users.id = login.user_id INNER JOIN permissions ON permissions.id = users.permission_id WHERE login.id =  $id");

            if(empty($result_login))
            {
                return;
            }

            return $result_login;
        }

         /**
         * Logout
         * @param array $params
         * @throws Exception
         */
        public function logout(array $params)
        {
            $result = $this->db->query("SELECT id FROM login WHERE expires_at > CURDATE() AND token = '". $params['token'] . "'");

            if(empty($result))
            {
                return;
            }

            $expires_at = new DateTime();
            $update_data = [
                'table' => 'login',
                'id' => [
                      'id' => $result[0]['id']
                ],
                'columns' => [
                      'expires_at' => $expires_at->format('Y-m-d H:i:s')
                ]
            ];

            return $this->db->update($update_data);
        }
        
        /**
         * Altera os usuários
         * @param array $params
         * @throws Exception
         */
        public function update(array $params)
        {
            $columns = [];

            if(isset($params['status']))
            {
                $columns['status'] = $params['status'];
            }
            if(isset($params['name']))
            {
                $columns['name'] = $params['name'];
            }
            if(isset($params['email']))
            {
                $columns['email'] = $params['email'];
            }
            if(isset($params['password']))
            {
                $columns['password'] = $params['password'];
            }
            if(isset($params['permission_id']))
            {
                $columns['permission_id'] = $params['permission_id'];
            }

            $update_data = [
                'table' => 'users',
                'id' => [
                      'id' => $params['id']
                ],
                'columns' => $columns
            ];
            return $this->db->update($update_data);
        }

        /**
         * Altera os usuários
         * @param array $params
         * @throws Exception
         */
        public function alterarStatus(array $params)
        {
            $update_data = [
                'table' => 'users',
                'id' => [
                      'id' => $params['id']
                ],
                'columns' => [
                      'status' => $params['status']
                ]
            ];
            return $this->db->update($update_data);
        }

        /**
         * Pega os usuários
         * @throws Exception
         */
        public function get($id = null)
        {
            try {
                $where = (!empty($id)) ? " AND users.id = $id" : " AND 1 = 1";
                
                $sql = "SELECT users.*, permissions.name AS user_permissions, users_status.descricao as user_status FROM users INNER JOIN permissions ON permissions.id = users.permission_id iNNER JOIN users_status ON users_status.id = users.status WHERE users.status = 1 ". $where;

                return $this->db->query($sql);

            } catch (Exception $e) {
                Utils::saveLogFile('catchh error.log', [
                    'error' => $e->getMessage()
                ]);
            }
        }
    }
}