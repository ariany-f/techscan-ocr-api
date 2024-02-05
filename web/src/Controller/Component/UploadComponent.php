<?php
/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

namespace Src\Controller\Component{
    use Src\App;
    use Tecno\Lib\Utils;


    class UploadComponent extends App
    {
        public $maxFiles = 1;
        public $allowedTypes = array('image/jpeg', 'application/msword', 'application/pdf');
        public $filesSize = 24000000; //em Bytes

        public function upload($data)
        {
            if(!empty($data)){
                if(count($data) > $this->maxFiles){
                    Utils::setMessage('error', "Permitido enviar apenas {$this->maxFiles} arquivo(s) por vez!");
                    Utils::redirect([
                        'url' => Utils::urlFull()
                    ]);
                }
            }

            foreach($data as $file){
                if($file['size'] > $this->filesSize){
                    Utils::setMessage('error', "Tamanho do arquivo não pode ultrapassar {($this->filesSize/1024)}MB!");
                    Utils::redirect([
                        'url' => Utils::urlFull()
                    ]);
                }

                if(!in_array($file['type'], $this->allowedTypes)){
                    Utils::setMessage('error', 'Formato de arquivo não permitido');
                    Utils::redirect([
                        'url' => Utils::urlFull()
                    ]);
                }
            }

            return $data;
        }
    }
}
