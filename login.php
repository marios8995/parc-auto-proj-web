<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoManager Deluxe - Autentificare</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-white min-h-screen flex overflow-hidden">

    <div class="hidden md:flex md:w-1/2 relative bg-[#f8fafc] justify-center items-center overflow-hidden border-r border-gray-100">
        <div class="absolute w-[550px] h-[550px] bg-[#e4efff] rounded-full -top-32 -right-32 opacity-70"></div>
        <div class="absolute w-[600px] h-[600px] bg-[#e6fceb] rounded-full -bottom-40 -left-40 opacity-70"></div>
        <img src="logo.png" alt="AutoManager Deluxe" onerror="this.style.display='none'" class="z-10 relative max-w-[400px] drop-shadow-sm bg-white p-4 rounded-xl">
    </div>

    <div class="w-full md:w-1/2 relative flex flex-col justify-center px-10 sm:px-20 lg:px-32 bg-white">
        
        <div class="max-w-[450px] w-full mx-auto">
            <h1 class="text-[32px] font-bold text-[#0f172a] mb-10">Bine ai venit!</h1>

            <div id="errorBox" class="hidden mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <span id="errorMessage" class="font-medium"></span>
            </div>

            <form id="formLogin" class="flex flex-col gap-6">
                
                <div>
                    <label class="block text-[13px] font-bold text-[#334155] mb-2">Nume Utilizator (Username)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <input type="text" id="username" required placeholder="admin" 
                               class="w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:border-[#2542b8] focus:ring-1 focus:ring-[#2542b8] text-gray-700 placeholder-gray-400 transition-colors">
                    </div>
                </div>

                <div>
                    <label class="block text-[13px] font-bold text-[#334155] mb-2">Parolă</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8V7z"></path></svg>
                        </div>
                        <input type="password" id="password" required placeholder="••••••••" 
                               class="w-full pl-11 pr-11 py-3.5 border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:border-[#2542b8] focus:ring-1 focus:ring-[#2542b8] text-gray-700 placeholder-gray-400 transition-colors">
                    </div>
                </div>

                <button type="submit" id="loginBtn"
                        class="w-full bg-[#1e3a8a] hover:bg-blue-900 text-white font-bold py-3.5 rounded-lg text-[14px] mt-2 shadow-sm transition-colors flex justify-center items-center gap-2">
                    <span>Intră în cont</span>
                    <svg id="loadingSpinner" class="hidden animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
                <div class="mt-6 text-center text-[14px] text-gray-600">
                    Nu ai un cont? 
                    <a href="register.php" class="font-bold text-blue-600 hover:text-blue-800 hover:underline transition-colors">
                        Înregistrează-te aici
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('formLogin').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const usernameInput = document.getElementById('username').value;
            const passwordInput = document.getElementById('password').value;
            
            const errorBox = document.getElementById('errorBox');
            const errorMessage = document.getElementById('errorMessage');
            const loginBtn = document.getElementById('loginBtn');
            const spinner = document.getElementById('loadingSpinner');

            errorBox.classList.add('hidden');
            loginBtn.disabled = true;
            loginBtn.classList.add('opacity-70');
            spinner.classList.remove('hidden');

            try {
                const params = new URLSearchParams();
                params.append('username', usernameInput);
                params.append('password', passwordInput);

                const response = await fetch('http://localhost:8000/api/auth/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: params
                });

                const data = await response.json();

                if (response.ok) {
                    localStorage.setItem('fleet_token', data.access_token);
                    window.location.href = 'index.php';
                } else {
                    errorBox.classList.remove('hidden');
                    errorMessage.textContent = "Nume de utilizator sau parolă greșită.";
                }

            } catch (error) {
                errorBox.classList.remove('hidden');
                errorMessage.textContent = "Verifică dacă API-ul este pornit.";
            } finally {
                loginBtn.disabled = false;
                loginBtn.classList.remove('opacity-70');
                spinner.classList.add('hidden');
            }
        });
    </script>
</body>
</html>