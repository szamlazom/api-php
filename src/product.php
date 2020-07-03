<?php

class Szamlazom_Product_List extends Szamlazom_List
{
}

/**
 * @property $id int
 * @property $vat_id string
 * @property $nr string
 * @property $title string
 * @property $price float
 * @property $comment string
 * @property $foreign_id string
 * @property $qty int
 * @property $qua string
 * @property $teaor string
 * @property $price_gross float
 * @property $ean string
 */
class Szamlazom_Product extends Szamlazom_Request
{

    /**
     * @return Szamlazom_Product_List|null
     */
    public static function getAll($page = 1, $count = 50)
    {
        return Szamlazom_Request::_getAll($page, $count, Szamlazom_Const::PRODUCT_PATH);
    }

    /**
     * @return Szamlazom_Product|null
     */
    public static function get($id)
    {
        return Szamlazom_Request::_get($id, Szamlazom_Const::PRODUCT_PATH);
    }

    protected function getNodeName()
    {
        return 'product';
    }

    protected function getOptionalAttributes()
    {
        return array('id', 'comment', 'foreign_id', 'qty', 'qua', 'teaor', 'price_gross', 'ean');
    }

    protected function getRequiredAttributes()
    {
        return array('vat_id', 'nr', 'title', 'price');
    }

}