<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoManager Deluxe - Gestiune Șoferi</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden text-gray-800">

    <aside class="w-64 bg-white border-r border-gray-100 flex flex-col h-full shrink-0 relative">
        <div class="absolute left-0 top-0 bottom-0 w-1 bg-blue-500"></div>

        <div class="h-24 flex items-center justify-center border-b border-gray-50 px-6 mb-2">
            <a href="index.php">
                <img src="logo.png" alt="AutoManager Deluxe" class="max-h-16 object-contain">
            </a>
        </div>

        <nav class="flex-1 px-4 py-4 flex flex-col gap-1.5 overflow-y-auto">
            <a href="masini.php" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Gestiune mașini</a>
            
            <a href="soferi.php" class="px-4 py-2.5 text-sm font-bold text-blue-600 bg-blue-50/80 rounded-lg transition-colors">Gestiune șoferi</a>
            
            <a href="service.php" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Service auto</a>
            <a href="asigurari.php" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Asigurări</a>
            <a href="viniete.php" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Viniete</a>
            <a href="anvelope.php" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Anvelope</a>
            <div class="my-2 border-t border-gray-100"></div>
            <a href="index.php" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Despre noi</a>
            <a href="contact.php" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Contact</a>
            <a href="login.php" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors mt-auto mb-4">Log in</a>
        </nav>
    </aside>

    <main class="flex-1 flex flex-col h-full overflow-hidden bg-[#f8fafc]">
        
        <header class="bg-white h-20 border-b border-gray-100 flex items-center justify-center shrink-0">
            <h1 class="text-[22px] font-bold text-blue-600">Gestiune șoferi</h1>
        </header>

        <div class="flex-1 overflow-y-auto p-8">
            <div class="max-w-6xl mx-auto">
                
                <div class="flex justify-between items-center mb-8">
                    <div class="relative w-80">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" id="searchInput" placeholder="Caută șofer, telefon..." class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-700 placeholder-gray-400 shadow-sm transition-colors">
                    </div>
                    
                    <button id="btnAdaugaSofer" class="bg-[#2563eb] hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-bold shadow-sm transition-colors duration-200 flex items-center gap-2">
                        <span class="text-lg leading-none">+</span>
                        Adaugă Șofer
                    </button>
                </div>

                <div class="w-full bg-white border border-gray-100 rounded-xl shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 text-[11px] font-bold text-gray-500 uppercase tracking-wider bg-white">
                                <th class="px-6 py-5 w-1/4">Șofer</th>
                                <th class="px-6 py-5 w-1/4">Date Contact</th>
                                <th class="px-6 py-5 w-1/5">Mașină Alocată</th>
                                <th class="px-6 py-5">Statut</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody" class="divide-y divide-gray-50">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <div id="modalSofer" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm hidden items-center justify-center z-50 transition-opacity">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-[550px] overflow-hidden flex flex-col">
            
            <div class="px-8 py-5 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-[18px] font-bold text-[#1e293b]">Adaugă Șofer Nou</h2>
                <button id="btnInchideModal" class="bg-gray-50 hover:bg-gray-100 text-gray-500 rounded-full p-1.5 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <form id="formAdaugaSofer" class="p-8">
                
                <div class="grid grid-cols-2 gap-x-6 gap-y-6 mb-6">
                    
                    <div>
                        <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Nume <span class="text-red-500">*</span></label>
                        <input type="text" required placeholder="ex: Popescu" class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-700 placeholder-gray-400">
                    </div>

                    <div>
                        <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Prenume <span class="text-red-500">*</span></label>
                        <input type="text" required placeholder="ex: Ion" class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-700 placeholder-gray-400">
                    </div>

                    <div>
                        <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Număr Telefon <span class="text-red-500">*</span></label>
                        <input type="tel" required placeholder="ex: 07xx xxx xxx" class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-700 placeholder-gray-400">
                    </div>

                    <div>
                        <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Adresă Email</label>
                        <input type="email" placeholder="ex: ion@mail.com" class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-700 placeholder-gray-400">
                    </div>

                    <div>
                        <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Serie Permis Conducere</label>
                        <input type="text" placeholder="ex: B00123456X" class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-700 placeholder-gray-400">
                    </div>

                    <div>
                        <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Mașină Alocată</label>
                        <select id="selectMasinaDisponibila" class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-700 bg-white">
                            <option value="">Fără mașină alocată</option>
                            </select>
                    </div>
                </div>

                <div class="mb-2">
                    <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Status Inițial</label>
                    <div class="relative">
                        <select class="w-full pl-8 pr-4 py-2.5 border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-700 bg-white appearance-none">
                            <option>Activ</option>
                            <option>În cursă</option>
                            <option>În concediu</option>
                        </select>
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <span class="w-2 h-2 rounded-full bg-[#10b981]"></span>
                        </div>
                        <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end gap-3 pt-6 mt-8 border-t border-gray-50">
                    <button type="button" id="btnAnuleaza" class="px-6 py-2.5 text-[14px] font-bold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-lg transition-colors">
                        Anulează
                    </button>
                    <button type="submit" class="px-6 py-2.5 text-[14px] font-bold text-white bg-[#2563eb] hover:bg-blue-700 rounded-lg transition-colors shadow-sm">
                        Salvează Șofer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
    
            // --- 1. CĂUTARE LIVE ---
            const searchInput = document.getElementById('searchInput');

            searchInput.addEventListener('input', (e) => {
                const term = e.target.value.toLowerCase();
                const tableRows = document.querySelectorAll('#tableBody tr'); 
                
                tableRows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(term) ? '' : 'none';
                });
            });

            // --- 2. MODAL ---
            const btnAdauga = document.getElementById('btnAdaugaSofer');
            const modal = document.getElementById('modalSofer');
            const btnInchideModal = document.getElementById('btnInchideModal');
            const btnAnuleaza = document.getElementById('btnAnuleaza');
            const formAdauga = document.getElementById('formAdaugaSofer');

            const toggleModal = (show) => {
                if (show) {
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                } else {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }
            };

            btnAdauga.addEventListener('click', () => toggleModal(true));
            btnInchideModal.addEventListener('click', () => toggleModal(false));
            btnAnuleaza.addEventListener('click', () => toggleModal(false));
            modal.addEventListener('click', (e) => { if (e.target === modal) toggleModal(false); });

            // --- 3. CONFIGURARE API ---
            const API_BASE_URL = 'http://localhost:8000/api';
            const token = localStorage.getItem('fleet_token');
            
            if (!token) {
                window.location.href = 'login.php';
            }

            // --- 4. PRELUARE MAȘINI DISPONIBILE (PENTRU SELECT) ---
            async function incarcaMasiniDisponibile() {
                try {
                    const res = await fetch(`${API_BASE_URL}/cars/?disponibil=true&limit=100`, {
                        headers: { 'Authorization': `Bearer ${token}` }
                    });
                    if (res.ok) {
                        const masini = await res.json();
                        const select = document.getElementById('selectMasinaDisponibila');
                        
                        // Resetăm select-ul
                        select.innerHTML = '<option value="">Fără mașină alocată</option>';
                        
                        // Adăugăm mașinile din API
                        masini.forEach(m => {
                            const option = document.createElement('option');
                            option.value = m.id;
                            option.textContent = `${m.marca} ${m.model} (${m.nr_inmatriculare})`;
                            select.appendChild(option);
                        });
                    }
                } catch (e) {
                    console.error("Eroare la încărcarea mașinilor:", e);
                }
            }

            // --- 5. PRELUARE ȘOFERI DIN API ---
            async function incarcaSoferi() {
                try {
                    const response = await fetch(`${API_BASE_URL}/drivers/?skip=0&limit=50`, {
                        headers: { 'Authorization': `Bearer ${token}` }
                    });

                    if (response.status === 401) {
                        localStorage.removeItem('fleet_token');
                        window.location.href = 'login.php';
                        return;
                    }

                    const soferi = await response.json();
                    randeazaTabel(soferi);
                } catch (error) {
                    document.getElementById('tableBody').innerHTML = `<tr><td colspan="4" class="text-center py-5 text-red-500 font-bold">Eroare API</td></tr>`;
                }
            }

            function randeazaTabel(listaSoferi) {
                const tableBody = document.getElementById('tableBody');
                tableBody.innerHTML = '';

                if (listaSoferi.length === 0) {
                    tableBody.innerHTML = `<tr><td colspan="4" class="text-center py-5 text-gray-500">Nu există șoferi.</td></tr>`;
                    return;
                }

                listaSoferi.forEach(sofer => {
                    const tr = document.createElement('tr');
                    tr.className = 'hover:bg-gray-50/50 transition-colors group';
                    tr.innerHTML = `
                        <td class="px-6 py-5">
                            <div class="font-bold text-[14px] text-gray-900">${sofer.nume_complet}</div>
                            <div class="text-[12px] text-gray-400 mt-0.5">Permis: ${sofer.numar_permis || 'N/A'}</div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="text-[14px] text-gray-800 font-medium">${sofer.telefon || 'Fără telefon'}</div>
                            <div class="text-[13px] text-gray-400 mt-0.5">CNP: ${sofer.cnp || 'N/A'}</div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="text-[14px] text-gray-800 font-semibold">Vezi Detalii...</div>
                            <div class="text-[12px] text-gray-500 mt-0.5">Click pentru istoric</div>
                        </td>
                        <td class="px-6 py-5">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md text-[12px] font-bold bg-[#e6fceb] text-[#10b981]">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#10b981]"></span> Activ
                            </span>
                        </td>
                    `;
                    tableBody.appendChild(tr);
                });
            }

            // --- 6. ADĂUGARE ȘOFER NOU (ȘI ALOCARE MAȘINĂ) ---
            formAdauga.addEventListener('submit', async (e) => {
                e.preventDefault();
                const inputs = formAdauga.querySelectorAll('input');
                const selectMasina = document.getElementById('selectMasinaDisponibila');
                
                const cnpDummy = "1" + Math.floor(100000000000 + Math.random() * 900000000000).toString();

                const soferNou = {
                    nume_complet: `${inputs[0].value} ${inputs[1].value}`,
                    telefon: inputs[2].value,
                    numar_permis: inputs[4].value || "B" + Math.floor(Math.random() * 100000),
                    cnp: cnpDummy
                };

                try {
                    const res = await fetch(`${API_BASE_URL}/drivers/`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': `Bearer ${token}`
                        },
                        body: JSON.stringify(soferNou)
                    });

                    if (res.ok) {
                        const soferSalvat = await res.json();
                        if (selectMasina.value !== "") {
                            const idMasina = parseInt(selectMasina.value);
                            const asociere = {
                                driver_id: soferSalvat.id,
                                car_id: idMasina
                            };

                            await fetch(`${API_BASE_URL}/associations/`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Authorization': `Bearer ${token}`
                                },
                                body: JSON.stringify(asociere)
                            });
                        }

                        toggleModal(false);
                        formAdauga.reset();
                        incarcaSoferi();
                        incarcaMasiniDisponibile();
                    } else {
                        alert('Eroare la adăugare! Vezi consola.');
                    }
                } catch (error) {
                    console.error(error);
                }
            });

            incarcaMasiniDisponibile();
            incarcaSoferi();
        });
    </script>
</body>
</html>