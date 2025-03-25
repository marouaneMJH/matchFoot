
const formations = {
    "4-2-3-1": [
        ["GK"],
        ["LB", "CB1", "CB2", "RB"],
        ["CDM1", "CDM2"],
        ["LM", "CAM", "RM"],
        ["ST"]
    ],
    "3-4-2-1": [
        ["GK"],
        ["CB1", "CB2", "CB3"],
        ["LM", "CM1", "CM2", "RM"],
        ["CAM1", "CAM2"],
        ["ST"]
    ]
};

function renderFormation(formation, containerSelector, isReversed = false) {
    const container = document.querySelector(containerSelector);
    container.innerHTML = "";

    let rows = formations[formation].map(line => {
        const rowDiv = document.createElement("div");
        rowDiv.className = "row";
        rowDiv.style.display = "flex";
        rowDiv.style.justifyContent = "center";
        rowDiv.style.gap = "40px"; // Augmenter l'espace entre les joueurs
        rowDiv.style.margin = "45px"; // Augmenter l'espacement vertical
        rowDiv.style.fontFamily = "Arial, sans-serif"; // Modifier le font-family
        

        line.forEach(position => {
            const playerDiv = document.createElement("div");
            playerDiv.className = "pos";
            playerDiv.innerText = position;
            rowDiv.appendChild(playerDiv);
        });

        return rowDiv;
    });

    // Si l'équipe doit être inversée, on inverse l'ordre des lignes
    if (isReversed) {
        rows.reverse();
    }

    rows.forEach(row => container.appendChild(row));
}

document.addEventListener("DOMContentLoaded", () => {
    renderFormation("4-2-3-1", ".team.home.pitchPositonsContainer");
    renderFormation("3-4-2-1", ".team.away.pitchPositonsContainer", true); // Inverser l'équipe du bas
});

