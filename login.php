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
        
        <img src="logo.png" alt="AutoManager Deluxe" class="z-10 relative max-w-[400px] drop-shadow-sm bg-white p-4 rounded-xl">
    </div>

    <div class="w-full md:w-1/2 relative flex flex-col justify-center px-10 sm:px-20 lg:px-32 bg-white">
        
        <a href="index.php" class="absolute top-10 right-10 flex items-center gap-2 text-[14px] text-gray-500 hover:text-gray-900 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Înapoi
        </a>

        <div class="max-w-[450px] w-full mx-auto">
            <h1 class="text-[32px] font-bold text-[#0f172a] mb-10">Bine ai venit!</h1>

            <form id="formLogin" class="flex flex-col gap-6">
                
                <div>
                    <label class="block text-[13px] font-bold text-[#334155] mb-2">Adresă de E-mail</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <input type="email" required placeholder="gigi24234@gmail.com" 
                               class="w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:border-[#2542b8] focus:ring-1 focus:ring-[#2542b8] text-gray-700 placeholder-gray-400 transition-colors">
                    </div>
                </div>

                <div>
                    <label class="block text-[13px] font-bold text-[#334155] mb-2">Parolă</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8V7z"></path></svg>
                        </div>
                        <input type="password" required placeholder="••••••••" 
                               class="w-full pl-11 pr-11 py-3.5 border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:border-[#2542b8] focus:ring-1 focus:ring-[#2542b8] text-gray-700 placeholder-gray-400 transition-colors">
                        
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center cursor-pointer text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between text-[13px]">
                    <label class="flex items-center gap-2 cursor-pointer text-gray-600">
                        <input type="checkbox" checked class="w-4 h-4 rounded border-gray-300 text-[#1d3596] focus:ring-[#1d3596] cursor-pointer">
                        Ține-mă minte
                    </label>
                    <a href="#" class="text-[#2542b8] font-bold hover:underline">Ai uitat parola?</a>
                </div>

                <button type="submit" 
                        class="w-full bg-[#1e3a8a] hover:bg-blue-900 text-white font-bold py-3.5 rounded-lg text-[14px] mt-2 shadow-sm transition-colors">
                    Intră în cont
                </button>

            </form>

            <div class="text-center mt-8 text-[13px] text-gray-500 flex flex-col gap-1 items-center">
                <span>Nu ai cont ?</span>
                <a href="register.php" class="text-[#1e3a8a] font-bold border-b border-dashed border-[#1e3a8a] hover:text-blue-900 transition-colors pb-0.5">
                    Înregistrează-te
                </a>
            </div>
        </div>

    </div>

    <script>
        document.getElementById('formLogin').addEventListener('submit', function(e) {
            e.preventDefault();
            // Când apasă "Intră în cont", îl ducem pe pagina principală a aplicației (Acasă)
            window.location.href = 'index.php';
        });
    </script>
</body>
</html>