<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM pakan ORDER BY id DESC");
$pakan = $stmt->fetchAll();

$message = isset($_GET['msg']) ? $_GET['msg'] : '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pakan</title>
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
                <a href="pakan.php" class="hover:text-orange-400 font-semibold"><i class="fas fa-leaf mr-1"></i>Pakan</a>
                <a href="obat.php" class="hover:text-orange-400"><i class="fas fa-capsules mr-1"></i>Obat</a>
                <a href="logout.php" class="text-white px-4 py-2 rounded-full btn"><i class="fas fa-sign-out-alt mr-1"></i>Logout</a>
            </nav>
        </div>
    </header>
    
    <main class="container mx-auto px-6 pt-24 pb-12">
        <?php if ($message): ?>
            <div class="bg-green-100 border-l-4 border-orange-600 text-orange-800 p-4 mb-6 rounded-r-lg animate-fade-in">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        
        <div class="bg-white rounded-xl shadow-lg p-6 card animate-fade-in">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-800"><i class="fas fa-leaf mr-2 text-orange-600"></i>Daftar Pakan</h2>
                <a href="add_pakan.php" class="text-white px-6 py-2 rounded-full btn"><i class="fas fa-plus mr-2"></i>Tambah Pakan</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full bg-white rounded-lg">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-4 text-left font-semibold text-gray-800">Nama Pakan</th>
                            <th class="p-4 text-left font-semibold text-gray-800">Jenis</th>
                            <th class="p-4 text-left font-semibold text-gray-800">Stok (kg)</th>
                            <th class="p-4 text-left font-semibold text-gray-800">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($pakan): ?>
                            <?php foreach ($pakan as $row): ?>
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-4 font-medium"><?php echo htmlspecialchars($row['nama_pakan']); ?></td>
                                    <td class="p-4"><?php echo htmlspecialchars($row['jenis']); ?></td>
                                    <td class="p-4"><?php echo htmlspecialchars($row['stok']); ?></td>
                                    <td class="p-4 flex space-x-2">
                                        <a href="edit_pakan.php?id=<?php echo $row['id']; ?>" class="bg-yellow-600 text-white px-3 py-1 rounded-full btn hover:bg-yellow-700"><i class="fas fa-edit mr-1"></i>Edit</a>
                                        <a href="delete_pakan.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Yakin hapus pakan <?php echo htmlspecialchars($row['nama_pakan']); ?>?')" 
                                           class="bg-red-600 text-white px-3 py-1 rounded-full btn hover:bg-red-700"><i class="fas fa-trash mr-1"></i>Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="4" class="p-8 text-center text-gray-500">Belum ada pakan yang ditambahkan.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
    </main>
</body>
</html>