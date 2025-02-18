<?php
require 'config.php';

// Vérifier si un ID de collecte est fourni
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: collection_list.php");
    exit;
}

$id = $_GET['id'];

// Récupérer les informations de la collecte
$stmt = $pdo->prepare("
SELECT 
	dechets_collectes.id,
	dechets_collectes.type_dechet,
    dechets_collectes.quantite_kg,
 	collectes.date_collecte,
    collectes.lieu,
    collectes.id_benevole,
    collectes.id AS collecte_id,
    benevoles.nom
FROM `dechets_collectes`
INNER JOIN collectes  ON dechets_collectes.id_collecte = collectes.id
INNER JOIN benevoles ON collectes.id_benevole = benevoles.id
WHERE dechets_collectes.id = ?
");
$stmt->execute([$id]);
$collecte = $stmt->fetch();


if (!$collecte) {
    header("Location: collection_list.php");
    exit;
}

// Récupérer la liste des bénévoles
$stmt_benevoles = $pdo->prepare("SELECT id, nom FROM benevoles ORDER BY nom");
$stmt_benevoles->execute();
$benevoles = $stmt_benevoles->fetchAll();

// Mettre à jour la collecte_list
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $date = $_POST["date"];
    $lieu = $_POST["lieu"];
    $benevole_id = $_POST["benevole"]; // Récupérer l'ID du bénévole sélectionné
    
    $stmt = $pdo->prepare("
    UPDATE collectes
    SET collectes.date_collecte = ?,
        collectes.lieu = ?,
        collectes.id_benevole = ?
    WHERE collectes.id = ?
    ");
    $stmt->execute([$date, $lieu, $benevole_id, $collecte['collecte_id']]);

    $type_dechet = $_POST["type_dechet"];
    $quantite_kg = $_POST["quantite_kg"];

    $stmt_dechets_collectes = $pdo->prepare("
    UPDATE dechets_collectes
    SET dechets_collectes.type_dechet = ?,
        dechets_collectes.quantite_kg = ?
    WHERE dechets_collectes.id = ?
    ");
    $stmt_dechets_collectes->execute([$type_dechet, $quantite_kg,$collecte['id']]);
    
    header("Location: collection_list.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une collecte</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">

</head>
<body class="bg-gray-100 text-gray-900">
<div class="flex h-screen">
    <!-- Dashboard -->
    <div class="bg-blue-200 text-black w-100 p-6">
        <h2 class="font-serif justify-center text-2xl font-bold mb-6 mt-10 px-3">Dashboard</h2>

            <li class = "list-none" ><a href="collection_list.php" class="text-xl flex items-center py-5 px-3 hover:bg-blue-400 rounded-lg"><i class="fas fa-tachometer-alt mr-3"></i> Tableau de bord</a></li>
            <li class = "list-none" ><a href="volunteer_list.php" class="text-xl flex items-center py-5 px-3 hover:bg-blue-400 rounded-lg"><i class="fa-solid fa-list mr-3"></i> Liste des bénévoles</a></li>
            <li class = "list-none" >
                <a href="user_add.php" class="text-xl flex items-center py-5 px-3 hover:bg-blue-400 rounded-lg">
                    <i class="fas fa-user-plus mr-3"></i> Ajouter un bénévole
                </a>
            </li>
            <li class = "list-none" ><a href="my_account.php" class="text-xl flex items-center py-5 px-3 hover:bg-blue-400 rounded-lg"><i class="fas fa-cogs mr-3"></i> Mon compte</a></li>

        <div class="mt-6">
            <button onclick="logout()" class="text-xl w-full bg-red-600 hover:bg-red-700 text-white py-5 rounded-lg shadow-md">
                Déconnexion
            </button>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="flex-1  items-center p-10 pt-10 overflow-y-auto">
        <h1 class="text-4xl font-bold text-blue-900 mb-6">Modifier une collecte</h1>

        <!-- Formulaire -->
        <div class="w-400 bg-white p-6 rounded-lg shadow-lg">
            <form method="POST" class="space-y-4 grid grid-cols-2 gap-4">
                <div class = "col-span-2">
                    <label class="block text-md font-medium text-gray-700"> Date :</label>
                    <input type="date" name="date" value="<?= htmlspecialchars($collecte['date_collecte']) ?>" required
                           class="w-full p-2 border border-gray-300 rounded-lg">
                </div>
                <div class = "col-span-2">
                    <label class="block text-md font-medium text-gray-700">Lieu :</label>
                    <input type="text" name="lieu" value="<?= htmlspecialchars($collecte['lieu']) ?>" required
                           class="w-full p-2 border border-gray-300 rounded-lg">
                </div>

                <div>
                    <label class="block text-md font-medium text-gray-700">Type de déchets collectés :</label>
                    <input 
                        type="text"
                        name="type_dechet"
                        value="<?= htmlspecialchars($collecte['type_dechet']) ?>" 
                           class="w-full p-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-md font-medium text-gray-700">Quantité collectée :</label>
                    <input 
                        type="text" 
                        name="quantite_kg"
                        value="<?= htmlspecialchars($collecte['quantite_kg']) ?>" 
                        class="w-full p-2 border border-gray-300 rounded-lg">
                </div>

                <!--<div>
                <label class="block text-md font-medium text-gray-700">Type de déchet :</label>
                <select name="type_dechet" required
                        class="w-full p-2 border border-gray-300 rounded-lg">
                        <option value="" disabled selected>Sélectionnez un type de déchet</option>
                        <option value="plastique">Plastique</option>
                        <option value="verre" >Verre</option>
                        <option value="metal" >Métal</option>
                        <option value="papier" >Papier</option>
                        <option value="organique" >Organique</option>
                    </select>
                </div>

                <div>
                    <label class="block text-md font-medium text-gray-700">Quantité :</label>
                    <input type="text" name="quantite_kg" 
                           class="w-full p-2 border border-gray-300 rounded-lg">
                </div>-->

                <div class = "col-span-2">
                    <label class="block text-md font-medium text-gray-700">Bénévole :</label>
                    <select name="benevole" required
                            class="w-full p-2 border border-gray-300 rounded-lg">
                        <option value="" disabled selected>Sélectionnez un·e bénévole</option>
                        <?php foreach ($benevoles as $benevole): ?>
                            <option value="<?= $benevole['id'] ?>" <?= $benevole['id'] == $collecte['id_benevole'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($benevole['nom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="flex justify-end space-x-4">
                    <a href="collection_list.php" class="bg-gray-500 text-white px-4 py-2 rounded-lg">Annuler</a>
                    <button type="submit" class="bg-blue-400 hover:bg-blue-500 text-white px-4 py-2 rounded-lg">Modifier</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
