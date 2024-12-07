<?php
class Get{

    protected $pdo;

    public function __construct(\PDO $pdo){
        $this -> pdo = $pdo;
    }
  
    public function getShows($id = null){
        $sqlString = "SELECT * FROM cards_tbl WHERE isdeleted=0";
        if($id != null){
            $sqlString .= " AND id=" . $id;
        }

        
        $data = array();
        $errmsg = "";
        $code = 0;

        try{
            if($result = $this->pdo->query($sqlString)->fetchAll()){
                foreach($result as $record){
                    array_push($data, $record);
                }
                $result = null;
                $code = 200;
                return array("code" => $code, "data" => $data);
            }
            else{
                $errmsg = "No data found";
                $code = 404;
            }
        }
        catch(\PDOException $e){
            $errmsg = $e -> getMessage();
            $code = 403;
        }

        return array("code" => $code, "errmsg" => $errmsg);
    }
}

?>