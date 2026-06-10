<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoManager Deluxe - Gestiune Mașini</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50/30 flex h-screen overflow-hidden text-gray-800">

    <aside class="w-64 bg-white border-r border-gray-100 flex flex-col h-full shrink-0">
        <div class="h-24 flex items-center justify-center border-b border-gray-50 px-6 mb-2">
            <!-- MODIFICAT: Logo trimite acum spre index.php în loc de acasa.php -->
            <a href="index.php">
                <img src="logo.png" alt="AutoManager Deluxe" class="max-h-16 object-contain">
            </a>
        </div>

        <nav class="flex-1 px-4 py-4 flex flex-col gap-1.5 overflow-y-auto">
            <a href="masini.php" class="px-4 py-2.5 text-sm font-bold text-blue-600 bg-blue-50/80 rounded-lg transition-colors">Gestiune mașini</a>
            <a href="soferi.php" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Gestiune șoferi</a>
            <a href="service.php" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Service auto</a>
            <a href="asigurari.php" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Asigurări</a>
            <a href="viniete.php" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Viniete</a>
            <!-- CORECTAT: Anvelope ducea la index.php din greșeală, l-am modificat să ducă la anvelope.php -->
            <a href="anvelope.php" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Anvelope</a>
            <div class="my-2 border-t border-gray-100"></div>
            <!-- MODIFICAT: Despre noi trimite acum spre index.php în loc de despre.php -->
            <a href="index.php" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Despre noi</a>
            <a href="contact.php" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Contact</a>
            <a href="login.php" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors mt-auto mb-4">Log in</a>
        </nav>
    </aside>

    <main class="flex-1 flex flex-col h-full overflow-hidden bg-white">
        
        <header class="bg-white h-20 border-b border-gray-100 flex items-center justify-center shrink-0">
            <h1 class="text-[22px] font-bold text-blue-500">Gestiune mașini</h1>
        </header>

        <div class="flex-1 overflow-y-auto p-8 bg-gray-50/20">
            <div class="max-w-6xl mx-auto">
                
                <div class="flex justify-between items-center mb-8">
                    <div class="relative w-80">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" id="searchInput" placeholder="Caută nr. înmatriculare..." class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 placeholder-blue-400 text-blue-600 font-medium transition-colors">
                        <div class="absolute bottom-2.5 left-10 w-32 h-[1px] bg-blue-500 opacity-50"></div>
                    </div>
                    
                    <button id="btnAdaugaMasina" class="bg-[#2563eb] hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold shadow-sm transition-colors duration-200 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Adaugă mașină
                    </button>
                </div>

                <div class="w-full">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-200 text-[11px] font-bold text-gray-400 uppercase tracking-wider">
                                <th class="px-2 py-4 w-1/4">Nr. Înmatriculare</th>
                                <th class="px-2 py-4 w-1/4">Marcă / Model</th>
                                <th class="px-2 py-4 w-1/4">Șofer</th>
                                <th class="px-2 py-4 w-1/4">Statut</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody" class="divide-y divide-gray-100">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <div id="modalMasina" class="fixed inset-0 bg-slate-800/40 backdrop-blur-sm hidden items-center justify-center z-50 transition-opacity">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-[500px] border-[3px] border-[#3b82f6] overflow-hidden flex flex-col">
            
            <div class="px-8 py-5 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-[18px] font-bold text-[#1e293b]">Adaugă Mașină</h2>
                <button id="btnInchideModal" class="bg-gray-100 hover:bg-gray-200 text-gray-500 rounded-full p-1.5 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <form id="formAdaugaMasina" class="p-8">
                
                <div class="mb-5">
                    <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Nr. Înmatriculare <span class="text-red-500">*</span></label>
                    <input type="text" required placeholder="ex: B 100 ABC" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-700 placeholder-gray-400">
                </div>

                <div class="grid grid-cols-2 gap-4 mb-5">
                    <div>
                        <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Marcă <span class="text-red-500">*</span></label>
                        <input type="text" required placeholder="ex: Dacia" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-700 placeholder-gray-400">
                    </div>
                    <div>
                        <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Model <span class="text-red-500">*</span></label>
                        <input type="text" required placeholder="ex: Logan" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-700 placeholder-gray-400">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-5">
                    <div>
                        <label class="block text-[13px] font-medium text-gray-600 mb-1.5">An Fabricație</label>
                        <select class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-700 bg-white">
                            <option>2024</option>
                            <option>2023</option>
                            <option>2022</option>
                            <option>2021</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Combustibil</label>
                        <select class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-700 bg-white">
                            <option>Diesel</option>
                            <option>Benzină</option>
                            <option>GPL</option>
                            <option>Hibrid</option>
                            <option>Electric</option>
                        </select>
                    </div>
                </div>

                <div class="mb-8">
                    <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Status Inițial</label>
                    <div class="relative">
                        <select class="w-full pl-8 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-700 bg-white appearance-none">
                            <option>Disponibilă</option>
                            <option>În cursă</option>
                            <option>În service</option>
                        </select>
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="w-2 h-2 rounded-full bg-[#10b981]"></span>
                        </div>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end gap-3 pt-6 border-t border-gray-50">
                    <button type="button" id="btnAnuleaza" class="px-5 py-2.5 text-sm font-bold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-lg transition-colors">
                        Anulează
                    </button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-[#2563eb] hover:bg-blue-700 rounded-lg transition-colors shadow-sm">
                        Salvează Mașina
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
    
        // --- 1. FUNCȚIONALITATE CĂUTARE (Filtrare Tabel) ---
        const searchInput = document.getElementById('searchInput');

        searchInput.addEventListener('input', (e) => {
            const term = e.target.value.toLowerCase();
            const tableRows = document.querySelectorAll('#tableBody tr');
            
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(term) ? '' : 'none';
            });
        });

        // --- 2. FUNCȚIONALITATE MODAL (Pop-up) ---
        const btnAdauga = document.getElementById('btnAdaugaMasina');
        const modal = document.getElementById('modalMasina');
        const btnInchideModal = document.getElementById('btnInchideModal');
        const btnAnuleaza = document.getElementById('btnAnuleaza');
        const formAdauga = document.getElementById('formAdaugaMasina'); // Îl declarăm O SINGURĂ DATĂ aici

        btnAdauga.addEventListener('click', () => {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });

        btnInchideModal.addEventListener('click', () => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        });

        btnAnuleaza.addEventListener('click', () => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        });

        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        });

        // --- 3. CONFIGURARE API ȘI AUTENTIFICARE ---
        const API_BASE_URL = 'http://localhost:8000/api';
        const token = localStorage.getItem('fleet_token');
        
        if (!token) {
            window.location.href = 'login.php';
        }

        // --- 4. FETCH DATE REALE DIN API ---
        async function incarcaMasini() {
            try {
                const response = await fetch(`${API_BASE_URL}/cars/?skip=0&limit=50`, {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });

                if (response.status === 401) {
                    // Token expirat, îl delogăm
                    localStorage.removeItem('fleet_token');
                    window.location.href = 'login.php';
                    return;
                }

                const dateReale = await response.json();
                randeazaTabel(dateReale);

            } catch (error) {
                console.error("Eroare la aducerea datelor:", error);
                document.getElementById('tableBody').innerHTML = `
                    <tr><td colspan="4" class="text-center py-5 text-red-500 font-bold">Nu am putut contacta serverul (API-ul).</td></tr>
                `;
            }
        }
        
        function randeazaTabel(listaMasini) {
            const tableBody = document.getElementById('tableBody');
            tableBody.innerHTML = '';

            if (listaMasini.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="4" class="text-center py-5 text-gray-500">Nu există nicio mașină înregistrată.</td></tr>`;
                return;
            }

            listaMasini.forEach(masina => {
                let bgStatus = 'bg-[#e6fceb]';
                let textStatus = 'text-[#10b981]';
                let dotStatus = 'bg-[#10b981]';

                if (masina.status === 'in_service') {
                    bgStatus = 'bg-[#fee2e2]'; textStatus = 'text-[#ef4444]'; dotStatus = 'bg-[#ef4444]';
                } else if (masina.status === 'inactiv') {
                    bgStatus = 'bg-[#f1f5f9]'; textStatus = 'text-[#64748b]'; dotStatus = 'bg-[#64748b]';
                }

                const tr = document.createElement('tr');
                tr.className = 'hover:bg-gray-50/50 transition-colors group';
                tr.innerHTML = `
                    <td class="px-2 py-5">
                        <div class="font-bold text-[14px] text-gray-900">${masina.nr_inmatriculare}</div>
                    </td>
                    <td class="px-2 py-5">
                        <div class="text-[14px] text-gray-800 font-medium">${masina.marca} ${masina.model}</div>
                        <div class="text-[12px] text-gray-400 mt-0.5">${masina.tip_combustibil || 'N/A'} - ${masina.an_fabricatie || 'N/A'}</div>
                    </td>
                    <td class="px-2 py-5">
                        <div class="text-[14px] text-gray-500">N/A</div>
                    </td>
                    <td class="px-2 py-5">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md text-[12px] font-bold ${bgStatus} ${textStatus}">
                            <span class="w-1.5 h-1.5 rounded-full ${dotStatus}"></span>
                            ${masina.status}
                        </span>
                    </td>
                `;
                tableBody.appendChild(tr);
            });
        }

        // --- 5. FUNCTIONALITATE ADĂUGARE MAȘINĂ REALĂ ---
        // Aici trimitem datele către backend
        formAdauga.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            // Extragem datele din formular
            const inputs = formAdauga.querySelectorAll('input, select');
            
            const masinaNoua = {
                nr_inmatriculare: inputs[0].value,
                marca: inputs[1].value,
                model: inputs[2].value,
                an_fabricatie: parseInt(inputs[3].value),
                tip_combustibil: inputs[4].value,
                status: inputs[5].value === "Disponibilă" ? "activ" : (inputs[5].value === "În service" ? "in_service" : "inactiv"),
                serie_sasiu: "SN" + Math.floor(Math.random() * 1000000000000000).toString().padStart(15, '0'),

                // VALORI DEFAULT
                kilometraj: 0,
                tip_caroserie: "Necunoscut",
                numar_locuri: 5,
                culoare: "Alb",
                categorie: "Autoturism",
                capacitate_cilindrica: 1.4,
                putere: 100,
                pret: 0,
                disponibil: true
            };

            try {
            const res = await fetch(`${API_BASE_URL}/cars/`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify(masinaNoua)
            });

            if (res.ok) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                formAdauga.reset();
                incarcaMasini();
            } else if (res.status === 422) {
                const errorData = await res.json();
                console.error("❌ EROARE 422 - FastAPI plânge după aceste câmpuri:", JSON.stringify(errorData.detail, null, 2));
                alert("A apărut eroarea 422! Apasă F12 și dă click pe 'Console' ca să vezi exact ce câmp lipsește.");
            } else {
                alert('Eroare necunoscută la adăugarea mașinii!');
            }
            } catch (error) {
                console.error(error);
            }
        });

        // Când se deschide pagina, aducem direct mașinile
        incarcaMasini();
    });
    </script>
</body>
</html>