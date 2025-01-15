<?php 
    class Config {
        // Connect to database
//in .env
        
         // Data source name
         
         protected $conn = null;
        public function __construct(){
            
            try {
                $this->conn = new PDO("mysql:host=".$this->HOST.";dbname=".$this->DBNAME, $this->USER, $this->PASSWORD);
                $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                
            } catch (PDOException $e) {
                die("[Cannot Connect] -> " .$e->getMessage());
            }
            return $this->conn;
        }
        //check data
        public function test_input($data){
            $data = strip_tags($data);
            $data = htmlspecialchars($data);
            $data = stripcslashes($data);
            $data = trim($data);
            return $data;
        }
        //convert JSON
        public function message ($content, $status){
            return json_encode(['message' => $content, 'error' => $status]);
        }
         
    }
?>