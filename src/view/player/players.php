<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./../styles/output.css">
    <link rel="stylesheet" href="./../styles/output.css">
    <link rel="stylesheet" href="./../../../assets/icons/fontawesome/css/all.min.css">

    <title>Player Management</title>

</head>
<body>
    <div class="container flex-column ml-7" 
    >
        <div class="p-5 bg-white rounded-lg">
            <h1 class="pl-3 mb-5 text-2xl font-bold text-gray-800 border-l-3 border-l-[var(--main-bg-color)]">OPERATIONS CRUD</h1>
        </div>

            <div class="add-players flex justify-between items-center mb-5">
                <h1 class="text-xl font-semibold text-gray-700 border-l-3 border-l-[var(--main-bg-color)] pl-1">Listes des Joueurs</h1>
                <button class="bg-[var(--main-bg-color)] text-white px-4 py-2 rounded-lg hover:bg-[var(--secondary-color)] hover:text-[var(--main-bg-color)] transition duration-300">
                    <a href="addPlayer.php">Ajouter un joueur</a>
                </button>
            </div>

        <table class="min-w-full border-separate   rounded-lg overflow-hidden">
            <thead class=" " style="color:#ACACAC;">
                <tr>
                    <th class="px-4 py-2">Id</th>
                    <th class="px-4 py-2">Nom</th>
                    <th class="px-4 py-2">Prénom</th>
                    <th class="px-4 py-2">Date de naissance</th>
                    <th class="px-4 py-2">Pied</th>
                    <th class="px-4 py-2">Poid</th>
                    <th class="px-4 py-2">Taille</th>
                    <th class="px-4 py-2">Equip</th>

                </tr>
            </thead>
            <tbody class="">
                <?php
                require __DIR__ . "/../../controller/palyerController.php";
                use controllers\PlayerController;

                foreach(PlayerController::getAll() as $player): ?>
                <tr class="hover:bg-gray-100 transition duration-300 ease-in-out">
                    <td class="pt-5  text-center"><?php echo $player['id_joueur']; ?></td>
                    <td class="pt-5  text-center"><?php echo $player['nom']; ?></td>
                    <td class="pt-5  text-center"><?php echo $player['prenom']; ?></td>
                    <td class="pt-5  text-center"><?php echo $player['date_naissance']; ?></td>
                    <td class="pt-5  text-center"><?php echo $player['pied']; ?></td>
                    <td class="pt-5  text-center"><?php echo $player['poid']; ?></td>
                    <td class="pt-5  text-center"><?php echo $player['taille']; ?></td>
                    <td class="pt-5  text-center"><?php echo $player['equip']; ?></td>
                    
                    <td class="pt-5  text-center">
                        <div class="flex justify-between border border-[var(--main-bg-color)] rounded-[7px] px-1">
                            <button class="text-[var(--main-bg-color)] hover:text-[var(--secondary-color)]"><a href="DeletePlayer.php?id=<?php echo $player['id_joueur']?>"><i class="fa-solid fa-trash " ></i></a></button>
                            <button class="text-[var(--main-bg-color)] hover:text-[var(--secondary-color)]"><a href="modefyPlayer.php?id=<?php echo $player['id_joueur']?>"><i class="fa-solid fa-pen " ></i></a></button>
                        </div>
                    </td>
                    <td class="pt-5  text-center"></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>
</html>