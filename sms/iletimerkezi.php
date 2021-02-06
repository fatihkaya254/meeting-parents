<?php 
$path = preg_replace('/wp-content.*$/', '', __DIR__);

require_once($path."wp-load.php");

if (isset($_POST['iletimerkezi']) && $_POST['iletimerkezi'] == "1") {
	$numbernumber = $_POST['numara'];
	$texttext = $_POST['mesaj'];
function sendRequest($site_name,$send_xml,$header_type) {

        //die('SITENAME:'.$site_name.'SEND XML:'.$send_xml.'HEADER TYPE '.var_export($header_type,true));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$site_name);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$send_xml);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$header_type);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);

        $result = curl_exec($ch);

        return $result;
    }

    $username   = '5073857166';
    $password   = 'Up3QKbnUGxGp9TL';
    $orgin_name = 'ISLYNZHNLR';

    $xml = <<<EOS
            <request>
                <authentication>
                    <username>{$username}</username>
                    <password>{$password}</password>
                </authentication>
                
                <order>
                    <sender>{$orgin_name}</sender>
                    <sendDateTime>01/05/2013 18:00</sendDateTime>
                    <message>
                        <text>{$texttext}</text>
                        <receipents>
                            <number>{$numbernumber}</number>
                        </receipents>
                    </message>
                </order>
                </request>
    EOS;
    $result = sendRequest('http://api.iletimerkezi.com/v1/send-sms',$xml,array('Content-Type: text/xml')); 
    die('<pre>'.var_export($result,1).'</pre>');
}