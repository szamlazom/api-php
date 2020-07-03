<?php

class Szamlazom_Client
{
    public function request($method, $url, $data = '')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_USERPWD, Szamlazom_Const::$api_key);

        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        } elseif ($method == 'PUT') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        } elseif ($method != 'GET') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        }

        $response = curl_exec($ch);
        if ($response === false) {
            $errorNumber = curl_errno($ch);
            curl_close($ch);
            $this->raiseCurlError($errorNumber);
        }

        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $this->checkStatusCode($statusCode, $response);

        return $response;
    }

    public function checkStatusCode($statusCode, $response)
    {
        if ($statusCode >= 200 && $statusCode < 400) {
            return;
        }

        switch ($statusCode) {
            case 500:
            case 502:
            case 503:
            case 504:
            case 0:
                throw new Szamlazom_ClientError('Kapcsolódási hiba, kód: ' . $statusCode);
            case 401:
                throw new Szamlazom_ClientError('Hibás API kulcs.');
            case 402:
                throw new Szamlazom_ClientError('Az előfizetés lejárt.');
            case 404:
                throw new Szamlazom_ClientError('A kér adat nem található vagy nem hozzáférhető.');
            case 405:
                throw new Szamlazom_ClientError('Nem engedélyezett kérés.');
            case 412:
                throw new Szamlazom_ClientError('Feldolgozás sikertelen: ' . $this->parseErrorXml($response));
            case 422:
                throw new Szamlazom_ClientError('A kérés nem került feldolgozásra hibás vagy üres XML.');
            case 429:
                throw new Szamlazom_RateError(
                    'Túl sok kérés érkezett az utolsó órában. Minden további kérés mellőzve lesz a követekző óra kezdetéig.'
                );
            default:
                throw new Szamlazom_ClientError('Hibás kérés, kód: ' . $statusCode);
        }
    }

    private function parseErrorXml($xml_s)
    {
        $xml = simplexml_load_string($xml_s);
        if (!$xml) {
            return null;
        }

        if ($xml->getName() == 'error') {
            return $xml->description;
        }

        return null;
    }

    private function raiseCurlError($errorNumber)
    {
        switch ($errorNumber) {
            case CURLE_COULDNT_CONNECT:
            case CURLE_COULDNT_RESOLVE_HOST:
            case CURLE_OPERATION_TIMEOUTED:
                throw new Szamlazom_CurlError("Failed to connect to szamlazom.");
            case CURLE_SSL_CACERT:
            case CURLE_SSL_PEER_CERTIFICATE:
                throw new Szamlazom_CurlError("Could not verify szamlazom's SSL certificate.");
            default:
                throw new Szamlazom_CurlError("An unexpected error occurred connecting with szamlazom.");
        }
    }

    public function getPdf($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_USERPWD, Szamlazom_Const::$api_key);
        curl_setopt($ch, CURLOPT_HEADER, false); // do not return headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/pdf'));
        $response = curl_exec($ch);
        if ($response === false) {
            $errorNumber = curl_errno($ch);
            curl_close($ch);
            $this->raiseCurlError($errorNumber);
        }
        curl_close($ch);
        return $response;
    }
}
