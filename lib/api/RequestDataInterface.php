<?php


namespace Api;


interface RequestDataInterface
{
    public function validate();

    public function toArray(): array;
}
