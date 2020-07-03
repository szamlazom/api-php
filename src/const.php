<?php

class Szamlazom_Error extends Exception
{
}

class Szamlazom_ValidationError extends Exception
{
}

class Szamlazom_ClientError extends Exception
{
}

class Szamlazom_RateError extends Exception
{
}

class Szamlazom_CurlError extends Exception
{
}

abstract class Szamlazom_List
{
    public $count;
    public $page;
    public $items;

    function __construct($count, $page, $items)
    {
        $this->count = $count;
        $this->page = $page;
        $this->items = $items;
    }

}

class Szamlazom_Const
{
    const VERSION = 'v1';
    const PARTNER_PATH = 'partners';
    const VAT_PATH = 'vats';
    const CURRENCY_PATH = 'currencies';
    const NUMBER_PATH = 'numbers';
    const PAYMENT_PATH = 'payments';
    const PRODUCT_PATH = 'products';
    const INVOICE_PATH = 'invoices';
    const COUNTRY_PATH = 'countries';

    static $api_key = '';
    static $api_url = 'https://api.szamlazom.hu';

    public static function uri($path)
    {
        return self::$api_url . '/' . Szamlazom_Const::VERSION . '/' . $path;
    }

}

