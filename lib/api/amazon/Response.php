<?php


namespace Api\Amazon;

use Api\ResponseInterface;
use SimpleXMLElement;

class Response implements ResponseInterface
{
    private $data;

    /**
     * Response constructor.
     * @param string $data XML response string
     */
    public function __construct($data)
    {
        $this->data = new SimpleXMLElement($data);
    }

    /**
     * @return bool
     */
    public function isError(): bool
    {
        if (isset($this->data->Error)) {
            return true;
        }
        return false;
    }

    /**
     * I'd use ?string as return type
     * @return string
     */
    public function getErrorMessage(): string
    {
        if (isset($this->data->Error)) {
            return (string)$this->data->Error->Message;
        }
        return '';
    }

    public function getData(): SimpleXMLElement
    {
        return $this->data;
    }
}
