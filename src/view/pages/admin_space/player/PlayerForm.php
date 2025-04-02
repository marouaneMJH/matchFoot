<?php

$playerId = '';
$playerFirstName = '';
$playerLastName = '';
$playerBirthDay = '';
$playerTaille = '';
$playerPoids = '';
$playerFoot = '';
$playerClub = '';
$playerCountry = '';
$playerPosition = '';
$is_update = false;


if (isset($_GET['id'])) {
    $playerId = $_GET['id'];
    $player = PlayerController::getPlayerById($playerId);
    $playerFirstName = $player[Player::$firstName];
    $playerLastName = $player[Player::$lastName];
    $playerBirthDay = $player[Player::$birthDate];
    $playerTaille = $player[Player::$height];
    $playerPoids = $player[Player::$weight];
    $playerFoot = $player[Player::$foot];
    $playerClub = $player[Player::$clubId];
    $playerCountry = $player[Player::$countryId];
    $playerPosition = $player[Player::$positionId];

    $is_update = true;
}
?>

<dialog
    id="clubModal"
    class="p-6 w-[32rem] bg-white shadow-lg rounded-md mx-auto my-auto">
    <form action="PlayerList.php" method="post" id="playerForm" enctype="multipart/form-data" class="space-y-4">
        <input type="text" name="id" value="<?php echo $playerId; ?>" hidden />
        <div>
            <label class="block text-sm font-medium" for="first_name">First Name</label>
            <input
                type="text"
                id="first_name"
                name="first_name"
                value="<?php echo $playerFirstName; ?>"
                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                required />
        </div>
        <div>
            <label class="block text-sm font-medium" for="last_name">Last Name</label>
            <input
                type="text"
                id="last_name"
                name="last_name"
                value="<?php echo $playerLastName; ?>"
                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                required />
        </div>
        <div>
            <label for="birth_date" class="block text-sm font-medium">Date Naissance</label>
            <input
                type="date"
                dateformat="yyyy-mm-dd"
                name="birth_date"
                id="birth_date"
                value="<?php echo $playerBirthDay; ?>"
                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                required>
        </div>
        <div>
            <label class="block text-sm font-medium" for="taille">Taille</label>
            <input
                type="number"
                id="taille"
                name="height"
                value="<?php echo $playerTaille; ?>"
                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                required />
        </div>
        <div>
            <label class="block text-sm font-medium" for="poids">Poids</label>
            <input
                type="number"    
                id="poids"
                name="weight"
                value="<?php echo $playerPoids; ?>"
                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                required />
        </div>
        <div>
            <label class="block text-sm font-medium" for="foot">Foot</label>
            <select name="foot" id="foot" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
                <option value="-1" default disabled selected>
                    Select Foot
                </option>
                <option value="L" <?php echo $playerFoot == 'L' ? 'selected' : ''; ?>>Left</option>
                <option value="R" <?php echo $playerFoot == 'R' ? 'selected' : ''; ?>>Right</option>
                <option value="B" <?php echo $playerFoot == 'B' ? 'selected' : ''; ?>>Both</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium" for="club">Club</label>
            <select name="club" id="club" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
                <option value="-1" default disabled selected>
                    Select Club
                </option>
                <?php
                $clubs = ClubController::index();
                foreach ($clubs as $club) : ?>
                    <option value="<?php echo $club[Club::$id]; ?>" <?php echo $playerClub == $club[Club::$id] ? 'selected' : ''; ?>>
                        <?php echo $club[Club::$name]; ?>
                    </option>
                <?php endforeach;
                ?>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium" for="country">Country</label>
            <select name="country" id="country" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
                <option value="-1" default disabled selected>
                    Select Country
                </option>
                <?php
                $countries = CountryController::index();
                foreach ($countries as $country) : ?>
                    <option value="<?php echo $country[Country::$id]; ?>" <?php echo $playerCountry == $country[Country::$id] ? 'selected' : ''; ?>>
                        <?php echo $country[Country::$name]; ?>
                    </option>
                <?php endforeach;
                ?>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium" for="position">Position</label>
            <select name="position" id="position" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
                <option value="-1" default disabled selected>
                    Select Position
                </option>
                <?php
                $positions = PositionController::index();
                foreach ($positions as $position) : ?>
                    <option value="<?php echo $position[Position::$id]; ?>" <?php echo $playerPosition == $position[Position::$id] ? 'selected' : ''; ?>>
                        <?php echo $position[Position::$name]; ?>
                    </option>
                <?php endforeach;
                ?>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium" for="image">Image</label>
            <input
                type="file"
                id="image"
                name="profile"
                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                />
        </div>
        <div class="flex justify-between">
            <button
                type="submit"
                name="submit"
                class="bg-[#5de967] text-white px-5 py-1 rounded-md hover:bg-[#73ff7d]">
                <?php echo $is_update ? 'Update' : 'Create'; ?>
            </button>
            <a href="PlayerList.php"

                id="closeModal"
                class="bg-red-500 text-white px-5 py-1 rounded ">
                Close
            </a>
        </div>
    </form>
</dialog>



<script>
    const modal = document.getElementById("clubModal");


    const creationField = document.getElementById("creation_date");
    creationField.addEventListener("change", (e) => {
        const digit = e.target.value();
        if (digit.length > 4) {
            e.target.value = digit.slice(0, 4);
        }
    });
</script>
<?php
if (isset($_GET['showModal'])) {
    echo '<script>modal.showModal();</script>';
}
?>