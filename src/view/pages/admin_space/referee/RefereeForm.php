<?php

$refereeId = $refereeFirstName = $refereeLastName = $refereeCountry = $refereeBirthDay = $refereeStartingDate  ='';
$is_update = false;

if (isset($_GET['id'])) {
    $refereeId = $_GET['id'];
    $referee = RefereeController::getRefereeById($refereeId);
    $refereeFirstName = $referee[Referee::$firstName];
    $refereeLastName = $referee[Referee::$lastName];
    $refereeCountry = $referee[Referee::$country_id];
    $refereeBirthDay = $referee[Referee::$birthDate];
    $refereeStartingDate = $referee[Referee::$startingDate];

    $is_update = true;
}
?>

<dialog
    id="clubModal"
    class="p-6 w-[32rem] bg-white shadow-lg rounded-md mx-auto my-auto">
    <form action="RefereeList.php" method="post" id="refereeForm" enctype="multipart/form-data" class="space-y-4">
        <input type="text" name="id" value="<?php echo $refereeId; ?>" hidden />
        <div>
            <label class="block text-sm font-medium" for="first_name">First Name</label>
            <input
                type="text"
                id="first_name"
                name="first_name"
                value="<?php echo $refereeFirstName; ?>"
                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                required />
        </div>
        <div>
            <label class="block text-sm font-medium" for="last_name">Last Name</label>
            <input
                type="text"
                id="last_name"
                name="last_name"
                value="<?php echo $refereeLastName; ?>"
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
                value="<?php echo $refereeBirthDay; ?>"
                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                required>
        </div>
        <div>
            <label for="starting_date" class="block text-sm font-medium">Date de debut</label>
            <input
                type="date"
                dateformat="yyyy-mm-dd"
                name="starting_date"
                id="starting_date"
                value="<?php echo $refereeStartingDate; ?>"
                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                required>
        </div>
        <div>
            <label class="block text-sm font-medium" for="role">Role</label>
            <select name="country_id" id="role" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
                <option value="-1" default disabled selected>
                    Select Country
                </option>
                <?php
                $countries = CountryController::index();
                foreach ($countries as $country) : ?>
                    <option value="<?php echo $country[Country::$id]; ?>" <?php echo $refereeCountry == $country[Country::$id] ? 'selected' : ''; ?>>
                        <?php echo $country[Country::$name]; ?>
                    </option>
                <?php endforeach;
                ?>
            </select>
        </div>
        <div class="flex justify-between">
            <button
                type="submit"
                name="submit"
                class="bg-[#5de967] text-white px-5 py-1 rounded-md hover:bg-[#73ff7d]">
                <?php echo $is_update ? 'Update' : 'Create'; ?>
            </button>
            <a href="RefereeList.php"

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