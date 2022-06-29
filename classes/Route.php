<?php
include_once 'classes/Dbh.php';
include_once 'classes/UserAuth.php';

class formController extends UserAuth{

    public $fullname;
    public $email;
    public $password;
    public $confirmPassword;
    public $country;
    public $gender;  

    public function __construct(){
        $this->db = new Db();
    }

    public function handleForm(){
        switch(true){
            case isset($_POST['register']):
                $this->fullname = $_POST['fullnames'];
                $this->email = $_POST['email'];
                $this->password = $_POST['password'];
                $this->confirmPassword = $_POST['confirmPassword'];
                $this->country = $_POST['country'];
                $this->gender = $_POST['gender'];

                $this->register(
                    $this->fullname, 
                    $this->email, 
                    $this->password, 
                    $this->confirmPassword, 
                    $this->country,
                    $this->gender 
                );
            break;
        
            case isset($_POST['login']):
                $this->email = $_POST['email'];
                $this->password = $_POST['password'];
                $this->login($this->email, $this->password);
            break;
                
            case isset($_POST["logout"]):
                $this->logout();
            break;

            case isset($_POST['delete']):
                $this->id = $_POST['id'];
                $this->deleteUser($this->id);
            break;

            case isset($_POST["reset"]):
                $this->email = $_POST['email'];
                $this->password = $_POST['password'];
                $this->updateUser($this->email, $this->password);
            break;
                    
            case isset($_POST["all"]):
                $this->getAllUsers();
            break;

            default: 
                echo 'No form was submitted';
            break;
        }
    }
}