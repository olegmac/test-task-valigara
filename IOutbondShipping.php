<?php

interface IOutbondShipping {

    /**
     * Need to realize logic that will sent command to Amazon FBA to ship order
     * and will return tracking number as string for this order.
     * if operation cannot be performed please throw Exception with error message
     * @param \Order $oOrder
     * @param \Buyer $oBuyer
     * @return string Tracking number must be returned
     * @throws Exception
     */
    public function ship(\Order $oOrder,\Data\Raw $oBuyer);
}
