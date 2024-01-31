<?php 
namespace Mvc\Portfolio\models;

use Mvc\Portfolio\core\registry;


    class Skills extends AbstractModel{
        public $table = 'skills';

        public function userSkills($user){
            return registry::get('dbconn')->select($this->table)->where('user_id')->preparedExecute([$user])->getAll();
        }
        
        public function addSkill($userid,$skill)
        {
            return $this->add($this->table,['skill'=>$skill,'user_id'=>$userid]);
        }

        public function editSkill($skillid,$skill)
        {
            return $this->edit($this->table,['skill'=>$skill],['id'=>$skillid]);
        }

        
        public function delSkill($sociallinkid)
        {
            return $this->delete($this->table,'id', $sociallinkid);
        }
    }

