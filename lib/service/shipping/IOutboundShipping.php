<?php

namespace Service\Shipping;

use Data\Order;
use Data\Raw\Buyer;
use Exception;

interface IOutboundShipping
{
    /**
     * Need to realize logic that will sent command to Amazon FBA to ship order
     * and will return tracking number as string for this order.
     * if operation cannot be performed please throw Exception with error message
     * @param Order $oOrder
     * @param Buyer $oBuyer
     * @return string Tracking number must be returned
     * @throws Exception
     */
    public function ship(Order $oOrder, Buyer $oBuyer);
}
