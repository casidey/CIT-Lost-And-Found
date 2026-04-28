<?php require 'includes/header.php'; ?>

<div class="flex h-screen w-full bg-white">
    <!-- Left Side: Red Gradient -->
    <div class="hidden md:flex w-1/2 flex-col justify-center items-center bg-gradient-to-br from-[#E54B4B] to-[#B22222] relative overflow-hidden">
        <div class="absolute inset-0 opacity-20 bg-[url('https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&q=80')] bg-cover mix-blend-overlay"></div>
        <div class="relative z-10 flex flex-col items-center text-center">
            <div class="w-24 h-24 bg-white p-1 rounded-full shadow-lg mb-4 flex items-center justify-center">
                <div class="w-full h-full bg-yellow-500 rounded-full flex items-center justify-center text-white text-3xl"><i class="fa-solid fa-graduation-cap"></i></div>
            </div>
            <h1 class="text-white text-2xl font-bold tracking-widest">CIT UNIVERSITY</h1>
            <p class="text-white text-xl font-light tracking-widest">LOST & FOUND</p>
        </div>
    </div>

    <!-- Right Side: Login Form -->
    <div class="w-full md:w-1/2 flex flex-col justify-center items-center p-8 relative">
        <a href="?page=landing" class="absolute top-8 left-8 text-gray-400 hover:text-citred text-sm font-semibold transition">← back</a>
        
        <div class="w-full max-w-sm bg-white p-8 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-50">
            <h2 class="text-2xl font-bold mb-1">Log In</h2>
            <p class="text-xs text-gray-400 mb-6">Please select your role and enter your credentials to Log In</p>

            <!-- IMPORTANT: Added id="login-form" -->
            <form id="login-form" action="?page=dashboard" method="POST" class="space-y-4">
                <input type="hidden" name="role" id="selected-role" value="student">

                <!-- Role Selector -->
                <div class="grid grid-cols-3 gap-2 mb-6">
                    <button type="button" id="btn-student" class="role-btn bg-citred text-white border border-transparent py-2 rounded shadow-sm text-xs flex flex-col items-center gap-1 transition duration-200">
                        <i class="fa-solid fa-user-graduate"></i> STUDENT
                    </button>
                    <button type="button" id="btn-faculty" class="role-btn bg-white text-gray-500 border border-gray-200 hover:bg-gray-50 py-2 rounded text-xs flex flex-col items-center gap-1 transition duration-200">
                        <i class="fa-solid fa-chalkboard-user"></i> FACULTY
                    </button>
                    <button type="button" id="btn-admin" class="role-btn bg-white text-gray-500 border border-gray-200 hover:bg-gray-50 py-2 rounded text-xs flex flex-col items-center gap-1 transition duration-200">
                        <i class="fa-solid fa-user-tie"></i> ADMIN
                    </button>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Email address</label>
                    <input type="email" placeholder="example@cit.edu" class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:border-citred focus:ring-1 focus:ring-citred transition">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Password</label>
                    <input type="password" placeholder="••••••••" class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:border-citred focus:ring-1 focus:ring-citred transition">
                </div>
                
                <button type="submit" class="w-full bg-citred hover:bg-citdarkred text-white font-semibold py-2.5 rounded shadow-md text-sm transition mt-2">Log In →</button>
                
                <!-- IMPORTANT: Updated Guest Button href -->
                <a href="?page=guest" class="w-full block text-center bg-white border border-gray-300 text-gray-700 font-semibold py-2.5 rounded shadow-sm text-sm hover:bg-gray-50 transition">Continue as Guest</a>
            </form>
            
            <p class="text-center text-[10px] text-gray-500 mt-6">Don't have an account? <a href="#" class="text-citred font-bold hover:underline">Contact Admin</a></p>
        </div>
    </div>
</div>

<script>
    const btnStudent = document.getElementById('btn-student');
    const btnFaculty = document.getElementById('btn-faculty');
    const btnAdmin = document.getElementById('btn-admin');
    const roleInput = document.getElementById('selected-role');
    const loginForm = document.getElementById('login-form'); // Added form reference

    const activeClasses =['bg-citred', 'text-white', 'border-transparent', 'shadow-sm'];
    const inactiveClasses =['bg-white', 'text-gray-500', 'border-gray-200', 'hover:bg-gray-50'];

    function selectRole(roleValue, clickedBtn) {
        roleInput.value = roleValue;

        // Change the form destination based on the role selected!
        if (roleValue === 'admin') {
            loginForm.action = '?page=admin';
        } else {
            loginForm.action = '?page=dashboard'; // Student & Faculty share the main dashboard
        }

        const allButtons =[btnStudent, btnFaculty, btnAdmin];
        allButtons.forEach(btn => {
            btn.classList.remove(...activeClasses);
            btn.classList.add(...inactiveClasses);
        });

        clickedBtn.classList.remove(...inactiveClasses);
        clickedBtn.classList.add(...activeClasses);
    }

    btnStudent.addEventListener('click', () => selectRole('student', btnStudent));
    btnFaculty.addEventListener('click', () => selectRole('faculty', btnFaculty));
    btnAdmin.addEventListener('click', () => selectRole('admin', btnAdmin));
</script>

</body>
</html>