<?php
	require_once dirname( __FILE__ ) . '/PHPMailer/PHPMailerAutoload.php';
	/*
    |--------------------------------------------------------------------------
    | Lấy cấu hình cài đặt theo khóa
    |--------------------------------------------------------------------------
    |
    | Trả về giá trị được cấu hình trong file configs/config.php
    | Trả về null nếu giá trị không tồn tại
    */
	function get_config($key,$default=null){
		$config = explode(".", $key);
		if(!isset($config[1])) return $default;
		global ${$config[0]};
		return isset(${$config[0]}[$config[1]])?${$config[0]}[$config[1]]:$default;
	}
	/*
    |--------------------------------------------------------------------------
    | Hiển thị giá trị cấu hình
    |--------------------------------------------------------------------------
    */
    function config($key,$default=null){
    	echo get_config($key,$default);
	}
	/*
    |--------------------------------------------------------------------------
    | Lấy liên kết website
    |--------------------------------------------------------------------------
    |
    | Trả về liên kết website được cấu hình trong file configs/config.php
    */
	function get_base_url(){
		return get_config("app.url");
	}
	/*
    |--------------------------------------------------------------------------
    | Hiển thị liên kết website
    |--------------------------------------------------------------------------
    */
    
	function base_url(){
		echo get_base_url();
	}
	/*
    |--------------------------------------------------------------------------
    | Lấy tiêu đề website
    |--------------------------------------------------------------------------    
    */
	function site_name(){
		config("app.name");
	}

	/*
    |--------------------------------------------------------------------------
    | keywords
    |--------------------------------------------------------------------------    
    */
	function keywords(){
		config("app.keywords");
	}
	/*
    |--------------------------------------------------------------------------
    | description
    |--------------------------------------------------------------------------    
    */
	function description(){
		config("app.description");
	}
	

	/*
    |--------------------------------------------------------------------------
    | Lấy liên kết file
    |--------------------------------------------------------------------------
    */
	function get_url($file=null){
		return get_base_url().$file;
	}

	/*
    |--------------------------------------------------------------------------
    | Hiển thị liên kết file
    |--------------------------------------------------------------------------
    */
	function the_url($file=null){
		echo get_url($file);
	}

	/*
    |--------------------------------------------------------------------------
    | Lấy thời gian cập nhật của file
    |--------------------------------------------------------------------------
    */
	function get_filemtime($file=null){
		if($file==null) return null;
		if(!file_exists($file)) return null;
		return filemtime($file);
	}

	/*
    |--------------------------------------------------------------------------
    | Hiển thị thời gian cập nhật file 
    |--------------------------------------------------------------------------
    */

	function the_filemtime($file=null){
		echo get_filemtime($file);
	}
	/*
    |--------------------------------------------------------------------------
    | Lấy thư mục file
    |--------------------------------------------------------------------------
    */
    function get_asset_dir_file($file){
    	return dirname( __FILE__ ) . "/../{$file}";
    }
	/*
    |--------------------------------------------------------------------------
    | Lấy liên kết file trong thư mục assets
    |--------------------------------------------------------------------------
    */
	function get_asset($file=null,$version=false){
		$assets = get_config("app.assets","assets/");
		if($file==null) return null;
		$file = "{$assets}{$file}";
		if(!file_exists(get_asset_dir_file($file))) return get_url($file);
		$file_url = get_url($file);
		if($version==true)
			$file_url .= "?".get_filemtime(get_asset_dir_file($file));
		return $file_url;
	}
	/*
    |--------------------------------------------------------------------------
    | Hiển thị liên kết file trong thư mục assets
    |--------------------------------------------------------------------------
    */
	function asset($file=null,$version=false){
		echo get_asset($file,$version);
	}
	/*
    |--------------------------------------------------------------------------
    | Chèn file trong thư mục include
    |--------------------------------------------------------------------------
    */
	function file_include($file=null){
		if($file==null) return null;
		include(dirname( __FILE__ ) . "/../include/{$file}");
	}
	/*
    |--------------------------------------------------------------------------
    | Chèn file meta
    |--------------------------------------------------------------------------
    */
	function get_meta($name=null){
		$template = $name==null?"meta.php":"meta-{$name}.php";
		file_include($template);
	}
	/*
    |--------------------------------------------------------------------------
    | Chèn file head
    |--------------------------------------------------------------------------
    */
	function get_head($name=null){
		$template = $name==null?"head.php":"head-{$name}.php";
		file_include($template);
	}
	/*
    |--------------------------------------------------------------------------
    | Chèn file analytics
    |--------------------------------------------------------------------------
    */
	function get_analytics($name=null){
		$template = $name==null?"analytics.php":"analytics-{$name}.php";
		file_include($template);
	}
	/*
    |--------------------------------------------------------------------------
    | Chèn file script
    |--------------------------------------------------------------------------
    */
	function get_script($name=null){
		$template = $name==null?"script.php":"script-{$name}.php";
		file_include($template);
	}
	/*
    |--------------------------------------------------------------------------
    | Chèn file menu
    |--------------------------------------------------------------------------
    */
	function get_menu($name=null){
		$template = $name==null?"menu.php":"menu-{$name}.php";
		file_include($template);
	}

	
	/*
    |--------------------------------------------------------------------------
    | Chèn file header
    |--------------------------------------------------------------------------
    */
	function get_header_os($name=null){
		$template = $name==null?"header.php":"header-{$name}.php";
		file_include($template);
	}

	/*
    |--------------------------------------------------------------------------
    | Chèn file footer
    |--------------------------------------------------------------------------
    */
	function get_footer_os($name=null){
		$template = $name==null?"footer.php":"footer-{$name}.php";
		file_include($template);
	}
	/*
    |--------------------------------------------------------------------------
    | Check điều kiện đang test pagespeed
    |--------------------------------------------------------------------------
    |
    | Áp dụng cho các đoạn mã làm chậm khi kiểm tra nhưng ko ảnh hưởng tới website
    | là liên kết js từ bên ngoài như facebook, google analytics
    */
	function not_pagespeed(){
		return (!isset($_SERVER['HTTP_USER_AGENT']) || stripos($_SERVER['HTTP_USER_AGENT'], 'Lighthouse') === false);
	}

	/*
    |--------------------------------------------------------------------------
    | Kiểm tra trang hiện tại là trang được chọn
    |--------------------------------------------------------------------------
    |
    */
    function is_pagename($page){
    	global $page_name;
		if($page===$page_name) return true;
		return false;
    }
    /*
    |--------------------------------------------------------------------------
    | Kiểm tra nếu đang là trang được chọn thì hiển thị nội dung tùy chỉnh
    |--------------------------------------------------------------------------
    |
    */
	function show_in_page($page=null,$show=null){
		if($page==null) return null;
		if(is_pagename($page)) echo $show;
	}
	/*
    |--------------------------------------------------------------------------
    | Active menu
    |--------------------------------------------------------------------------
    |
    */
	function active_menu($page=null,$class='active'){
		show_in_page($page,$class);
	}
	/*
    |--------------------------------------------------------------------------
    | Lấy thẻ bao logo
    |--------------------------------------------------------------------------
    | Đối với trang chủ, thường logo sẽ được bao thẻ H1, trang sub sẽ là thẻ DIV
    */
	function logo_tag($tag="div",$default="h1"){
		global $page_name;
		echo $page_name=="top"?$default:$tag;
	}
	/*
    |--------------------------------------------------------------------------
    | Kiểm tra trang đang nhận phương thức POST
    |--------------------------------------------------------------------------
    */
    function is_method($method="GET"){
    	return $_SERVER['REQUEST_METHOD'] === $method;
    }
    /*
    |--------------------------------------------------------------------------
    | Gửi email sử dụng phpmailer
    |--------------------------------------------------------------------------
    */
    function send_email_with_phpmailer($subject, $body, $mailto,$bcc=null){
    	if($mailto==null) return false;
		$mail = new PHPMailer();
		$mail->IsSMTP();

		if(get_config("mail.debug",false))
			$mail->SMTPDebug 	= 	get_config("mail.debug");

		$mail->SMTPAuth 	=	get_config("mail.smtp_auth",true);
		$mail->CharSet 		=	get_config("mail.char_set",'UTF-8');
		$mail->SMTPSecure 	=	get_config("mail.smtp_secure",'ssl');
		$mail->Host 		=	get_config("mail.host",'smtp.gmail.com');
		$mail->Port 		=	get_config("mail.port",465); 
		$mail->IsHTML(get_config("mail.is_html",true));
	    $mail->Username = get_config("mail.username");
	    $mail->Password = get_config("mail.password");
	    $mail->SetFrom(get_config("mail.username"), get_config("mail.name"));
		$mail->Subject = $subject;
		$mail->Body = $body;
		if(is_array($mailto)):
			foreach($mailto as $to) $mail->AddAddress($to);
		else:
			$mail->AddAddress($mailto);
		endif;
		if(is_array($bcc)){
			foreach($bcc as $_bcc)	$mail->addBCC($_bcc);
		}else{
			$mail->addBCC($bcc);	
		}
		return $mail->Send();
    }
    /*
    |--------------------------------------------------------------------------
    | Gửi email sử dụng hàm mặc định của php
    |--------------------------------------------------------------------------
    */
    function send_email_php($subject, $body, $mailto, $bcc=null){ 
    	$encode = "UTF-8";
		$name = mb_encode_mimeheader(get_config("mail.name"));
		$from = get_config("mail.from");
		$header="From: {$name}<{$from}>";
		$reply = get_config("mail.reply");
		if(is_array($reply) && isset($reply["email"])):
			if(isset($reply['name'])):
				$reply_to = mb_encode_mimeheader($reply["email"])."<{$reply["email"]}>";
			else:
				$reply_to = $reply["email"];
			endif;
			$header.="\nReply-To: {$reply_to}";
		endif;
		$header .= "\nContent-Type: text/plain;charset=iso-2022-jp\nX-Mailer: PHP/".phpversion();
		$body = mb_convert_encoding($body,"JIS",$encode);
		$subject = mb_convert_encoding($subject,"JIS",$encode);
		if(!@mb_send_mail($mailto,$subject,$body,$header)){
			return false;
		}
		return true;
	}

	/*
    |--------------------------------------------------------------------------
    | Hàm gửi mail
    |--------------------------------------------------------------------------
    */
    function oison_send_email($subject, $body, $mail_to,$multi=false,$bcc=null){    	
    	$phpmailer = get_config("mail.phpmailer",true);
    	$action = $phpmailer?"send_email_with_phpmailer":"send_email_php";

    	if(!is_array($mail_to))
    		$mail_to = explode(",",preg_replace('/\s+/', '', $mail_to));

    	if($bcc!=null && !is_array($bcc))
    		$bcc = explode(",",preg_replace('/\s+/', '', $bcc));

    	if($multi==false):
			foreach ($mail_to as $key => $to):
				if($key == 0):
					if(!$action($subject, $body, $to,$bcc)):
						return false;
					endif;
				else:
					$action($subject, $body, $to);
				endif;
			endforeach;
			return true;
		else:
			return $action($subject, $body, $mail_to,$bcc);
		endif;
	}
	/*
    |--------------------------------------------------------------------------
    | Chuyển hướng
    |--------------------------------------------------------------------------
    */
    function redirect($to,$method="GET"){
    	if($method!="POST"):
    		header("Location: {$to}");
    	else:
    	?>
    		<form id="redirect-form" action="<?php echo $to;?>" method="POST">
				<input type="hidden" name="token" value="<?php config("mail.token");?>">
			</form>
			<script type="text/javascript">
			    document.getElementById('redirect-form').submit();
			</script>
		<?php 
    	endif;
    }
    function email_template($file){
    	ob_start();
        include (dirname( __FILE__ ) . "/../config/email/{$file}");
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
    function compile($content,$field,$data){
    	return preg_replace("/{".$field."}/", $data, $content);
    }
    function post_field($key,$default=null){
    	return isset($_POST[$key])?$_POST[$key]:$default;
    }
    /*
    |--------------------------------------------------------------------------
    | Lấy IP client
    |--------------------------------------------------------------------------
    */
    function get_real_ip_address(){
	    if (!empty($_SERVER['HTTP_CLIENT_IP'])){//check ip from share internet
	    	$ip	=	$_SERVER['HTTP_CLIENT_IP'];
	    }elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){   //to check ip is pass from proxy
	      	$ip	=	$_SERVER['HTTP_X_FORWARDED_FOR'];
	    }else{
	      $ip 	=	$_SERVER['REMOTE_ADDR'];
	    }
	    return $ip;
	}
	/*
    |--------------------------------------------------------------------------
    | Lấy thông tin vị trí từ địa chỉ IP
    |--------------------------------------------------------------------------
    */
	function get_info_from_ip($ip = null, $purpose = "location", $deep_detect = true) {
	    $output = null;
	    if($ip==null) $ip = get_real_ip_address();
	    if (filter_var($ip, FILTER_VALIDATE_IP) === false) {
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