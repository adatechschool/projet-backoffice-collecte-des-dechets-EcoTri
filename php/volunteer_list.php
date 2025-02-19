<?php
require 'config.php';
// Requête SQL pour récupérer les bénévoles avec la quantité totale de déchets collectés
$sql = '
    SELECT benevoles.id, benevoles.nom, benevoles.email, benevoles.role, 
           ROUND(SUM(COALESCE(dechets_collectes.quantite_kg, 0)), 3) AS QTÉ_Totale
    FROM benevoles
    LEFT JOIN collectes ON benevoles.id = collectes.id_benevole
    LEFT JOIN dechets_collectes ON collectes.id = dechets_collectes.id_collecte
    GROUP BY benevoles.id, benevoles.nom, benevoles.email, benevoles.role
';
// On prépare la requête
$query = $pdo->prepare($sql);
// On exécute la requête
$query->execute();
// On stocke le résultat dans un tableau associatif
$result = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Bénévoles</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900">
<div class="flex h-screen">
    <!-- Barre de navigation -->
    <div class="bg-blue-200 text-black w-100 p-6">
        <h2 class=" font-serif justify-center text-2xl font-bold mb-6 mt-10 px-3">Dashboard</h2>
            <li class = "list-none"><a href="collection_list.php" class="text-xl flex items-center py-5 px-3 hover:bg-blue-400 rounded-lg"><i
                            class="fas fa-tachometer-alt mr-3"></i> Tableau de bord</a></li>
            <li class = "list-none"><a href="collection_add.php" class="text-xl flex items-center py-5 px-3 hover:bg-blue-400 rounded-lg"><i
                            class="fas fa-plus-circle mr-3"></i> Ajouter une collecte</a></li>
            <li class = "list-none"><a href="volunteer_list.php" class="text-xl flex items-center py-5 px-3 hover:bg-blue-400 rounded-lg"><i
                            class="fa-solid fa-list mr-3"></i> Liste des bénévoles</a></li>
            <li class = "list-none">
                <a href="user_add.php" class="text-xl flex items-center py-5 px-3 hover:bg-blue-400 rounded-lg">
                    <i class="fas fa-user-plus mr-3"></i> Ajouter un bénévole
                </a>
            </li>
            <li class = "list-none"><a href="my_account.php" class="text-xl flex items-center py-5 px-3 hover:bg-blue-400 rounded-lg"><i
                            class="fas fa-cogs mr-3"></i> Mon compte</a></li>
        <div class="mt-6">
        <button onclick="logout()" ><a href="login.php" class="text-xl w-full bg-red-600 hover:bg-red-700 text-white py-5 rounded-lg shadow-md">
            Déconnexion </a>
        </button>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="flex-1 p-8 overflow-y-auto">
        <!-- Titre -->
        <h1 class="text-4xl font-bold text-blue-900 mb-6">Liste des Bénévoles</h1>

        <!-- Tableau des bénévoles -->
        <div class="overflow-hidden rounded-lg shadow-lg bg-white">
            <table class="w-full table-auto border-collapse">
                <thead class="bg-blue-400 text-white">
                <tr>
                    <th class="py-3 px-4 text-left">Nom</th>
                    <th class="py-3 px-4 text-left">Email</th>
                    <th class="py-3 px-4 text-left">Rôle</th>
                    <th class="py-3 px-4 text-left">Quantité collectée</th> <!-- Nouvelle colonne -->
                    <th class="py-3 px-4 text-left">Actions</th>
                </tr>
                </thead>

                <tbody class="divide-y divide-gray-300">
                <?php
                    foreach($result as $benevoles){
                ?>

                <tr class="hover:bg-gray-100 transition duration-200">
                    <td class="py-3 px-4"><?= htmlspecialchars($benevoles['nom'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td class="py-3 px-4"><?= htmlspecialchars($benevoles['email'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td class="py-3 px-4"><?= htmlspecialchars($benevoles['role'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td class="py-3 px-4"><?= htmlspecialchars($benevoles['QTÉ_Totale'], ENT_QUOTES, 'UTF-8') ?> kg</td> <!-- Affichage de QTÉ -->
                    <td class="py-3 px-4 flex space-x-2">
<<<<<<< HEAD
                    <a href="volunteer_edit.php?id=<?= $benevoles['id']?>" class="bg-cyan-200 hover:bg-cyan-600 text-white px-4 py-2 rounded-lg shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
=======
                    <a href="volunteer_edit.php?id=<?= $benevoles['id']?>"class="bg-blue-400 hover:bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
>>>>>>> 24c1d3296c6a155b09bbd80943c88e4583df22a7
                            ✏️ Modifier
                        </a>
                        <a href="volunteer_delete.php?id=<?= $benevoles['id'] ?>"
                           class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow-lg focus:outline-none focus:ring-2 focus:ring-red-500 transition duration-200">
                            🗑️ Supprimer
                        </a>
                    </td>
                </tr>
                <?php
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
