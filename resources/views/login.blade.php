<!DOCTYPE html>
<html lang="id">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta charset="UTF-8">
    <title>Login - SIPANCAR</title>
    
    <link href="https://fonts.googleapis.com/css2?family=ABeeZee&display=swap" rel="stylesheet">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'ABeeZee', sans-serif; }
        body { background-color: #FFFFFF; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .login-container { width: 540px; position: relative; }
        .login-header { background-color: #9AFCFF; height: 97px; border-radius: 20px 20px 0 0; display: flex; justify-content: space-between; align-items: center; padding: 0 40px; box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); position: relative; z-index: 2; }
        .login-header h1 { font-size: 30px; color: #000000; font-weight: normal; }
        
        /* Modifikasi CSS Logo Header (Transparan & Menggunakan Gambar) */
        .logo-placeholder { 
            width: 65px; 
            height: 65px; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
        }
        .logo-placeholder img {
            width: 100%;
            height: 100%;
            object-fit: contain; 
            filter: drop-shadow(0px 2px 3px rgba(0,0,0,0.1));
        }

        .login-body { background: rgba(217, 217, 217, 0.15); border-radius: 0 0 20px 20px; padding: 50px 80px; box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); margin-top: -10px; text-align: center; }
        .login-body h2 { font-size: 30px; color: #000000; margin-bottom: 10px; font-weight: normal; }
        .login-body p { font-size: 20px; color: #000000; margin-bottom: 30px; }
        .form-group { text-align: left; margin-bottom: 25px; }
        .form-group label { display: block; font-size: 15px; color: #000000; margin-bottom: 8px; padding-left: 15px; }
        .input-wrapper { position: relative; }
        .input-wrapper input { width: 100%; height: 45px; background: #D9D9D9; border: 1px solid #000000; border-radius: 20px; padding: 0 20px; font-size: 15px; color: #545454; box-shadow: inset 0px 4px 4px rgba(0, 0, 0, 0.1); }
        .input-wrapper input:focus { outline: none; border-color: #9AFCFF; }
        .eye-icon { position: absolute; right: 20px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #545454; user-select: none; }
        .btn-login { width: 120px; height: 35px; background: #9AFCFF; border-radius: 20px; border: none; font-size: 16px; color: #000000; cursor: pointer; margin-top: 10px; margin-bottom: 20px; transition: 0.3s; }
        .btn-login:hover { background: #7de8ed; }
        .register-link { display: block; font-size: 13px; color: #000000; text-decoration: none; }
        .register-link:hover { text-decoration: underline; color: #0056b3; }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="login-header">
            <div class="logo-placeholder">
                <img src="https://upload.wikimedia.org/wikipedia/commons/1/12/Logo_BMKG_%282010%29.png" alt="BMKG">
            </div> 
            <h1>SIPANCAR</h1>
            <div class="logo-placeholder">
            <img src="https://3.bp.blogspot.com/-BRV8kAVyi4I/XDX3S86Pk5I/AAAAAAAABwA/K5fnfc4c1VYps0EcV32qP6yB96kghqU3QCLcBGAs/s1600/logo%2Bjawa%2Bbarat.png" alt="JABAR">
            </div>
        </div>

        <div class="login-body">
            <h2>Selamat Datang</h2>
            <p>Silahkan Login</p>

            @if(session('sukses'))
                <p style="color: #009900; font-size: 14px; margin-bottom: 15px; font-weight: bold;">{{ session('sukses') }}</p>
            @endif
            @if(session('error'))
                <p style="color: #ff0000; font-size: 14px; margin-bottom: 15px; font-weight: bold;">{{ session('error') }}</p>
            @endif

            <form action="{{ url('/login') }}" method="POST">
            @csrf
                <div class="form-group">
                    <label>Username</label>
                    <div class="input-wrapper">
                        <input type="text" name="username" placeholder="Masukkan Username Anda" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="input-wrapper">
                        <input type="password" name="password" placeholder="Masukkan Password Anda" required>
                        <span class="eye-icon">👁️</span>
                    </div>
                </div>

                <button type="submit" class="btn-login">Login</button>
                
                <a href="{{ url('/register') }}" class="register-link">Belum memiliki akun ? Daftar akun dan mulai !</a>
            </form>
        </div>
    </div>
    <script>
    // Script Ikon Mata
    const eyeIcons = document.querySelectorAll('.eye-icon');

    eyeIcons.forEach(icon => {
        icon.addEventListener('click', function() {
            const inputWrapper = this.closest('.input-wrapper');
            const inputField = inputWrapper.querySelector('input');

            if (inputField.type === 'password') {
                inputField.type = 'text';
                this.textContent = '🙈'; 
            } else {
                inputField.type = 'password';
                this.textContent = '👁️'; 
            }
        });
    });
</script>
</body>
</html>