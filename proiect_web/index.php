<?php require_once 'data.php'; ?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoManager Deluxe - Anvelope</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 flex h-screen overflow-hidden text-gray-800">

    <aside class="w-64 bg-white border-r border-gray-100 flex flex-col h-full shrink-0">
        <div class="h-20 flex items-center px-6 mb-4">
            <div class="flex items-center gap-3 text-blue-600 font-bold text-[15px]">
                <div class="bg-blue-50 p-2 rounded-lg">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                </div>
                AutoManager Deluxe
            </div>
        </div>
    <nav class="flex-1 px-4 flex flex-col gap-1.5">
            <a href="masini.php" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Gestiune mașini</a>
            
            <a href="soferi.php" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Gestiune șoferi</a>
            
            <a href="service.php" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Service auto</a>
            
            <a href="asigurari.php" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Asigurări</a>
            
            <a href="viniete.php" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Viniete</a>
            
            <a href="index.php" class="px-4 py-2.5 text-sm font-bold text-blue-600 bg-blue-50/80 rounded-lg transition-colors mt-2">Anvelope</a>
        </nav>
    </aside>

    <main class="flex-1 flex flex-col h-full overflow-hidden">
        <header class="bg-white h-20 border-b border-gray-100 flex items-center justify-center shrink-0 shadow-sm z-10">
            <h1 class="text-[22px] font-bold text-blue-600">Anvelope</h1>
        </header>

        <div class="flex-1 overflow-y-auto p-8">
            <div class="max-w-6xl mx-auto">
                <div class="flex justify-between items-center mb-6">
                    <div class="relative">
                        <input type="text" placeholder="Caută nr. auto, marcă anvelopă..." class="w-80 pl-4 pr-10 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 placeholder-gray-400 shadow-sm transition-all">
                    </div>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold shadow-sm transition-colors duration-200">
                        Adaugă Set Anvelope
                    </button>
                </div>

                <div class="bg-white border border-gray-100 rounded-xl shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                <th class="px-6 py-5 w-1/5">Mașină</th>
                                <th class="px-6 py-5 w-1/4">Sezon & Detalii</th>
                                <th class="px-6 py-5 w-1/5">Uzură (Stare)</th>
                                <th class="px-6 py-5 w-1/6">Locație</th>
                                <th class="px-6 py-5">Statut</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            <?php foreach($anvelope as $item): ?>
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-5">
                                    <div class="font-bold text-[15px] text-gray-900"><?= $item['masina'] ?></div>
                                    <div class="text-sm text-gray-500 mt-0.5"><?= $item['numar'] ?></div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-[15px] text-gray-800"><?= $item['sezon'] ?></div>
                                    <div class="text-sm text-gray-500 mt-0.5"><?= $item['model_anvelopa'] ?></div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-[15px] text-gray-800"><?= $item['uzura_mm'] ?></div>
                                    <div class="text-sm <?= $item['uzura_culoare'] ?> mt-0.5"><?= $item['uzura_text'] ?></div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-[15px] text-gray-800"><?= $item['locatie'] ?></div>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md text-xs font-bold <?= $item['statut_bg'] ?> <?= $item['statut_text'] ?>">
                                        <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                        <?= $item['statut_label'] ?>
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

    <script src="script.js"></script>
</body>
</html>