<?php
/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

namespace Tecno\Database {

    interface Dbs
    {
        /**
         * Executa query
         * @param string $sql
         * @param array $bind
         * @return mixed
         */
        public function query(string $sql, array $bind = []);

        /**
         * Insere dados
         * @param string $table
         * @param array $insert
         * @return mixed
         */
        public function insert(string $table, array $insert);

        /**
         * Insere ou atualiza os dados
         * @param string $table
         * @param array $replace
         * @return mixed
         */
        public function replace(string $table, array $replace);

        /**
         * Update
         * @param array $query
         * @return mixed
         */
        public function update(array $query);

        /**
         * Monta string e o array para fazer o bind
         * @param array $in_array
         * @return mixed
         */
        public function inWhere(array $in_array = []);
    }
}