<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoManager Deluxe - Viniete</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body { font-family: 'Inter', sans-serif; }</style>
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
            <a href="soferi.php" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Gestiune șoferi</a>
            <a href="service.php" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Service auto</a>
            <a href="asigurari.php" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Asigurări</a>
            
            <a href="viniete.php" class="px-4 py-2.5 text-sm font-bold text-blue-600 bg-blue-50/80 rounded-lg transition-colors">Viniete</a>
            
            <a href="anvelope.php" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Anvelope</a>
            
            <div class="my-2 border-t border-gray-100"></div>
            <a href="index.php" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Despre noi</a>
            <a href="contact.php" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Contact</a>
            <a href="login.php" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors mt-auto mb-4">Log in</a>
        </nav>
    </aside>

    <main class="flex-1 flex flex-col h-full overflow-hidden bg-[#f8fafc]">
        <header class="bg-white h-20 border-b border-gray-100 flex items-center justify-center shrink-0">
            <h1 class="text-[22px] font-bold text-blue-600">Viniete</h1>
        </header>

        <div class="flex-1 overflow-y-auto p-8">
            <div class="max-w-6xl mx-auto">
                <div class="flex justify-between items-center mb-8">
                    <div class="relative w-80">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" id="searchInput" placeholder="Caută nr. auto, țară..." class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-700 placeholder-gray-400 shadow-sm transition-colors">
                    </div>
                    <button id="btnAdaugaVinieta" class="bg-[#2563eb] hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-bold shadow-sm transition-colors duration-200 flex items-center gap-2">
                        Adaugă Vinietă
                    </button>
                </div>

                <div class="w-full bg-white border border-gray-100 rounded-xl shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 text-[11px] font-bold text-gray-500 uppercase tracking-wider bg-white">
                                <th class="px-6 py-5 w-1/5">Mașină</th>
                                <th class="px-6 py-5 w-1/4">Țară / Tip</th>
                                <th class="px-6 py-5 w-1/6">Valabilitate</th>
                                <th class="px-6 py-5 w-1/5">Expiră La</th>
                                <th class="px-6 py-5">Statut</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody" class="divide-y divide-gray-50">
                            <?php foreach($viniete as $item): ?>
                            <tr class="hover:bg-gray-50/50 transition-colors group">
                                <td class="px-6 py-5">
                                    <div class="font-bold text-[14px] text-gray-900"><?= $item['masina'] ?></div>
                                    <div class="text-[13px] text-gray-500 mt-0.5"><?= $item['nr'] ?></div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-[14px] text-gray-800 font-medium"><?= $item['tara'] ?></div>
                                    <div class="text-[13px] text-gray-400 mt-0.5"><?= $item['tip'] ?></div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-[14px] text-gray-600"><?= $item['valabilitate'] ?></div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-[14px] <?= $item['expira_style'] ?>"><?= $item['expira_la'] ?></div>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md text-[12px] font-bold <?= $item['statut_bg'] ?> <?= $item['statut_text'] ?>">
                                        <span class="w-1.5 h-1.5 rounded-full <?= $item['dot_color'] ?>"></span>
                                        <?= $item['statut'] ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <div id="modalVinieta" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm hidden items-center justify-center z-50 transition-opacity">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-[600px] overflow-hidden flex flex-col">
            <div class="px-8 py-5 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-[18px] font-bold text-[#1e293b]">Adaugă Vinietă / Taxă de drum</h2>
                <button id="btnInchideModal" class="bg-gray-50 hover:bg-gray-100 text-gray-500 rounded-full p-1.5 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form id="formAdaugaVinieta" class="p-8">
                <div class="grid grid-cols-2 gap-x-6 gap-y-6 mb-2">
                    <div>
                        <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Selectează Mașina <span class="text-red-500">*</span></label>
                        <select id="selectMasinaVinieta" required class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-700 bg-white">
                            <option value="" disabled selected>-- Se încarcă mașinile... --</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Țara / Tip Vinietă <span class="text-red-500">*</span></label>
                        <select required class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-700 bg-white">
                            <option>România (Rovinietă)</option><option>Ungaria (Matrica)</option><option>Bulgaria (Vinetka)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Perioadă Valabilitate <span class="text-red-500">*</span></label>
                        <select required class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-700 bg-white">
                            <option>12 Luni (1 An)</option><option>1 Lună (30 Zile)</option><option>1 Săptămână (7 Zile)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Cost Vinietă</label>
                        <div class="flex">
                            <input type="text" value="139" class="w-full px-3 py-2.5 border border-gray-200 rounded-l-lg border-r-0 text-[14px] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-700">
                            <span class="inline-flex items-center px-4 bg-[#f8fafc] border border-gray-200 rounded-r-lg text-[13px] font-bold text-gray-500">RON</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Data Începerii <span class="text-red-500">*</span></label>
                        <input type="date" required value="2026-06-10" class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-700 bg-white">
                    </div>
                    <div>
                        <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Data Expirării</label>
                        <input type="date" value="2027-06-09" class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-500 bg-[#f8fafc]">
                    </div>
                    <div>
                        <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Număr Chitanță / SMS</label>
                        <input type="text" placeholder="ex: 987654321" class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-700 placeholder-gray-400">
                    </div>
                    <div>
                        <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Notificare Expirare</label>
                        <select class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-700 bg-white">
                            <option>Cu 5 zile înainte</option><option>Cu 1 zi înainte</option><option>Fără notificare</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end gap-3 pt-6 mt-6 border-t border-gray-50">
                    <button type="button" id="btnAnuleaza" class="px-5 py-2.5 text-[14px] font-bold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-lg transition-colors">Anulează</button>
                    <button type="submit" class="px-5 py-2.5 text-[14px] font-bold text-white bg-[#2563eb] hover:bg-blue-700 rounded-lg transition-colors shadow-sm">Salvează Vinieta</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // --- 1. CĂUTARE LIVE REPARATĂ ---
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
            const btnAdauga = document.getElementById('btnAdaugaVinieta');
            const modal = document.getElementById('modalVinieta');
            const btnInchideModal = document.getElementById('btnInchideModal');
            const btnAnuleaza = document.getElementById('btnAnuleaza');
            const formAdauga = document.getElementById('formAdaugaVinieta');

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
            const VINIETE_ENDPOINT = '/viniete/'; 
            
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
                        const select = document.getElementById('selectMasinaVinieta');
                        select.innerHTML = '<option value="" disabled selected>-- Alege Mașina --</option>';
                        
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

            // --- 5. PRELUARE VINIETE ---
            async function incarcaViniete() {
                try {
                    const res = await fetch(`${API_BASE_URL}${VINIETE_ENDPOINT}?limit=100`, {
                        headers: { 'Authorization': `Bearer ${token}` }
                    });

                    if (res.status === 401) {
                        localStorage.removeItem('fleet_token');
                        window.location.href = 'login.php';
                        return;
                    }

                    if (res.ok) {
                        const viniete = await res.json();
                        randeazaTabel(viniete);
                    }
                } catch (e) {
                    document.getElementById('tableBody').innerHTML = `<tr><td colspan="5" class="text-center py-5 text-red-500 font-bold">Eroare conexiune API</td></tr>`;
                }
            }

            function randeazaTabel(lista) {
                const tbody = document.getElementById('tableBody');
                tbody.innerHTML = '';

                if (lista.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="5" class="text-center py-5 text-gray-500">Nu există viniete active.</td></tr>`;
                    return;
                }

                lista.forEach(v => {
                    const masina = carsMap[v.car_id] || {nr_inmatriculare: 'Ștearsă', marca: 'N/A', model: ''};
                    const azi = new Date();
                    const exp = new Date(v.data_expirare);
                    const diffDays = Math.ceil((exp - azi) / (1000 * 60 * 60 * 24));

                    let statusBg = 'bg-[#e6fceb]', statusText = 'text-[#10b981]', dotColor = 'bg-[#10b981]', statusMsg = 'Valabil';
                    let dataStyle = 'text-[#10b981] font-bold';

                    if (diffDays < 0) {
                        statusBg = 'bg-[#fee2e2]'; statusText = 'text-[#ef4444]'; dotColor = 'bg-[#ef4444]'; statusMsg = 'Expirat';
                        dataStyle = 'text-[#ef4444] font-bold';
                    } else if (diffDays <= 7) { // Setăm alarma la 7 zile
                        statusBg = 'bg-[#fef3c7]'; statusText = 'text-[#d97706]'; dotColor = 'bg-[#f59e0b]'; statusMsg = 'Expiră curând';
                        dataStyle = 'text-[#d97706] font-bold';
                    }

                    const dataExpStr = new Date(v.data_expirare).toLocaleDateString('ro-RO');
                    const numeTara = v.tara === "RO" ? "România" : (v.tara === "HU" ? "Ungaria" : (v.tara === "BG" ? "Bulgaria" : v.tara));

                    const tr = document.createElement('tr');
                    tr.className = 'hover:bg-gray-50/50 transition-colors group';
                    tr.innerHTML = `
                        <td class="px-6 py-5">
                            <div class="font-bold text-[14px] text-gray-900">${masina.marca} ${masina.model}</div>
                            <div class="text-[13px] text-gray-500 mt-0.5">${masina.nr_inmatriculare}</div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="text-[14px] text-gray-800 font-medium">${numeTara}</div>
                            <div class="text-[13px] text-gray-400 mt-0.5">${v.cost ? v.cost + ' RON' : '-'}</div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="text-[14px] text-gray-600">${diffDays >= 0 ? diffDays + ' Zile Rămase' : 'Expirată de ' + Math.abs(diffDays) + ' zile'}</div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="text-[14px] ${dataStyle}">${dataExpStr}</div>
                        </td>
                        <td class="px-6 py-5">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md text-[12px] font-bold ${statusBg} ${statusText}">
                                <span class="w-1.5 h-1.5 rounded-full ${dotColor}"></span>
                                ${statusMsg}
                            </span>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            }

            // --- 6. SALVARE VINIETĂ ---
            formAdauga.addEventListener('submit', async (e) => {
                e.preventDefault();
                
                const inputs = formAdauga.querySelectorAll('input');
                const selects = formAdauga.querySelectorAll('select');
                let taraSelectata = selects[1].value;
                let taraCode = "RO";
                if (taraSelectata.includes("Ungaria")) taraCode = "HU";
                if (taraSelectata.includes("Bulgaria")) taraCode = "BG";

                const vinietaNoua = {
                    car_id: parseInt(selects[0].value),
                    tara: taraCode,
                    data_inceput: new Date(inputs[1].value).toISOString(),
                    data_expirare: new Date(inputs[2].value).toISOString(),
                    cost: parseFloat(inputs[0].value) || 0.0
                };

                try {
                    const res = await fetch(`${API_BASE_URL}${VINIETE_ENDPOINT}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': `Bearer ${token}`
                        },
                        body: JSON.stringify(vinietaNoua)
                    });

                    if (res.ok) {
                        toggleModal(false);
                        formAdauga.reset();
                        incarcaViniete();
                    } else {
                        const err = await res.json();
                        console.error("Eroare API 422:", err);
                        alert('Eroare la salvare! (Vezi consola F12)');
                    }
                } catch (error) {
                    console.error(error);
                }
            });

            // --- 7. START ---
            async function init() {
                await incarcaMasini();
                await incarcaViniete();
            }
            init();
        });
    </script>
</body>
</html>