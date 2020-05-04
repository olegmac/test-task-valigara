<?php

namespace Data\Raw;

use ArrayObject;

/**
 * @property int $country_id
 * @property string $name
 * @property string $shop_username
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property array $data
 * @property string $country_code
 * @property string $country_code3
 * @author antons
 */
class Buyer extends ArrayObject
{
    /**
     * Buyer constructor.
     * Properties are implicitly set with type casting.
     * @param array $array
     */
    public function __construct($array = [])
    {
        if (isset($array['country_id'])) {
            $this->country_id = (int)$array['country_id'];
        }

        if (isset($array['name'])) {
            $this->name = (string)$array['name'];
        }

        if (isset($array['shop_username'])) {
            $this->shop_username = (string)$array['shop_username'];
        }

        if (isset($array['email'])) {
            $this->email = (string)$array['email'];
        }

        if (isset($array['phone'])) {
            $this->phone = (string)$array['phone'];
        }

        if (isset($array['address'])) {
            $this->address = (string)$array['address'];
        }

        if (isset($array['data']) && is_array($array['data'])) {
            $this->data = $array['data'];
        }

        parent::__construct($array, self::ARRAY_AS_PROPS);
    }
}
