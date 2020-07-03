<?php

class Szamlazom_Payment_List extends Szamlazom_List
{
}

/**
 * @property $id int
 * @property $title string
 * @property $days int
 * @property $code string
 */
class Szamlazom_Payment extends Szamlazom_Request
{

    /**
     * @return Szamlazom_Payment_List|null
     */
    public static function getAll($page = 1, $count = 50)
    {
        return Szamlazom_Request::_getAll($page, $count, Szamlazom_Const::PAYMENT_PATH);
    }

    /**
     * @return Szamlazom_Payment|null
     */
    public static function get($id)
    {
        return Szamlazom_Request::_get($id, Szamlazom_Const::PAYMENT_PATH);
    }

    protected function getNodeName()
    {
        return 'payment';
    }

    protected function getOptionalAttributes()
    {
        return array('id');
    }

    protected function getRequiredAttributes()
    {
        return array('title', 'days');
    }

}
