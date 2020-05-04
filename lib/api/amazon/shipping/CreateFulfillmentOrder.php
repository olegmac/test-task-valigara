<?php


namespace Api\Amazon\Shipping;

use Api\RequestDataInterface;
use Exceptions\ApiInvalidValueException;

class CreateFulfillmentOrder implements RequestDataInterface
{
    /** @var string */
    public $marketplaceId;

    /** @var string */
    public $sellerFulfillmentOrderId;

    /** @var string */
    public $fulfillmentAction;

    /** @var string */
    public $displayableOrderId;

    /**
     * DateTime object would be better
     * @var string
     */
    public $displayableOrderDateTime;

    /** @var string */
    public $displayableOrderComment;

    /** @var string */
    public $shippingSpeedCategory;

    /**
     * Address object is preferable
     * @var string
     */
    public $destinationAddress;

    /** @var string */
    public $fulfillmentPolicy;

    /** @var array */
    public $notificationEmailList = [];

    /** @var string */
    public $cODSettings;

    /** @var string */
    public $items = [];

    /** @var string */
    public $deliveryWindow;

    /**
     * Keys are set according to MWS doc
     * @param CreateFulfillmentOrderItem $item
     */
    public function add_item(CreateFulfillmentOrderItem $item)
    {
        $key = (string)(count($this->items) + 1);
        $this->items[$key] = $item;
    }

    /**
     * Here I'd actually use external Validator class and provide more debug information and validate each field
     * separately
     */
    public function validate()
    {

        if (
            !$this->sellerFulfillmentOrderId
            || !$this->displayableOrderId
            || !$this->displayableOrderDateTime
            || !$this->displayableOrderComment
            || !$this->shippingSpeedCategory
            || !$this->destinationAddress
            || !$this->items
            || mb_strlen($this->sellerFulfillmentOrderId) > 40
            || mb_strlen($this->displayableOrderId) > 40
            || mb_strlen($this->displayableOrderComment) > 1000
        ) {
            throw new ApiInvalidValueException('Invalid property value given');
        }

        foreach ($this->items as $item) {
            $item->validate();
        }
    }

    /**
     * Not best way, but time limits
     * @return array
     */
    public function toArray(): array
    {
        $order = clone $this;

        $result = [];
        foreach ($order as $orderKey => $orderValue) {
            if ($orderKey === 'items') {
                $items = [];
                foreach ($orderValue as $itemKey => $orderItem) {
                    /** @var  CreateFulfillmentOrderItem $orderItem */
                    $items[$itemKey] = $orderItem->toArray();
                }
                $orderValue = $items;
            }
            if ($orderValue === null || $orderValue === []) {
                continue;
            }
            $orderKey = ucfirst($orderKey);
            $result[$orderKey] = $orderValue;
        }
        unset($order);
        return $result;
    }
}
