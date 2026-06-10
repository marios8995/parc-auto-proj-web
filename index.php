<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoManager Deluxe - Acasă</title>
    
    <!-- Fontul Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-white text-gray-800 min-h-screen flex flex-col">

    <!-- Meniul de Navigare (Sus) -->
    <nav class="flex justify-center items-center gap-10 py-8 text-[14px] font-semibold">
        <!-- Link către pagina principală -->
        <a href="index.php" class="text-blue-500 hover:text-blue-700 transition-colors">Acasă</a>
        <!-- Link către Contact -->
        <a href="contact.php" class="text-gray-500 hover:text-gray-800 transition-colors">Contact</a>
        <!-- Link către Login -->
        <a href="login.php" class="text-gray-500 hover:text-gray-800 transition-colors">Log in</a>
    </nav>

    <!-- Conținutul Principal -->
    <main class="flex-1 max-w-6xl mx-auto w-full px-6">
        
        <!-- Secțiunea Hero -->
        <section class="flex flex-col md:flex-row items-center justify-between mt-8 mb-20 gap-12">
            
            <!-- Textul din stânga -->
            <div class="w-full md:w-3/5">
                <h1 class="text-[42px] font-bold text-[#00c2a8] mb-6 leading-tight">
                    AutoManager Deluxe
                </h1>
                <p class="text-blue-500 text-[15px] leading-relaxed font-medium pr-10">
                    La AutoManager Deluxe, misiunea noastră este simplă: să eliminăm riscurile și costurile neprevăzute din managementul mașinii tale. Am înțeles că o flotă eficientă nu înseamnă doar mașini pe drum, ci un flux continuu de informații despre asigurări, service și mentenanță. De aceea, am creat o soluție de tip all-in-one care te anunță înainte să expire actele, te ajută să monitorizezi uzura anvelopelor și îți oferă un control total asupra bugetului, totul printr-o interfață intuitivă, creată special pentru manageri exigenți.
                </p>
            </div>

            <!-- Logo-ul din dreapta (Setat corect catre index.php) -->
            <div class="w-full md:w-2/5 flex justify-center md:justify-end">
                <a href="index.php">
                    <img src="logo.png" alt="AutoManager Deluxe Logo" class="w-full max-w-[350px] object-contain opacity-90 drop-shadow-sm">
                </a>
            </div>
            
        </section>

        <!-- Secțiunea Servicii Oferite -->
        <section class="mb-24">
            <h2 class="text-center text-2xl font-bold text-[#1f2937] mb-10">Servicii Oferite</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 max-w-5xl mx-auto">
                <a href="masini.php" class="bg-white border border-gray-100 rounded-2xl h-28 flex items-center justify-center shadow-[0_2px_15px_-3px_rgba(0,0,0,0.05)] hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <span class="text-blue-600 font-bold text-lg">Gestiune mașini</span>
                </a>
                <a href="soferi.php" class="bg-white border border-gray-100 rounded-2xl h-28 flex items-center justify-center shadow-[0_2px_15px_-3px_rgba(0,0,0,0.05)] hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <span class="text-blue-600 font-bold text-lg">Gestiune șoferi</span>
                </a>
                <a href="service.php" class="bg-white border border-gray-100 rounded-2xl h-28 flex items-center justify-center shadow-[0_2px_15px_-3px_rgba(0,0,0,0.05)] hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <span class="text-blue-600 font-bold text-lg">Service auto</span>
                </a>
                <a href="asigurari.php" class="bg-white border border-gray-100 rounded-2xl h-28 flex items-center justify-center shadow-[0_2px_15px_-3px_rgba(0,0,0,0.05)] hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <span class="text-blue-600 font-bold text-lg">Asigurări</span>
                </a>
                <a href="viniete.php" class="bg-white border border-gray-100 rounded-2xl h-28 flex items-center justify-center shadow-[0_2px_15px_-3px_rgba(0,0,0,0.05)] hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <span class="text-blue-600 font-bold text-lg">Viniete</span>
                </a>
                <a href="anvelope.php" class="bg-white border border-gray-100 rounded-2xl h-28 flex items-center justify-center shadow-[0_2px_15px_-3px_rgba(0,0,0,0.05)] hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <span class="text-blue-600 font-bold text-lg">Anvelope</span>
                </a>
            </div>
        </section>

        <!-- Secțiunea Program de Lucru -->
        <section class="max-w-4xl mx-auto mb-16 w-full">
            <div class="bg-[#212b3d] rounded-2xl px-8 py-10 text-center shadow-lg">
                <h3 class="text-white text-xl font-bold mb-6">Program de lucru</h3>
                <div class="text-gray-300 text-[15px] font-medium flex flex-col gap-2">
                    <p>Luni - Vineri: 08:00 - 18:00</p>
                    <p>Sâmbătă: 09:00 - 14:00</p>
                    <p class="text-[#ef4444]">Duminică: Închis</p>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="py-8 text-center text-[11px] font-medium text-gray-500">
        © 2026 AutoManager Deluxe. Toate drepturile rezervate.
    </footer>

</body>
</html>