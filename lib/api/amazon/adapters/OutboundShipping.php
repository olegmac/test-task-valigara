<?php


namespace Api\Amazon\Adapters;

use Api\Amazon\Request;
use Api\Amazon\Shipping\CreateFulfillmentOrder;
use Api\Amazon\Shipping\CreateFulfillmentOrderItem;
use Api\Amazon\Shipping\GetFulfillmentOrder;
use Data\Order;
use Data\Raw\Buyer;
use DateTime;
use Exceptions\ApiBadResponseException;
use HttpException;
use Service\Shipping\IOutboundShipping;

class OutboundShipping implements IOutboundShipping
{
    const DEFAULT_SHIPMENT = 'Standard';

    /**
     * @param Order $oOrder
     * @param Buyer $oBuyer
     * @return string
     * @throws ApiBadResponseException
     * @throws HttpException
     * @throws
     */
    public function ship(Order $oOrder, Buyer $oBuyer)
    {
        $createFulfillmentOrderData = new CreateFulfillmentOrder();
        $createFulfillmentOrderData->marketplaceId = $oOrder->data['store_name'];
        $createFulfillmentOrderData->sellerFulfillmentOrderId = $oOrder->data['order_id'];
        $createFulfillmentOrderData->fulfillmentAction = Request::ACTION_PARAMS[Request::CREATE_FULFILLMENT_ORDER_ACTION]['action'];
        $createFulfillmentOrderData->displayableOrderId = $oOrder->data['order_unique'];
        $createFulfillmentOrderData->displayableOrderDateTime = DateTime::createFromFormat('Y-m-d', $oOrder->data['order_date'])->format(DateTime::ATOM);
        $createFulfillmentOrderData->displayableOrderComment = $oOrder->data['comments'];
        /** Maybe I was supposed to use shipping_type_id or shipping_name */
        $createFulfillmentOrderData->shippingSpeedCategory = self::DEFAULT_SHIPMENT;
        $createFulfillmentOrderData->destinationAddress = $oOrder->data['shipping_address'];
        $createFulfillmentOrderData->notificationEmailList['1'] = $oBuyer->email;

        foreach ($oOrder->data['products'] as $item) {
            $fulfillmentOrderItem = new CreateFulfillmentOrderItem();
            $fulfillmentOrderItem->sellerSKU = $item['sku'];
            $fulfillmentOrderItem->sellerFulfillmentOrderItemId = $item['product_id'];
            $fulfillmentOrderItem->quantity = $item['amount'];
            $fulfillmentOrderItem->displayableComment = $item['comment'];
            //Maybe wrong field used
            $fulfillmentOrderItem->perUnitDeclaredValue = $item['original_price'];
            $fulfillmentOrderItem->perUnitPrice = $item['buying_price'];
            $createFulfillmentOrderData->add_item($fulfillmentOrderItem);
        }
        $createFulfillmentOrderData->validate();
        $request = new Request(Request::CREATE_FULFILLMENT_ORDER_ACTION, $oBuyer->country_code);
        $result = $request->perform($createFulfillmentOrderData);
        if ($result->isError()) {
            throw new ApiBadResponseException($result->getErrorMessage());
        }

        $getFulfillmentOrderData = new GetFulfillmentOrder();
        $getFulfillmentOrderData->sellerFulfillmentOrderId = $createFulfillmentOrderData->sellerFulfillmentOrderId;
        $request = new Request(Request::GET_FULFILLMENT_ORDER_ACTION, $oBuyer->country_code);
        $result = $request->perform($getFulfillmentOrderData);
        if ($result->isError()) {
            throw new ApiBadResponseException($result->getErrorMessage());
        }
        $trackingNumbers = [];
        if (isset($result->getData()->GetFulfillmentOrderResult)) {
            foreach ($result->getData()->GetFulfillmentOrderResult->FulfillmentShipment->member as $shipment) {
                if (isset($shipment->FulfillmentShipmentPackage)) {
                    foreach ($shipment->FulfillmentShipmentPackage->member as $package) {
                        if (isset($package->TrackingNumber)) {
                            $trackingNumbers[] = (string)$package->TrackingNumber;
                        }
                    }
                }
            }
        }
        return implode(',', $trackingNumbers);
    }
}
