
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<style>
    body {
        font-family: Arial, sans-serif;
    }
    .form-container {
        max-width: 400px;
        margin: 50px auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
    }
    input[type="text"], input[type="password"] {
        width: 100%;
        padding: 10px;
        margin: 5px 0;
        border: 1px solid #ccc;
        border-radius: 3px;
        box-sizing: border-box;
    }
    input[type="submit"] {
        width: 100%;
        padding: 10px;
        margin-top: 10px;
        border: none;
        border-radius: 3px;
        background-color: #0ca474;
        color: white;
        cursor: pointer;
    }
    .error {
        color: red;
        font-size: 0.9em;
    }
    .form-title {
        text-align: center;
        font-size: 2em;
    }
    
.form__text {
    text-align: center;
}

.form__link {
    color: var(--color-secondary);
    text-decoration: none;
    cursor: pointer;
}

.form__link:hover {
    text-decoration: underline;
}
.form-hidden {
    display: none;
}
</style>
</head>
<body>

<div class="form-container" id = "Login">
    <h2 class="form-title">Login</h2>
    <form id="login-form" method="post">
        <div>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username">
            <span id="username-error" class="error"></span>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
            <span id="password-error" class="error"></span>
        </div>
        <input type="submit" value="Login">
        <p class="form__text">
            <a href="#" class="form__link">Forgot your password?</a>
        </p>
        <p class="form__text">
            <a class="form__link" href="./" id="linkCreateAccount">Don't have an account? Create account</a>
        </p>
        
    </form>
</div>

<div class="form-hidden form-container" id="CreateAccount">
    <h2 class="form-title">Create Account</h2>
    <form id="create-account-form" method="post" action="create_account.php">
        <div>
            <label for="create-username">Username:</label>
            <input type="text" id="create-username" name="username">
            <span id="username-error" class="error"></span>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email">
            <span id="email-error" class="error"></span>
        </div>
        <div>
            <label for="create-password">Password:</label>
            <input type="password" id="create-password" name="password">
            <span id="password-error" class="error"></span>
        </div>
        <div>
            <label for="confirm-password">Confirm Password:</label>
            <input type="password" id="confirm-password" name="confirm-password">
            <span id="confirm-error" class="error"></span>
        </div>
        <input type="submit" value="Create">
        <p class="form__text">
            <a class="form__link" href="./" id="linkLogin">Already have an account? Login</a>
        </p>
    </form>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- <script src="signin.php"></script> -->
<script>
$(document).ready(function() {
    $('#login-form').submit(function(event) {
        event.preventDefault(); 

        // Reset thông báo lỗi
        $('.error').text('');

        // Lấy giá trị từ form
        var username = $('#username').val();
        var password = $('#password').val();

        // Kiểm tra dữ liệu
        var isValid = true;

        if (username.trim() === '') {
            $('#username-error').text('Username is required');
            isValid = false;
        } else if (username.length < 5) {
            $('#username-error').text('Username must be at least 5 characters long');
            isValid = false;
        }

        if (password.trim() === '') {
            $('#password-error').text('Password is required');
            isValid = false;
        } else if (password.length < 6) {
            $('#password-error').text('Password must be at least 6 characters long');
            isValid = false;
        }

        // Nếu dữ liệu hợp lệ thì submit form
        if (isValid) {
            $.ajax({
                    url: '/login.php',
                    method: 'POST',
                    data: { username: username, password: password },
                    success: function (response) {
                        if (response.trim() === 'success') {
                            alert('Login seccessfully');
                        } else {
                            alert(response.trim());
                        }
                    },
                    error: function () {
                        alert('Error occurred while logging in');
                    }
                });
        }
    });

    $('#CreateAccount').submit(function(event) {
    event.preventDefault();
    var username = $('#create-username').val();
    var email = $('#email').val();
    var password = $('#create-password').val();
    var confirmPassword = $('#confirm-password').val();
    var usernameError = $('#username-error');
    var emailError = $('#email-error');
    var passwordError = $('#password-error');
    var confirmError = $('#confirm-error');
    var isValid = true;

    if (username === '') {
        usernameError.text('Username is required');
        isValid = false;
    } else {
        usernameError.text('');
    }

    if (email === '') {
        emailError.text('Email is required');
        isValid = false;
    } else {
        emailError.text('');
    }

    if (password === '') {
        passwordError.text('Password is required');
        isValid = false;
    } else {
        passwordError.text('');
    }

    if (confirmPassword === '') {
        confirmError.text('Confirm password is required');
        isValid = false;
    } else if (confirmPassword !== password) {
        confirmError.text('Password and confirm password do not match');
        isValid = false;
    } else {
        confirmError.text('');
    }

    if (isValid) {
        $.ajax({
            type: 'POST',
            url: '/signin.php',
            data: {
                username: username,
                email: email,
                password: password
            },
            success: function(response) {
                if (response === 'Data inserted successfully') {
                    $('#create-account-form').trigger('reset');
                    alert('Account created successfully');
                } else {
                    alert(response.trim());
                }
            }
        });
    }
});
    // Hiển thị form tạo tài khoản khi click vào link
    document.querySelector('#linkCreateAccount').addEventListener('click', e => {
        e.preventDefault();
        document.querySelector('#CreateAccount').classList.remove('form-hidden');
        document.querySelector('.form-container').classList.add('form-hidden');
    
    });
    // Hiển thị form đăng nhập khi click vào link
    document.querySelector('#linkLogin').addEventListener('click', e => {
        e.preventDefault();
        document.querySelector('#CreateAccount').classList.add('form-hidden');
        document.querySelector('.form-container').classList.remove('form-hidden');
    });
});


</script>

</body>
</html>