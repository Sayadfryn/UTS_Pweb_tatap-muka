<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$stmt = $pdo->prepare("SELECT h.*, p.nama_pakan AS pakan_nama, o.nama_obat 
                       FROM hewan h 
                       JOIN pakan p ON h.id_pakan = p.id 
                       JOIN obat o ON h.id_obat = o.id 
                       WHERE h.id = ?");
$stmt->execute([$_GET['id']]);
$hewan = $stmt->fetch();

if (!$hewan) {
    header("Location: dashboard.php");
    exit;
}

$gambar_default = '';
switch (strtolower($hewan['nama_hewan'])) {
    case 'sapi':
        $gambar_default = 'https://images.pexels.com/photos/1105666/pexels-photo-1105666.jpeg';
        break;
    case 'kambing':
        $gambar_default = 'https://images.pexels.com/photos/2098157/pexels-photo-2098157.jpeg';
        break;
    case 'ayam':
        $gambar_default = 'https://images.pexels.com/photos/36762/duckling-birds-yellow-fluffy.jpg';
        break;
    default:
        $gambar_default = 'https://images.pexels.com/photos/162240/bull-calf-cow-farm-162240.jpeg';
}
$gambar = !empty($hewan['gambar_link']) ? $hewan['gambar_link'] : $gambar_default;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Hewan</title>
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
            <h2 class="text-2xl font-semibold text-gray-800 mb-6"><i class="fas fa-paw mr-2 text-orange-600"></i>Detail Hewan</h2>
            <div class="space-y-4">
                <p><strong>Nama Hewan:</strong> <?php echo htmlspecialchars($hewan['nama_hewan']); ?></p>
                <p><strong>Kode Hewan:</strong> <?php echo htmlspecialchars($hewan['kode_hewan']); ?></p>
                <p><strong>Tanggal Masuk:</strong> <?php echo date('d-m-Y', strtotime($hewan['tanggal_masuk'])); ?></p>
                <p><strong>Pakan:</strong> <?php echo htmlspecialchars($hewan['pakan_nama']); ?></p>
                <p><strong>Obat:</strong> <?php echo htmlspecialchars($hewan['nama_obat']); ?></p>
                <p><strong>Keterangan:</strong> <?php echo htmlspecialchars($hewan['keterangan'] ?: 'Tidak ada keterangan'); ?></p>
            </div>
            <div class="mt-6">
                <img src="<?php echo htmlspecialchars($gambar); ?>" alt="Gambar <?php echo htmlspecialchars($hewan['nama_hewan']); ?>" class="w-full h-auto rounded-lg shadow-md">
            </div>
            <div class="mt-6 flex space-x-4">
                <a href="edit_hewan.php?id=<?php echo $hewan['id']; ?>" class="bg-yellow-600 text-white px-4 py-2 rounded-full btn"><i class="fas fa-edit mr-1"></i>Edit</a>
                <a href="dashboard.php" class="bg-blue-600 text-white px-4 py-2 rounded-full btn"><i class="fas fa-arrow-left mr-1"></i>Kembali</a>
                <button onclick="window.print()" class="bg-blue-600 text-white px-4 py-2 rounded-full btn"><"">Cetak </button>
            </div>
        </div>
    </main>
</body>
</html>