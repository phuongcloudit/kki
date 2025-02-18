<?php 
    require_once dirname( __FILE__ ) . '../../include/functions.php'; 
    $page_name = "request-form";
    $admin_email_1 = "taizo_shinoda@v-kki.co.jp";
    $admin_email_2 = "shin_takahara@v-kki.co.jp";
    $admin_email_3 = "tomonori_nishiguchi@v-kki.co.jp";
    $admin_email_4 = "masashi_ogura@v-kki.co.jp";
    $from_name = "KKI";
    $from_email = "no-reply@v-kki.co.jp";

$confirm = false;
if($_SERVER['REQUEST_METHOD']==="POST"):
        $fields = array(
            "name"		=>	"お名前",
            "furigana"	=>	"フリガナ",
            "company_name"	=>	"施設名・会社名・団体名",
            "position"	=>	"職種",
            "address"	=>	"ご住所",
            "phone"		=>	"電話番号",
            "email"		=>	"メールアドレス",
            "document"	=>	"資料の送付",
            "content"	=>	"内容",
        );
        $requireds = array("name","furigana","company_name","position","code-a","code-b","address","phone","email","document");
        $all_fields = array("name","furigana","company_name","position","code-a","code-b","address","phone","email","document","content");
        $confirm = true;
        foreach ($requireds as $key => $required):
            if(form_error($required)): $confirm = false; break; endif;
        endforeach;
        if($confirm==true && field("send_mail")==="send"):

            $subject = "【株式会社KKI】お客様よりお問い合わせがありました。";
            $body 	=	email_template("contact_admin.txt");
            foreach ($all_fields as $field) $body  =  compile($body,$field,post_field($field));

            $email = new PHPMailer();
            $email->CharSet 		=	'UTF-8';
            $email->SetFrom($from_email, post_field(name));
            $email->Subject   = $subject;
            $email->Body      = $body;
            $email->AddAddress( $admin_email_1);
            $email->AddAddress( $admin_email_2);
            $email->AddAddress( $admin_email_3);
            $email->AddAddress( $admin_email_4);

            if($email->send()):
                $subject = "【株式会社KKI】無料サンプル請求ありがとうございました。";
                $body 	=	email_template("contact_customer.txt");
                foreach ($all_fields as $field) $body  =  compile($body,$field,post_field($field));

                $email = new PHPMailer();
                $email->CharSet 		=	'UTF-8';
                $email->SetFrom($from_email, $from_name);
                $email->Subject   = $subject;
                $email->Body      = $body;
                $email->AddAddress(post_field("email"));
                $email->send();
                redirect("../thanks.html","POST");
                exit();
            else:
                exit("送信できませんでした。再度ご確認ください。");
            endif;
        endif;
endif;
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>サンプル請求フォーム  | 株式会社 KKI </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <meta name="description" content="包材に関することは株式会社KKIお任せください。" />
    <meta name="keywords" content="株式会社,KKI,包材" />
    <link rel="stylesheet" type="text/css" media="screen" href=".../../assets/css/style.css">
    <link rel="stylesheet" type="text/css" media="screen" href=".../../assets/css/fonts.css">
</head>

