<?php
class Post{

    protected $pdo;

    public function __construct(\PDO $pdo){
        $this -> pdo = $pdo;
    }
    public function postShows($body){
        $values = [];
        $errmsg = "";
        $code = 0;

        foreach($body as $value){
            array_push($values, $value);
        }

        try{
            $sqlString = "INSERT INTO cards_tbl(name, tags, isdeleted) VALUES (?, ?, ?)";
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
}

?>