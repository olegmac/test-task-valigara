<?php


namespace Api;


interface ResponseInterface
{
    public function isError();

    public function getData();
}
