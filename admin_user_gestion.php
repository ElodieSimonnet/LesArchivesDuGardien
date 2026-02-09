<?php
require_once 'components/utils/db_connection.php';
require_once 'components/utils/is_admin.php';
restrictToAdmin();
?>
<?php include 'retrieveAllUsersData.php';?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/phosphor-icons"></script>
    <link href="assets/css/output.css" rel="stylesheet">
    <title>Gestion des utilisateurs</title>
</head>
<body>
    <?php include 'components/admin_sidebar.php'; ?>
      <main class="flex-1 overflow-y-auto bg-[url(../images/lava_cave_mobile.jpg)] bg-cover bg-center lg:bg-[url(../images/lava_cave.jpg)] bg-fixed text-primary-white font-sans p-4 lg:p-8 lg:ml-64">
        
        <div class="flex justify-center mb-10 mt-4">
          <h2 class="px-8 lg:px-16 py-3 border-2 border-primary-orange bg-[#1a0f0a] text-primary-orange font-bold uppercase tracking-[0.2em] shadow-2xl rounded-lg text-center">
            Gestion des Utilisateurs
          </h2>
        </div>

        <section class="max-w-7xl mx-auto w-full">
          <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 mb-6 bg-[#1a0f0a] p-3 border-t border-b border-primary-orange">
            <div class="lg:col-span-6 relative">
              <span class="absolute left-3 top-2.5 text-primary-orange">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
              </span>
              <input type="text" placeholder="Rechercher un utilisateur" class="w-full bg-black/40 border border-amber-900/70 rounded-md py-2 pl-10 pr-4 text-sm focus:outline-none focus:border-primary-orange text-amber-100">
            </div>
            <div class="lg:col-span-3 relative">
              <span class="absolute left-3 top-2.5 text-primary-orange">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                    </svg>
              </span>
              <input type="text" placeholder="Filtrer" class="w-full bg-black/40 border border-amber-900/70 rounded-md py-2 pl-10 pr-4 text-sm text-amber-100 outline-none focus:outline-none focus:border-primary-orange transition-all">
            </div>
            <button class="lg:col-span-3 bg-amber-500 hover:bg-amber-400 text-black font-black py-2 rounded uppercase text-xs tracking-tighter flex items-center justify-center gap-2 transition-transform active:scale-95 shadow-lg shadow-amber-500/20">
              <span class="text-lg">+</span> NOUVEL UTILISATEUR
            </button>
          </div>

          <div role="table" class="w-full border border-primary-orange rounded-lg bg-[#1a0f0a] overflow-hidden">
            <div role="rowgroup" class="hidden lg:block border-b border-primary-orange bg-[#1a0f0a]">
              <div role="row" class="grid grid-cols-12 py-4 text-[11px] font-black uppercase tracking-widest text-primary-orange">
                <div role="columnheader" class="col-span-2 text-center lg:border-r-2 lg:border-transparent">ID</div>
                <div role="columnheader" class="col-span-2 text-center lg:border-r-2 lg:border-transparent">Nom</div>
                <div role="columnheader" class="col-span-3 text-center lg:border-r-2 lg:border-transparent">Email</div>
                <div role="columnheader" class="col-span-2 text-center lg:border-r-2 lg:border-transparent">Dernière Connexion</div>
                <div role="columnheader" class="col-span-1 text-center lg:border-r-2 lg:border-transparent">Statut</div>
                <div role="columnheader" class="col-span-2 text-center lg:border-r-2 lg:border-transparent">Actions</div>
              </div>
            </div>

            <div role="rowgroup" class="flex flex-col divide-y divide-amber-900/20">
                <?php foreach ($all_users as $userRow) : ?>
                    <div role="row" class="flex flex-col lg:grid lg:grid-cols-12 bg-row-dark lg:items-stretch border-b border-primary-orange gap-3 lg:gap-0 p-5 lg:p-0 hover:bg-amber-500/5 transition-all group">
                        
                        <div role="cell" class="lg:col-span-2 lg:p-4 flex justify-between lg:justify-center items-center lg:border-r-2 lg:border-dotted lg:border-primary-orange">
                            <span class="lg:hidden text-[12px] font-bold text-primary-orange uppercase">ID</span>
                            <span class="font-bold text-primary-white"><?php echo htmlspecialchars($userRow['id']); ?></span>
                        </div>

                        <div role="cell" class="lg:col-span-2 lg:p-4 flex justify-between lg:justify-center items-center lg:border-r-2 lg:border-dotted lg:border-primary-orange">
                            <span class="lg:hidden text-[12px] font-bold text-primary-orange uppercase">Nom</span>
                            <span class="font-bold text-primary-white"><?php echo htmlspecialchars($userRow['username']); ?></span>
                        </div>

                        <div role="cell" class="lg:col-span-3 lg:p-4 flex justify-between lg:justify-center items-center lg:border-r-2 lg:border-dotted lg:border-primary-orange overflow-hidden">
                            <span class="lg:hidden text-[12px] font-bold text-primary-orange uppercase">Email</span>
                            <span class="text-primary-white text-base truncate px-2"><?php echo htmlspecialchars($userRow['email']); ?></span>
                        </div>

                        <div role="cell" class="lg:col-span-2 lg:p-4 flex justify-between lg:justify-center items-center lg:border-r-2 lg:border-dotted lg:border-primary-orange">
                            <span class="lg:hidden text-[12px] font-bold text-primary-orange uppercase">Connexion</span>
                            <span class="text-base text-primary-white">
                                <?php echo !empty($userRow['last_login']) ? htmlspecialchars($userRow['last_login']) : 'Jamais'; ?>
                            </span>
                        </div>

                        <div role="cell" class="lg:col-span-1 lg:p-4 flex justify-between lg:justify-center items-center lg:border-r-2 lg:border-dotted lg:border-primary-orange">
                            <span class="lg:hidden text-[12px] font-bold text-primary-orange uppercase">Statut</span>
                            <?php 
                                $currentStatus = $userRow['status']; 
                                
                                // On définit la couleur selon la valeur texte récupérée en BDD
                                $statusColor = 'text-green-500'; // Par défaut (Actif)
                                if ($currentStatus === 'Suspendu') $statusColor = 'text-primary-orange';
                                if ($currentStatus === 'Banni') $statusColor = 'text-red-500'; 
                            ?>
                            <span class="font-black text-[12px] <?php echo $statusColor; ?> uppercase tracking-widest">
                                <?php echo htmlspecialchars($currentStatus); ?>
                            </span>
                        </div>

                        <div role="cell" class="lg:col-span-2 lg:p-4 flex justify-end lg:justify-center items-center gap-3">
                            <a href="edit_user.php?id=<?php echo $userRow['id']; ?>" class="p-2 border border-primary-orange rounded text-primary-orange hover:bg-primary-orange hover:text-black transition-all">
                                <i class="ph ph-pencil-simple text-3xl"></i>
                            </a>
                            <a href="delete_user.php?id=<?php echo $userRow['id']; ?>" onclick="return confirm('Supprimer cet utilisateur ?')" class="p-2 border border-primary-orange rounded text-primary-orange hover:bg-red-600 transition-all hover:border-none hover:text-black ">
                                <i class="ph ph-trash text-3xl"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <div class="w-full flex justify-center mt-12 mb-8">
                <nav class="flex items-center gap-2 md:gap-3" aria-label="Pagination">
        
                    <!-- <a href="#" class="flex items-center justify-center w-10 h-10 md:w-12 md:h-12 bg-primary-black border-2 border-primary-orange/70 rounded-xl text-primary-white hover:border-primary-orange transition-all group"> 
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>-->

                    <a href="#" class="flex items-center justify-center w-10 h-10 md:w-12 md:h-12 bg-primary-black border-2 border-primary-orange rounded-xl text-primary-white font-black text-lg md:text-xl shadow-[0_0_15px_rgba(249,115,22,0.4)]">
                        1
                    </a>

                    <a href="#" class="flex items-center justify-center w-10 h-10 md:w-12 md:h-12 bg-primary-black border-2 border-primary-orange/40 rounded-xl text-primary-white font-black text-lg md:text-xl hover:border-primary-orange transition-all">
                        2
                    </a>

                    <div class="flex items-end gap-1 px-1 h-10 md:h-12 pb-2">
                        <span class="w-2 h-2 bg-primary-black rounded-full"></span>
                        <span class="w-2 h-2 bg-primary-black rounded-full"></span>
                        <span class="w-2 h-2 bg-primary-black rounded-full"></span>
                    </div>

                    <a href="#" class="flex items-center justify-center w-10 h-10 md:w-12 md:h-12 bg-primary-black border-2 border-primary-orange/40 rounded-xl text-primary-white font-black text-lg md:text-xl hover:border-primary-orange transition-all">
                    15
                    </a>

                    <a href="#" class="flex items-center justify-center w-10 h-10 md:w-12 md:h-12 bg-primary-black border-2 border-primary-orange/40 rounded-xl text-primary-white hover:border-primary-orange transition-all group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>

                </nav>
            </div>
      </main>
    </div>
  </div>
</body>