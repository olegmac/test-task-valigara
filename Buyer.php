<?php

namespace Data\Raw;

/**
 * Description of \Data\Raw\Buyer
 * @property int $country_id 
 * @property string $name 
 * @property string $shop_username 
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property array $data
 * @author antons
 */
class Buyer extends \ArrayObject {

    public function __construct($array = array()) {
        parent::__construct($array, self::ARRAY_AS_PROPS);
    }

    public function get_country_code() {
        
    }

    public function get_country_code3() {
        
    }

}

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
