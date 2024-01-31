<?php 
    namespace Mvc\Portfolio\core;

    use \Exception;

    class validation extends Exception {

        private $key;
        private $value;

        private $regexPatterns = [
            'int'           => '[0-9]+',
            'tel'           => '[0-9+\s()-]+',
            'email'         => '[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})',
            'password'      => '(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,32}'
        ];

        public function setValue(array $data)
        {
            $key = array_keys($data); 
            $this -> value = $data[$key[0]];
            $this -> key = $key[0];
            return $this;
        }

        public function fInteger()
        {
            $this -> value = filter_var(trim($this->value),FILTER_SANITIZE_NUMBER_INT);
            $this -> notEmpty();
            $regex = '/^('.$this -> regexPatterns['int'].')$/u';
            if(!preg_match($regex,$this -> value)){
                throw new Exception($this -> key . ' not valid');
            }
            return $this;
        }

        public function fEmail()
        {
            $this -> value = filter_var(trim($this->value),FILTER_VALIDATE_EMAIL);
            $this -> value = filter_var(trim($this->value),FILTER_SANITIZE_SPECIAL_CHARS);
            $this -> notEmpty();
            $regex = '/^('.$this -> regexPatterns['email'].')$/u';
            if(!preg_match($regex,$this -> value)){
                throw new Exception($this -> key . ' not valid');
            }
            return $this;
        }

        public function fPhone()
        {
            $this -> value = filter_var(trim($this->value),FILTER_SANITIZE_NUMBER_INT);
            $this -> notEmpty();
            $regex = '/^('.$this -> regexPatterns['tel'].')$/u';
            if(!preg_match($regex,$this -> value)){
                throw new Exception($this -> key . ' not valid');
            }
            return $this;
        }

        public function fString()
        {
            $this -> value = filter_var(trim($this->value),FILTER_SANITIZE_SPECIAL_CHARS);
            $this -> notEmpty();
            return $this; 
        }

        public function fImage()
        {

            $img = $this -> value;
            if(!empty($img['name']) ){
                if( $img['error'] == 0 ){
                    $ava_ext = ['jpg','png','jfif','gif','webp'];
                    $img_ext = pathinfo($img['name'],PATHINFO_EXTENSION);
                    if(in_array($img_ext,$ava_ext)){
                        if($img['size'] <= 2000000){
                            $this -> value = md5(uniqid()).".webp";
                            move_uploaded_file($img['tmp_name'],"D:\\xampp\htdocs\\revealme\public\admin\dist\img\\{$this -> value}");
                        }else{ 
                            throw new Exception($this -> key." size is big try another one");
                         }
                    }else{
                        throw new Exception($this -> key." extention is not valid");
                     }
                }else{ 
                    throw new Exception($this -> key." is not uploaded");
                }
            }else{
                $this -> value = false;
            }
            return $this;
        }

        public function fImages()
        {
            $img = $this -> value;
            $count = count($img['name']);
            $images = [] ;
            if(empty($img['name'][0]) ){
                $this -> value = false;
                return $this;
            }
            for($i = 0;$i < $count ;$i++ ){
                if(!empty($img['name'][$i]) ){
                    if( $img['error'][$i] == 0 ){
                        $ava_ext = ['jpg','png','jfif','gif'];
                        $img_ext = pathinfo($img['name'][$i],PATHINFO_EXTENSION);
                        if(in_array($img_ext,$ava_ext)){
                            if($img['size'][$i] <= 2000000){
                                $images[] = md5(uniqid()).".".$img_ext;
                                move_uploaded_file($img['tmp_name'][$i],"D:\\xampp\htdocs\startbootstrap-freelancer-gh-pages\public\admin\dist\img\\".$images[$i]);
                            }else{ 
                                throw new Exception($this -> key." number $i size is big try another one");
                            }
                        }else{
                            throw new Exception($this -> key." number $i extention is not valid");
                        }
                    }else{ 
                        throw new Exception($this -> key." number $i is not uploaded");
                    }
                }else{
                }  
            }
            $this -> value = $images;
            return $this;
        }

        public function imagevalid(){
            
        }

        public function fPassword()
        {
            $this -> notEmpty();
            $regex = '/^('.$this -> regexPatterns['password'].')$/u';
            if(!preg_match($regex,$this->value)){
                throw new Exception('Password Must Has Minimum 8 Characters In Length ,At Least One Uppercase English Letter,At Least Lne Lowercase English Letter,At Least One Digit');
            }
            return $this;
        }

        public function hash(){
            $this-> value = password_hash($this->value,PASSWORD_DEFAULT);
            return $this;
        }

        public function notEmpty()
        {
            if(empty($this->value)){
                throw new Exception($this -> key.' is not valid');
            }
        }

        public function min($length)
        {       
            if(strlen($this-> value) < $length)
            {
                throw new Exception($this->key.' must not be less than '.$length);
            }

            return $this;
        }

        public function max($length)
        {
            if(strlen($this-> value) > $length)
            {
                throw new Exception($this->key.' must not be more than '.$length);
            }
            return $this;
        }

        public function getValue()
        {
            return $this -> value;
        }
    }

?>