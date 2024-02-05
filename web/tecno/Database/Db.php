<?php
/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

namespace Tecno\Database {

    use Exception;
    use Config\Config;
    use Tecno\Lib\Mailer;
    use Tecno\Lib\Session;

    class Db implements Dbs {

        /**
         * @vars
         */
        public $config,
            $adapter;

        /**
         * Db constructor
         * @param string $database
         * @throws Exception
         */
        public function __construct(string $database)
        {
            $this->config = Config::vars('database')[$database][Config::vars('service_mode')];

            /**
             * Ajuste para uma situacao especifica nao afeta o legado
             */
           if(isset($this->config['change_database_user']) and $this->config['change_database_user'] == true and isset($this->config['password_default']) and isset($_SESSION['Auth']['username']))
           {
               $this->config['username'] = strtolower($_SESSION['Auth']['username']);
               $this->config['password'] = $this->config['password_default'];
           }

            switch ($this->config['type'])
            {
                case 'mysql':
                    $database = new Mysql($this->config);
                    $this->adapter = $database;
                break;

                case 'postgres':
                    $database = new Postgres($this->config);
                    $this->adapter = $database;
                 break;

                default:
                    self::typeError(__('Database type error') . ' (' . $this->config['type'] . ')');
            }
        }

        /**
         * Retorna erro type de banco ou conexao
         * @throws Exception
         */
        public static function typeError($error)
        {
            try {
                throw new Exception($error);
            }
            catch (Exception $e)
            {
                $mails = Config::vars('mail_listener');
                echo Config::vars('debug') ? $e : __('Database error');
                $error = [
                    'subject' => __('Tecnoprog Framework - Database error'),
                    'to' => $mails['errors'],
                    'layout' => 'default',
                    'template' => 'error',
                    'vars' => [
                        'title' => __('Mail errors'),
                        'error' => $e
                    ]
                ];
                $mail = new Mailer();
                $mail->send($error);
                die;
            }
        }

        /**
         * @param string $sql
         * @param array $bind
         * @return array|bool|Exception|mixed|\PDO|\PDOException|string
         * @throws Exception
         */
        public function query(string $sql, array $bind = [])
        {
            return $this->adapter->query($sql, $bind);
        }

        /**
         * @param string $sequence_name
         * @return array|bool|Exception|mixed|\PDO|\PDOException|string
         * @throws Exception
         */
        public function lastInsertId(string $sequence_name = null)
        {
            return $this->adapter->lastInsertId($sequence_name);
        }

        /**
         * @param string $table
         * @param array $insert
         * @return mixed
         * @throws Exception
         *
         */
        public function insert(string $table, array $insert)
        {
            return $this->adapter->insert($table, $insert);
        }

        /**
         * @param string $table
         * @param array $replace
         * @return mixed
         * @throws Exception
         *
         */
        public function replace(string $table, array $replace)
        {
            return $this->adapter->replace($table, $replace);
        }

        /**
         * @param array $query
         * @return bool|mixed
         * @throws Exception
         */
        public function update(array $query)
        {
            return $this->adapter->update($query);
        }

        /**
         * Monta string e o array para fazer o bind
         * @param array $in_array
         * @return array|mixed
         */
        public function inWhere(array $in_array = [])
        {
            return $this->adapter->inWhere($in_array);
        }
    }
}