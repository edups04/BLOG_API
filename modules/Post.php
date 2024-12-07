<?php

include_once "Common.php";
class Post extends Common{

    protected $pdo;

    public function __construct(\PDO $pdo){
        $this -> pdo = $pdo;
    }
    public function postChannel($body){
        $result = $this->postData("cards_tbl", $body, $this->pdo);
        if($result['code'] == 200){
            return $this->generateResponse($result['data'], "success", "Successfully created new records.", $result['code']);
        }
        return $this->generateResponse(null, "failed", $result['errmsg'], $result['code']);

    }

    public function postShows($body){
        $result = $this->postData("adult_swim_bumps", $body, $this->pdo);
        if($result['code'] == 200){
            return $this->generateResponse($result['data'], "success", "Successfully created new records.", $result['code']);
        }
        return $this->generateResponse(null, "failed", $result['errmsg'], $result['code']);
    }
}

?>