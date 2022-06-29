<?php
// session_start();

class Db{
        //set your configs here
        protected $hostname = "127.0.0.1";
        protected $username = "root";
        protected $dbname = "zuriphp";
        protected $password = "";

        function connect(){
        $conn = new mysqli($this->hostname, 
                            $this->username, 
                            $this->password,
                            $this->dbname);
        if(!$conn){
            echo "<script> alert('Error connecting to the database') </script>";
        }
        return $conn;

        // print_r($conn);
        }

        
       
};
