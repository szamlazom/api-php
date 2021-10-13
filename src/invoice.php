<?php

class Szamlazom_Invoice_Item_List extends Szamlazom_List
{
}

/**
 * Számla sortétel adatok
 *
 * @property string $title                          Megnevezés
 * @property float $net                            Nettó ár
 * @property int $qty                            Mennyiség
 * @property string $qua                            Mennyiségi egység
 * @property int $vat_id                         Áfa azonosító
 * @property string $comment                        Megjegyzés
 * @property string $teaor                          VTSZ/SZJ vagy egyéb azonosító
 * @property string $neta_declaration               Neta tv-ben meghatározott adókötelezettség (Y|N)
 * @property string $intermediated_service          Közvetített szolgáltatás jelző (Y|N)
 * @property string $deposit_indicator              Bettdíj jelző (Y|N)
 * @property string $advance_indicator              Előleg jellegű (Y|N)
 * @property string $margin_scheme_indicator        Különbözet szerinti szabályozás jelző (TRAVEL_AGENCY|SECOND_HAND|ARTWORK|ANTIQUES)
 * @property string $ekaer_ids                      EKAER azonosítók listája vesszőval vagy szóközzel tagolva
 * @property string $neta                           *DEPRICATED* Neta tv-ben meghatározott adókötelezettség (Y|N)
 * @property string $kozvetitett_szolg              *DEPRICATED* Közvetített szolgáltatás jelző (Y|N)
 */
class Szamlazom_Invoice_Item extends Szamlazom_Request
{

    protected function getNodeName()
    {
        return 'item';
    }

    protected function getOptionalAttributes()
    {
        return array(
            'comment',
            'teaor',
            'neta_declaration',
            'intermediated_service',
            'deposit_indicator',
            'advance_indicator',
            'margin_scheme_indicator',
            'ekaer_ids',
            'neta',
            'kozvetitett_szolg'
        );
    }

    protected function getRequiredAttributes()
    {
        return array('title', 'net', 'qty', 'qua', 'vat_id');
    }

}

class Szamlazom_Invoice_List extends Szamlazom_List
{
}

/**
 * @property        int $partner_id                 Partner azonosítója a számlázóban
 * @property        int $payment_id                 Fizetési mód azonosítója a számlázóban
 * @property        int $currency_id                Pénznem azonosítója a számlázóban
 * @property        string $expire                     Teljesítési dátuma
 * @property        string $accounting_delivery                     Számviteli teljesítés dátuma
 * @property        string $due                        Fizetési határidő dátuma
 * @property        string $comment                    Megjegyzés
 * @property        string $nr_order                   Rendelésszám
 * @property        string $nr_other                   Egyéb azonosító
 * @property        int $number_id                  Sorszám azonosítója a számlázóban
 * @property        array $items                      Sortételek listája Szamlazom_Invoice_Item_List
 * @property        string $lang                       Nyelv (hu|en)
 * @property        string $cash_accounting_indicator  Pénzforgalmi jelző (Y|N)
 * @property-read   string $nr                         Számla sorszáma
 * @property-read   string $currency_code              Pénznem ISO kódja
 * @property-read   int $currency_round             Pénznem kerekítés tizedes száma
 * @property-read   float $currency_rate              Pénznem váltási értéke
 * @property-read   int $print                      Nyomtatások száma
 * @property-read   float $net                        Számla nettó értéke
 * @property-read   float $vat                        Számla áfa értéke
 * @property-read   float $gross                      Számla bruttó értéke
 * @property-read   int $user_id                    Rögzítő felhasználó azonosítója a számlázóban
 * @property-read   int $cancelled                  Számla azonosítója ami érvénytelenítette a számlát
 * @property-read   int $cancelling                 Számla azonosítója amit érvénytelenít
 * @property-read   string $partner_vat_status         Partner ÁFA státusza
 * @property-read   string $partner_name               Partner neve
 * @property-read   string $partner_tax_nr             Partner adószáma
 * @property-read   string $partner_tax_nr_eu          Partner közösségi adószáma
 * @property-read   string $partner_tax_nr_group       Partner csoportos adószáma
 * @property-read   string $partner_tax_nr_third       Partner harmadik országbeli adószáma
 * @property-read   string $partner_country            Partner címének országa
 * @property-read   string $partner_country_id         Partner címének ország azonosítója a számlázóban
 * @property-read   string $partner_country_code       Partner címének ország kódja
 * @property-read   string $partner_zip                Partner címének irányítószáma
 * @property-read   string $partner_city               Partner címének települése
 * @property-read   string $partner_address            Partner címének címe
 * @property-read   string $partner_post_name          Partner postázási neve
 * @property-read   string $partner_post_country       Partner postázási címének országa
 * @property-read   string $partner_post_country_id    Partner postázási címének ország azonosítója a számlázóban
 * @property-read   string $partner_post_country_code  Partner postázási címének ország kódja
 * @property-read   string $partner_post_zip           Partner postázási címének irányítószáma
 * @property-read   string $partner_post_city          Partner postázási címének települése
 * @property-read   string $partner_post_address       Partner postázási címének címe
 * @property-read   string $small_taxpayer             Kisadózó jelölés (Y/N)
 * @property-read   string $self_employed              Egyéni vállalkozó jelölés (Y/N)
 * @property-read   string $self_employed_nr           Egyéni vállalkozó azonosító
 * @property-read   string $individual_exemption       Alanyi adómentes jelölés (Y|N)
 * @property-read   int $type                       Számla típusa (1 normál számla, 2 díjbekérő, 3 önszámla)
 * @property-read   int $id                         Számla egyedi azonosítója a számlázóban
 * @property-read   string $payment_code               Fizetési mód típus kódja
 * @property        string $comment_header             Fejléc megjegyzés
 */
class Szamlazom_Invoice extends Szamlazom_Request
{

    /**
     * @return Szamlazom_Invoice_List|null
     */
    public static function getAll($page = 1, $count = 50)
    {
        return Szamlazom_Request::_getAll($page, $count, Szamlazom_Const::INVOICE_PATH);
    }

    /**
     * @return Szamlazom_Invoice|null
     */
    public static function get($id)
    {
        return Szamlazom_Request::_get($id, Szamlazom_Const::INVOICE_PATH);
    }

    public static function getPdf($id)
    {
        $url = Szamlazom_Const::uri(Szamlazom_Const::INVOICE_PATH) . '/' . $id;
        $client = new Szamlazom_Client();
        return $client->getPdf($url);
    }

    public static function sign($id)
    {
        $url = Szamlazom_Const::uri(Szamlazom_Const::INVOICE_PATH) . '/' . $id . '/sign';
        $client = new Szamlazom_Client();
        self::_XmlValidate($client->request('PUT', $url));
        return true;
    }

    public static function send($id)
    {
        $url = Szamlazom_Const::uri(Szamlazom_Const::INVOICE_PATH) . '/' . $id . '/send';
        $client = new Szamlazom_Client();
        self::_XmlValidate($client->request('PUT', $url));
        return true;
    }

    protected function getNodeName()
    {
        return 'invoice';
    }

    public function create()
    {
        $this->_save(Szamlazom_Const::INVOICE_PATH);
    }

    protected function getOptionalAttributes()
    {
        return array(
            'id',
            'comment',
            'nr_order',
            'nr_other',
            'number_id',
            'lang',
            'cash_accounting_indicator',
            'comment_header',
            'accounting_delivery'
        );
    }

    protected function getRequiredAttributes()
    {
        return array('partner_id', 'payment_id', 'expire', 'due', 'items');
    }

}
