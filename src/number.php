<?php

class Szamlazom_Number_List extends Szamlazom_List
{
}

/**
 * @property $id int
 * @property $title string
 * @property $prefix string
 * @property $suffix string
 * @property $decimals int
 * @property $currency_id int
 * @property $type int
 * @property $default int
 * @property $closed string
 */
class Szamlazom_Number extends Szamlazom_Request
{

    /**
     * @return Szamlazom_Number_List|null
     */
    public static function getAll($page = 1, $count = 50)
    {
        return Szamlazom_Request::_getAll($page, $count, Szamlazom_Const::NUMBER_PATH);
    }

    /**
     * @return Szamlazom_Number|null
     */
    public static function get($id)
    {
        return Szamlazom_Request::_get($id, Szamlazom_Const::NUMBER_PATH);
    }

    protected function getNodeName()
    {
        return 'number';
    }

    protected function getOptionalAttributes()
    {
        return array('id', 'type', 'default');
    }

    protected function getRequiredAttributes()
    {
        return array('title', 'prefix', 'suffix', 'decimals', 'currency_id');
    }

}
