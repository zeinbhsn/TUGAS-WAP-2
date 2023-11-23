<?php
    include('connection.php');

    class Inventory {

        function __construct()
        {
            $this->database = new ConnectionDatabase();
        }

        function getAll(){
            $query = "SELECT * FROM inventory";
            $data = mysqli_query($this->database->connection, $query);
            
            $res = [];
    
            while($item = mysqli_fetch_array($data)) {
                $res[] = $item;
            }

            $this->database->closeConnection();
    
            return $res;
        }

        function store($name, $stock, $expired_at){
            $query = "INSERT INTO `inventory` (`name`, `stock`, `expired_at`) VALUES (?,?,?)";

            $process = $this->database->connection->prepare($query);

            if($process) {
                $process->bind_param('sss', $name, $stock, $expired_at);
                $process->execute();
            } else {
                $error = $this->database->connection->errno . ' ' . $this->database->connection->error;
                echo $error;
            }
            
            $process->close();
            $this->database->closeConnection();            

            return true;
        }

    }
?>