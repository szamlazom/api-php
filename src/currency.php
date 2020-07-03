<?php

class Szamlazom_Currency_List extends Szamlazom_List
{
}

/**
 * @property $id int
 * @property $title string
 * @property $code string
 * @property $code_iso string
 * @property $rate float
 * @property $round int
 */
class Szamlazom_Currency extends Szamlazom_Request
{

    /**
     * @return Szamlazom_Currency_List|null
     */
    public static function getAll($page = 1, $count = 50)
    {
        return Szamlazom_Request::_getAll($page, $count, Szamlazom_Const::CURRENCY_PATH);
    }

    /**
     * @return Szamlazom_Currency|null
     */
    public static function get($id)
    {
        return Szamlazom_Request::_get($id, Szamlazom_Const::CURRENCY_PATH);
    }

    protected function getNodeName()
    {
        return 'currency';
    }

    protected function getOptionalAttributes()
    {
        return array('id', 'rate', 'round');
    }

    protected function getRequiredAttributes()
    {
        return array('title', 'code', 'code_iso');
    }

}
