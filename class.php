<?php

class Student{
    private $name;

    public function __construct($name)
    {  
        $this->name =$name;
        $this->demo();
    }
    public function capNhatName($ten) {
        $this->name = $ten;
    }
    public function demo() {
        
    }
    public function layNameRaManHinh() {
        return $this->name;
    }
}

$sv1 = new Student("Tính");