<body>
    <div class="wrapper">
        <header>
            <div class="container clearfix">
                <div id="logo">
                    <a href="http://www.v-kki.co.jp">
                        <img src="http://www.v-kki.co.jp/wp-content/themes/kki.com/img/logo.png" width="150" />
                    </a>
                </div>
                <div id="mainMenu">
                    <ul>
                        <li><a href="http://www.v-kki.co.jp/company/">会社概要</a></li>
                        <li><a href="http://www.v-kki.co.jp/factory/">工場設備</a></li>
                        <li><a href="http://www.v-kki.co.jp/product/">製品事例</a></li>
                        <li><a href="http://www.v-kki.co.jp/section/">部門紹介</a></li>
                        <li><a href="http://www.v-kki.co.jp/careers/">採用情報</a></li>
                        <li><a href="http://www.v-kki.co.jp/contact/">問い合わせ</a></li>
                    </ul>
                </div>
                <div id="menu">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>

            </div>
        </header>
        <section class="request-page-heading">
            <div class="container">
                <div class="page-heading-content">
                    <h1 class="title">無料サンプル請求</h1>
                </div>
            </div>
        </section>
        <section id="request-content">
            <div class="container">
                <div class="request-form">
                    <div class="form-notice">
                        <span class="red">※</span>の表示がある項目につきましては必ず入力くださいますよう、お願いいたします。
                    </div>
                    <div class="form-content">
                        <form method="POST" >
                            <table>
                                <tr>
                                    <th>ご担当者様名<span class="red">※</span></th>
                                    <td class="<?php has_error("name");?>">
                                        <input type="text" name="name" value="<?php get_field("name");?>" />
                                        <?php get_error("name");?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>フリガナ<span class="red">※</span></th>
                                    <td class="<?php has_error("furigana");?>">
                                        <input type="text" name="furigana" value="<?php get_field("furigana");?>" />
                                        <?php get_error("furigana");?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>会社名<span class="red">※</span></th>
                                    <td class="<?php has_error("company_name");?>">
                                        <input type="text" name="company_name"
                                            value="<?php get_field("company_name");?>" />
                                        <?php get_error("company_name");?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>部署名<span class="red">※</span></th>
                                    <td class="<?php has_error("position");?>">
                                        <input type="text" name="position" value="<?php get_field("position");?>" />
                                        <?php get_error("position");?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>お届け先住所<span class="red">※</span></th>
                                    <td class="<?php has_error("code-a");?>">
                                        <div class="postal_code">
                                            <span>〒</span>
                                            <input type="text" name="code-a" placeholder=""
                                                value="<?php get_field("code-a");?>">
                                            <span>-</span>
                                            <input type="text" name="code-b" placeholder=""
                                                value="<?php get_field("code-b");?>">
                                            <?php get_error("code-a");?>
                                        </div>
                                        <textarea class="shipping-add" name="address"
                                            placeholder=""><?php get_field("address");?></textarea>
                                        <?php get_error("address");?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>ご担当者様電話番号<span class="red">※</span></th>
                                    <td class="<?php has_error("phone");?>">
                                        <input type="text" name="phone" value="<?php get_field("phone");?>" />
                                        <?php get_error("phone");?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>ご担当者様メールアドレス<span class="red">※</span></th>
                                    <td class="<?php has_error("email");?>">
                                        <input type="email" name="email" value="<?php get_field("email");?>" />
                                        <?php get_error("email");?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>ご希望サンプル<span class="red">※</span></th>
                                    <td>
                                        <div class="radio-group">
                                            <input id="document-1" type="radio" name="document" value="超速トレーバッグ"
                                                <?php get_checked("document","超速トレーバッグ");?> />
                                            <label for="document-1">超速トレーバッグ</label>
                                            <input id="document-2" type="radio" name="document" value="テイクアウトトレーバック"
                                                <?php get_checked("document","テイクアウトトレーバック");?> />
                                            <label for="document-2">テイクアウトトレーバック</label><br>
                                            <input id="document-3" type="radio" name="document"
                                                value="超速トレーバッグ・テイクアウトトレーバック両方"
                                                <?php get_checked("document","超速トレーバッグ・テイクアウトトレーバック両方");?> />
                                            <label for="document-3">超速トレーバッグ・テイクアウトトレーバック両方</label>
                                        </div>
                                        <?php get_error("document");?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>ご要望</th>
                                    <td>
                                        <textarea class="request" name="content"
                                            placeholder=""><?php get_field("content");?></textarea>
                                    </td>
                                </tr>
                            </table>
                            <div class="request-note">
                                <div class="request-note-content">
                                    <p>個人情報の取扱いについて<br>
                                        当サイトより取得した個人情報は適切に管理いたします。個人情報保護法に定める例外事項を除き、本人の同意を得ることなく第三者に提供、開示しません。</p>
                                </div>
                            </div>
                            <div class="form-action">
                                <input type="hidden" name="send_mail" value="send" />
                                <button class="btn btn-primary" type="submit">
                                    送 信
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="inquiry-by-phone">
                    <h2 class="title">お電話でのお問い合わせ</h2>
                    <div class="inquiry-content clearfix">
                        <div class="inquiry-column left">
                            <img src=".../../assets/images/phone-large.png">
                            <div class="tel-fax">
                                <div><span>TEL </span><a href="tel:0568281105">0568-28-1105</a></div>
                                <div><span>FAX </span>0568-28-6462</div>
                            </div>
                        </div>
                        <div class="inquiry-column right">
                            【受付時間】平日8:30〜17:00<br> 土・日曜、祝日、夏季休暇や年末年始<br> などは休みをいただいております。
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <footer>
            <div class="container">
                <div id="footer">
                    <div class="copy_right">
                        © 2017 KKI
                    </div>
                    <div id="info_footer">
                        ■ 会社名　株式会社 KKI<br />
                        ■ 所在地　〒480-0202<br />
                        愛知県西春日井郡豊山町大字豊場字大山75<br />
                    </div>
                    <div id="logo_footer">
                        <img src="http://www.v-kki.co.jp/wp-content/themes/kki.com/img/logo-footer.png" width="150">
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src=".../../assets/js/jquery-3.4.1.min.js"></script>
    <script src=".../../assets/js/script.js"></script>
</body>

</html>