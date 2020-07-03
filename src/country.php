<?php

class Szamlazom_Country_List extends Szamlazom_List
{
}

/**
 * @property $id int
 * @property $title string
 * @property $code string
 */
class Szamlazom_Country extends Szamlazom_Request
{

    /**
     * @return Szamlazom_Country_List|null
     */
    public static function getAll($page = 1, $count = 50)
    {
        return Szamlazom_Request::_getAll($page, $count, Szamlazom_Const::COUNTRY_PATH);
    }

    /**
     * @return Szamlazom_Country|null
     */
    public static function get($id)
    {
        return Szamlazom_Request::_get($id, Szamlazom_Const::COUNTRY_PATH);
    }

    protected function getNodeName()
    {
        return 'vat';
    }

    protected function getOptionalAttributes()
    {
        return array('id', 'title', 'code');
    }

    protected function getRequiredAttributes()
    {
        return array();
    }

}
