<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoManager Deluxe - Asigurări</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden text-gray-800">

    <aside class="w-64 bg-white border-r border-gray-100 flex flex-col h-full shrink-0">
        <div class="h-24 flex items-center justify-center border-b border-gray-50 px-6 mb-2">
            <a href="acasa.php">
                <img src="logo.png" alt="AutoManager Deluxe" class="max-h-16 object-contain">
            </a>
        </div>

        <nav class="flex-1 px-4 py-4 flex flex-col gap-1.5 overflow-y-auto">
            <a href="masini.php" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Gestiune mașini</a>
            <a href="soferi.php" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Gestiune șoferi</a>
            <a href="service.php" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Service auto</a>
            
            <a href="asigurari.php" class="px-4 py-2.5 text-sm font-bold text-blue-600 bg-blue-50/80 rounded-lg transition-colors">Asigurări</a>
            
            <a href="viniete.php" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Viniete</a>
            <a href="anvelope.php" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Anvelope</a>
            <div class="my-2 border-t border-gray-100"></div>
            <a href="index.php" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Despre noi</a>
            <a href="contact.php" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Contact</a>
            <a href="login.php" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors mt-auto mb-4">Log in</a>
        </nav>
    </aside>

    <main class="flex-1 flex flex-col h-full overflow-hidden bg-white">
        
        <header class="bg-white h-20 border-b border-gray-100 flex items-center justify-center shrink-0">
            <h1 class="text-[22px] font-bold text-blue-600">Asigurări</h1>
        </header>

        <div class="flex-1 overflow-y-auto p-8 bg-gray-50/30">
            <div class="max-w-6xl mx-auto">
                
                <div class="flex justify-between items-center mb-8">
                    <div class="relative w-96">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" id="searchInput" placeholder="Caută nr. auto, asigurare..." class="w-full pl-11 pr-4 py-2.5 border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-700 placeholder-gray-400 shadow-sm transition-colors">
                    </div>
                    
                    <button id="btnAdaugaAsigurare" class="bg-[#2563eb] hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-bold shadow-sm transition-colors duration-200 flex items-center gap-2">
                        <span class="text-lg leading-none">+</span>
                        Adaugă Asigurare
                    </button>
                </div>

                <div class="w-full bg-white border border-gray-100 rounded-xl shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 text-[11px] font-bold text-gray-500 uppercase tracking-wider bg-white">
                                <th class="px-6 py-5 w-1/5">Mașină</th>
                                <th class="px-6 py-5 w-1/4">Tip Asigurare</th>
                                <th class="px-6 py-5 w-1/5">Expiră La</th>
                                <th class="px-6 py-5 w-1/6">Zile Rămase</th>
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

    <div id="modalAsigurare" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm hidden items-center justify-center z-50 transition-opacity">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-[600px] overflow-hidden flex flex-col">
            
            <div class="px-8 py-5 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-[18px] font-bold text-[#1e293b]">Adaugă Asigurare</h2>
                <button id="btnInchideModal" class="bg-gray-50 hover:bg-gray-100 text-gray-500 rounded-full p-1.5 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <form id="formAdaugaAsigurare" class="p-8">
                
                <div class="grid grid-cols-2 gap-x-6 gap-y-6 mb-2">
                    
                    <div>
                        <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Selectează Mașina <span class="text-red-500">*</span></label>
                        <select id="selectMasina" required class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-700 bg-white">
                            <option value="">-- Se încarcă mașinile... --</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Tip Asigurare <span class="text-red-500">*</span></label>
                        <select id="tipAsigurare" required class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-700 bg-white">
                            <option>RCA</option>
                            <option>CASCO</option>
                            <option>Asistență Rutieră</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Companie Asiguratoare</label>
                        <input type="text" id="companieAsiguratoare" placeholder="ex: Groupama" class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-700 placeholder-gray-400">
                    </div>

                    <div>
                        <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Număr Poliță (Seria)</label>
                        <input type="text" placeholder="ex: RO-12345678" class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-700 placeholder-gray-400">
                    </div>

                    <div>
                        <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Data Începerii <span class="text-red-500">*</span></label>
                        <input type="date" id="dataInceput" required class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-700 bg-white">
                    </div>

                    <div>
                        <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Data Expirării <span class="text-red-500">*</span></label>
                        <input type="date" id="dataExpirare" required class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-700 bg-white">
                    </div>

                    <div>
                        <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Cost Poliță</label>
                        <div class="flex">
                            <input type="text" id="costPolita" placeholder="ex: 1250" class="w-full px-3 py-2.5 border border-gray-200 rounded-l-lg border-r-0 text-[14px] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-700 placeholder-gray-400">
                            <!-- Dropdown adăugat pentru selectarea monedei -->
                            <select id="monedaPolita" class="px-3 bg-[#f8fafc] border border-gray-200 rounded-r-lg text-[13px] font-bold text-[#1e3a8a] focus:outline-none cursor-pointer">
                                <option>RON</option>
                                <option>EUR</option>
                                <option>HUF</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Alertă Expirare</label>
                        <select class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-700 bg-white">
                            <option>Cu 15 zile înainte</option>
                            <option>Cu 30 de zile înainte</option>
                            <option>Cu 7 zile înainte</option>
                        </select>
                    </div>

                </div>
                
                <div class="flex justify-end gap-3 pt-6 mt-6 border-t border-gray-50">
                    <button type="button" id="btnAnuleaza" class="px-5 py-2.5 text-[14px] font-bold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-lg transition-colors">
                        Anulează
                    </button>
                    <button type="submit" class="px-5 py-2.5 text-[14px] font-bold text-white bg-[#2563eb] hover:bg-blue-700 rounded-lg transition-colors shadow-sm">
                        Salvează Asigurarea
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
            const btnAdauga = document.getElementById('btnAdaugaAsigurare');
            const modal = document.getElementById('modalAsigurare');
            const btnInchideModal = document.getElementById('btnInchideModal');
            const btnAnuleaza = document.getElementById('btnAnuleaza');
            const formAdauga = document.getElementById('formAdaugaAsigurare');

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
            const ASIGURARI_ENDPOINT = '/asigurari/';
            
            if (!token) window.location.href = 'login.php';

            let carsMap = {};

            // --- 4. PRELUARE MAȘINI ---
            async function incarcaMasini() {
                try {
                    const res = await fetch(`${API_BASE_URL}/cars/?limit=100`, {
                        headers: { 'Authorization': `Bearer ${token}` }
                    });
                    if (res.ok) {
                        const masini = await res.json();
                        const select = document.getElementById('selectMasina');
                        select.innerHTML = '<option value="">-- Alege Mașina --</option>';
                        
                        masini.forEach(m => {
                            carsMap[m.id] = m; 
                            const opt = document.createElement('option');
                            opt.value = m.id;
                            opt.textContent = `${m.nr_inmatriculare} - ${m.marca} ${m.model}`;
                            select.appendChild(opt);
                        });
                    }
                } catch (e) { console.error("Eroare mașini:", e); }
            }

            // --- 5. PRELUARE ASIGURĂRI ---
            async function incarcaAsigurari() {
                try {
                    const res = await fetch(`${API_BASE_URL}${ASIGURARI_ENDPOINT}?limit=100`, {
                        headers: { 'Authorization': `Bearer ${token}` }
                    });

                    if (res.status === 401) {
                        localStorage.removeItem('fleet_token');
                        window.location.href = 'login.php';
                        return;
                    }

                    if (res.status === 404) {
                        alert("Eroare 404: Endpointul pentru asigurări e greșit.");
                        return;
                    }

                    const asigurari = await res.json();
                    randeazaTabel(asigurari);
                } catch (e) {
                    document.getElementById('tableBody').innerHTML = `<tr><td colspan="5" class="text-center py-5 text-red-500 font-bold">Eroare API</td></tr>`;
                }
            }

            function randeazaTabel(lista) {
                const tbody = document.getElementById('tableBody');
                tbody.innerHTML = '';

                if (lista.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="5" class="text-center py-5 text-gray-500">Nu există asigurări înregistrate.</td></tr>`;
                    return;
                }

                lista.forEach(a => {
                    const masina = carsMap[a.car_id] || {nr_inmatriculare: 'Ștearsă', marca: 'N/A', model: ''};
                    
                    const azi = new Date();
                    const exp = new Date(a.data_expirare);
                    const diffTime = exp - azi;
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                    let statusBg = 'bg-[#e6fceb]', statusText = 'text-[#10b981]', dotColor = 'bg-[#10b981]', statusMsg = 'Valabil';
                    let dataStyle = 'text-gray-500', zileStyle = 'text-[#10b981] font-bold', zileMsg = `${diffDays} zile`;

                    if (diffDays < 0) {
                        statusBg = 'bg-[#fee2e2]'; statusText = 'text-[#ef4444]'; dotColor = 'bg-[#ef4444]'; statusMsg = 'Expirat';
                        dataStyle = 'text-[#ef4444]'; zileStyle = 'text-[#ef4444] font-bold'; zileMsg = `Expirat de ${Math.abs(diffDays)} zile`;
                    } else if (diffDays <= 30) {
                        statusBg = 'bg-[#fef3c7]'; statusText = 'text-[#d97706]'; dotColor = 'bg-[#f59e0b]'; statusMsg = 'Expiră curând';
                        zileStyle = 'text-[#d97706] font-bold';
                    }

                    const dIntl = new Intl.DateTimeFormat('ro-RO', { day: 'numeric', month: 'long', year: 'numeric' });
                    const dataExpStr = dIntl.format(exp);

                    const tr = document.createElement('tr');
                    tr.className = 'hover:bg-gray-50/50 transition-colors group';
                    tr.innerHTML = `
                        <td class="px-6 py-5">
                            <div class="font-bold text-[14px] text-gray-900">${masina.marca} ${masina.model}</div>
                            <div class="text-[13px] text-gray-500 mt-0.5">${masina.nr_inmatriculare}</div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="text-[14px] text-gray-800 font-medium">${a.tip}</div>
                            <div class="text-[13px] text-gray-400 mt-0.5">${a.companie || '-'}</div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="text-[14px] ${dataStyle}">${dataExpStr}</div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="text-[14px] ${zileStyle}">${zileMsg}</div>
                        </td>
                        <td class="px-6 py-5">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md text-[12px] font-bold ${statusBg} ${statusText}">
                                <span class="w-1.5 h-1.5 rounded-full ${dotColor}"></span> ${statusMsg}
                            </span>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            }

           // --- 6. ADĂUGARE ASIGURARE NOUĂ (CU PROTECȚIE STRICTĂ) ---
            const inputDataInceput = document.getElementById('dataInceput');
            const inputDataExpirare = document.getElementById('dataExpirare');

            // 1. Ce se întâmplă când modifici Data de Început:
            inputDataInceput.addEventListener('change', () => {
                if (inputDataInceput.value) {
                    let minDate = new Date(inputDataInceput.value);
                    minDate.setDate(minDate.getDate() + 1); 
                    inputDataExpirare.min = minDate.toISOString().split('T')[0];

                    if (inputDataExpirare.value && inputDataExpirare.value <= inputDataInceput.value) {
                        inputDataExpirare.value = ''; 
                        alert('Data de expirare a fost ștearsă deoarece era înaintea datei de început!');
                    }
                }
            });

            // 2. Ce se întâmplă când modifici Data de Expirare:
            inputDataExpirare.addEventListener('change', () => {
                if (inputDataExpirare.value) {
                    let maxDate = new Date(inputDataExpirare.value);
                    maxDate.setDate(maxDate.getDate() - 1); 
                    inputDataInceput.max = maxDate.toISOString().split('T')[0];

                    if (inputDataInceput.value && inputDataInceput.value >= inputDataExpirare.value) {
                        inputDataInceput.value = ''; 
                        alert('Data de început a fost ștearsă deoarece era după data de expirare!');
                    }
                }
            }

            formAdauga.addEventListener('submit', async (e) => {
                e.preventDefault();
                
                const dataInc = new Date(inputDataInceput.value);
                const dataExp = new Date(inputDataExpirare.value);

                if (dataInc >= dataExp) {
                    alert('Eroare: Data expirării trebuie să fie strict după data de început!');
                    return; 
                }

                const carIdVal = document.getElementById('selectMasina').value;
                if (!carIdVal) {
                    alert('Eroare: Te rog selectează o mașină din listă!');
                    return;
                }

                let tipSelectat = document.getElementById('tipAsigurare').value;
                if (tipSelectat.includes("Asistență")) tipSelectat = "ASISTENTA_RUTIERA"; 

                const asigurareNoua = {
                    car_id: parseInt(carIdVal),
                    tip: tipSelectat, 
                    companie: document.getElementById('companieAsiguratoare').value,
                    data_inceput: dataInc.toISOString(),
                    data_expirare: dataExp.toISOString(),
                    cost: parseFloat(document.getElementById('costPolita').value) || 0
                    // Moneda din select poate fi stocată local sau trimisă dacă API-ul o suportă în viitor
                };

                try {
                    const res = await fetch(`${API_BASE_URL}${ASIGURARI_ENDPOINT}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': `Bearer ${token}` 
                        },
                        body: JSON.stringify(asigurareNoua)
                    });

                    if (res.ok) {
                        toggleModal(false);
                        formAdauga.reset();
                        inputDataExpirare.removeAttribute('min');
                        inputDataInceput.removeAttribute('max');
                        incarcaAsigurari(); 
                        alert('Asigurarea a fost adăugată cu succes!');
                    } else {
                        const err = await res.json();
                        console.error("Eroare trimisă de backend (422):", err);
                        alert('Eroare la adăugare! Backend-ul a respins datele (vezi F12 -> Console).');
                    }
                } catch (error) {
                    console.error("Eroare de conexiune:", error);
                }
            });

            // --- 7. INITIALIZARE MAGICĂ ---
            async function init() {
                await incarcaMasini();
                await incarcaAsigurari();
            }
            init();
        });
    </script>
</body>
</html>