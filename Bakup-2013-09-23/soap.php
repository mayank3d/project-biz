<?php
$request = '<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Header>
    <AuthenticationHeader xmlns="http://tempuri.org/">
      <password>PreT%@2012</password>
      <userId>pretalkz1</userId>
    </AuthenticationHeader>
  </soap:Header>
  <soap:Body>
    <GetCarrierList xmlns="http://tempuri.org/">
      <version>1.1</version>
    </GetCarrierList>
  </soap:Body>
</soap:Envelope>';
echo $_SERVER['DOCUMENT_ROOT'];
$wsdl = $_SERVER['DOCUMENT_ROOT'].'/ws.php?wsdl';
$sh_param = array(
                    'userId'    =>    'pretalkz1',
                    'password'    =>    'PreT%@2012'); 
					
$wsdl = 'http://www.fonpinsstaging.com/Services/servicemanager.asmx?wsdl';
//$wsdl = 'http://tempuri.org/PurchasePin';
$client = new SoapClient($wsdl);
//echo $soap->getPuzzle("1");
$client->GetQuote($sh_param);
print_r($client->GetQuoteResult);
print_r($client);


var_dump($client->__getLastRequest());
var_dump($client->__getLastResponse()); 


?>