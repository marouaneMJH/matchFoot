<?php

$clubName = '';
$clubNickname = '';
$clubStadeName = '';
$clubTrainerName = '';
$clubCreationDate = '';
$clubLogoPath = '';
$clubId = '';
$is_update = false;


if (isset($_GET['id'])) {
    $club = ClubController::getClubById($_GET['id']);

    $clubId = $club[Club::$id];
    $clubName = $club[Club::$name];
    $clubNickname = $club[Club::$nickname];
    $clubStadeName = $club['stadium'][Stadium::$name];
    $clubCreationDate = $club[Club::$founded_at];
    $clubLogoPath = $club['logo'];
    $is_update = true;



}

?>


<dialog
    id="clubModal"
    class="p-6 w-[32rem] bg-white shadow-lg rounded-md mx-auto my-auto">
    <form action="ClubList.php" method="post" id="clubForm" enctype="multipart/form-data" class="space-y-4">
        <input type="text" name="id" value="<?php echo $clubId; ?>" hidden />
        <div>
            <label class="block text-sm font-medium" for="name">Club Name</label>
            <input
                type="text"
                id="name"
                name="name"
                value="<?php echo $clubName; ?>"
                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                required />
        </div>
        <div>
            <label class="block text-sm font-medium" for="nickname">Nickname</label>
            <input
                type="text"
                id="nickname"
                name="nickname"
                value="<?php echo $clubNickname; ?>"
                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                required />
        </div>
        <div>
            <label class="block text-sm font-medium" for="staedname">Stade Name</label>

            <select name="stade_id" id="stade_id" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                <option value="-1" default disabled selected>
                    Select Stade
                </option>
                <?php
                $stades = StadiumController::index();
                var_dump($stades);
                foreach ($stades as $stade):?>
                    <option value="<?php echo $stade[Stadium::$id]; ?>" <?php echo isset($clubStadeName) && $clubStadeName == $stade[Stadium::$name] ? 'selected' : ''; ?>>
                        <?php echo $stade[Stadium::$name]; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium" for="staedname">Trainer Name</label>

            <select name="stade_id" id="stade_id" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                <option value="-1" default disabled selected>
                    Select Trainer
                </option>
                <?php
                
                foreach ($trainers as $trainer):?>
                    <option value="<?php echo $trainer[Staff::$id]; ?>" <?php echo isset($clubTrainerName) && $clubTrainerName == $trainer[Staff::$lastName] ? 'selected' : ''; ?>>
                        <?php echo $trainer[Staff::$lastName]; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium" for="logo">Creation Date</label>
            <input
                type="text"
                id="creation_date"
                oninput="this.value = this.value.replace(/\D/g, '').slice(0, 4)"
                name="founded_at"
                value="<?php echo $clubCreationDate; ?>"
                class="w-full px-3 py-2 border rounded-md" />
        </div>

        <div>
            <label class="block text-sm font-medium" for="logo">Club Logo</label>
            <input
                type="file"
                id="logo"
                name="logo"
                
                class="w-full px-3 py-2 border rounded-md"
                accept="image/*" />
        </div>

        <div class="flex justify-between">
            <button
                type="submit"
                name="submit"
                class="bg-[#5de967] text-white px-5 py-1 rounded-md hover:bg-[#73ff7d]">
                <?php echo $is_update ? 'Update' : 'Create'; ?>
            </button>
            <a href="ClubList.php"
                
                id="closeModal"
                class="bg-red-500 text-white px-5 py-1 rounded ">
                Close
                </a>
        </div>
    </form>
</dialog>



<script>
    const modal = document.getElementById("clubModal");
    // document
    //   .getElementById("openModal")
    //   .addEventListener("click", () => modal.showModal());
    // document
    //   .getElementById("closeModal")
    //   .addEventListener("click", () => modal.close());


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