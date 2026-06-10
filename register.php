<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoManager Deluxe - Creează Cont</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#f8fafc] min-h-screen flex flex-col items-center justify-center p-4">

    <div class="bg-white rounded-[20px] shadow-[0_8px_30px_rgb(0,0,0,0.04)] w-full max-w-[460px] p-10">
        
        <h2 class="text-[22px] font-bold text-center text-[#1e293b] mb-8">
            Creează Cont Firmă
        </h2>

        <form id="formInregistrare" class="flex flex-col gap-5">
            
            <div>
                <label class="block text-[13px] text-gray-600 mb-1.5">Nume Firmă*</label>
                <input type="text" required 
                       class="w-full px-4 py-3 bg-[#f8fafc] border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:border-[#2542b8] focus:bg-white transition-colors">
            </div>

            <div>
                <label class="block text-[13px] text-gray-600 mb-1.5">Nume și Prenume</label>
                <input type="text" 
                       class="w-full px-4 py-3 bg-[#f8fafc] border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:border-[#2542b8] focus:bg-white transition-colors">
            </div>

            <div>
                <label class="block text-[13px] text-gray-600 mb-1.5">Adresă Email</label>
                <input type="email" required 
                       class="w-full px-4 py-3 bg-[#f8fafc] border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:border-[#2542b8] focus:bg-white transition-colors">
            </div>

            <div>
                <label class="block text-[13px] text-gray-600 mb-1.5">Telefon</label>
                <input type="tel" 
                       class="w-full px-4 py-3 bg-[#f8fafc] border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:border-[#2542b8] focus:bg-white transition-colors">
            </div>

            <button type="submit" 
                    class="w-full bg-[#1d3596] hover:bg-blue-800 text-white font-bold py-3.5 rounded-lg text-[14px] mt-2 transition-colors">
                Creează un cont
            </button>

        </form>

        <p class="text-center text-[13px] text-gray-500 mt-6">
            Ai deja cont? 
            <a href="login.php" class="text-[#1d3596] font-bold hover:underline">Autentifică-te aici</a>
        </p>

    </div>

    <script>
        document.getElementById('formInregistrare').addEventListener('submit', function(e) {
            e.preventDefault();
            // Afișăm un mesaj de succes
            alert('Contul a fost creat cu succes! Vei fi redirecționat către pagina de autentificare.');
            // Redirecționăm automat către pagina de login
            window.location.href = 'login.php';
        });
    </script>
</body>
</html>