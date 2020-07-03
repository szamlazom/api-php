<?php

class Szamlazom_Partner_List extends Szamlazom_List
{
}

/**
 * @property $id int
 * @property $name string
 * @property $country string
 * @property $country_id int
 * @property $country_code string
 * @property $zip string
 * @property $city string
 * @property $address string
 * @property $payment_id int
 * @property $email string
 * @property $foreign_id string
 * @property $tax_nr string
 * @property $tax_nr_eu string
 * @property $tax_nr_group string
 * @property $post_name string
 * @property $post_country string
 * @property $post_country_id int
 * @property $post_country_code string
 * @property $post_zip string
 * @property $post_city string
 * @property $post_address string
 * @property $address_name string
 * @property $address_kind string
 * @property $address_building string
 * @property $address_nr string
 * @property $address_staircase string
 * @property $address_floor string
 * @property $address_door string
 * @property $bank_account string
 */
class Szamlazom_Partner extends Szamlazom_Request
{

    /**
     * @return Szamlazom_Partner_List|null
     */
    public static function getAll($page = 1, $count = 50)
    {
        return Szamlazom_Request::_getAll($page, $count, Szamlazom_Const::PARTNER_PATH);
    }

    /**
     * @return Szamlazom_Partner|null
     */
    public static function get($id)
    {
        return Szamlazom_Request::_get($id, Szamlazom_Const::PARTNER_PATH);
    }

    public function create()
    {
        $this->_save(Szamlazom_Const::PARTNER_PATH);
    }

    public function update()
    {
        $this->_update(Szamlazom_Const::PARTNER_PATH);
    }

    protected function getNodeName()
    {
        return 'partner';
    }

    protected function getOptionalAttributes()
    {
        return array(
            'id',
            'payment_id',
            'email',
            'foreign_id',
            'tax_nr',
            'tax_nr_eu',
            'tax_nr_group',
            'post_name',
            'country',
            'country_id',
            'post_zip',
            'post_city',
            'post_address',
            'post_country',
            'post_country_id',
            'address_name',
            'address_kind',
            'address_building',
            'address_nr',
            'address_staircase',
            'address_floor',
            'address_door',
            'bank_account'
        );
    }

    protected function getRequiredAttributes()
    {
        return array('name', 'zip', 'city', 'address');
    }

}
