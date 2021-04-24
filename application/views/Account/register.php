<div class="sign-wrap">
    <div class="login-html">
        <div class="login-form">
            <h2 align="center">Регистрация</h2>
            <form class="sign-in-htm" action="/register" method="post">
                <div class="group">
                    <label for="login" class="label">Логин</label>
                    <input id="login" name="login" type="text" class="input" regex="[A-Za-z0-9]" required>
                </div>
                <div class="group">
                    <label for="email" class="label">Электронный адрес</label>
                    <input id="email" name="email" type="email" class="input" required>
                </div>
                <div class="group">
                    <label for="pass" class="label">Пароль</label>
                    <input id="pass" name="password" type="password" class="input" data-type="password" required>
                </div>
                <div class="group">
                    <label for="conf_pass" class="label">Пароль еще раз</label>
                    <input id="conf_pass" name="conf_password" type="password" class="input" data-type="password" required>
                </div>
                <div class="group">
                    <input type="submit" class="button" value="Зарегистрироваться">
                </div>
                <output class="error-message"></output>
                <div class="hr"></div>
                <div class="foot-lnk">
                    <a href="/login">Уже зарегистрированы?</a>
                </div>
            </form>
        </div>
    </div>
</div>