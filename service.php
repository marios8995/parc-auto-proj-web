<?php
// Datele pentru tabelul de service
$interventii = [
    [
        'masina' => 'Dacia Logan', 'nr' => 'B 100 ABC',
        'detalii_titlu' => 'Revizie Periodică (Filtre + Ulei)', 'detalii_data' => '12 Mai 2026',
        'atelier' => 'AutoCenter București',
        'cost_text' => '1.450 RON', 'cost_style' => 'font-bold text-gray-900',
        'statut' => 'Finalizat', 'statut_bg' => 'bg-[#e6fceb]', 'statut_text' => 'text-[#10b981]', 'dot_color' => 'bg-[#10b981]'
    ],
    [
        'masina' => 'Skoda Octavia', 'nr' => 'CJ 25 XZY',
        'detalii_titlu' => 'Înlocuire Plăcuțe Frână', 'detalii_data' => '26 Mai 2026',
        'atelier' => 'ProService Cluj',
        'cost_text' => 'Estimativ: <span class="font-bold text-gray-900">850 RON</span>', 'cost_style' => 'text-gray-500',
        'statut' => 'În lucru', 'statut_bg' => 'bg-[#e0f2fe]', 'statut_text' => 'text-[#2563eb]', 'dot_color' => 'bg-[#3b82f6]'
    ],
    [
        'masina' => 'Ford Focus', 'nr' => 'TM 99 WOW',
        'detalii_titlu' => 'Reparație Motor', 'detalii_data' => '02 Iun 2026',
        'atelier' => 'Reprezentanța Ford',
        'cost_text' => 'Încă în garanție', 'cost_style' => 'text-gray-400',
        'statut' => 'Programat', 'statut_bg' => 'bg-[#fef9c3]', 'statut_text' => 'text-[#ca8a04]', 'dot_color' => 'bg-[#eab308]'
    ]
];
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoManager Deluxe - Service auto</title>
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
            
            <a href="service.php" class="px-4 py-2.5 text-sm font-bold text-blue-600 bg-blue-50/80 rounded-lg transition-colors">Service auto</a>
            
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
            <h1 class="text-[22px] font-bold text-blue-600">Service auto</h1>
        </header>

        <div class="flex-1 overflow-y-auto p-8">
            <div class="max-w-6xl mx-auto">
                
                <div class="flex justify-between items-center mb-8">
                    <div class="relative w-96">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" id="searchInput" placeholder="Caută reparație, nr. auto..." class="w-full pl-11 pr-4 py-2.5 border-2 border-blue-400 rounded-lg text-[15px] focus:outline-none focus:ring-1 focus:ring-blue-500 text-gray-700 placeholder-blue-300 shadow-sm transition-colors">
                    </div>
                    
                    <button id="btnAdaugaInterventie" class="bg-[#2563eb] hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-bold shadow-sm transition-colors duration-200 flex items-center gap-2">
                        <span class="text-lg leading-none">+</span>
                        Adaugă Intervenție auto
                    </button>
                </div>

                <div class="w-full bg-white border border-gray-100 rounded-xl shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 text-[11px] font-bold text-gray-400 uppercase tracking-wider bg-gray-50/50">
                                <th class="px-6 py-5 w-1/5">Mașină</th>
                                <th class="px-6 py-5 w-1/4">Detalii Intervenție</th>
                                <th class="px-6 py-5 w-1/5">Atelier Service</th>
                                <th class="px-6 py-5 w-1/6">Cost Total</th>
                                <th class="px-6 py-5">Status</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody" class="divide-y divide-gray-50">
                            <?php foreach($interventii as $item): ?>
                            <tr class="hover:bg-gray-50/50 transition-colors group">
                                <td class="px-6 py-5">
                                    <div class="font-bold text-[14px] text-gray-900"><?= $item['masina'] ?></div>
                                    <div class="text-[13px] text-gray-500 mt-0.5"><?= $item['nr'] ?></div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-[14px] text-gray-800 font-medium"><?= $item['detalii_titlu'] ?></div>
                                    <div class="text-[13px] text-gray-400 mt-0.5"><?= $item['detalii_data'] ?></div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-[14px] text-gray-500"><?= $item['atelier'] ?></div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-[14px] <?= $item['cost_style'] ?>">
                                        <?= $item['cost_text'] ?>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md text-[12px] font-bold <?= $item['statut_bg'] ?> <?= $item['statut_text'] ?>">
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

    <div id="modalService" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm hidden items-center justify-center z-50 transition-opacity">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-[550px] overflow-hidden flex flex-col">
            <div class="px-8 py-5 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-[18px] font-bold text-[#1e293b]">Adaugă Intervenție Service</h2>
                <button id="btnInchideModal" class="bg-gray-50 hover:bg-gray-100 text-gray-500 rounded-full p-1.5 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <form id="formAdaugaService" class="p-8">
                <div class="grid grid-cols-2 gap-x-6 gap-y-5 mb-5">
                    <div>
                        <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Selectează Mașina <span class="text-red-500">*</span></label>
                        <select required class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-500 bg-white">
                            <option value="" disabled selected>ex: B 100 ABC</option>
                            <option>Dacia Logan (B 100 ABC)</option><option>Skoda Octavia (CJ 25 XZY)</option><option>Ford Focus (TM 99 WOW)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Data Programării <span class="text-red-500">*</span></label>
                        <input type="date" required class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-700 bg-white">
                    </div>
                    <div>
                        <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Tip Intervenție <span class="text-red-500">*</span></label>
                        <select required class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-700 bg-white">
                            <option>Revizie anuală</option><option>Schimb ulei / filtre</option><option>Reparație motor</option><option>Sistem frânare</option><option>Diagnoză</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Atelier Service</label>
                        <input type="text" placeholder="ex: Auto Center SRL" class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-700 placeholder-gray-400">
                    </div>
                    <div>
                        <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Cost</label>
                        <div class="flex">
                            <input type="text" placeholder="ex: 1500" class="w-full px-3 py-2.5 border border-gray-200 rounded-l-lg border-r-0 text-[14px] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-700 placeholder-gray-400">
                            <span class="inline-flex items-center px-4 bg-[#f8fafc] border border-gray-200 rounded-r-lg text-[13px] font-bold text-gray-500">RON</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Status</label>
                        <div class="relative">
                            <select class="w-full pl-8 pr-4 py-2.5 border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-700 bg-[#fbfcfd] appearance-none">
                                <option>Programat</option><option>În lucru</option><option>Finalizat</option>
                            </select>
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none"><span class="w-2 h-2 rounded-full bg-[#eab308]"></span></div>
                            <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-2">
                    <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Detalii / Note reparație</label>
                    <textarea rows="3" placeholder="Probleme constatate..." class="w-full px-3 py-3 border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-700 placeholder-gray-400 resize-none"></textarea>
                </div>
                
                <div class="flex justify-end gap-3 pt-6 mt-4 border-t border-gray-50">
                    <button type="button" id="btnAnuleaza" class="px-5 py-2.5 text-[14px] font-bold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-lg transition-colors">Anulează</button>
                    <button type="submit" class="px-5 py-2.5 text-[14px] font-bold text-white bg-[#2563eb] hover:bg-blue-700 rounded-lg transition-colors shadow-sm">Salvează Intervenția</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            
            // Logica pentru CĂUTARE
            const searchInput = document.getElementById('searchInput');
            const tableRows = document.querySelectorAll('#tableBody tr');

            searchInput.addEventListener('input', (e) => {
                const term = e.target.value.toLowerCase();
                tableRows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(term) ? '' : 'none';
                });
            });

            // Logica pentru FEREASTRA MODALĂ (Formularul de adăugare)
            const btnAdauga = document.getElementById('btnAdaugaInterventie');
            const modal = document.getElementById('modalService');
            const btnInchideModal = document.getElementById('btnInchideModal');
            const btnAnuleaza = document.getElementById('btnAnuleaza');
            const formAdauga = document.getElementById('formAdaugaService');

            // Deschidere modal
            btnAdauga.addEventListener('click', () => {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });

            // Închidere din X
            btnInchideModal.addEventListener('click', () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });

            // Închidere din butonul Anulează
            btnAnuleaza.addEventListener('click', () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });

            // Închidere dacă dai click pe fundalul întunecat
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }
            });

            // Submit formular
            formAdauga.addEventListener('submit', (e) => {
                e.preventDefault();
                alert('Intervenția service a fost salvată cu succes!');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                formAdauga.reset();
            });
        });
    </script>
</body>
</html>