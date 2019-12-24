<html>
<head>
<title>User Login</title>
<link href="./view/css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div>
        <form action="login-action.php" method="post" id="frmLogin" onSubmit="return validate();">
            <div class="grid-container">
            <div class="demo-table">
                <div class="menu-icon_login">TB
                    <i class="fas fa-bars header__menu"></i>
                </div>
                <div class="form-head">Login</div>
                <?php 
                if(isset($_SESSION["errorMessage"])) {
                ?>
                <div class="error-message"><?php  echo $_SESSION["errorMessage"]; ?></div>
                <?php 
                unset($_SESSION["errorMessage"]);
                } 
                ?>
                <div class="field-column">
                    <div>
                        <label for="username">Username</label>
                    </div>
                    <div>
                        <input name="user_name" id="user_name" type="text"
                            class="demo-input-box">
                    </div>
                    <span id="user_info" class="error-info"></span>
                </div>
                <div class="field-column">
                    <div>
                        <label for="password">Password</label>
                    </div>
                    <div>
                        <input name="password" id="password" type="password"
                            class="demo-input-box">
                    </div>
                    <span id="password_info" class="error-info"></span>
                </div>
                <div class=field-column>
                    <div>
                        <input type="submit" name="login" value="Login"
                        class="btnLogin"></span>
                    </div>
                </div>
            </div>
            </div>
        </form>
    </div>
    <script>
    function validate() {
        var $valid = true;
        document.getElementById("user_info").innerHTML = "";
        document.getElementById("password_info").innerHTML = "";
        
        var userName = document.getElementById("user_name").value;
        var password = document.getElementById("password").value;
        if(userName == "") 
        {
            document.getElementById("user_info").innerHTML = "Please fill the username";
           
        	$valid = false;
        }
        if(password == "") 
        {
            document.getElementById("password_info").innerHTML = "Please fill the password";
            $valid = false;
        }
        return $valid;
    }
    </script>
</body>
</html>