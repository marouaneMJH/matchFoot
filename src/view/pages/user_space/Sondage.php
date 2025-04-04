<div id="sondage" class="content-section overflow-auto w-[95%] h-[80vh]">
    <h2>Participez aux Sondages</h2>

    <div class="poll-container">
        <!-- Sondage 1 -->
        <div class="poll">
            <h3>Qui remportera la Botola Pro cette saison ?</h3>
            <form>
                <label><input type="radio" name="champion" value="RSB"> RSB Berkane</label>
                <label><input type="radio" name="champion" value="WAC"> Wydad AC</label>
                <label><input type="radio" name="champion" value="FAR"> AS FAR</label>
                <label><input type="radio" name="champion" value="Raja"> Raja CA</label>
                <button type="button" onclick="submitVote(this)">Votez</button>
            </form>
        </div>

        <!-- Sondage 2 -->
        <div class="poll">
            <h3>Quel est le meilleur joueur de la saison ?</h3>
            <form>
                <label><input type="radio" name="best_player" value="Joueur1"> Anas Zniti</label>
                <label><input type="radio" name="best_player" value="Joueur2"> Yahya Jabrane</label>
                <label><input type="radio" name="best_player" value="Joueur3"> Reda Jaadi</label>
                <label><input type="radio" name="best_player" value="Joueur4"> Tarik Tissoudali</label>
                <button type="button" onclick="submitVote(this)">Votez</button>
            </form>
        </div>
    </div>

    <div id="poll-results" class="hidden">
        <h3>Merci pour votre vote !</h3>
        <p>Les résultats seront publiés prochainement.</p>
    </div>

</div>