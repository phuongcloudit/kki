<form method="POST" action="./confirm.html">
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
                <input type="text" name="company_name" value="<?php get_field("company_name");?>" />
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
            <td class="<?php has_error("address");?>">
                <textarea class="shipping-add" name="address" placeholder=""><?php get_field("address");?></textarea>
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
                    <input id="document-3" type="radio" name="document" value="超速トレーバッグ・テイクアウトトレーバック両方"
                        <?php get_checked("document","超速トレーバッグ・テイクアウトトレーバック両方");?> />
                    <label for="document-3">超速トレーバッグ・テイクアウトトレーバック両方</label>
                </div>
                <?php get_error("document");?>
            </td>
        </tr>
        <tr>
            <th>ご要望</th>
            <td>
                <textarea class="request" name="content" placeholder=""><?php get_field("content");?></textarea>
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