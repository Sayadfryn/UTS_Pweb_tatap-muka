<?php
session_start();
include 'config.php';

if (isset($_SESSION['admin_logged_in'])) {
    header("Location: dashboard.php");
    exit;
}

$error = '';
if ($_POST) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    
    if ($user && $user['password'] === $password) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $user['username'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to bottom, #fef3c7, #f3e8b3);
        }
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        .btn {
            background: linear-gradient(to right, #f97316, #ea580c);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border-radius: 12px;
        }
        .btn:hover {
            transform: scale(1.03);
            box-shadow: 0 6px 14px rgba(249, 115, 22, 0.4);
        }
        .navbar {
            background: linear-gradient(to right, #4a7043, #2f855a);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .animate-fade-in {
            animation: fadeIn 1s ease-in-out;
        }
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center">
    <header class="navbar text-white p-4 fixed top-0 w-full z-10">
        <div class="container mx-auto px-6 flex justify-between items-center">
            <div class="flex items-center">
                <i class="fas fa-tractor text-orange-400 text-2xl mr-3"></i>
                <h1 class="text-xl font-bold">Peternakan Nusantara</h1>
            </div>
            <a href="index.php" class="hover:text-orange-400"><i class="fas fa-home mr-2"></i>Beranda</a>
        </div>
    </header>
    
    <main class="container mx-auto px-6 mt-20">
        <div class="bg-white p-8 rounded-xl shadow-lg max-w-md mx-auto card animate-fade-in">
            <h2 class="text-2xl font-bold text-center mb-6 text-gray-800"><i class="fas fa-lock mr-2 text-orange-600"></i>Login Admin</h2>
            
            <?php if ($error): ?>
                <div class="bg-red-100 border-l-4 border-red-600 text-red-700 p-4 mb-4 rounded-r">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2"><i class="fas fa-user mr-2"></i>Username</label>
                    <input type="text" name="username" required 
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-600"
                           placeholder="Masukkan username">
                </div>
                
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2"><i class="fas fa-key mr-2"></i>Password</label>
                    <input type="password" name="password" required 
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-600"
                           placeholder="Masukkan password">
                </div>
                
                <button type="submit" class="w-full text-white py-3 rounded-lg btn">
                    <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                </button>
            </form>
            <img src="https://2.bp.blogspot.com/-F_C9p4vD9Zg/VXO9E9PmPxI/AAAAAAAABMo/RrUrNbZ-vBc/s1600/ternak%2Bsapi.JPG" class="mt-6 w-full h-auto rounded-lg">
        </div>
    </main>
</body>
</html>