<?php 


namespace Mvc\Portfolio\controllers;

use Exception;
use Mvc\Portfolio\controllers\AbstractController;
use Mvc\Portfolio\models\projects;


    class Home extends AbstractController
    {
        public function index()
        {
            try
            {
                $check = $this -> sessionhandeler();
                if($check){
                    $data = [];
                    $data['title'] = 'Home';
                    $data['count'] = (new projects) -> getFriendsProjectsCount($_SESSION['userId']);
                    $data['projects'] = (new projects) -> getFriendsProjects($_SESSION['userId']);
                    // echo "<pre>";
                    // print_r($data);die;
                    $this -> view('index',$data);
                }else{
                    redirect("/home/signin");
                }
            }
            catch(Exception $e)
            {
                redirect("/Error/index/404 Not Found");
            }

        }

        public function signIn()
        {
            $check = $this -> sessionhandeler();
            if(!$check){
                $data = [];
                $data['title'] = 'Reveal me | sign in';
                $data['error'] = (isset($_SESSION['error'])) ? $_SESSION['error'] : "";
                $this -> view('signin',$data);
                (isset($_SESSION['error'])) ? $_SESSION['error'] = "" : "";
            }else{
                redirect("/");
            }
        }

        public function signUp()
        {
            $check = $this -> sessionhandeler();
            if(!$check){
                $data['title'] = 'Reveal me | sign up';
                $data['error'] = (isset($_SESSION['error']))? $_SESSION['error'] : "";
                $this -> view('signup',$data);
                (isset($_SESSION['error'])) ? $_SESSION['error'] = "" : "";
            }else{
                redirect("/");
            }
        }
        
        public function logout()
        {
            session_start();
            session_unset();
            session_destroy();
            redirect('/home/signin');
        }
    }