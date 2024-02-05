<?php
/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

namespace Tecno\Auth {

    use Tecno\Lib\Session;
    use Tecno\Lib\Utils;
    use Tecno\Database\Db;

    class Database {

        /**
         * Dados
         * @var array
         */
        private $config, $db;

        /**
         * Database constructor
         * @param array $params
         * @throws \Exception
         */
        public function __construct(array $params)
        {
            $this->config = $params;
            $this->db = new Db('default');
        }

        /**
         * Checa de action exige autenticao
         * @param array $params
         * @return bool
         * @throws \Exception
         */
        public function allow(array $params)
        {
            $this->config['allow'] = $params;
            $details = Utils::getDetailsExec();
            if(!in_array(strtolower($details['action']), array_map('strtolower', $this->config['allow'])))
            {
                self::authCheck($details, $this->config);
            }
            return true;
        }

        /**
         * @param array $params
         * @param array $config
         * @return array|bool|mixed|string
         * @throws \Exception
         */
        public function authCheck(array $params, array $config)
        {
            $result = false;
            $return_to = Utils::urlFull();

            /**
             * Limpa registro de erro se houver
             */
            Session::del('AppAuthWarning');

            /**
             * Session
             */
            $auth = Session::read('Auth');

            /**
             * Tabela campos personalizados
             */
            $table = $this->config['table'];
            $user = $this->config['user'];
            $password = $this->config['password'];
            $identifier = isset($this->config['identifier']) ? $this->config['identifier'] : 'id';
            $profile = isset($this->config['profile']) ? $this->config['profile'] : false;
            $session_ex = isset($this->config['session_ex']) ? $this->config['session_ex'] : false;
            $other_validate = isset($this->config['other_validate']) ? $this->config['other_validate'] : [];

            /**
             * Ha controle extra na session
             */
            if($session_ex and $auth)
            {
                $session_ex_db = $this->db->query("SELECT ${table}.${session_ex} FROM ${table} WHERE id = ${auth['id']}");
                if(!(isset($session_ex_db[0][$session_ex]) and $session_ex_db[0][$session_ex] == $auth[$session_ex]))
                {
                    Session::del('Auth');
                    Session::write('AppAuthWarning', __('Your data has been changed, you need to login again!'));
                    Utils::redirect([
                        'url' => (isset($this->config['redirect_login']['url']) and !empty($this->config['redirect_login']['url'])) ? $this->config['redirect_login']['url'] : '',
                        'controller' => (isset($this->config['redirect_login']['controller']) and !empty($this->config['redirect_login']['controller'])) ? $this->config['redirect_login']['controller'] : '',
                        'action' => (isset($this->config['redirect_login']['action']) and !empty($this->config['redirect_login']['action'])) ? $this->config['redirect_login']['action'] : ''
                    ], $return_to);
                }
            }

            /**
             * Session OK
             */
            if($auth)
            {
                $result = true;
                goto output;
            }

            /**
             * Validando no POST
             */
            if(!$auth and (!isset($_POST[$user]) or !isset($_POST[$password])))
            {
                Session::del('Auth');
                Session::write('AppAuthWarning', __('Access denied, area requires authentication!'));
                Utils::redirect([
                    'url' => (isset($this->config['redirect_login']['url']) and !empty($this->config['redirect_login']['url'])) ? $this->config['redirect_login']['url'] : '',
                    'controller' => (isset($this->config['redirect_login']['controller']) and !empty($this->config['redirect_login']['controller'])) ? $this->config['redirect_login']['controller'] : '',
                    'action' => (isset($this->config['redirect_login']['action']) and !empty($this->config['redirect_login']['action'])) ? $this->config['redirect_login']['action'] : ''
                ], $return_to);
            }

            $where = "${table}.${user} = :${user}\n";
            $query = "SELECT \n\t${table}.${identifier},\n";
            $query .= ($profile) ? "\t${table}.${profile},\n" : '';
            $query .= ($session_ex) ? "\t${table}.${session_ex},\n" : '';
            foreach ($other_validate as $key => $value)
            {
                $query .= "\t${table}.${key},\n";
            }
            $query .= "\t${table}.${password}\nFROM\n\t${table}\nWHERE\n\t";
            $bind = [
                ":${user}" => $_POST[$user]
            ];
            $query = $query . $where;
            $data_user = current($this->db->query($query, $bind));

            /**
             * User não encontrado
             */
            if(!is_array($data_user))
            {
                Session::del('Auth');
                Session::write('AppAuthWarning', __('User not found, check data and try again!'));
                Utils::redirect([
                    'url' => (isset($this->config['redirect_login']['url']) and !empty($this->config['redirect_login']['url'])) ? $this->config['redirect_login']['url'] : '',
                    'controller' => (isset($this->config['redirect_login']['controller']) and !empty($this->config['redirect_login']['controller'])) ? $this->config['redirect_login']['controller'] : '',
                    'action' => (isset($this->config['redirect_login']['action']) and !empty($this->config['redirect_login']['action'])) ? $this->config['redirect_login']['action'] : ''
                ]);
            }

            /**
             * Outra validacao antes da senha
             */
            $check_validate = [];
            foreach ($other_validate as $key => $value)
            {
                if($data_user[$key] != $value)
                {
                    $check_validate[$key] = $data_user[$key];
                }
            }
            if($check_validate)
            {
                $result['error'] = $check_validate;
                goto output;
            }

            /**
             * Tem senha master
             */
            $master_password_id = false;
            $user_id = $data_user[$identifier];
            if(isset($config['master']))
            {
                $master = $config['master'];
                $query_master = "SELECT\n\t${master['table']}.${master['master_id']}\n";
                $query_master .= "FROM\n\t${master['table']}\nWHERE";
                $validate = isset($master['validate']) ? $master['validate'] : [];
                $query_master_where = "\n\t${master['table']}.${master['password']} = :${master['password']}\n";
                foreach ($validate as $key => $value)
                {
                    $query_master_where .= "AND\n\t${master['table']}.${key} = ${value}\n";
                }
                $bind = [
                    ":${master['password']}" => Utils::hash($_POST[$password])
                ];
                $query_master = $query_master .$query_master_where;
                $data_master = current($this->db->query($query_master, $bind));
                $master_password_id = is_array($data_master) ? current($data_master) : false;
            }

            /**
             * Master password confirmado
             */
            if($master_password_id)
            {
                /**
                 * Faz registro de log
                 */
                if(isset($config['master']['log']))
                {
                    $log = $config['master']['log'];
                    $this->db->query("INSERT INTO ${log['table']}
                        (
                            ${log['master_id']},
                            ${log['user_id']}
                        )
                        VALUES
                        (
                            ${master_password_id},
                            ${user_id}
                        )"
                    );
                }
                goto master_password;
            } 

            /**
             * Valida senha do user
             */
            if($data_user[$password] != Utils::hash($_POST[$user] . $_POST[$password]))
            {
                Session::del('Auth');
                Session::write('AppAuthWarning', __('Incorrect password, try again!'));
                Utils::redirect([
                    'url' => (isset($this->config['redirect_login']['url']) and !empty($this->config['redirect_login']['url'])) ? $this->config['redirect_login']['url'] : '',
                    'controller' => (isset($this->config['redirect_login']['controller']) and !empty($this->config['redirect_login']['controller'])) ? $this->config['redirect_login']['controller'] : '',
                    'action' => (isset($this->config['redirect_login']['action']) and !empty($this->config['redirect_login']['action'])) ? $this->config['redirect_login']['action'] : ''
                ]);
            }

            /**
             * Nao tem session
             */
            master_password:
            if(!$auth)
            {
                if ($session_ex) {
                    $control_key = md5($user_id . microtime(true));
                    $this->db->update([
                        'table' => $table,
                        'id' => [
                            'id' => $user_id
                        ],
                        'columns' => [
                            $session_ex => $control_key
                        ]
                    ]); 
                }

                $result = [
                    'id' => $data_user[$identifier]
                ];
            } 

            output:
                return $result;
        }
    }
}