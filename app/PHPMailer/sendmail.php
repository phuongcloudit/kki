<?php 
date_default_timezone_set('Asia/Tokyo');
include('PHPMailerAutoload.php');

function getBody($order=false){
	//Chuyển hướng về trang chủ nếu không nhập email
	if(!isset($_POST['email'])) return false;

	extract($_POST);
	$body = "<p>お客様からお問い合わせを受信しました</p>";
	$body .="<p>--------------------------------------------------------------</p>";		
	$body .= "ショッピング枠残高: " . $balance . "<br>";
	$body .= "ご利用希望金額: " . $amount . "<br>";
	$body .= "お名前: " . $name . "<br>";
	$body .= "フリガナ: " . $phone . "<br>";
	$body .= "性別: " . $sex . "<br>";
	$body .= "メールアドレス: " .$email. "<br>";
	$body .= "ご連絡先: " . $contact ."<br>";
	$body .= "ご住所: " . $address ."<br>";
	$body .= "当社が金融・貸金業者でないことを理解していますか？: " . $loan . "<br>";
	$body .="<p>--------------------------------------------------------------</p>";
    if($order)
        $body .= "コード：orderid=" . date("dHis") ."<br>";
	$ip = getRealIpAddr();
	$ipinfo = ipInfo($ip);
	$body .= "送信したIPアドレス: " . $ip . "<br>";
	if($ipinfo) $body .= "送信した場所: " . $ipinfo['city'] . ", " . $ipinfo['country']."<br>";
	return $body;
}

function send_email($subject, $body, $to){
    $username =  "mailphp.0000@gmail.com";
    $password =  "v6u9k9U'>YaD:QSc";

	$mail = new PHPMailer(); // create a new object
	$mail->IsSMTP(); // enable SMTP
	//$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth = true; // authentication enabled
	$mail->CharSet = 'UTF-8';
	$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 465; // or 587
	$mail->IsHTML(true);
    $mail->Username = $username;
    $mail->Password = $password;
    $mail->SetFrom($username, 'Gift Cash');
	$mail->Subject = $subject;
	$mail->Body = $body;
	$mail->AddAddress($to);
	return $mail->Send();
}

function email_success(){
?>
	<form id="redirectThanks" action="./thanks/" method="POST">
		<input type="hidden" name="token" value="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9">
	</form>
	<script type="text/javascript">
	    document.getElementById('redirectThanks').submit();
	</script>
<?php 
}
function email_failer(){
?>
	<p>お問い合わせ内容を送信できませんでした。</p>
	<p>しばらくたってから、もう一度お試しください。</p>
<?php 
}
function getRealIpAddr(){
    if (!empty($_SERVER['HTTP_CLIENT_IP'])){//check ip from share internet
    	$ip	=	$_SERVER['HTTP_CLIENT_IP'];
    }elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){   //to check ip is pass from proxy
      	$ip	=	$_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
      $ip 	=	$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
function ipInfo($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
    $output = NULL;
    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }
    $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
    $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
    $continents = array(
        "AF" => "Africa",
        "AN" => "Antarctica",
        "AS" => "Asia",
        "EU" => "Europe",
        "OC" => "Australia (Oceania)",
        "NA" => "North America",
        "SA" => "South America"
    );
    if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
            switch ($purpose) {
                case "location":
                    $output = array(
                        "city"           => @$ipdat->geoplugin_city,
                        "state"          => @$ipdat->geoplugin_regionName,
                        "country"        => @$ipdat->geoplugin_countryName,
                        "country_code"   => @$ipdat->geoplugin_countryCode,
                        "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                        "continent_code" => @$ipdat->geoplugin_continentCode
                    );
                    break;
                case "address":
                    $address = array($ipdat->geoplugin_countryName);
                    if (@strlen($ipdat->geoplugin_regionName) >= 1)
                        $address[] = $ipdat->geoplugin_regionName;
                    if (@strlen($ipdat->geoplugin_city) >= 1)
                        $address[] = $ipdat->geoplugin_city;
                    $output = implode(", ", array_reverse($address));
                    break;
                case "city":
                    $output = @$ipdat->geoplugin_city;
                    break;
                case "state":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "region":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "country":
                    $output = @$ipdat->geoplugin_countryName;
                    break;
                case "countrycode":
                    $output = @$ipdat->geoplugin_countryCode;
                    break;
            }
        }
    }
    return $output;
}