
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
        <h2 class="title-registration">Реєстрація</h2>
        <form method="POST" id="registration_form" action="action_registration">
            <label for="form-login">Логін:</label><br>
            <input id="form-login" name="login" type="text"><br>
            <label for="form-password">Пароль:</label><br>
            <input id="form-password" name="password" type="password"><br>
            <label for="form-password_check">Повторіть пароль:</label><br>
            <input id="form-password_check" name="password_check" type="password"><br>
            <label for="form-email">Електронна адреса:</label><br>
            <input id="form-email" name="email" type="email"><br>

            <div class="gcapthcha" id="form_captcha"></div>

            <input name="submit-registration" type="submit">
        </form>
    </div>
</main>
<script src="/scripts/registration.js" defer></script>
<script src="https://www.google.com/recaptcha/api.js?onload=onload_captcha&render=explicit" async defer></script>