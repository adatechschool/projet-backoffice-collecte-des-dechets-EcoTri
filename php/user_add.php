<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = $_POST["nom"];
    $email = $_POST["email"];
    $mot_de_passe = $_POST["mot_de_passe"];
    $role = $_POST["role"];
    
    // Insérer la collecte avec le bénévole sélectionné
    $sql = $pdo-> prepare("INSERT INTO benevoles(nom, email, mot_de_passe, role) VALUES ('$nom', '$email','$mot_de_passe','$role')");
    $sql->execute();

    header("Location: volunteer_list.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Bénévole</title>
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
            <li class = "list-none"><a href="my_account.php" class="text-xl flex items-center py-5 px-3 hover:bg-blue-400 rounded-lg"><i
                            class="fas fa-cogs mr-3"></i> Mon compte</a></li>

        <div class="mt-6">
        <button onclick="logout()" ><a href="login.php" class="text-xl w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow-md">
         Déconnexion </a></button>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="flex-1 p-8 overflow-y-auto mt-20">
        <h1 class="text-4xl font-bold text-blue-900 mb-6 max-w-lg mx-auto">Ajouter un Bénévole</h1>

        <!-- Formulaire d'ajout -->
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg mx-auto">
            <form action="user_add.php" method="POST">
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Nom</label>
                    <input type="text" name="nom"
                           class="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Nom du bénévole" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Email</label>
                    <input type="email" name="email"
                           class="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Email du bénévole" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Mot de passe</label>
                    <input type="password" name="mot_de_passe"
                           class="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Mot de passe" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Rôle</label>
                    <select name="role"
                            class="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="participant">Participant</option>
                        <option value="admin">Admin</option>

                    </select>
                </div>

                <div class="mt-6">
                    <button
                            type="submit"
                            class="w-full bg-blue-400 hover:bg-blue-500 text-white py-3 rounded-lg shadow-md font-semibold">
                        Ajouter le bénévole
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>





