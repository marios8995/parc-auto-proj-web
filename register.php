<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoManager Deluxe - Creează Cont</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-[#f8fafc] min-h-screen flex flex-col items-center justify-center p-4">

    <div class="bg-white rounded-[20px] shadow-[0_8px_30px_rgb(0,0,0,0.04)] w-full max-w-[460px] p-10">
        
        <h2 class="text-[22px] font-bold text-center text-[#1e293b] mb-6">
            Creează Cont AutoManager
        </h2>

        <div id="errorBox" class="hidden mb-6 p-4 text-[13px] text-red-800 rounded-lg bg-red-50 border border-red-200">
            <span id="errorMsg" class="font-bold"></span>
        </div>

        <form id="formInregistrare" class="flex flex-col gap-5">
            
            <div>
                <label class="block text-[13px] text-gray-600 mb-1.5">Nume Utilizator (Username) <span class="text-red-500">*</span></label>
                <input type="text" id="regUsername" required placeholder="ex: admin_flota"
                       class="w-full px-4 py-3 bg-[#f8fafc] border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:border-[#2542b8] focus:bg-white transition-colors">
            </div>

            <div>
                <label class="block text-[13px] text-gray-600 mb-1.5">Adresă Email <span class="text-red-500">*</span></label>
                <input type="email" id="regEmail" required placeholder="contact@firma.ro"
                       class="w-full px-4 py-3 bg-[#f8fafc] border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:border-[#2542b8] focus:bg-white transition-colors">
            </div>

            <div>
                <label class="block text-[13px] text-gray-600 mb-1.5">Parolă <span class="text-red-500">*</span></label>
                <input type="password" id="regPassword" required placeholder="Minim 8 caractere"
                       class="w-full px-4 py-3 bg-[#f8fafc] border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:border-[#2542b8] focus:bg-white transition-colors">
                <p class="text-[11px] text-gray-400 mt-1.5">Parola trebuie să conțină minim o cifră și o literă mare.</p>
            </div>

            <button type="submit" id="btnSubmit"
                    class="w-full bg-[#1d3596] hover:bg-blue-800 text-white font-bold py-3.5 rounded-lg text-[14px] mt-2 transition-colors flex justify-center items-center gap-2">
                <span>Creează contul</span>
            </button>

        </form>

        <p class="text-center text-[13px] text-gray-500 mt-6">
            Ai deja cont? 
            <a href="login.php" class="text-[#1d3596] font-bold hover:underline">Autentifică-te aici</a>
        </p>

    </div>

    <script>
        document.getElementById('formInregistrare').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const btnSubmit = document.getElementById('btnSubmit');
            const errorBox = document.getElementById('errorBox');
            const errorMsg = document.getElementById('errorMsg');
            
            errorBox.classList.add('hidden');
            btnSubmit.disabled = true;
            btnSubmit.classList.add('opacity-75');

            const userData = {
                username: document.getElementById('regUsername').value,
                email: document.getElementById('regEmail').value,
                password: document.getElementById('regPassword').value,
                is_active: true,
                role: "USER"
            };

            try {
                const res = await fetch('http://localhost:8000/api/accounts/register', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(userData)
                });

                if (res.ok) {
                    alert('Contul a fost creat cu succes! Te poți autentifica.');
                    window.location.href = 'login.php';
                } else {
                    const err = await res.json();
                    errorBox.classList.remove('hidden');
                    
                    // Tratăm erorile de validare de la Pydantic (ex: parola prea slabă)
                    if (err.detail && Array.isArray(err.detail)) {
                        errorMsg.textContent = "Eroare: " + err.detail[0].msg;
                    } else if (err.detail) {
                        errorMsg.textContent = err.detail; // Erorile tale custom (ex: Email deja folosit)
                    } else {
                        errorMsg.textContent = "A apărut o eroare la crearea contului.";
                    }
                }
            } catch (error) {
                errorBox.classList.remove('hidden');
                errorMsg.textContent = "Nu s-a putut contacta serverul.";
            } finally {
                btnSubmit.disabled = false;
                btnSubmit.classList.remove('opacity-75');
            }
        });
    </script>
</body>
</html>