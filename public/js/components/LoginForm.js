const LoginForm = function()
{
    return `
            <div class="form-wrapper">
                <form id="loginForm">
                    <div class="input-wrapper">
                        <input name="username" type="text" placeholder="Username"/>
                    </div>
                    <div class="input-wrapper">
                        <input name="password" type="password" placeholder="Password"/>
                    </div>
                    <button class="btn" onClick="login(event)">Login</button>
                </form>
            </div>
        `;
}
export default LoginForm