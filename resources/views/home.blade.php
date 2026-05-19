<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - SIPANCAR</title>
    
    <link href="https://fonts.googleapis.com/css2?family=ABeeZee&display=swap" rel="stylesheet">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'ABeeZee', sans-serif; }
        body { background-color: #FFFFFF; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        
        /* CONTAINER KOTAK KACA 1000x600 (Sama dengan Dashboard) */
        .home-container { 
            display: flex; 
            width: 1000px; 
            height: 600px; 
            background: rgba(255, 245, 245, 0.15); 
            box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); 
            border-radius: 20px; 
            overflow: hidden; 
        }

        /* SIDEBAR (Warna solid cyan sama dengan Dashboard) */
        .sidebar { width: 220px; background: #9AFCFF; display: flex; flex-direction: column; padding-top: 30px; border-right: 1px solid rgba(0,0,0,0.1); z-index: 10; }
        .sidebar-logos { display: flex; justify-content: space-evenly; align-items: center; margin-bottom: 40px; }
        
        /* Logo Sidebar Transparan */
        .logo-small { 
            width: 65px; 
            height: 65px; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
        }

        .logo-small img {
            width: 100%;
            height: 100%;
            object-fit: contain; 
        }
        
        /* MENU NAVIGASI (Garis border hitam sama dengan Dashboard) */
        .nav-menu { display: flex; flex-direction: column; flex-grow: 1; }
        .nav-item { display: flex; align-items: center; padding: 15px 25px; text-decoration: none; color: #000000; font-size: 18px; border-bottom: 1px solid #000000; transition: 0.3s; }
        .nav-item.active, .nav-item:hover { background-color: rgba(255,255,255,0.4); font-weight: bold;}
        .nav-item.first-item { border-top: 1px solid #000000; }
        
        .logout-btn { display: flex; align-items: center; padding: 15px 25px; text-decoration: none; color: #000000; font-size: 18px; border-top: 1px solid #000000; margin-bottom: 20px; }
        .logout-btn:hover { background-color: #ffcccc; }

        /* KONTEN UTAMA HOME */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center; /* Teks dan logo ngumpul di tengah */
            align-items: center;
            background-color: #FAFAFA; /* Sama dengan background peta */
            position: relative;
        }

        .title-top {
            font-size: 40px;
            font-weight: normal;
            color: #000000;
            margin-bottom: 30px; /* Jarak ke logo */
            z-index: 2;
        }

        .title-bottom {
            font-size: 40px;
            font-weight: normal;
            color: #000000;
            margin-top: 30px; /* Jarak ke logo */
            letter-spacing: 2px;
            z-index: 2;
        }

        /* LOGO TENGAH YANG DIPERBAIKI (Tajam & Transparan) */
        .center-logo {
            width: 250px;
            height: 250px;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1;
        }
        
        /* Memastikan gambar di tengah menyesuaikan wadah dengan rapi */
        .center-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            filter: drop-shadow(0px 4px 6px rgba(0,0,0,0.1)); /* Tambahan bayangan tipis agar logo lebih hidup */
        }
    </style>
</head>
<body>

    <div class="home-container">
        <div class="sidebar">
            <div class="sidebar-logos">
                <div class="logo-small">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/1/12/Logo_BMKG_%282010%29.png" alt="BMKG">
                </div>
                <div class="logo-small">
                    <img src="https://3.bp.blogspot.com/-BRV8kAVyi4I/XDX3S86Pk5I/AAAAAAAABwA/K5fnfc4c1VYps0EcV32qP6yB96kghqU3QCLcBGAs/s1600/logo%2Bjawa%2Bbarat.png" alt="JABAR">
                </div>
            </div>

            <div class="nav-menu">
                <a href="{{ url('/home') }}" class="nav-item active first-item">🏠 Home</a>
                <a href="{{ url('/dashboard') }}" class="nav-item">📊 Dashboard</a>
                <a href="{{ url('/data') }}" class="nav-item">🗄️ Data</a> 
            </div>

            <form action="{{ url('/logout') }}" method="POST" style="margin: 0; padding: 0;">
                @csrf
                <button type="submit" class="logout-btn" style="width: 100%; text-align: left; background: none; cursor: pointer; border: none; font-family: 'ABeeZee', sans-serif;">
                    🚪 Log out
                </button>
            </form>
        </div> 

        <div class="main-content">
            <h1 class="title-top">Selamat Datang</h1>
            
            <div class="center-logo">
                <img src="https://upload.wikimedia.org/wikipedia/commons/1/12/Logo_BMKG_%282010%29.png" alt="BMKG" class="bmkg">
            </div>

            <h1 class="title-bottom">SIPANCAR</h1>
        </div>
    </div>

</body>
</html>