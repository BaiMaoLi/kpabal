<?php
try {
    $opts = array(
        'http' => array(
            'user_agent' => 'PHPSoapClient'
        )
    );
    $context = stream_context_create($opts);

    $wsdlUrl = 'http://www.kpabal.com/CI/jotform/UAT_AFGOpportunitySyncVersion4_R7028.wsdl';
    $soapClientOptions = array(
        'stream_context' => $context,
        'cache_wsdl' => WSDL_CACHE_NONE
    );

    $client = new SoapClient($wsdlUrl, $soapClientOptions);

    $checkVatParameters = array(
        'countryCode' => 'DK',
        'vatNumber' => '47458714'
    );

    $result = $client->checkVat($checkVatParameters);
    print_r($result);
}
catch(Exception $e) {
    echo $e->getMessage();
}
?>