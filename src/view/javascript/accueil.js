document.addEventListener("DOMContentLoaded", function () {
    const menuItems = document.querySelectorAll("#menu li");
    const contentSections = document.querySelectorAll(".content-section");

    menuItems.forEach(item => {
        item.addEventListener("click", function () {
            // Retirer 'active' de tous les items
            menuItems.forEach(li => li.classList.remove("active"));

            // Ajouter 'active' à l'élément cliqué
            this.classList.add("active");

            // Cacher toutes les sections
            contentSections.forEach(section => section.classList.add("hidden"));

            // Afficher la section correspondante
            const sectionId = this.getAttribute("data-content");
            document.getElementById(sectionId).classList.remove("hidden");
        });
    });
});


function submitVote(button) {
    // Désactiver les options après le vote
    let form = button.closest("form");
    let inputs = form.querySelectorAll("input[type='radio']");
    inputs.forEach(input => input.disabled = true);

    // Afficher un message de confirmation
    document.getElementById("poll-results").classList.remove("hidden");

    // Désactiver le bouton après le vote
    button.disabled = true;
    button.innerText = "Vote enregistré";
}
