

function submitVote(button) {
  // Désactiver les options après le vote
  let form = button.closest("form");
  let inputs = form.querySelectorAll("input[type='radio']");
  inputs.forEach((input) => (input.disabled = true));

  // Afficher un message de confirmation
  document.getElementById("poll-results").classList.remove("hidden");

  // Désactiver le bouton après le vote
  button.disabled = true;
  button.innerText = "Vote enregistré";
}
