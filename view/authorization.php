<script src="/scripts/lib.js"></script>
<script type="text/javascript">
      var onload_captcha = function() {
        grecaptcha.render('form_captcha', {
          'sitekey' : '6Lc6u2clAAAAAElN6SiYyzD24swge_0wnhHC_2W3'
        });
      };
</script>
<main>
    <div class="window-registration">
        <h2 class="title-registration">Вхід</h2>
        <form method="POST" id="authorization_form" action="action_authorization">
            <label for="form-login">Логін:</label><br>
            <input id="form-login" name="login" type="text"><br>
            <label for="form-password">Пароль:</label><br>
            <input id="form-password" name="password" type="password"><br>
            <div class="gcapthcha" id="form_captcha"></div>
            <input type="hidden" name="action" value="authorization">
            <input name="submit-authorization" type="submit">
        </form>
    </div>
</main>
<script src="/scripts/authorization.js" defer></script>
<script src="https://www.google.com/recaptcha/api.js?onload=onload_captcha&render=explicit" async defer></script>