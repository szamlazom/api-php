# szamlazom.hu PHP API interfész

Ez a csomag használható a szamlazom.hu API interfész kommunikációjához 

## Telepítés

Telepítés a Composer segítségével:

```
composer require szamlazom/api-php
```

A használathoz a composer autolader betöltését követően csak az API kulcsot kell megadni:

```php
<?php
  require 'vendor/autoload.php';

  Szamlazom_Const::$api_key = '123456789ABCDEFG';
```

### Példa egy számla elkészítésére

```php
    $items = array ();

    $item = new Szamlazom_Invoice_Item();
    $item->title = 'Teszt tétel 10 db és 100 Ft nettó egységárral';
    $item->net = 100;
    $item->qty = 10;
    $item->qua = 'db';
    $item->vat_id = 4; // előzőleg rögzített áfa típus
    $items[] = $item;

    $invoice = new Szamlazom_Invoice();
    $invoice->partner_id = 1; // előzőleg rögzített partner
    $invoice->payment_id = 2; // előzőleg rögzített fizetési mód
    $invoice->number_id = 3; // előzőleg rögzített számlatömb 
    $invoice->expire = strftime('%Y-%m-%d');
    $invoice->due = strftime('%Y-%m-%d', strtotime('+8 day'));
    $invoice->items = $items;
    $invoice->comment = 'Teszt számla léterhozása';
    $invoice->create();
```

### Inkrementális szinkronizálás `since_id` alapján

Csak az utoljára ismert azonosítónál újabb számlák jönnek vissza, növekvő sorrendben
(`GET /v1/invoices?since_id=1234&page=1&count=50`).

```php
    $last_id = 1234; // utoljára szinkronizált számla azonosító
    $page = 1;
    do {
        $list = Szamlazom_Invoice::getSince($last_id, $page, 100);
        foreach ($list->items as $invoice) {
            // feldolgozás...
        }
        $page++;
    } while ($page <= ceil($list->count / 100));
```
