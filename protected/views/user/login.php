<div id="login" class="block_popup">
    <div class="content">
        <div class="title"><p>账户登录</p></div>
        
        <h1></h1>

        <?php if (isset($errors)) { ?>
        <div>
            <?php foreach ($errors as $v) echo '<li>'.$v; ?>
        </div>
        <?php } ?>
        <div class="form">
            <form action="" method="post">
                <input type="hidden" value="<?php echo Yii::app()->getRequest()->getCsrfToken(); ?>" name="YII_CSRF_TOKEN" /> 
                <div class="column">
                    <p class="label">帐户: &nbsp;</p>
                    <div class="field"><input type="text" name="User[username]" id="username" placeholder="输入手机号码" class="required"/></div>
                </div>

                <div class="clearboth" style="height:10px"></div>

                <div class="column">
                    <p class="label">密码: &nbsp;</p>
                    <div class="field"><input type="password" name="User[password]" id="password" /></div>
                </div>
                
                <div class="clearboth" style="height:10px"></div>

                <div class="column">
                    <p class="forgot_pass"><a href="http://cgb.anarry.com/web/forgotPassword">找回登录密码?</a></p>
                </div>
                <div class="clearboth" style="height:10px"></div>

                <div class="column">
                    <button class="enter" style="border:0;padding:0;"><span>登 录</span></button>
                </div>
                <div class="column">
                    <a href="http://cgb.anarry.com/web/reg" class="general_button w_icon registration"><span>免费注册</span></a>
                </div>
                
            </form>
        </div>
        
    </div>
</div>
