<center>
    <div style="background-color: aqua; width: 600px; height: 350px; border-radius: 10px;">
        <br>
        <h3>Login in your account</h3>

        <form action="/login" method="post">

            <div>
                <input type="text" style="padding: 12px 20px; margin: 8px 0" name="login" placeholder="Enter login" regex="[A-Za-z0-9]" required>
            </div>
            <div>
                <input type="password" style="padding: 12px 20px; margin: 8px 0" name="password" placeholder="Enter password" required>
            </div>
            <div>
                <input type="submit" style="padding: 12px 20px; margin: 8px 0" name="submit", value="Submit">
            </div>

        </form>

        <div>
            <span>Forgot</span>
            <a href="/restore">Password?</a>
        </div>

        <div style="margin-top: 20px; margin-right: 20px; text-align: right">
            <a href="/register">Create account</a>
        </div>


    </div>


</center>