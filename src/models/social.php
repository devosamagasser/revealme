<?php 
namespace Mvc\Portfolio\models;

use Mvc\Portfolio\core\registry;


    class Social extends AbstractModel{
        public $table = 'social';
        public $usersocial = 'userlinks';

        public function userlinks($user)
        {
            return registry::get('dbconn')->select($this->usersocial,["$this->usersocial.link","$this->usersocial.id as social_id","$this->table.*"])->join($this->table,"id",$this->usersocial,"social_id")->where('user_id')->preparedExecute([$user])->getAll();
        }
        
        public function socialLinks()
        {
            return registry::get('dbconn')->select($this->table)->normalExecute()->getAll();
        }

        public function addLink($userid,$socialid,$link)
        {
            return $this->add($this->usersocial,['user_id'=>$userid,'social_id'=>$socialid,'link'=>$link]);
        }

        public function editLink($socialid,$link,$sociallinkid)
        {
            return $this->edit($this->usersocial,['social_id'=>$socialid,'link'=>$link],['id'=>$sociallinkid]);
        }

        public function delLink($sociallinkid)
        {
            return $this->delete($this->usersocial,'id', $sociallinkid);
        }


    }