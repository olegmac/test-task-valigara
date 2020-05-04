<?php


namespace Api;


interface RequestInterface
{
    public function perform(RequestDataInterface $data): ResponseInterface;
}
