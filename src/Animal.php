<?php
  class Animal {
    private $id;
    private $name;
    private $gender;
    private $breed;
    private $type_id;
    private $date_enroll;

    function __construct($name, $gender, $breed, $type_id, $date_enroll=null, $id=null) {
      $this->name = $name;
      $this->gender = $gender;
      $this->breed = $breed;
      $this->type_id = $type_id;
      $this->date_enroll = $date_enroll;
      $this->id = $id;
    }

    function setId ($new_id) {
      $this->id = (int) $new_id;
    }
    function getId () {
      return $this->id;
    }
    function setGender ($new_gender) {
      $this->gender = (string) $new_gender;
    }
    function getGender () {
      return $this->gender;
    }
    function setBreed ($new_breed) {
      $this->breed = (string) $new_breed;
    }
    function getBreed () {
      return $this->breed;
    }
    function setTypeId ($new_type_id) {
      $this->type_id = (int) $new_type_id;
    }
    function getTypeId () {
      return $this->type_id;
    }
    function setDate ($new_date) {
      $this->date_enroll = (string) $new_date;
    }
    function getDate(){
      return $this->date_enroll;
    }
    function setName($new_name) {
      $this->name = (string) $new_name;
    }
    function getName () {
      return $this->name;
    }
    function save () {
      $executed = $GLOBALS['db']->exec("INSERT INTO animals (name, gender, breed, type_id, date_enroll) VALUES ('{$this->getName()}','{$this->getGender()}','{$this->getBreed()}',{$this->getTypeId()}, NOW());");
      if($executed){
        $this->id = $GLOBALS['db']->lastInsertId();
        return true;
      } else {
        return false;
      }
    }

    static function getAll () {
      $returned_animals = $GLOBALS['db']->query("SELECT * FROM animals ORDER BY date_enroll;");
      $results = $returned_animals->fetchAll(PDO::FETCH_OBJ);
      return $results;
    }

    static function getTypeAnimals ($value) {
      $returned_animals = $GLOBALS['db']->query("SELECT * FROM animals WHERE type_id = $value ORDER BY name;");
      $results = $returned_animals->fetchAll(PDO::FETCH_OBJ);
      return $results;
    }

    static function find($id) {
      $returned_animal = $GLOBALS['db']->prepare("SELECT * FROM animals WHERE id = :id;");
      $returned_animal->bindParam(':id', $id, PDO::PARAM_STR);
      $returned_animal->execute();
      $results = $returned_animal->fetchAll(PDO::FETCH_OBJ);
      return $results;
    }

    function update($new_name, $new_gender, $new_breed){
      $executed = $GLOBALS['db']->exec("UPDATE animals SET name = '{$new_name}', gender='{$new_gender}', breed='{$new_breed}' WHERE id = {$this->getId()};");
      if($executed){
        $this->setName($new_name);
        $this->setGender($new_gender);
        $this->setBreed($new_breed);
        return true;
      } else {
        return false;
      }
    }

  }
?>
