<?php

require_once 'models/authmodel.php';
class Auth extends SessionController{

    function __construct(){
        parent::__construct();
    }

    function render(){
        $this->view->render('auth/index');
    }

    function authenticate(){
        if($this->existPOST(['email', 'password'])){
            $email = $this->getPOST('email');
            $password = $this->getPOST('password');

            # Verifica si hay campos vacios
            if($this->emptyVariables([$email, $password])){
                
                $this->redirect('auth',['error' => ErrorMessages::ERROR_USER_EMPTY]);
            
            # Verifica si el mail es valido
            }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->redirect('auth',['error' => ErrorMessages::ERROR_USER_EMAIL]);
            }
            
            $user = $this->model->login($email, $password);

            if($user != NULL){
                $this->initialize($user);
            }else{
                $this->redirect('auth',['error' => ErrorMessages::ERROR_USER_INCORRECT]);
            }

        }else {
            $this->redirect('auth',['error' => ErrorMessages::ERROR_USER_CREATED]);
        }

    }
}