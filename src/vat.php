<?php

class Szamlazom_Vat_List extends Szamlazom_List
{
}

/**
 * @property $id int
 * @property $title string
 * @property $code string
 * @property $comment string
 */
class Szamlazom_Vat extends Szamlazom_Request
{

    /**
     * @return Szamlazom_Vat_List|null
     */
    public static function getAll($page = 1, $count = 50)
    {
        return Szamlazom_Request::_getAll($page, $count, Szamlazom_Const::VAT_PATH);
    }

    /**
     * @return Szamlazom_Vat|null
     */
    public static function get($id)
    {
        return Szamlazom_Request::_get($id, Szamlazom_Const::VAT_PATH);
    }

    protected function getNodeName()
    {
        return 'vat';
    }

    protected function getOptionalAttributes()
    {
        return array('id', 'comment');
    }

    protected function getRequiredAttributes()
    {
        return array('title', 'code');
    }

}
