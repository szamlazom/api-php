<?php

abstract class Szamlazom_Request
{
    protected $_values = array();
    /** @var Szamlazom_Client */
    protected $_client = null;

    abstract protected function getNodeName();

    abstract protected function getOptionalAttributes();

    abstract protected function getRequiredAttributes();

    public function __set($k, $v)
    {
        $this->_values[$k] = $v;
    }

    public function __get($k)
    {
        return isset($this->_values[$k]) ? $this->_values[$k] : null;
    }

    public function __isset($k)
    {
        return isset($this->_values[$k]);
    }

    public function __unset($k)
    {
        unset($this->_values[$k]);
    }

    protected static function _getAll($page, $count, $path)
    {
        $client = new Szamlazom_Client();

        $response = $client->request('GET', Szamlazom_Const::uri($path) . '?page=' . $page . '&count=' . $count);

        return self::_XmlToObject($response, true);
    }

    protected static function _get($id, $path)
    {
        $client = new Szamlazom_Client();

        $response = $client->request('GET', Szamlazom_Const::uri($path) . '/' . $id);
        return self::_XmlToObject($response);
    }

    protected function _save($path)
    {
        if (is_null($this->_client)) {
            $this->_client = new Szamlazom_Client();
        }

        $response = $this->_client->request('POST', Szamlazom_Const::uri($path), $this->xml());
        $this->_XmlMergeSelf($response);
    }

    protected function _update($path)
    {
        if (is_null($this->_client)) {
            $this->_client = new Szamlazom_Client();
        }

        if (!isset($this->id)) {
            throw new Szamlazom_Error('Az "id" mező nincs definiálva.');
        }

        $response = $this->_client->request('PUT', Szamlazom_Const::uri($path) . '/' . $this->id, $this->xml());
        $this->_XmlMergeSelf($response);
    }

    /**
     * @param SimpleXMLElement $xml
     * @return mixed
     * @throws Szamlazom_Error
     */
    protected function xml($xml = null)
    {
        if (!($xml instanceof SimpleXMLElement)) {
            $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><request />');
        }
        $x = $xml->addChild($this->getNodeName());

        foreach ($this->getRequiredAttributes() as $field) {
            if (!isset($this->{$field})) {
                throw new Szamlazom_Error('A(z) "' . $field . '" kötelező mező nincs definiálva.');
            }

            if (is_array($this->{$field})) {
                $xml = $x->addChild($field);
                /** @var $item Szamlazom_Request */
                foreach ($this->{$field} as $item) {
                    $item->xml($xml);
                }
            } else {
                if (is_null($this->{$field})) {
                    throw new Szamlazom_Error('A(z) "' . $field . '" kötelező mező üres.');
                }
                $x->addChild($field, htmlspecialchars($this->{$field}));
            }
        }

        foreach ($this->getOptionalAttributes() as $field) {
            if (isset($this->{$field})) {
                if (is_array($this->{$field})) {
                    $xml = $x->addChild($field);
                    /** @var $item Szamlazom_Request */
                    foreach ($this->{$field} as $item) {
                        $item->xml($xml);
                    }
                } else {
                    $x->addChild($field, htmlspecialchars($this->{$field}));
                }
            }
        }

        return $x->asXML();
    }

    protected static function _XmlValidate($xml_s)
    {
        libxml_use_internal_errors(true);

        if (trim($xml_s) == '') {
            throw new Szamlazom_ValidationError('Üres XML.');
        }

        $xml = simplexml_load_string($xml_s);
        if ($xml === false) {
            $error = array_shift(libxml_get_errors());
            throw new Szamlazom_ValidationError(
                sprintf(
                    '%s on %d line in %d level and %d column',
                    $error->message,
                    $error->line,
                    $error->level,
                    $error->column
                )
            );
        }

        return $xml;
    }

    protected function _XmlMergeSelf($xml_s)
    {
        $xml = self::_XmlValidate($xml_s);

        $node_name = $this->getNodeName();

        $node = $xml->{$node_name}[0];
        foreach ($node as $field => $value) {
            $this->{$field} = (string)$value;
        }
    }

    protected static function _XmlToObject($xml, $many = false, $prefix = '')
    {
        if (is_string($xml)) {
            $xml = self::_XmlValidate($xml);
        }

        $model = '_' . ucfirst($xml->children()->getName());
        $class = 'Szamlazom' . $prefix . $model;

        if (!class_exists($class)) {
            throw new Szamlazom_Error('A(z) "' . $class . '" osztály nincs definiálva.');
        }

        $count = 0;
        $page = 0;
        if ($xml->attributes()->count) {
            $count = (int)$xml->attributes()->count;
            $page = (int)$xml->attributes()->page;
        }

        $list = array();
        foreach ($xml as $nodes) {
            // skip empty nodes in lists when empty
            if (!$nodes->count()) {
                continue;
            }

            $obj = new $class;
            foreach ($nodes as $field => $value) {
                if ($value->count() > 0) {
                    $obj->{$field} = self::_XmlToObject($value, true, $prefix . $model);
                } else {
                    // XXX: type attribute check for type conversion
                    $obj->{$field} = (string)$value;
                }
            }

            $list[] = $obj;
        }

        if ($many === true) {
            $class .= '_List';
            return new $class($count, $page, $list);
        }

        return sizeof($list) ? $list[0] : null;
    }

}
