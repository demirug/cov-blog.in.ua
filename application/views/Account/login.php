<div class="login-wrap">
    <div class="login-html">
        <div class="login-form">
            <h2 align="center">Вход</h2>
            <form class="sign-in-htm" action="/login" method="post">
                <div class="group">
                    <label for="login" class="label">Логин</label>
                    <input id="login" name="login" type="text" class="input" regex="[A-Za-z0-9]" required>
                </div>
                <div class="group">
                    <label for="pass" class="label">Пароль</label>
                    <input id="pass" name="password" type="password" class="input" data-type="password" required>
                </div>
                <div class="group">
                    <input type="hidden" name="isPermanent" value="0">
                    <input id="check" name="isPermanent" value="1" type="checkbox" class="check" checked>
                    <label for="check"><span class="icon"></span> Запомнить меня</label>
                </div>
                <div class="group">
                    <input type="submit" class="button" value="Войти">
                </div>
                <output class="error-message"></output>
                <div class="hr"></div>
                <div class="foot-lnk">
                    <a href="/register">Создать аккаунт</a>
                </div>
            </form>
        </div>
    </div>
</div>