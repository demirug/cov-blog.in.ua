<center>
    <div style="background-color: aqua; width: 600px; height: 350px; border-radius: 10px;">
        <br>
        <h3>Register</h3>

        <form action="/register" method="post">

            <div>
                <input type="text" style="padding: 12px 20px; margin: 8px 0" name="login" placeholder="Enter login" regex="[A-Za-z]" required>
            </div>
            <div>
                <input type="password" style="padding: 12px 20px; margin: 8px 0" name="password" placeholder="Enter password" required>
            </div>
            <div>
                <input type="password" style="padding: 12px 20px; margin: 8px 0" name="password" placeholder="Confirm password" required>
            </div>
            <div>
                <input type="submit" style="padding: 12px 20px; margin: 8px 0" name="submit", value="Submit">
            </div>

        </form>

        <div>
            <span>Already registered? </span>
            <a href="/login">Login</a>
        </div>

    </div>
</center>