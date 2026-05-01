<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CIT University - Lost & Found</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,700;1,800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        citred: '#DE2027',
                        citdarkred: '#b8171d',
                        citlightred: '#fce8e8',
                        footerbg: '#DC6E6E',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #fcfcfc; scroll-behavior: smooth; }
        
        /* 
           Gradient fades from solid white on the left (for text readability) 
           to mostly transparent on the right (so the building shows clearly).
        */
        .hero-bg {
            background-image: linear-gradient(to right, rgba(255, 255, 255, 0.98) 0%, rgba(255, 255, 255, 0.85) 45%, rgba(255, 255, 255, 0.15) 100%), url('images/cit-building.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>
<body class="antialiased text-gray-800 font-sans overflow-x-hidden">

<!-- Navbar -->
<nav class="bg-white py-5 px-8 lg:px-16 flex justify-between items-center w-full shadow-sm sticky top-0 z-50">
    <div class="flex items-center gap-4 cursor-pointer">
        <img src="images/cit-logo.png" alt="CIT Logo" class="w-14 h-14 object-contain">
        <div class="flex flex-col">
            <span class="font-extrabold text-[15px] leading-tight text-gray-900 tracking-wide">CIT UNIVERSITY</span>
            <span class="font-extrabold text-[15px] leading-tight text-gray-900 tracking-wide">LOST & FOUND</span>
        </div>
    </div>
    
    <div class="hidden md:flex gap-10 text-[13px] font-bold text-gray-700 tracking-wider">
        <a href="#" class="text-citred transition-colors hover:opacity-80">HOME</a>
        <a href="#how-it-works" class="hover:text-citred transition-colors">HOW IT WORKS</a>
        <a href="#features" class="hover:text-citred transition-colors">FEATURES</a>
    </div>
    
    <!-- Clickable Login Button -->
    <a href="?page=login" class="bg-citred hover:bg-citdarkred text-white text-[14px] font-bold py-3 px-8 rounded shadow transition-all tracking-wide">LOG IN</a>
</nav>

<!-- Hero Section -->
<main class="relative hero-bg">
    <div class="max-w-[1490px] mx-auto px-8 lg:px-16 py-12 lg:py-20 grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center min-h-[85vh]">
        
        <!-- Left Content -->
        <div class="lg:col-span-6 z-10 pt-10 lg:pt-0">
            <div class="bg-citred text-white text-[12px] font-bold px-3 py-1.5 rounded-md inline-flex items-center gap-2 tracking-widest uppercase mb-8 shadow-sm">
                <div class="w-1.5 h-1.5 bg-white rounded-full"></div>
                CIT Lost & Found
            </div>
            
            <h1 class="text-[48px] lg:text-[64px] font-black text-gray-900 leading-[1.1] mb-6 tracking-tight">
                LOST AND FOUND FOR<br>
                <span class="text-citred">CIT UNIVERSITY</span>
            </h1>
            
            <p class="text-gray-700 text-[16px] lg:text-[18px] mb-10 leading-[1.8] max-w-[600px] font-medium drop-shadow-sm">
                Our University Lost and Found System is a centralized web-based platform designed to help students and staff easily report, search, and recover lost belongings within the campus. Our platform simplifies the process by providing a secure and organized way to connect item owners with finders.
            </p>
            
            <div class="flex flex-wrap gap-5">
                <a href="?page=login" class="bg-citred hover:bg-citdarkred text-white text-[14px] font-bold py-4 px-8 rounded shadow-lg flex items-center gap-3 transition-transform hover:-translate-y-1">
                    GET STARTED 
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
                <a href="#how-it-works" class="bg-white border-2 border-gray-200 hover:bg-gray-50 text-gray-800 text-[14px] font-bold py-4 px-8 rounded shadow-sm transition-all tracking-wide">LEARN MORE</a>
            </div>
        </div>
        
        <!-- Right Image Layout -->
        <div class="lg:col-span-6 relative flex justify-center items-center w-full min-h-[500px] lg:min-h-[650px] mt-16 lg:mt-0">
            
            <!-- FIXED: The White Background Card -->
            <!-- Adjusted dimensions and rotation to perfectly frame the students -->
            
            <div class="absolute w-[400px] sm:w-[500px] lg:w-[750px] h-[220px] sm:h-[320px] lg:h-[400px] bg-white rounded-[2.5rem] shadow-2xl transform rotate-[-174deg] right-32 lg:-right-32 top-32 lg:top-32 z-0"></div>
            <!-- FIXED: Students Image -->
            <!-- Significantly scaled up to be large, and translated so their heads and bodies pop over the edges of the card -->
            <img src="images/students.png" alt="CIT Students" class="relative z-10 w-[125%] lg:w-[145%] max-w-none h-auto object-contain drop-shadow-2xl transform lg:-translate-x-12 translate-y-6 lg:translate-y-12">
            
        </div>

    </div>
</main>

<!-- Features Section -->
<section id="features" class="max-w-[1400px] mx-auto px-8 lg:px-16 py-24 text-center">
    <p class="text-citred text-[13px] font-extrabold uppercase tracking-widest mb-4">WHY USE LOST & FOUND</p>
    <h2 class="text-[36px] lg:text-[42px] font-black italic mb-6 tracking-tight text-gray-900">A Smarter Way to Find What's Lost</h2>
    <p class="text-gray-600 text-[16px] mb-16 max-w-3xl mx-auto font-medium">A centralized web-based platform that helps students and staff report, search, and recover lost items within the university campus.</p>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Feature 1 -->
        <div class="bg-white p-10 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 text-left hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all">
            <div class="w-16 h-16 bg-citlightred flex items-center justify-center rounded-2xl mb-6">
                <!-- Shield Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8 text-citred">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21.75c-4.478 0-8.268-2.943-9.542-7.24a.75.75 0 01.121-.715 11.968 11.968 0 0118.842 0 .75.75 0 01.121.715C20.268 18.807 16.478 21.75 12 21.75z" />
                </svg>
            </div>
            <h3 class="font-bold text-[16px] text-gray-900 mb-4 tracking-wide uppercase">Secure and Verified System</h3>
            <p class="text-gray-500 text-[14px] leading-[1.7]">Only registered university students and staff can access the system, reducing false reports and improving reliability.</p>
        </div>
        <!-- Feature 2 -->
        <div class="bg-white p-10 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 text-left hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all">
            <div class="w-16 h-16 bg-citlightred flex items-center justify-center rounded-2xl mb-6">
                <!-- Lightning Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8 text-citred">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                </svg>
            </div>
            <h3 class="font-bold text-[16px] text-gray-900 mb-4 tracking-wide uppercase">Fast and Organized Process</h3>
            <p class="text-gray-500 text-[14px] leading-[1.7]">All reports are stored in one centralized database, making it easier to search and track lost or found items.</p>
        </div>
        <!-- Feature 3 -->
        <div class="bg-white p-10 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 text-left hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all">
            <div class="w-16 h-16 bg-citlightred flex items-center justify-center rounded-2xl mb-6">
                <!-- Check Circle Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8 text-citred">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="font-bold text-[16px] text-gray-900 mb-4 tracking-wide uppercase">Higher Chance of Recovery</h3>
            <p class="text-gray-500 text-[14px] leading-[1.7]">With detailed reporting, image uploads, and administrator approval, items have a greater chance of being returned to their rightful owners.</p>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section id="how-it-works" class="max-w-[1400px] mx-auto px-8 lg:px-16 py-24 text-center">
    <p class="text-citred text-[13px] font-extrabold uppercase tracking-widest mb-4">HOW IT WORKS</p>
    <h2 class="text-[36px] lg:text-[42px] font-black italic mb-6 tracking-tight text-gray-900 max-w-4xl mx-auto leading-[1.2]">
        Don't worry. In three easy steps, you can report, search, and recover your item safely.
    </h2>
    <p class="text-gray-600 text-[16px] mb-16 max-w-3xl mx-auto font-medium">A centralized web-based platform that helps students and staff report, search, and recover lost items within the university campus.</p>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Step 1 -->
        <div class="bg-white p-10 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 text-left hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all">
            <div class="w-16 h-16 bg-citlightred flex items-center justify-center rounded-2xl mb-6">
                <!-- Using uniform shield icon for steps as per design -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8 text-citred">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21.75c-4.478 0-8.268-2.943-9.542-7.24a.75.75 0 01.121-.715 11.968 11.968 0 0118.842 0 .75.75 0 01.121.715C20.268 18.807 16.478 21.75 12 21.75z" />
                </svg>
            </div>
            <h3 class="font-bold text-[16px] text-gray-900 mb-4 tracking-wide uppercase">Step 1 : Sign In</h3>
            <p class="text-gray-500 text-[14px] leading-[1.7]">Students must sign in using their university account before posting or claiming an item. This ensures that only authorized users can access the system and submit reports.</p>
        </div>
        <!-- Step 2 -->
        <div class="bg-white p-10 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 text-left hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all">
            <div class="w-16 h-16 bg-citlightred flex items-center justify-center rounded-2xl mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8 text-citred">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21.75c-4.478 0-8.268-2.943-9.542-7.24a.75.75 0 01.121-.715 11.968 11.968 0 0118.842 0 .75.75 0 01.121.715C20.268 18.807 16.478 21.75 12 21.75z" />
                </svg>
            </div>
            <h3 class="font-bold text-[16px] text-gray-900 mb-4 tracking-wide uppercase">Step 2 : Post or Search Items</h3>
            <p class="text-gray-500 text-[14px] leading-[1.7]">Users can report a lost or found item by filling out the required details such as title, description, category, date, and location. An image upload is also required. Users may also browse using filters.</p>
        </div>
        <!-- Step 3 -->
        <div class="bg-white p-10 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 text-left hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all">
            <div class="w-16 h-16 bg-citlightred flex items-center justify-center rounded-2xl mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8 text-citred">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21.75c-4.478 0-8.268-2.943-9.542-7.24a.75.75 0 01.121-.715 11.968 11.968 0 0118.842 0 .75.75 0 01.121.715C20.268 18.807 16.478 21.75 12 21.75z" />
                </svg>
            </div>
            <h3 class="font-bold text-[16px] text-gray-900 mb-4 tracking-wide uppercase">Step 3 : Claim and Verification</h3>
            <p class="text-gray-500 text-[14px] leading-[1.7]">If a user finds their lost item in the system, they can submit a claim request with proof of ownership. The administrator reviews the request and verifies the claim before marking the item as returned.</p>
        </div>
    </div>
</section>

<!-- Detailed Footer Section -->
<footer class="bg-footerbg text-white pt-16 pb-8 border-t-8 border-citdarkred mt-12">
    <div class="max-w-[1400px] mx-auto px-8 lg:px-16">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
            <!-- Brand Column -->
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center gap-4 mb-6">
                    <img src="images/cit-logo.png" alt="CIT Logo" class="w-14 h-14 object-contain bg-white rounded-full p-1 border-2 border-white">
                    <div class="flex flex-col">
                        <span class="font-extrabold text-[16px] leading-tight tracking-wide">CIT UNIVERSITY</span>
                        <span class="font-medium text-[14px] text-white/90">LOST & FOUND</span>
                    </div>
                </div>
                <p class="text-white/80 text-[14px] leading-relaxed max-w-sm mb-6">
                    A dedicated platform to help our university community retrieve lost items securely and efficiently. We are committed to building a safer campus environment.
                </p>
                <div class="flex gap-4">
                    <a href="#" class="w-10 h-10 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center transition-colors">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                    </a>
                    <a href="#" class="w-10 h-10 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center transition-colors">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div>
                <h4 class="font-bold text-[16px] mb-6 uppercase tracking-wider">Quick Links</h4>
                <ul class="space-y-3 text-[14px] text-white/80">
                    <li><a href="#" class="hover:text-white hover:underline transition-all">Home</a></li>
                    <li><a href="#how-it-works" class="hover:text-white hover:underline transition-all">How It Works</a></li>
                    <li><a href="#features" class="hover:text-white hover:underline transition-all">Features</a></li>
                    <li><a href="?page=login" class="hover:text-white hover:underline transition-all">Report Lost Item</a></li>
                    <li><a href="?page=login" class="hover:text-white hover:underline transition-all">Browse Found Items</a></li>
                </ul>
            </div>
            
            <!-- Support Column -->
            <div>
                <h4 class="font-bold text-[16px] mb-6 uppercase tracking-wider">Support</h4>
                <ul class="space-y-3 text-[14px] text-white/80">
                    <li><a href="#" class="hover:text-white hover:underline transition-all">FAQ</a></li>
                    <li><a href="#" class="hover:text-white hover:underline transition-all">Terms of Service</a></li>
                    <li><a href="#" class="hover:text-white hover:underline transition-all">Privacy Policy</a></li>
                    <li class="pt-4 mt-2 border-t border-white/20">
                        <p class="flex items-center gap-2 mb-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg> support@cit.edu</p>
                        <p class="flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg> +1 (234) 567-890</p>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Copyright Bottom -->
        <div class="border-t border-white/20 pt-6 flex flex-col md:flex-row justify-between items-center text-[12px] text-white/60">
            <p>&copy; 2023 CIT University Lost & Found. All rights reserved.</p>
            <p class="mt-2 md:mt-0">Designed securely for the campus community.</p>
        </div>
    </div>
</footer>

</body>
</html>