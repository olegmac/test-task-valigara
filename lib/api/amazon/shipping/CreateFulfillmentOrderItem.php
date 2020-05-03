<?php


namespace Api\Amazon\Shipping;

use Api\RequestInterface;
use Exceptions\ApiInvalidValueException;

class CreateFulfillmentOrderItem implements RequestInterface
{
    /** @var string */
    public $sellerSKU;

    /** @var string */
    public $sellerFulfillmentOrderItemId;

    /** @var int */
    public $quantity;

    /** @var string */
    public $giftMessage;

    /** @var string */
    public $displayableComment;

    /** @var string */
    public $fulfillmentNetworkSKU;

    /** @var string */
    public $perUnitDeclaredValue;

    /** @var string */
    public $perUnitPrice;

    /** @var string */
    public $perUnitTax;

    /**
     * Here I'd actually use external Validator class and provide more debug information and validate each field
     * separately
     */
    public function validate()
    {
        if (
            !$this->sellerSKU
            || !$this->sellerFulfillmentOrderItemId
            || !$this->quantity
            || $this->quantity < 1
            || mb_strlen($this->sellerSKU) > 50
            || mb_strlen($this->sellerFulfillmentOrderItemId) > 50
        ) {
            throw new ApiInvalidValueException('Invalid property value given');
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $item = clone $this;
        $item->validate();
        $result = [];
        foreach ($item as $key => $value) {
            $key = ucfirst($key);
            if ($value === null) {
                continue;
            }
            $result[$key] = $value;
        }
        unset($item);
        return $result;
    }
}
