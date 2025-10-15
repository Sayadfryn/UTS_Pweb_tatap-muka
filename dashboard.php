<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

$stmt_chart = $pdo->query("SELECT p.jenis, COUNT(h.id) as jumlah 
                           FROM hewan h 
                           JOIN pakan p ON h.id_pakan = p.id 
                           GROUP BY p.jenis");
$chart_data = $stmt_chart->fetchAll();
$chart_labels = [];
$chart_values = [];
foreach ($chart_data as $data) {
    $chart_labels[] = $data['jenis'];
    $chart_values[] = $data['jumlah'];
}

$message = isset($_GET['msg']) ? $_GET['msg'] : '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Peternakan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                <a href="dashboard.php" class="hover:text-orange-400 font-semibold"><i class="fas fa-paw mr-1"></i>Hewan</a>
                <a href="pakan.php" class="hover:text-orange-400"><i class="fas fa-leaf mr-1"></i>Pakan</a>
                <a href="obat.php" class="hover:text-orange-400"><i class="fas fa-capsules mr-1"></i>Obat</a>
                <a href="logout.php" class="text-white px-4 py-2 rounded-full btn"><i class="fas fa-sign-out-alt mr-1"></i>Logout</a>
            </nav>
        </div>
    </header>
    
    <main class="container mx-auto px-6 pt-24 pb-12">
        <?php if ($message): ?>
            <div class="bg-green-100 border-l-4 border-orange-600 text-orange-800 p-4 mb-6 rounded-r-lg animate-fade-in">
                <p><?php echo htmlspecialchars($message); ?></p>
            </div>
        <?php endif; ?>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div class="bg-white rounded-xl shadow-lg p-6 card animate-fade-in">
                <h3 class="text-xl font-semibold mb-4 text-gray-800"><i class="fas fa-chart-bar mr-2 text-orange-600"></i>Jumlah Hewan Berdasarkan Pakan</h3>
                <canvas id="hewanChart" height="100"></canvas>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 card animate-fade-in">
                <h3 class="text-xl font-semibold mb-4 text-gray-800"><i class="fas fa-info-circle mr-2 text-orange-600"></i>Ringkasan</h3>
                <?php
                $total_hewan = $pdo->query("SELECT COUNT(*) FROM hewan")->fetchColumn();
                $total_pakan = $pdo->query("SELECT SUM(stok) FROM pakan")->fetchColumn();
                $total_obat = $pdo->query("SELECT COUNT(*) FROM obat")->fetchColumn();
                ?>
                <p class="text-gray-600 mb-2"><i class="fas fa-paw mr-2 text-orange-600"></i>Total Hewan: <span class="font-semibold"><?php echo $total_hewan; ?></span></p>
                <p class="text-gray-600 mb-2"><i class="fas fa-leaf mr-2 text-orange-600"></i>Total Stok Pakan: <span class="font-semibold"><?php echo $total_pakan; ?> kg</span></p>
                <p class="text-gray-600"><i class="fas fa-capsules mr-2 text-orange-600"></i>Total Jenis Obat: <span class="font-semibold"><?php echo $total_obat; ?></span></p>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6 card animate-fade-in">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-800"><i class="fas fa-list mr-2 text-orange-600"></i>Daftar Hewan Ternak</h2>
                <a href="add_hewan.php" class="text-white px-6 py-2 rounded-full btn">
                    <i class="fas fa-plus mr-2"></i>Tambah Hewan
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full bg-white rounded-lg">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-4 text-left font-semibold text-gray-800">Nama Hewan</th>
                            <th class="p-4 text-left font-semibold text-gray-800">Kode Hewan</th>
                            <th class="p-4 text-left font-semibold text-gray-800">Tanggal Masuk</th>
                            <th class="p-4 text-left font-semibold text-gray-800">Pakan</th>
                            <th class="p-4 text-left font-semibold text-gray-800">Obat</th>
                            <th class="p-4 text-left font-semibold text-gray-800">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $pdo->query("SELECT h.*, p.nama_pakan AS pakan_nama, o.nama_obat 
                                            FROM hewan h 
                                            JOIN pakan p ON h.id_pakan = p.id 
                                            JOIN obat o ON h.id_obat = o.id 
                                            ORDER BY h.tanggal_masuk DESC");
                        if ($stmt->rowCount() > 0) {
                            while ($row = $stmt->fetch()) {
                                echo "<tr class='border-b hover:bg-gray-50'>";
                                echo "<td class='p-4 font-medium'>" . htmlspecialchars($row['nama_hewan']) . "</td>";
                                echo "<td class='p-4'>" . htmlspecialchars($row['kode_hewan']) . "</td>";
                                echo "<td class='p-4'>" . date('d-m-Y', strtotime($row['tanggal_masuk'])) . "</td>";
                                echo "<td class='p-4'>" . htmlspecialchars($row['pakan_nama']) . "</td>";
                                echo "<td class='p-4'>" . htmlspecialchars($row['nama_obat']) . "</td>";
                                echo "<td class='p-4 flex space-x-2'>";
                                echo "<a href='view_hewan.php?id={$row['id']}' class='bg-blue-600 text-white px-3 py-1 rounded-full btn hover:bg-blue-700'><i class='fas fa-eye mr-1'></i>Lihat</a>";
                                echo "<a href='edit_hewan.php?id={$row['id']}' class='bg-yellow-600 text-white px-3 py-1 rounded-full btn hover:bg-yellow-700'><i class='fas fa-edit mr-1'></i>Edit</a>";
                                echo "<a href='delete_hewan.php?id={$row['id']}' onclick='return confirm(\"Yakin hapus hewan " . htmlspecialchars($row['nama_hewan']) . "?\")' class='bg-red-600 text-white px-3 py-1 rounded-full btn hover:bg-red-700'><i class='fas fa-trash mr-1'></i>Hapus</a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6' class='p-8 text-center text-gray-500'>Belum ada hewan yang ditambahkan.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    
    <script>
        const ctx = document.getElementById('hewanChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($chart_labels); ?>,
                datasets: [{
                    label: 'Jumlah Hewan',
                    data: <?php echo json_encode($chart_values); ?>,
                    backgroundColor: ['#f97316', '#4a7043', '#d97706'],
                    borderColor: ['#ea580c', '#2f855a', '#b45309'],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true, title: { display: true, text: 'Jumlah Hewan' } },
                    x: { title: { display: true, text: 'Jenis Pakan' } }
                }
            }
        });
    </script>
</body>
</html>