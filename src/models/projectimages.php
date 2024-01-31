<?php 

    namespace Mvc\Portfolio\models;
    use Exception;
    use Mvc\Portfolio\core\registry;

    class projectimages extends AbstractModel{
        public $table   = 'project_photo';
        
        public function getPhotosById($project)
        {
            try{
                return registry::get('dbconn')->select($this->table,['photo'])->where('project')->preparedExecute([$project])->getAll();
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        }

        public function addImages($projectId,array $images)
        {
            foreach($images as $image){
                $this->add($this->table,['photo'=>$image,'project'=>$projectId]);
            }
        }

    }