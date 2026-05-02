<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// If already logged in, go straight to dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: index.php?page=dashboard");
    exit();
}

require_once __DIR__ . '/../config/db.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email         = trim($_POST['email'] ?? '');
    $password      = $_POST['password'] ?? '';
    $selected_role = $_POST['role'] ?? 'student';

    if (!empty($email) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT * FROM tblusers WHERE email = ? AND role = ? LIMIT 1");
        $stmt->execute([$email, $selected_role]);
        $user = $stmt->fetch();

        // Supports both plain-text passwords (dev) and hashed passwords (production)
        $password_ok = false;
        if ($user) {
            if (password_verify($password, $user['password'])) {
                $password_ok = true;
            } elseif ($password === $user['password']) {
                // plain-text fallback (your current DB has plain text)
                $password_ok = true;
            }
        }

        if ($password_ok) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role']    = $user['role'];
            $_SESSION['email']   = $user['email'];

            header("Location: index.php?page=dashboard");
            exit();
        } else {
            $error = "Invalid email, password, or role selection.";
        }
    } else {
        $error = "Please fill in all fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CIT University - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        citred: '#DC3545',
                        citdarkred: '#c82333',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans antialiased text-gray-900 bg-white min-h-screen flex m-0 overflow-x-hidden">

<div class="flex flex-col md:flex-row min-h-screen w-full">

    <!-- Left Side Image -->
    <div class="hidden md:flex w-1/2 relative flex-col items-center justify-center min-h-screen">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('images/cit-building.png');"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-[#E86464]/90 to-[#800000]/95 mix-blend-multiply"></div>

        <a href="index.php?page=landing" class="absolute top-10 left-10 text-white hover:text-gray-200 text-[15px] font-bold flex items-center gap-2 z-20 transition-all hover:-translate-x-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            back
        </a>

        <div class="relative z-10 flex flex-col items-center text-center px-8 w-full max-w-lg">
            <div class="w-56 h-56 relative flex items-center justify-center mb-8 drop-shadow-2xl">
                <img src="images/cit-logo.png" alt="CIT Logo" class="w-full h-full object-contain">
            </div>
            <h1 class="text-white text-4xl lg:text-5xl font-black tracking-widest mb-2 shadow-black drop-shadow-lg">CIT UNIVERSITY</h1>
            <h2 class="text-white text-4xl lg:text-5xl font-black tracking-widest shadow-black drop-shadow-lg">LOST & FOUND</h2>
        </div>
    </div>

    <!-- Right Side Form -->
    <div class="w-full md:w-1/2 flex flex-col justify-center items-center p-8 lg:p-16 bg-white relative min-h-screen">

        <div class="w-full max-w-[460px] bg-white p-10 rounded-[1.5rem] shadow-[0_8px_30px_rgb(0,0,0,0.06)] border border-gray-100">
            <h2 class="text-[28px] font-extrabold text-gray-900 mb-2">Log In</h2>
            <p class="text-[14px] text-gray-500 mb-8 font-medium">Please select your role and enter your credentials to Log In</p>

            <!-- Error message -->
            <?php if (!empty($error)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6 text-sm" role="alert">
                    <span class="block sm:inline"><?= htmlspecialchars($error) ?></span>
                </div>
            <?php endif; ?>

            <form id="login-form" action="index.php?page=login" method="POST" class="space-y-6">
                <input type="hidden" name="role" id="selected-role" value="student">

                <!-- Role selector -->
                <div class="grid grid-cols-3 gap-4 mb-8">
                    <button type="button" id="btn-student" class="role-btn bg-citred text-white border-transparent shadow-md hover:bg-citdarkred py-4 rounded-xl flex flex-col items-center justify-center gap-2.5 transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-7 h-7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                        </svg>
                        <span class="text-[11px] font-bold tracking-wider uppercase">STUDENT</span>
                    </button>

                    <button type="button" id="btn-faculty" class="role-btn bg-white text-gray-700 border border-gray-200 shadow-[0_2px_10px_rgba(0,0,0,0.04)] hover:bg-gray-50 py-4 rounded-xl flex flex-col items-center justify-center gap-2.5 transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-7 h-7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                        </svg>
                        <span class="text-[11px] font-bold tracking-wider uppercase">FACULTY</span>
                    </button>

                    <button type="button" id="btn-admin" class="role-btn bg-white text-gray-700 border border-gray-200 shadow-[0_2px_10px_rgba(0,0,0,0.04)] hover:bg-gray-50 py-4 rounded-xl flex flex-col items-center justify-center gap-2.5 transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-7 h-7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                        <span class="text-[11px] font-bold tracking-wider uppercase">ADMIN</span>
                    </button>
                </div>

                <div class="space-y-5">
                    <div>
                        <label class="block text-[13px] font-bold text-gray-700 mb-2 uppercase tracking-wide">Email address</label>
                        <input type="email" name="email" placeholder="name@cit.edu" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg text-[15px] text-gray-900 placeholder-gray-400 focus:outline-none focus:border-citred focus:ring-2 focus:ring-citred/20 transition-all shadow-sm">
                    </div>
                    <div>
                        <label class="block text-[13px] font-bold text-gray-700 mb-2 uppercase tracking-wide">Password</label>
                        <input type="password" name="password" placeholder="••••••••" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg text-[15px] text-gray-900 placeholder-gray-400 focus:outline-none focus:border-citred focus:ring-2 focus:ring-citred/20 transition-all shadow-sm">
                    </div>
                </div>

                <div class="pt-4 flex flex-col gap-3.5">
                    <button type="submit" class="w-full bg-citred hover:bg-citdarkred text-white font-bold py-3.5 rounded-lg shadow-lg text-[15px] transition-all hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        Log In
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </button>

                    <a href="index.php?page=guest-dashboard" class="w-full block text-center bg-white border-2 border-gray-200 text-gray-800 font-bold py-3 rounded-lg shadow-sm text-[15px] hover:bg-gray-50 hover:border-gray-300 transition-all">
                        Continue as Guest
                    </a>
                </div>
            </form>

            <p class="text-center text-[13px] font-semibold text-gray-600 mt-8">
                Don't have an account? <a href="#" class="text-citred hover:underline ml-1">Contact Admin</a>
            </p>
        </div>
    </div>
</div>

<script>
    const btnStudent = document.getElementById('btn-student');
    const btnFaculty = document.getElementById('btn-faculty');
    const btnAdmin   = document.getElementById('btn-admin');
    const roleInput  = document.getElementById('selected-role');

    const activeClasses   = ['bg-citred', 'text-white', 'border-transparent', 'shadow-md'];
    const inactiveClasses = ['bg-white', 'text-gray-700', 'border-gray-200', 'shadow-[0_2px_10px_rgba(0,0,0,0.04)]'];

    function selectRole(roleValue, clickedBtn) {
        roleInput.value = roleValue;
        [btnStudent, btnFaculty, btnAdmin].forEach(btn => {
            btn.classList.remove(...activeClasses);
            btn.classList.add(...inactiveClasses, 'hover:bg-gray-50');
        });
        clickedBtn.classList.remove(...inactiveClasses, 'hover:bg-gray-50');
        clickedBtn.classList.add(...activeClasses);
    }

    btnStudent.addEventListener('click', () => selectRole('student', btnStudent));
    btnFaculty.addEventListener('click', () => selectRole('faculty', btnFaculty));
    btnAdmin.addEventListener('click',   () => selectRole('admin',   btnAdmin));
</script>

</body>
</html>