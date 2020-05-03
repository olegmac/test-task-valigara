<?php

namespace Data;

class Order
{

    protected $id;
    public $data;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function load()
    {
        $this->data = [];
    }

}
