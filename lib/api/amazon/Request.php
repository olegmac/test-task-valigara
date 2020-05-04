<?php


namespace Api\Amazon;

use Api\RequestDataInterface;
use Exceptions\ApiEndpointException;
use HttpException;
use function http_build_query;

class Request
{

    const ACCESS_KEY = '';
    const AUTH_TOKEN = '';
    const MERCHANT_ID = '';

    const CREATE_FULFILLMENT_ORDER_ACTION = 0;
    const GET_FULFILLMENT_ORDER_ACTION = 1;
    const GET_PACKAGE_TRACKING_DETAILS_ACTION = 2;


    const ACTION_PARAMS = [
        self::CREATE_FULFILLMENT_ORDER_ACTION => [
            'method' => 'POST',
            'service' => 'FulfillmentOutboundShipment',
            'action' => 'CreateFulfillmentOrder',
            'version' => '2010-10-01',
        ],
        self::GET_FULFILLMENT_ORDER_ACTION => [
            'method' => 'POST',
            'service' => 'FulfillmentOutboundShipment',
            'action' => 'CreateFulfillmentOrder',
            'version' => '2010-10-01',
        ],
        self::GET_PACKAGE_TRACKING_DETAILS_ACTION => [
            'method' => 'POST',
            'service' => 'FulfillmentOutboundShipment',
            'action' => 'CreateFulfillmentOrder',
            'version' => '2010-10-01',
        ],
    ];

    const ENDPOINTS_BY_CODE = [
        'US' => 'mws.amazonservices.com',
    ];

    private $endpoint;
    private $method;
    private $action;
    private $service;
    private $version;

    public function __construct(int $actionId, string $endpointCode)
    {
        if (!isset($this::ENDPOINTS_BY_CODE[$endpointCode])) {
            throw new ApiEndpointException("No endpoint with code {$endpointCode}");
        }
        $this->endpoint = $this::ENDPOINTS_BY_CODE[$endpointCode];
        $this->method = $this::ACTION_PARAMS[$actionId]['method'];
        $this->action = $this::ACTION_PARAMS[$actionId]['action'];
        $this->service = $this::ACTION_PARAMS[$actionId]['service'];
        $this->version = $this::ACTION_PARAMS[$actionId]['version'];
    }

    /**
     * @param RequestDataInterface $data
     * @return Response
     * @throws HttpException
     */
    public function perform(RequestDataInterface $data): Response
    {
        $data->validate();
        $query = $this->build_query_string($data->toArray());
        $client = new \Http\Request();
        $url = "https://{$this->endpoint}/{$this->service}";
        /** @noinspection DegradedSwitchInspection */
        switch ($this->method) {
            case 'POST':
                $result = $client->post($url, $query);
                break;
            default:
                $result = $client->get($url);
        }
        return new Response($result);
    }

    /**
     * @param array $data
     * @return string
     */
    private function build_query_string(array $data): string
    {
        $queryArray = [
            'AWSAccessKeyId' => self::ACCESS_KEY,
            'Action' => $this->action,
            'Parameters' => $data,
            'MWSAuthToken' => self::AUTH_TOKEN,
            'SellerId' => self::MERCHANT_ID,
            'SignatureMethod' => Signature::METHOD,
            'SignatureVersion' => Signature::VERSION,
            'Timestamp' => date('c'),
            'Version' => $this->version,
        ];
        asort($queryArray);
        $queryString = http_build_query($queryArray);
        $canonicalizedQueryRequest = "POST\n{$this->endpoint}\n/{$this->service}/{$this->version}\n$queryString";

        $queryArray['Signature'] = Signature::get($canonicalizedQueryRequest, self::ACCESS_KEY);
        asort($queryArray);
        return http_build_query($queryArray);
    }
}
