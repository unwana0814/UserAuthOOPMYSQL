<?php
session_start();

include_once 'classes/Dbh.php';
include_once 'classes/Route.php';


class UserAuth extends Db{
    protected $db;

    public function __construct(){
        $this->db = new Db();
        // return self::$db;
    }

    public function register($fullname, $email, $password, $confirmPassword, $country, $gender){
        $conn = $this->db->connect();
        if($this->checkEmailExist($email)){ 
            echo "User Already Exist";
            header("refresh: 2; ./forms/register.php");
        } else {
            if($this->confirmPasswordMatch($password, $confirmPassword)){
                $sql = "INSERT INTO students (`full_names`, `country`, `email`, `gender`, `password`) VALUES ('$fullname','$country', '$email', '$gender', '$password')";
                if($conn->query($sql)){
                    echo "User Successfully Registered";
                    header("refresh: 2; ./forms/login.php");
                } 
            } else{
                echo "Password Does not Match";
                header("refresh: 2; ./forms/register.php");
            }
        }
    }

    public function login($email, $password){
        $conn = $this->db->connect();
        $sql = "SELECT * FROM students WHERE email='$email' AND `password`='$password'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            $_SESSION['email'] = $email;
            echo "Logged in Successful";
            header("refresh: 2; ./dashboard.php");
        } else {
            echo "Invalid Email or Password";
            header("refresh:2; ./forms/login.php");
        }
    }

    public function getAllUsers(){
        $conn = $this->db->connect();
        $sql = "SELECT * FROM students";
        $result = $conn->query($sql);
        echo"<html>
        <head>
        <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' integrity='sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T' crossorigin='anonymous'>
        </head>
        <body>
        <center><h1><u> ZURI PHP STUDENTS </u> </h1> 
        <table class='table table-bordered' border='0.5' style='width: 80%; background-color: smoke; border-style: none'; >
        <tr style='height: 40px'>
            <thead class='thead-dark'> <th>ID</th><th>Full Names</th> <th>Email</th> <th>Gender</th> <th>Country</th> <th>Action</th>
        </thead></tr>";
        if($result->num_rows > 0){
            while($data = mysqli_fetch_assoc($result)){
                //show data
                echo "<tr style='height: 20px'>".
                    "<td style='width: 50px; background: gray'>" . $data['id'] . "</td>
                    <td style='width: 150px'>" . $data['full_names'] .
                    "</td> <td style='width: 150px'>" . $data['email'] .
                    "</td> <td style='width: 150px'>" . $data['gender'] . 
                    "</td> <td style='width: 150px'>" . $data['country'] . 
                    "</td>
                    <td style='width: 150px'> 
                    <form action='action.php' method='post'>
                    <input type='hidden' name='id'" .
                     "value=" . $data['id'] . ">".
                    "<button class='btn btn-danger' type='submit', name='delete'> DELETE </button> </form> </td>".
                    "</tr>";
            }
            echo "</table></table></center></body></html>";
        }
    }

    public function deleteUser($id){
        $conn = $this->db->connect();
        $sql = "DELETE FROM students WHERE id = '$id'";
        if($conn->query($sql) === TRUE){
            echo "User successfully deleted";
            header("refresh:0.5; url=action.php?all");
        } else {
            echo "User not deleted";
            header("refresh:0.5; url=action.php?all");
        }
    }

    public function updateUser($email, $password){
        $conn = $this->db->connect();
        if($this->checkEmailExist($email)){
           $sql = "UPDATE students SET password = '$password' WHERE email = '$email'";
            if($conn->query($sql) === TRUE){
                echo "Password Successfully Changed";
                header("refresh: 2; ./forms/login.php");
            }
        }else{
            echo "Invalid Email";
            header("refresh: 2; ./forms/resetpassword.php");
        }
    }

    public function logout(){
        session_destroy();
        echo "Logout Successfully";
        header('refresh: 2; index.php');
    }

    public function confirmPasswordMatch($password, $confirmPassword){
        if($password === $confirmPassword){
            return true;
        } else {
            return false;
        }
    }

    public function checkEmailExist($email){
        $conn = $this->db->connect();
        $sql = "SELECT * FROM students WHERE email = '$email'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            return true;
        } else {
            return false;
        }
    }
}