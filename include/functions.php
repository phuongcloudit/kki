<?php
	require_once dirname( __FILE__ ) . '/../app/init.php';
	function has_error($field){
		if($_SERVER['REQUEST_METHOD'] !=="POST") return false;
		if(!isset($_POST[$field]) || !$_POST[$field] || 
			($field=="email" && !filter_var(field($field), FILTER_VALIDATE_EMAIL)) ||
			($field=="email_confirm" && field($field) != field("email"))):
			echo "has-error";
		endif;

	}
	function form_error($field){
		if($_SERVER['REQUEST_METHOD'] !=="POST") return true;
		if(!isset($_POST[$field]) || !$_POST[$field] || 
			($field=="email" && !filter_var(field($field), FILTER_VALIDATE_EMAIL))):
			return true;
		endif;
		return false;
	}
	function get_error($field){
		if($_SERVER['REQUEST_METHOD'] !=="POST") return false;
		$error = false;
		if(!field($field)) $error = "必須項目です。入力してください。";
		if(!$error && $field=="code-a" &&  !field('code-b')) $error = "必須項目です。入力してください。";
		if(!$error && $field=="email" && !filter_var(field($field), FILTER_VALIDATE_EMAIL))
			$error = "メールアドレスはメールアドレスの形式が正しくありません。"; 
		if($error !== false):
			echo "<div class='error'>";
			echo $error;
			echo "</div>";
		endif;
	}

	function field($field){
		return isset($_POST[$field])?$_POST[$field]:null;
	}
	function get_field($field=null){
		if($field==null) return false;
		echo field($field);
	}
	function get_selected($field,$value){
		if(field($field)===$value){
			echo "selected";	
		}
	}
	
	function get_checked($field,$value, $default=null){
		if(field($field)===$value){
			echo "checked";	
		}
		if($_SERVER['REQUEST_METHOD'] !=="POST") echo $default;	
	}