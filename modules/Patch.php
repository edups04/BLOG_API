<?php
class Patch{

    protected $pdo;

    public function __construct(\PDO $pdo){
        $this -> pdo = $pdo;
    }

    public function PatchShows($body, $id){
        $values = [];
        $errmsg = "";
        $code = 0;

        foreach($body as $value){
            array_push($values, $value);
        }

        array_push($values, $id);

        try{
            $sqlString = "UPDATE cards_tbl SET name=?,  tags=? WHERE id = ?";
            $sql = $this->pdo->prepare($sqlString);
            $sql->execute($values);

            $code = 200;
            $data = null;

            return array("data"=>$data, "code"=>$code); 
        }
        catch(\PDOException $e){
            $errmsg = $e->getMessage();
            $code = 400;
        }

        
        return array("errmsg"=>$errmsg, "code"=>$code); 
    }

    public function archiveShows($id){
        $errmsg = "";
        $code = 0;

        try{
            $sqlString = "UPDATE cards_tbl SET isdeleted=1 WHERE id = ?";
            $sql = $this->pdo->prepare($sqlString);
            $sql->execute([$id]);

            $code = 200;
            $data = null;

            return array("data"=>$data, "code"=>$code); 
        }
        catch(\PDOException $e){
            $errmsg = $e->getMessage();
            $code = 400;
        }

        
        return array("errmsg"=>$errmsg, "code"=>$code); 
    }
}

?>