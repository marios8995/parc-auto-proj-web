<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoManager Deluxe - Contact</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-white text-gray-800 min-h-screen flex flex-col">

    <header class="border-b border-gray-50 w-full">
        <div class="max-w-[1100px] mx-auto px-8 py-5 grid grid-cols-3 items-center">
            
            <div class="flex justify-start">
                <a href="index.php">
                    <img src="logo.png" alt="AutoManager Deluxe" class="h-20 object-contain drop-shadow-sm">
                </a>
            </div>

            <nav class="flex justify-center gap-10 text-[14px] font-semibold">
                <a href="index.php" class="text-gray-500 hover:text-gray-800 transition-colors">Acasă</a>
                <a href="contact.php" class="text-[#253bb8] font-bold">Contact</a>
            </nav>

            <div></div>
        </div>
    </header>

    <main class="flex-1 max-w-[1100px] mx-auto w-full px-8 py-16 flex flex-col md:flex-row gap-16 md:gap-32">
        
        <div class="w-full md:w-1/3 flex flex-col gap-12 mt-2">
            
            <div>
                <h2 class="text-[#253bb8] font-bold uppercase tracking-wide text-[14px] mb-5">
                    Contactează-ne
                </h2>
                <div class="flex flex-col gap-2.5 text-[15px] text-gray-600 font-medium">
                    <a href="mailto:contact@automanager.ro" class="text-gray-600 hover:text-[#2542b8] transition-colors">
                        contact@automanager.ro
                    </a>
                    <p>+40 727 696 069</p>
                    <p>Sibiu, România</p>
                </div>
            </div>

            <div>
                <h3 class="text-gray-400 font-bold text-[15px] mb-3">
                    Program de lucru
                </h3>
                <div class="flex flex-col gap-1.5 text-[14px] text-gray-500 font-medium">
                    <p>Luni - Vineri: 08:00 - 18:00</p>
                    <p>Sâmbătă: 09:00 - 14:00</p>
                    <p class="text-[#ef4444]">Duminică: Închis</p>
                </div>
            </div>

        </div>

        <div class="w-full md:w-2/3">
            <form id="formContact" class="flex flex-col gap-5 max-w-[480px]">
                
                <div>
                    <label class="block text-[13px] font-bold text-[#374151] mb-2">Nume și Prenume</label>
                    <input type="text" required 
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-md text-[14px] focus:outline-none focus:border-[#253bb8] focus:ring-1 focus:ring-[#253bb8] bg-[#fbfcfd] transition-colors">
                </div>

                <div>
                    <label class="block text-[13px] font-bold text-[#374151] mb-2">Adresă Email</label>
                    <input type="email" required 
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-md text-[14px] focus:outline-none focus:border-[#253bb8] focus:ring-1 focus:ring-[#253bb8] bg-[#fbfcfd] transition-colors">
                </div>

                <div>
                    <label class="block text-[13px] font-bold text-[#374151] mb-2">Mesajul tău</label>
                    <textarea rows="4" required 
                              class="w-full px-4 py-3 border border-gray-200 rounded-md text-[14px] focus:outline-none focus:border-[#253bb8] focus:ring-1 focus:ring-[#253bb8] bg-[#fbfcfd] resize-none transition-colors"></textarea>
                </div>

                <div class="mt-2">
                    <button type="submit" 
                            class="bg-[#253bb8] hover:bg-[#1a2c8a] text-white font-bold py-2.5 px-8 rounded-md text-[14px] shadow-sm transition-colors">
                        Trimite Mesaj
                    </button>
                </div>

            </form>
        </div>

    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const formContact = document.getElementById('formContact');
            
            formContact.addEventListener('submit', (e) => {
                e.preventDefault();
                alert('Mesajul tău a fost trimis cu succes! Te vom contacta în scurt timp.');
                formContact.reset();
            });
        });
    </script>
</body>
</html>