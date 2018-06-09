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
    <script>
        var _hmt = _hmt || [];
        (function() {
            var hm = document.createElement("script");
            hm.src = "https://hm.baidu.com/hm.js?2956dec3b6166621e58c99352751e255";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    </script>
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
<script>
    window.onload = function(){
        showtime();
        function addZero(i){
            if(i<10){
                i = "0" + i;
            }return i;
        }
        function showtime() {
            var nowtime = new Date();
            var endtime = new Date("2018/06/18,00:00:00");
            var lefttime = parseInt((endtime.getTime() - nowtime.getTime()) / 1000);
            var d = parseInt(lefttime / (24 * 60 * 60));
            var h = parseInt(lefttime / (60 * 60) % 24);
            var m = parseInt(lefttime / 60 % 60);
            var s = parseInt(lefttime % 60);
            h = addZero(h);
            m = addZero(m);
            s = addZero(s);
            $('#countdown .countdown').html(d + ":" + h + ":" + m + ":" + s);
            if(lefttime<=0){
                $('#is_end').show();
                $('#contdown').hide();
                return;
            }
            setTimeout(showtime,1000);
        }
    }
</script>
<script type="text/javascript">
    $(function(){
        var baseUrl = "https://candy.linfinity.io";
        // var baseUrl = "http://candy-dev.com"; // dev

        // 初始化时，将提交、短信验证码、再次发送验证码隐藏
        $("#commit-btn").hide();
        $("#sms-code-container").hide();
        $("#sms-code-again-container").hide();

        var localeStr = getCookie('localeStr');
        var loginToken = getCookie('loginToken');
        var smsCodeFlag = 0; // 是否已经发送过短信
        // if(localeStr && loginToken) {
        //     window.location.href = "detail.html";
        //     return;
        // }

        var languageOffset = $("#language").offset();
        var _top = languageOffset.top;
        var _left = languageOffset.left;
        $("#language-dropdown").css({
            left: _left + 80,
            top: _top + 13
        });

        //检测浏览器语言
        var browserLanguage = (navigator.language || navigator.browserLanguage).toLowerCase();
        localeStr = 'en';
        if(browserLanguage.indexOf("ko") > -1) {
            localeStr = 'ko_KR';
        }
        if(browserLanguage.indexOf("ja") > -1) {
            localeStr = 'ja_JP';
        }
        if(browserLanguage.indexOf("zh") > -1) {
            localeStr = 'zh_CN';
        }
        if(browserLanguage.indexOf("ru") > -1) {
            localeStr = 'Rus';
        }

        $("#mobile").intlTelInput({
            preferredCountries: ['cn', 'kr', 'us', 'tw', 'ru', 'jp'],
            utilsScript: "js/utils.js"
        });

        var loginForm = {
            localeStr: localeStr
        };

        var arr = window.location.href.split('#');
        var sign = 0;
        if(arr && arr.length > 1) {
            sign = arr[1].substr(1);
        }

        var refreshContent = function(language) {
            if (languageJson && !$.isEmptyObject(languageJson)) {
                loginForm.localeStr = language;
                $("#title1").empty().html(languageJson[language].login.title1);
                $("#title3").empty().html(languageJson[language].login.title3);
                $("#desc1").empty().html(languageJson[language].login.candyDescription1);
                $("#desc2").empty().html(languageJson[language].login.candyDescription2);
                $("#desc3").empty().html(languageJson[language].login.candyDescription3);
                $("#mobile").prop("placeholder", languageJson[language].login.mobilePlaceholder);
                $("#smsCode").prop("placeholder", languageJson[language].login.smsCodePlaceholder);
                $("#sms-code-btn").empty().html(languageJson[language].login.login);
                $("#commit-btn").empty().html(languageJson[language].login.commitBtn);
                $("#sms-code-again-btn").empty().html(languageJson[language].login.validationCodeAgainBtn);
                $(".candy-process").empty().html(languageJson[language].login.candyProcess);
                $("#end_1").empty().html(languageJson[language].login.end_1);
                $("#end_2").empty().html(languageJson[language].login.end_2);
                $(".cd").empty().html(languageJson[language].login.countdown);
                // 是否显示is_end
                if ($('#is_end').length > 0) {
                    $('#is_end').text(languageJson[loginForm.localeStr].login.candyActivityEnd)
                }
            }
        };

        var languageJson = {};
        $.getJSON('/i18n/language.json?v=1', function(json) {
            languageJson = json;
            if (localeStr !== "zh_CN") {
                refreshContent(localeStr);
                refreshIntlTelInput(localeStr);
                $("#language").val(localeStr);
            }

            // 是否显示is_end
            if ($('#is_end').length > 0) {
                $('#is_end').text(languageJson[loginForm.localeStr].login.candyActivityEnd)
            }
        });

        var refreshIntlTelInput = function(language) {
            if (smsCodeFlag) { // 如果已经发送过短信了，切换语言的时候，不修改国家码
                return;
            }
            if (language && language === "zh_CN") {
                $("#mobile").intlTelInput("setCountry", "cn");
                return;
            }
            if (language && language === "ko_KR") {
                $("#mobile").intlTelInput("setCountry", "kr");
                return;
            }
            if (language && language === "en") {
                $("#mobile").intlTelInput("setCountry", "us");
                return;
            }
            if (language && language === "ja_JP") {
                $("#mobile").intlTelInput("setCountry", "jp");
                return;
            }
            if (language && language === "Rus") {
                $("#mobile").intlTelInput("setCountry", "ru");
                return;
            }
        };

        $("#language").on("change", function(){
            var _language = $("#language").val();
            refreshContent(_language);
            refreshIntlTelInput(_language);
        });

        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-center",
            "preventDuplicates": true,
            "timeOut": "2500"
        };
        var toastFunc = function (options){
            toastr.warning(options.text);
        };

        $("#sms-code-btn").on("click", function(){
            $("#sms-code-btn").prop('disabled', true);
            $("#sms-code-btn").addClass("btn-disabled");
            var intlNumber = $("#mobile").intlTelInput("getNumber");
            var intlNumberType = $("#mobile").intlTelInput("getNumberType");
            var intlSelectedCountryData = $("#mobile").intlTelInput("getSelectedCountryData");
            if (!intlSelectedCountryData || $.isEmptyObject(intlSelectedCountryData)) {
                toastFunc({text: languageJson[loginForm.localeStr].login.countryCodeEmpty});
                $("#sms-code-btn").prop('disabled', false).removeClass("btn-disabled");
                return;
            }
            if (!intlNumber || !intlNumber === '') {
                toastFunc({text: languageJson[loginForm.localeStr].login.mobileEmpty});
                $("#sms-code-btn").prop('disabled', false).removeClass("btn-disabled");
                return;
            }
            var isValid = $("#mobile").intlTelInput("isValidNumber");
            if (!isValid) {
                toastFunc({text: languageJson[loginForm.localeStr].login.mobileInvalid});
                $("#sms-code-btn").prop('disabled', false).removeClass("btn-disabled");
                return;
            }
            loginForm.mobile = intlNumber;
            loginForm.countryCode = intlSelectedCountryData.dialCode;
            if(!loginForm.ticket && window.capInit) {
                $("#TCaptcha").show();
                checkIfCapInitLoaded();
                return;
            }
            if (!loginForm.ticket) {
                $.getJSON(baseUrl + "/webapi/jsUrls", function(response){
                    if (!response.errcode) {
                        // 将第三方验证码涉及的jsappend到body
                        appendJsToBody(response.data.jsUrl)
                    } else {
                        toastFunc({text: response.errmsg})
                    }
                });
            }
        });

        $("#sms-code-again-btn").on("click", function() {
            $("#sms-code-again-btn").prop('disabled', true);
            $("#sms-code-again-btn").addClass("btn-disabled");
            var intlNumber = $("#mobile").intlTelInput("getNumber");
            var intlNumberType = $("#mobile").intlTelInput("getNumberType");
            var intlSelectedCountryData = $("#mobile").intlTelInput("getSelectedCountryData");
            if (!intlSelectedCountryData || $.isEmptyObject(intlSelectedCountryData)) {
                toastFunc({text: languageJson[loginForm.localeStr].login.countryCodeEmpty});
                $("#sms-code-again-btn").prop('disabled', false).removeClass("btn-disabled");
                return;
            }
            if (!intlNumber || !intlNumber === '') {
                toastFunc({text: languageJson[loginForm.localeStr].login.mobileEmpty});
                $("#sms-code-again-btn").prop('disabled', false).removeClass("btn-disabled");
                return;
            }
            var isValid = $("#mobile").intlTelInput("isValidNumber");
            if (!isValid) {
                toastFunc({text: languageJson[loginForm.localeStr].login.mobileInvalid});
                $("#sms-code-again-btn").prop('disabled', false).removeClass("btn-disabled");
                return;
            }
            loginForm.mobile = intlNumber;
            loginForm.countryCode = intlSelectedCountryData.dialCode;
            if(!loginForm.ticket && window.capInit) {
                $("#TCaptcha").show();
                checkIfCapInitLoaded();
                return;
            }
            if (!loginForm.ticket) {
                $.getJSON(baseUrl + "/webapi/jsUrls", function(response){
                    if (!response.errcode) {
                        // 将第三方验证码涉及的jsappend到body
                        appendJsToBody(response.data.jsUrl)
                    } else {
                        toastFunc({text: response.errmsg})
                    }
                });
            }
        });

        var appendJsToBody = function(jsUrl) {
            var scriptObj = document.createElement('script');
            scriptObj.setAttribute('src', jsUrl);
            scriptObj.setAttribute('type', 'text/javascript');
            document.body.appendChild(scriptObj);
            checkIfCapInitLoaded();
        };
        var checkIfCapInitLoaded = function() {
            if (!window.capInit) {
                window.setTimeout(function () {
                    checkIfCapInitLoaded();
                }, 100);
                return;
            }
            window.capInit(document.getElementById("TCaptcha"), {
                callback: capchaCallback,
                showHeader: true,
                type: 'popup',
                lang: getLangOfCapcha(loginForm.localeStr)
            });
        };
        var getLangOfCapcha = function(language) {
            return language === 'zh_CN' ? 2052 : 1033;
        };
        var capchaCallback = function(retJson) {
            if (retJson && retJson.ticket) { // 第三方验证通过
                console.log(retJson.ticket);
                loginForm.ticket = retJson.ticket;
                $("#TCaptcha").hide();
                sendSmsCode(loginForm);
            } else {
                $("#sms-code-btn").prop('disabled', false);
                $("#sms-code-btn").removeClass("btn-disabled");
                $("#sms-code-again-btn").prop('disabled', false);
                $("#sms-code-again-btn").removeClass("btn-disabled");
                loginForm.ticket = null;
                window.capDestroy();
            }
        };
        var timer = 119;
        var sendSmsCode = function(submitForm) {
            $.ajax({
                dataType: "json",
                contentType:'application/json;charset=UTF-8',//关键是要加上这行
                traditional:true,//这使json格式的字符不会被转码
                data: JSON.stringify(submitForm),
                type: "post",
                timeout: 20000,
                url: baseUrl + "/webapi/smsCodes",
                success: function (response) {
                    if (!response.errcode) { // 短信发送成功
                        smsCodeFlag = 1; // 短信发送成功后，切换语言，不修改国家码
                        // toastFunc({text: response.data});
                        toastr["success"](response.data);
                        // 验证码发送成功后，将获取验证码的按钮disable，同时开始读秒
                        refreshSendSmsCodeBtn();
                        $("#mobile-container").hide();
                        $("#sms-code-btn").hide();
                        $("#commit-btn").show();
                        $("#sms-code-container").show();
                        $("#sms-code-again-container").show();
                        $("#sms-code-again-btn").prop("disabled", true).addClass("btn-disabled");
                        window.setTimeout(function(){
                            $("#smsCode").trigger("click").focus();
                        }, 200);
                        loginForm.ticket = null;
                        window.capDestroy()
                    } else if (response.errcode === 7005) { // ticket无效或过期
                        loginForm.ticket = null;
                        window.capDestroy()
                        $("#sms-code-btn").prop("disabled", false).removeClass("btn-disabled");
                    } else {
                        toastFunc({text: response.errmsg});
                        $("#sms-code-btn").prop("disabled", false).removeClass("btn-disabled");
                    }
                },
                error: function (response){
                    console.log(response);
                }
            });
        };
        var refreshSendSmsCodeBtn = function() {
            window.setTimeout(function () {
                refreshSendSmsCodeBtnRecursively()
            }, 1000);
        };
        var refreshSendSmsCodeBtnRecursively = function() {
            if (timer < 1) {
                timer = 119;
                $("#mobile-container").show();
                $("#sms-code-again-btn").prop("disabled", false).removeClass("btn-disabled");
                $("#sms-code-again-btn").empty().html(languageJson[loginForm.localeStr].login.validationCodeAgainBtn);
            } else {
                if (timer > 0) { // 这个if是为了防止提交后修改timer导致再次修改timer引起的错误
                    timer = timer - 1;
                    if (loginForm.localeStr === "en") {
                        $("#sms-code-again-btn").empty().html(languageJson[loginForm.localeStr].login.seconds.replace(/\{0\}/g, timer + ''));
                    } else {
                        $("#sms-code-again-btn").empty().html(timer + '' + languageJson[loginForm.localeStr].login.seconds);
                    }
                }
                window.setTimeout(function () {
                    refreshSendSmsCodeBtnRecursively();
                }, 1000);
            }
        };
        $("#commit-btn").on("click", function(){
            $("#commit-btn").prop("disabled", true).addClass("btn-disabled");
            var intlNumber = $("#mobile").intlTelInput("getNumber");
            var intlNumberType = $("#mobile").intlTelInput("getNumberType");
            var intlSelectedCountryData = $("#mobile").intlTelInput("getSelectedCountryData");
            if (!intlSelectedCountryData || $.isEmptyObject(intlSelectedCountryData)) {
                toastFunc({text: languageJson[loginForm.localeStr].login.countryCodeEmpty});
                $("#sms-code-btn").prop('disabled', false).removeClass("btn-disabled");
                return
            }
            if (!intlNumber || !intlNumber === '') {
                toastFunc({text: languageJson[loginForm.localeStr].login.mobileEmpty});
                $("#sms-code-btn").prop('disabled', false).removeClass("btn-disabled");
                return
            }
            var isValid = $("#mobile").intlTelInput("isValidNumber");
            if (!isValid) {
                toastFunc({text: languageJson[loginForm.localeStr].login.mobileInvalid});
                $("#sms-code-btn").prop('disabled', false).removeClass("btn-disabled");
                return
            }
            loginForm.mobile = intlNumber;
            loginForm.countryCode = intlSelectedCountryData.dialCode;
            var smsCode = $("#smsCode").val();
            if (!smsCode.length) {
                toastFunc({text: languageJson[loginForm.localeStr].login.smsCodeEmpty});
                $("#commit-btn").prop("disabled", false).removeClass("btn-disabled");
                return
            }
            loginForm.smsCode = smsCode;
            loginForm.ticket = undefined;
            if(sign) {
                loginForm.sign = sign;
            }
            $.ajax({
                dataType: "json",
                contentType:'application/json;charset=UTF-8',//关键是要加上这行
                traditional:true,//这使json格式的字符不会被转码
                data: JSON.stringify(loginForm),
                type: "post",
                timeout: 20000,
                url: baseUrl + "/webapi/register",
                success: function (response) {
                    if (!response.errcode) {
                        document.cookie = 'localeStr=' + loginForm.localeStr + ';expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/';
                        // toastFunc({text: languageJson[loginForm.localeStr].login.registerSuccessfully});
                        if (response.data.registered) {
                            toastr["success"](languageJson[loginForm.localeStr].login.loginSuccessfully);
                        } else {
                            toastr["success"](languageJson[loginForm.localeStr].login.registerSuccessfully);
                        }
                        window.setTimeout(function(){
                            timer = 0 // 让那个该死的refresh停下来
                            $("#sms-code-again-btn").hide();
                            window.location.href = "/profile/" + response.data.token;
                        }, 2000);
                    } else {
                        toastFunc({text: response.errmsg});
                        $("#commit-btn").prop("disabled", false).removeClass("btn-disabled");
                    }
                },
                error: function (response){
                    console.log(response);
                    $("#commit-btn").prop("disabled", false).removeClass("btn-disabled");
                }
            });
        });
    });
</script>
</body>
</html>