<?php


interface Validator
{
    public function validate($data, &$msg): bool;
}