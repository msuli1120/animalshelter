<?php
  class Type {
    private $type;
    private $id;

    function __construct ($type, $id = null) {
      $this->type = $type;
      $this->id = $id;
    }

    function setType ($new_type) {
      $this->type = (string) $new_type;
    }

    function getType () {
      return  $this->type;
    }

    function setId ($new_id) {
      $this->id = (int) $new_id;
    }

    function getId () {
      return $this->id;
    }

  }
?>
