<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="cache-control" content="no-cache">
    <link rel="stylesheet" href="https://candy.linfinity.io/css/prism.css">
    <link rel="stylesheet" href="https://candy.linfinity.io/css/intlTelInput.css">
    <link rel="stylesheet" href="https://candy.linfinity.io/css/toastr.min.css">
    <link rel="stylesheet" href="https://candy.linfinity.io/css/demo.css?v=05051138">
    <script type="text/javascript" src="https://candy.linfinity.io/js/prism.js"></script>
    <script type="text/javascript" src="https://candy.linfinity.io/js/jquery.min.js"></script>
    <script type="text/javascript" src="https://candy.linfinity.io/js/intlTelInput.min.js"></script>
    <script type="text/javascript" src="https://candy.linfinity.io/js/toastr.min.js"></script>
    <title id="navigationTitle">Linfinity Candy</title>
    <style>
        .toast-success {
            background-color: #A6C73B;
        }
        .g-recaptcha {
            margin: 0 auto;
        }
        .progress {
            width: 300px;
            background: #ddd;
            text-align: center;
            margin: 0 auto;
        }
        .curRate {
            width: 100.00%;
            background: #f30;
        }
        .round-conner {
            height: 30px;
            line-height: 30px;
            color: #FFFFFF;
            border-radius: 15px;
        }
    </style>

</head>
<body>
<div class="language-container" style="text-align: right">
    <p style="height: 28px;line-height: 28px;display: inline-block;margin-right: 5px;">Language:</p>
    <select id="language" class="language">
        <option value="zh_CN" selected="true">中文</option>
        <option value="ko_KR">한국, 한국</option>
        <option value="Rus">Россия</option>
        <option value="en">English</option>
        <option value="ja_JP">Japan</option>
    </select>
    <img class="language-dropdown" id="language-dropdown" src="https://candy.linfinity.io/img/dropdown.png">
</div>
<div class="banner"><img src="https://candy.linfinity.io/img/logo.png"></div>
    <div id="end_1" class="title1">糖果已经可以提现了</div>
    
<div class="mobile-container" id="mobile-container">
    <input style="width: 100%;color: #000;" type="tel" id="mobile" class="mobile-input" placeholder="请输入手机号">
</div>
<div class="sms-code-container" id="sms-code-container">
    <input style="color: #000;" type="text" id="smsCode" class="sms-code-input" placeholder="请输入验证码">
</div>
<div class="sms-code-again-container" id="sms-code-again-container">
    <button class="sms-code-again-btn" id="sms-code-again-btn">重新发送</button>
</div>

<div class="g-recaptcha" data-sitekey="6LdDk1cUAAAAAPETiGd2h9OlWwW7zTFnZqVJ8zUg"></div>

<div class="btn-container">
    <button class="commit-btn" id="sms-code-btn">登陆</button>
    <button class="commit-btn" id="commit-btn">提 交</button>
    <p id="chinese"></p>
</div>
<div id="TCaptcha" style="display: none;"></div>
    <div id="countdown" style="margin-top: 30px;text-align: center;background: #F5F5F5;padding: 10px 0;color: red;"><span class="cd">提现结束倒计时</span> : <span class="countdown"></span></div>
    <div id="is_end" style="margin-top: 30px;text-align: center;background: #F5F5F5;padding: 10px 0;color: red;display: none;"></div>
</body>
</html>