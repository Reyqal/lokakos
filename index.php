<?php
// session_start();
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Debug: Log semua data POST
    error_log("POST Data: " . print_r($_POST, true));
    
    $email = $_POST['email'];
    $password = $_POST['password'];
    $userType = $_POST['userType'];

    // Debug: Log query parameters
    error_log("Querying user with email: $email and role: $userType");

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND role = ?");
    $stmt->execute([$email, $userType]);
    $user = $stmt->fetch();

    // Debug: Log user data
    error_log("User data found: " . print_r($user, true));

    if ($user && password_verify($password, $user['password'])) {
        // Debug: Log successful login
        error_log("Login successful for user ID: {$user['id']}");
        
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['nama_lengkap'] = $user['nama_lengkap'];

        // Debug: Log session data
        error_log("Session data set: " . print_r($_SESSION, true));

        $redirect = $userType === 'pencari' ? 'pencari/dashboard_pencari.html' : 'pemilik/dashboard_pemilik.html';
        
        // Debug: Log redirect URL
        error_log("Redirecting to: $redirect");

        $response = [
            'status' => 'success',
            'redirect' => $redirect
        ];
    } else {
        // Debug: Log failed login attempt
        error_log("Login failed - User found: " . ($user ? 'Yes' : 'No'));
        if ($user) {
            error_log("Password verification failed for email: $email");
        }

        $response = [
            'status' => 'error',
            'message' => 'Email atau password salah!'
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lokakos - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.2/feather.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #1E3A8A;
        }
        .navi-blue {
            background-color: #1E3A8A;
        }
        .navi-light {
            background-color: #3B82F6;
        }
    </style>

<body class="min-h-screen flex items-center justify-center">
        <div class="w-full max-w-md p-8 space-y-8 bg-white rounded-lg shadow-lg">
        <div class="text-center">
            <h1 class="text-3xl font-bold text-navi-blue">LOKAKOS</h1>
            <p class="mt-2 text-gray-600">Temukan kos impianmu dengan mudah</p>
        </div>
        
        <div class="flex space-x-4 mb-6">
            <button id="btnPencari" class="flex-1 py-2 px-4 rounded-lg bg-blue-500 text-white font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition">
                Pencari Kos
            </button>
            <button id="btnPemilik" class="flex-1 py-2 px-4 rounded-lg bg-gray-200 text-gray-700 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition">
                Pemilik Kos
            </button>
        </div>
        
        <form id="loginForm" class="mt-8 space-y-6">
            <div class="rounded-md shadow-sm space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input id="email" name="email" type="email" required class="py-2 px-3 block w-full border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input id="password" name="password" type="password" required class="py-2 px-3 block w-full border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i data-feather="eye" class="text-gray-400 cursor-pointer" onclick="togglePassword()"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="remember-me" class="ml-2 block text-sm text-gray-700">Ingat saya</label>
                </div>

                <div class="text-sm">
                    <a href="#" class="font-medium text-blue-600 hover:text-blue-500">Lupa password?</a>
                </div>
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Masuk
                </button>
            </div>
        </form>

                <div class="text-center text-sm">
            <span class="text-gray-600">Belum punya akun?</span>
            <a href="register.html" class="font-medium text-blue-600 hover:text-blue-500">Daftar sekarang</a>
        </div>
    </div>

    <script>
        feather.replace();
        
       feather.replace();
        
        let userType = 'pencari';
        document.getElementById('btnPencari').addEventListener('click', function() {
            userType = 'pencari';
            this.classList.remove('bg-gray-200', 'text-gray-700');
            this.classList.add('bg-blue-500', 'text-white');
            document.getElementById('btnPemilik').classList.remove('bg-blue-500', 'text-white');
            document.getElementById('btnPemilik').classList.add('bg-gray-200', 'text-gray-700');
        });
        
        document.getElementById('btnPemilik').addEventListener('click', function() {
            userType = 'pemilik';
            this.classList.remove('bg-gray-200', 'text-gray-700');
            this.classList.add('bg-blue-500', 'text-white');
            document.getElementById('btnPencari').classList.remove('bg-blue-500', 'text-white');
            document.getElementById('btnPencari').classList.add('bg-gray-200', 'text-gray-700');
        });

        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData();
            formData.append('email', document.getElementById('email').value);
            formData.append('password', document.getElementById('password').value);
            formData.append('userType', userType);

            try {
                const response = await fetch('index.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.status === 'success') {
                    // Tampilkan notifikasi sukses
                    await Swal.fire({
                        icon: 'success',
                        title: 'Login Berhasil!',
                        text: 'Selamat datang kembali!',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    // Redirect setelah notifikasi ditutup
                    window.location.href = data.redirect;
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Gagal',
                        text: data.message
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan pada server'
                });
            }
        });

        function togglePassword() {
            const passwordInput = document.getElementById('password');
            passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>
</html>