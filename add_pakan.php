<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

if ($_POST) {
    $nama_pakan = trim($_POST['nama_pakan']);
    $jenis = trim($_POST['jenis']);
    $stok = $_POST['stok'];
    
    $stmt = $pdo->prepare("INSERT INTO pakan (nama_pakan, jenis, stok) VALUES (?, ?, ?)");
    if ($stmt->execute([$nama_pakan, $jenis, $stok])) {
        header("Location: pakan.php?msg=Pakan berhasil ditambahkan");
        exit;
    } else {
        $error = "Gagal menambahkan pakan!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pakan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to bottom, #fef3c7, #f3e8b3);
        }
        .navbar {
            background: linear-gradient(to right, #4a7043, #2f855a);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .btn {
            background: linear-gradient(to right, #f97316, #ea580c);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
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
<body>
    <header class="navbar text-white p-4 fixed top-0 w-full z-10">
        <div class="container mx-auto px-6 flex justify-between items-center">
            <div class="flex items-center">
                <i class="fas fa-tractor text-orange-400 text-2xl mr-3"></i>
                <h1 class="text-xl font-bold">Peternakan Nusantara</h1>
            </div>
            <nav class="flex items-center space-x-6">
                <a href="dashboard.php" class="hover:text-orange-400"><i class="fas fa-paw mr-1"></i>Hewan</a>
                <a href="pakan.php" class="hover:text-orange-400"><i class="fas fa-leaf mr-1"></i>Pakan</a>
                <a href="obat.php" class="hover:text-orange-400"><i class="fas fa-capsules mr-1"></i>Obat</a>
                <a href="logout.php" class="text-white px-4 py-2 rounded-full btn"><i class="fas fa-sign-out-alt mr-1"></i>Logout</a>
            </nav>
        </div>
    </header>
    
    <main class="container mx-auto px-6 pt-24 pb-12">
        <div class="bg-white rounded-xl shadow-lg p-6 card animate-fade-in max-w-2xl mx-auto">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6"><i class="fas fa-leaf mr-2 text-orange-600"></i>Tambah Pakan</h2>
            
            <?php if (isset($error)): ?>
                <div class="bg-red-100 border-l-4 border-red-600 text-red-700 p-4 mb-4 rounded-r">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2"><i class="fas fa-leaf mr-2"></i>Nama Pakan</label>
                    <input type="text" name="nama_pakan" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-600" placeholder="Masukkan nama pakan">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2"><i class="fas fa-list mr-2"></i>Jenis</label>
                    <input type="text" name="jenis" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-600" placeholder="Masukkan jenis pakan">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2"><i class="fas fa-weight mr-2"></i>Stok (kg)</label>
                    <input type="number" name="stok" required min="0" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-600" placeholder="Masukkan stok pakan">
                </div>
                <div class="flex space-x-4">
                    <button type="submit" class="bg-orange-600 text-white px-6 py-2 rounded-full btn"><i class="fas fa-save mr-2"></i>Simpan</button>
                    <a href="pakan.php" class="bg-blue-600 text-white px-6 py-2 rounded-full btn"><i class="fas fa-arrow-left mr-2"></i>Kembali</a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>