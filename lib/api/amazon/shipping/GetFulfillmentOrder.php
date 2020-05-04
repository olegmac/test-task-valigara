<?php


namespace Api\Amazon\Shipping;

use Api\RequestDataInterface;
use Exceptions\ApiInvalidValueException;

class GetFulfillmentOrder implements RequestDataInterface
{
    public $sellerFulfillmentOrderId;

    public function validate()
    {
        if ($this->sellerFulfillmentOrderId === null) {
            throw new ApiInvalidValueException('No package number provided');
        }
    }

    public function toArray(): array
    {
        return [
            'SellerFulfillmentOrderId' => $this->sellerFulfillmentOrderId,
        ];
    }
}
