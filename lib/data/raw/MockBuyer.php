<?php


namespace Data\Raw;


class MockBuyer extends Buyer {

    public function __construct() {
        parent::__construct(array(
            'country_id' => '236',
            'shop_username' => 'mamagarlick',
            'email' => 'mglifecenter@yahoo.com',
            'phone' => '570 484 1596',
            'address' => 'Maria Garlick
37 Baird Rd
Lock Haven
PA
17745 United States

',
            'data' => array(),
        ));
    }

    public function get_country_code() {
        return 'US';
    }

    public function get_country_code3() {
        return 'USA';
    }

}
