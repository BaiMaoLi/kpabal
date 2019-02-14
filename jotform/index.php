<?php
$birthday=$_POST['dateof'][1].'/'.$_POST['dateof'][0].'/'.$_POST['dateof'][2];
$birthday="28/11/2008";
if($_POST['name'][1]=="Mr."){
    $gender ='M';
}else{
    $gender ='F';
}
if(  preg_match( '/^\+\d(\d{3})(\d{3})(\d{4})$/', $_POST['mobile133'],  $matches ) )
{
    $phone = $matches[1] . '-' .$matches[2] . '-' . $matches[3];
}

$xml='
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:cus="http://siebel.com/CustomUI" xmlns:opp="http://www.siebel.com/xml/Opportunity" xmlns:web="http://siebel.com/webservices">
   <soapenv:Header>
		<web:SessionType>none</web:SessionType>
		<web:PasswordText>nv40ps</web:PasswordText>
		<web:UsernameToken>TBROKER</web:UsernameToken>
   </soapenv:Header>
   <soapenv:Body>
      <cus:SyncOpportunity4_Input>
         <cus:SendConfirmationEmail>?</cus:SendConfirmationEmail>
         <cus:UpdateToken></cus:UpdateToken>
         <cus:SimpologyBypass>?</cus:SimpologyBypass>
         <opp:Opportunity>
            <opp:Comments>Jotform Opportunity</opp:Comments>
             <opp:Description>Jotform data set</opp:Description>
             <opp:IntegrationId>1</opp:IntegrationId>
             <opp:LoanWriterId>TBROKER</opp:LoanWriterId>
            <opp:Applicant>
               <opp:FirstName>'.$_POST['name'][1].'</opp:FirstName>
               <opp:IntegrationId>11</opp:IntegrationId>
               <opp:LastName>'.$_POST['name'][2].'</opp:LastName>
               <opp:MiddleName>'.$_POST['name'][3].'</opp:MiddleName>
               <opp:MaritalStatus>'.$_POST['maritalstatus'].'</opp:MaritalStatus>
               <opp:EmailAddress>'.$_POST['email'].'</opp:EmailAddress> 
               <opp:DateOfBirth>'.$birthday.'</opp:DateOfBirth>
               <opp:Title>'.str_replace(".","",$_POST['name'][0]).'</opp:Title>
               <opp:Gender>'.$gender.'</opp:Gender>
               <opp:CellularPhone>'.$phone.'</opp:CellularPhone>
              <opp:DirectAddressStreet>'.$_POST['address'][0].'</opp:DirectAddressStreet>
              <opp:DirectAddressCity>'.$_POST['address'][2].'</opp:DirectAddressCity>
              <opp:DirectAddressPostalCode>'.$_POST['address'][4].'</opp:DirectAddressPostalCode>
              <opp:DirectAddressState>'.$_POST['address'][3].'</opp:DirectAddressState>
              <opp:MaritalStatus>'.$_POST['maritalstatus'].'</opp:MaritalStatus>
            </opp:Applicant>
           ';
if(isset($_POST['name40'][1])) {
    if($_POST['name40'][1]!="" && $_POST['name40'][2] && $_POST['name40'][3]) {
        if(  preg_match( '/^\+\d(\d{3})(\d{3})(\d{4})$/', $_POST['mobile118'],  $matches ) )
        {
            $phone1 = $matches[1] . '-' .$matches[2] . '-' . $matches[3];
        }
        $dateof41=$_POST['dateof41'][1].'/'.$_POST['dateof41'][0].'/'.$_POST['dateof41'][2];
        $dateof41="28/11/2008";
        if($_POST['name40'][1]=="Mr."){
            $gender1 ='M';
        }else{
            $gender1 ='F';
        }
        $xml .= '
            <opp:Applicant>
               <opp:FirstName>' . $_POST['name40'][1] . '</opp:FirstName>
               <opp:IntegrationId>11</opp:IntegrationId>
               <opp:LastName>' . $_POST['name40'][2] . '</opp:LastName>
               <opp:MiddleName>' . $_POST['name40'][3] . '</opp:MiddleName>
               <opp:MaritalStatus>' . $_POST['maritalstatus42'] . '</opp:MaritalStatus>
               <opp:EmailAddress>' . $_POST['email43'] . '</opp:EmailAddress> 
               <opp:DateOfBirth>' . $dateof41 . '</opp:DateOfBirth>
               <opp:Title>' . str_replace(".", "", $_POST['name40'][0]) . '</opp:Title>
               <opp:Gender>' . $gender1 . '</opp:Gender>
               <opp:CellularPhone>' . $phone1 . '</opp:CellularPhone>
              <opp:DirectAddressStreet>'.$_POST['address113'][0].'</opp:DirectAddressStreet>
              <opp:DirectAddressCity>'.$_POST['address113'][2].'</opp:DirectAddressCity>
              <opp:DirectAddressPostalCode>'.$_POST['address113'][4].'</opp:DirectAddressPostalCode>
              <opp:DirectAddressState>'.$_POST['address113'][3].'</opp:DirectAddressState>
              <opp:MaritalStatus>'.$_POST['maritalstatus'].'</opp:MaritalStatus>
            </opp:Applicant>
            ';
    }
}
$xml.='
          </opp:Opportunity>
         <cus:CallingSystem>AFGIntegrationTesting</cus:CallingSystem>
         <cus:KeepLocking>?</cus:KeepLocking>
         <cus:Error_spcCode>?</cus:Error_spcCode>
         <cus:EmailAddrOverwrite>?</cus:EmailAddrOverwrite>
      </cus:SyncOpportunity4_Input>
   </soapenv:Body>
