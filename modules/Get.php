<?php
include_once "Common.php";
class Get extends Common{

    protected $pdo;

    public function __construct(\PDO $pdo){
        $this -> pdo = $pdo;
    }
  
    public function getShows($id = null){
        $condition = "isdeleted = 0";
        if($id != null){
            $condition .= " AND bump_id=" . $id;
        }

        $result = $this->getDataByTable('adult_swim_bumps', $condition, $this->pdo);
        if($result['code'] == 200){
            return $this->generateResponse($result['data'], "success", "Successfully retrieved records", $result['code']);
        }
        return $this->generateResponse(null, "failed", $result['errmsg'], $result['code']);

    }


    public function getChannel($id = null){
        $condition = "isdeleted = 0";
        if($id != null){
            $condition .= " AND id=" . $id;
        }

        $result = $this->getDataByTable('cards_tbl', $condition, $this->pdo);
        if($result['code'] == 200){
            return $this->generateResponse($result['data'], "success", "successfully retrieved records", $result['code']);
        }
        return $this->generateResponse(null, "failed", $result['errmsg'], $result['code']);

    }
}

?>