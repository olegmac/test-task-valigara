<?php


namespace Api;


interface RequestInterface
{
    public function validate();

    public function toArray(): array;
}
