<?php
include_once 'db.php';

class Encuesta extends DB{
    
    private $totalVotes;
    private $optionSelected;

    public function setOptionSelected($option){
        $this->optionSelected = $option;
    }

    public function getOptionSelected(){
        return $this->optionSelected;
    }

    public function vote(){
        $query = $this->connect()->prepare('UPDATE comidas SET votos = votos + 1 WHERE opcion = :opcion');
        $query->execute(['opcion' => $this->optionSelected]);
    }

    public function showResults(){
        return $this->connect()->query('SELECT * FROM comidas');
    }

    public function getTotalVotes(){
        $query = $this->connect()->query('SELECT SUM(votos) AS total_votos FROM comidas');
        $this->totalVotes = $query->fetch(PDO::FETCH_OBJ)->total_votos;
        return $this->totalVotes;
    }

    public function getPercentageVotes($votes){
        return round(($votes / $this->totalVotes) * 100, 0);
    }

}

?>