</soapenv:Envelope>
';
$url = "https://flexuat.afgonline.com.au/eai_enu/start.swe?SWEExtSource=WebService&SWEExtCmd=Execute&WSSOAP=1";
$headers = array(
    "Content-type: text/xml",
    "Content-length: " . strlen($xml),
    'SOAPAction: "document/http://siebel.com/CustomUI:SyncOpportunity4"',
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 0);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$data = curl_exec($ch);
curl_close($ch);
print_r($data);echo "<br>";
//print_r($xml);echo "<br>";
//print_r( $_POST );echo "<br>";


/*if(  preg_match( '/^\+\d(\d{3})(\d{3})(\d{4})$/', $_POST['mobile133'],  $matches ) )
{
    $result = $matches[1] . '-' .$matches[2] . '-' . $matches[3];
    $xml.=' <opp:CellularPhone>'.$result.'</opp:CellularPhone>';
}
*/
$zz='Array ( [submission_id] => 4190133441817082435 [formID] => 81753088962872 [ip] => 69.163.33.181 
[name] => Array ( [0] => Mr. [1] => zz [2] => xx [3] => cc ) [dateof] => Array ( [0] => 20 [1] => 11 [2] => 2018 ) [maritalstatus] => Defacto [email] => a@aaa.com [mobile133] => 2222222222222222 [address] => Array ( [0] => aa [1] => ss [2] => dd [3] => ff [4] => gg [5] => ) [startdate] => Array ( [0] => 12 [1] => 11 [2] => 2018 ) [currentresidential20] => Own (No Mortgage) [previousaddress116] => Array ( [0] => zz [1] => xx [2] => cc [3] => v [4] => b [5] => ) [dependents] => 2 [mothersmaiden] => nn [currentemployment] => Contractor [input24] => Part Time [occupation] => nn [employerbusinessname] => mm [typea135] => 33 [startdate30] => Array ( [0] => 05 [1] => 11 [2] => 2018 ) 
[name40] => Array ( [0] => Mr. [1] => q [2] => w [3] => e ) [dateof41] => Array ( [0] => 29 [1] => 10 [2] => 2018 ) [maritalstatus42] => Single [email43] => a@a.com [mobile118] => 11111111 [address113] => Array ( [0] => qq [1] => ww [2] => ee [3] => rr [4] => tt [5] => ) [startdate47] => Array ( [0] => 29 [1] => 10 [2] => 2018 ) [currentresidential48] => Mortgaged [previousaddress] => Array ( [0] => yy [1] => uu [2] => ii [3] => oo [4] => pp [5] => ) [dependents53] => 1 [mothersmaiden54] => aa [currentemployment59] => PAYG [input60] => Full Time [occupation61] => ss [employerbusinessname62] => dd [typea] => 12 [startdate66] => Array ( [0] => 12 [1] => 11 [2] => 2018 ) [input156] => {"widget_metadata":{"type":"links","value":[{"url":"https://www.jotform.com/uploads/MasonRoberts/form_files/Mason Roberts Credit Guide and Privacy November 2018.5bf23305b81305.31283363.pdf","name":"Mason Roberts Credit Guide and Privacy November 2018.pdf"}]}} )';

?>