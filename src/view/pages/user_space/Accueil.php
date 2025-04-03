<?php

require_once './../../../controller/AuthController.php';
require_once './components/HeaderNavBar.php';
require_once './components/Sidebar.php';

// initialize the HeaderNavBar component with the base path and authentication status
$headerNav = new HeaderNavBar('../../', AuthController::isLoggedIn());
$sidebar = new Sidebar('../../');

?>




<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SoftFootball</title>
    <link rel="stylesheet" href="../../styles/accueil.css" />
    <link rel="stylesheet" href="./../../styles/output.css" />
    
    <!-- href sert à charger les icônes de Font Awesome via une CDN,
     sans avoir besoin de télécharger manuellement les fichiers -->

    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
    <script src="../../javascript/accueil.js"></script>
  </head>
  <body>
    <?php echo  $headerNav->render(); ?>

    <main>
      
    
      <?php echo $sidebar->render(); ?>

        <section id="content">
          <div id="accueil" class="content-section">
            <h2>Match en direct</h2>
            <a href="./match-details.php" target="_blank" class="match-link">
            <section class="live-match">
                <div class="team-info">
                    <img src="../../assets/images/equipes_logo/raja_logo.jpeg" alt="RCA" class="team-logo">
                    <span class="team-name">Raja CA</span>
                </div>
                <div class="match-statistics">
                    <div class="result">
                        <span class="goals">3</span>
                        <div class="time-container">
                            <div class="time-content">
                                <span class="time">16:30 <br>LIVE</span>
                            </div>
                        </div>
                        <span class="goals">1</span>
                    </div>
                    <div class="match-info">
                        <img src="../../assets/images/equipes_logo/stadium image.jpeg" alt="Stadium" class="info-icon">
                        <span class="info">Donor, Casablanca</span>
                        <img src="../../assets/images/equipes_logo/whistle.png" alt="Referee" class="info-icon">
                        <span class="info">Bouchra Karboubi</span>
                    </div>
                </div>
                <div class="team-info">
                    <img src="../../assets/images/equipes_logo/WYDAD_logo.png" alt="WAC" class="team-logo">
                    <span class="team-name">Wydad AC</span>
                </div>
            </section>
          </a>
            <section class="live-match">
                <div class="team-info">
                    <img  src="../../assets/images/equipes_logo/berkane_logo.jpeg" alt="RCA" class="team-logo">
                    <span class="team-name">RS Berkane</span>
                </div>
                <div class="match-statistics">
                    <div class="result">
                        <span class="goals">0</span>
                        <div class="time-container">
                            <div class="time-content">
                                <span class="time">16:00 <br> LIVE</span>
                            </div>
                        </div>
                        <span class="goals">2</span>
                    </div>
                    <div class="match-info">
                        <img src="../../assets/images/equipes_logo/stadium image.jpeg" alt="Stadium" class="info-icon">
                        <span class="info">Moulay Abdallah ,Rabat</span>
                        <img src="../../assets/images/equipes_logo/whistle.png" alt="Referee" class="info-icon">
                        <span class="info">Redoane jayid</span>
                    </div>
                </div>
                <div class="team-info">
                    <img src="../../assets/images/equipes_logo/AS far_logo.jpeg" alt="WAC" class="team-logo">
                    <span class="team-name">AS Far</span>
                </div>
                
            </section>
            <section class="live-matches">
                <h2>Matchs à venir</h2>
                <div class="match">
                    <div class="team-info">
                        <img src="../../assets/images/equipes_logo/AS far_logo.jpeg" alt="AS FAR">
                        <span class="team-name">AS FAR</span>
                    </div>
                    <div class="match-details">
                        <span class="time">20:00</span>
                        <span class="status upcoming">aujourd'hui</span>
                    </div>
                    <div class="team-info">
                        <span class="team-name">Difaa HJ</span>
                        <img src="../../assets/images/equipes_logo/jdida_logo.jpeg" alt="RS Berkane">
                    </div>
                    <div class="stadium"> Stade Moulay Abdallah, Rabat</div>
                </div>
                <div class="match">
                    <div class="team-info">
                        <img src="../../assets/images/equipes_logo/FUS_logo.png" alt="AS FAR">
                        <span class="team-name">Fathe US</span>
                    </div>
                    <div class="match-details">
                        <span class="time">20:00</span>
                        <span class="status upcoming">Demain</span>
                    </div>
                    <div class="team-info">
                        <span class="team-name">HU Agadir</span>
                        <img src="../../assets/images/equipes_logo/HUSA_logo.png" alt="RS Berkane">
                    </div>
                    <div class="stadium"> Stade Moulay Abdallah, Rabat</div>
                </div>
                <div class="match">
                    <div class="team-info">
                        <img src="../../assets/images/equipes_logo/IR tanger_logo.png" alt="AS FAR">
                        <span class="team-name">IR Tanger</span>
                    </div>
                    <div class="match-details">
                        <span class="time">21:00</span>
                        <span class="status upcoming">Demain</span>
                    </div>
                    <div class="team-info">
                        <span class="team-name">US Touarga </span>
                        <img src="../../assets/images/equipes_logo/touarga_logo.png" alt="RS Berkane">
                    </div>
                    <div class="stadium"> Stade Moulay Abdallah, Rabat</div>
                </div>
            
                <div class="match">
                    <div class="team-info">
                        <img src="../../assets/images/equipes_logo/tetouan_logo.png" alt="Wydad AC">
                        <span class="team-name"> M Tetouan</span>
                    </div>
                    <div class="match-details">
                        <span class="time">19:00</span>
                        <span class="status upcoming">Demain</span>
                    </div>
                    <div class="team-info">
                        <span class="team-name">JS Soualem</span>
                        <img src="../../assets/images/equipes_logo/SOUALEM_logo.png" alt="Raja CA">
                    </div>
                    <div class="stadium"> Stade Mohamed V, Casablanca</div>
                </div>
            </section>
            
            <section class="previous-matches">
                <h2>Résultats précédents</h2>
                <div class="result">
                    <span class="team"><img src="../../assets/images/equipes_logo/AS far_logo.jpeg" alt="AS FAR">FAR</span>
                    <span class="score">0 - 2</span>
                    <span class="team"><img src="../../assets/images/equipes_logo/berkane_logo.jpeg" alt="RS Berkane">RSB</span>
                    <span class="status">Full-Time</span>
                    <span class="date">18 Décembre 2022</span>
                </div>
                <div class="result">
                    <span class="team"><img src="../../assets/images/equipes_logo/IR tanger_logo.png" alt="AS FAR"> IRT</span>
                    <span class="score">4 - 1</span>
                    <span class="team"><img src="../../assets/images/equipes_logo/SCCM_logo.png" alt="RS Berkane">SCCM</span>
                    <span class="status">Full-Time</span>
                    <span class="date">17 Décembre 2022</span>
                </div>
                <div class="result">
                    <span class="team"><img src="../../assets/images/equipes_logo/jdida_logo.jpeg" alt="AS FAR">DHJ</span>
                    <span class="score">2 - 2</span>
                    <span class="team"><img src="../../assets/images/equipes_logo/touarga_logo.png" alt="RS Berkane"> TER</span>
                    <span class="status">Full-Time</span>
                    <span class="date">16 Décembre 2022</span>
                </div>
                <div class="result">
                    <span class="team"><img src="../../assets/images/equipes_logo/FUS_logo.png" alt="AS FAR"> FUS</span>
                    <span class="score">5 - 4</span>
                    <span class="team"><img src="../../assets/images/equipes_logo/Zemamra_logo.jpeg" alt="RS Berkane">ZEM</span>
                    <span class="status">Full-Time</span>
                    <span class="date">16 Décembre 2022</span>
                </div>
                <div class="result">
                    <span class="team"><img src="../../assets/images/Resized_logo/berchid.png" alt="AS FAR"> CABJ</span>
                    <span class="score">7 - 0</span>
                    <span class="team"><img src="../../assets/images/equipes_logo/COMD_logo.png" alt="RS Berkane">CODM</span>
                    <span class="status">Full-Time</span>
                    <span class="date">11 Décembre 2022</span>
                </div>
            </section>
            
            
            
        </div>
        <source>
        <div id="classement" class="content-section hidden">
            <section class="league-table">
                <h2>Classement</h2>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Club</th>
                            <th>MP</th>
                            <th>W</th>
                            <th>D</th>
                            <th>L</th>
                            <th>GF</th>
                            <th>GA</th>
                            <th>GD</th>
                            <th>Pts</th>
                            <th>Last 5</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td><img src="../../assets/images/equipes_logo/berkane_logo.jpeg" alt="RSB"> RSB </td>
                            <td>23</td>
                            <td>17</td>
                            <td>5</td>
                            <td>1</td>
                            <td>37</td>
                            <td>9</td>
                            <td>28</td>
                            <td class="points">56</td>
                            <td class="last5">
                              <img src="../../assets/icons_2/done_icon.png" alt="Win">
                              <img src="../../assets/icons_2/minus_icon.jpeg" alt="Draw">
                              <img src="../../assets/icons_2/done_icon.png" alt="Win">
                              <img src="../../assets/icons_2/done_icon.png" alt="Win">
                              <img src="../../assets/icons_2/false_icon.png" alt="Win">
                          </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><img src="../../assets/images/equipes_logo/wydad_logo.png" alt="Wydad AC"> WAC</td>
                            <td>23</td>
                            <td>11</td>
                            <td>8</td>
                            <td>4</td>
                            <td>34</td>
                            <td>21</td>
                            <td>13</td>
                            <td class="points">41</td>
                            <td class="last5">
                              <img src="../../assets/icons_2/done_icon.png" alt="Win">
                              <img src="../../assets/icons_2/minus_icon.jpeg" alt="Draw">
                              <img src="../../assets/icons_2/done_icon.png" alt="Win">
                              <img src="../../assets/icons_2/done_icon.png" alt="Win">
                              <img src="../../assets/icons_2/minus_icon.jpeg" alt="Win">
                          </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><img src="../../assets/images/equipes_logo/Zemamra_logo.jpeg" alt="RCA Zemamra"> CAZ</td>
                            <td>23</td>
                            <td>12</td>
                            <td>4</td>
                            <td>7</td>
                            <td>28</td>
                            <td>19</td>
                            <td>9</td>
                            <td class="points">40</td>
                            <td class="last5">
                              <img src="../../assets/icons_2/false_icon.png" alt="Win">
                              <img src="../../assets/icons_2/false_icon.png" alt="Draw">
                              <img src="../../assets/icons_2/done_icon.png" alt="Win">
                              <img src="../../assets/icons_2/done_icon.png" alt="Win">
                              <img src="../../assets/icons_2/false_icon.png" alt="Win">
                          </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td><img src="../../assets/images/equipes_logo/FUS_logo.png" alt="FUS Rabat"> FUS</td>
                            <td>23</td>
                            <td>11</td>
                            <td>6</td>
                            <td>6</td>
                            <td>35</td>
                            <td>18</td>
                            <td>17</td>
                            <td class="points">39</td>
                            <td class="last5">
                              <img src="../../assets/icons_2/minus_icon.jpeg" alt="Win">
                              <img src="../../assets/icons_2/done_icon.png" alt="Draw">
                              <img src="../../assets/icons_2/done_icon.png" alt="Win">
                              <img src="../../assets/icons_2/false_icon.png" alt="Win">
                              <img src="../../assets/icons_2/done_icon.png" alt="Win">
                          </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td><img src="../../assets/images/equipes_logo/AS far_logo.jpeg" alt="AS FAR">  FAR</td>
                            <td>23</td>
                            <td>10</td>
                            <td>9</td>
                            <td>4</td>
                            <td>34</td>
                            <td>19</td>
                            <td>15</td>
                            <td class="points">39</td>
                           
                            <td class="last5">
                              <img src="../../assets/icons_2/false_icon.png" alt="Win">
                              <img src="../../assets/icons_2/done_icon.png" alt="Win">
                              <img src="../../assets/icons_2/minus_icon.jpeg" alt="Draw">
                              <img src="../../assets/icons_2/done_icon.png" alt="Win">
                              <img src="../../assets/icons_2/minus_icon.jpeg" alt="Draw">
                          </td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td><img src="../../assets/images/equipes_logo/MAS_FES_logo.png" alt="MAS Fès"> MAS</td>
                            <td>23</td>
                            <td>10</td>
                            <td>7</td>
                            <td>6</td>
                            <td>25</td>
                            <td>19</td>
                            <td>6</td>
                            <td class="points">37</td>
                            <!-- <td class="last5">➖ ❌ ✅ ➖ ❌</td> -->
                            <td class="last5">
                              <img src="../../assets/icons_2/done_icon.png" alt="Win">
                              <img src="../../assets/icons_2/minus_icon.jpeg" alt="Draw">
                              <img src="../../assets/icons_2/done_icon.png" alt="Win">
                              <img src="../../assets/icons_2/done_icon.png" alt="Win">
                              <img src="../../assets/icons_2/false_icon.png" alt="Win">
                          </td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td><img src="../../assets/images/equipes_logo/raja_logo.jpeg" alt="Raja CA"> RCA</td>
                            <td>23</td>
                            <td>8</td>
                            <td>9</td>
                            <td>6</td>
                            <td>24</td>
                            <td>20</td>
                            <td>4</td>
                            <td class="points">33</td>
                            <!-- <td class="last5">✅ ✅ ✅ ➖ ✅</td> -->
                            <td class="last5">
                              <img src="../../assets/icons_2/done_icon.png" alt="Win">
                              <img src="../../assets/icons_2/done_icon.png" alt="Win">
                              <img src="../../assets/icons_2/done_icon.png" alt="Win">
                              <img src="../../assets/icons_2/minus_icon.jpeg" alt="Draw">
                              <img src="../../assets/icons_2/done_icon.png" alt="Win">
                          </td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td><img src="../../assets/images/equipes_logo/Safi_logo.jpeg" alt="OC Safi"> OCS</td>
                            <td>23</td>
                            <td>8</td>
                            <td>8</td>
                            <td>7</td>
                            <td>26</td>
                            <td>27</td>
                            <td>-1</td>
                            <td class="points">32</td>
                            <!-- <td class="last5">❌ ✅ ➖ ➖ ➖</td> -->
                            <td class="last5">
                              <img src="../../assets/icons_2/false_icon.png" alt="Win">
                              <img src="../../assets/icons_2/done_icon.png" alt="Win">
                              <img src="../../assets/icons_2/minus_icon.jpeg" alt="Draw">
                              <img src="../../assets/icons_2/minus_icon.jpeg" alt="Draw">
                              <img src="../../assets/icons_2/minus_icon.jpeg" alt="Draw">
                          </td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td><img src="../../assets/images/equipes_logo/jdida_logo.jpeg" alt="Difaâ El Jadidi"> DHJ</td>
                            <td>23</td>
                            <td>8</td>
                            <td>7</td>
                            <td>8</td>
                            <td>27</td>
                            <td>30</td>
                            <td>-3</td>
                            <td class="points">31</td>
                            <td class="last5">❌ ➖ ➖ ➖ ✅</td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td><img src="../../assets/images/equipes_logo/COMD_logo.png" alt="CDM"> CDM</td>
                            <td>23</td>
                            <td>7</td>
                            <td>9</td>
                            <td>7</td>
                            <td>22</td>
                            <td>30</td>
                            <td>-8</td>
                            <td class="points">30</td>
                            <td class="last5">➖ ✅ ✅ ➖ ✅</td>
                        </tr>
                        <!-- Ajoute d'autres équipes si nécessaire -->
                    </tbody>
                </table>
            </section>
        </div>
        <div id="actualite" class="content-section hidden">
          <h2>Dernières Actualités</h2>
          
          <div class="news-container">
              <div class="news-item">
                  <img src="../../assets/images/news/RsbVsWac.jpeg" alt="Match Highlight">
                  <div class="news-content">
                      <h3>RS Berkane s'impose face à Wydad AC</h3>
                      <p>Lors d'un choc en haut du classement, le RSB a battu le Wydad AC 2-1 grâce à un but décisif dans les dernières minutes.</p>
                      <a href="#">Lire plus</a>
                  </div>
              </div>
      
              <div class="news-item">
                  <img src="../../assets/images/news/coach_change.jpeg" alt="Changement d'entraîneur">
                  <div class="news-content">
                      <h3>Changement d'entraîneur au Raja CA</h3>
                      <p>Le Raja Casablanca annonce l'arrivée d'un nouveau coach après une série de mauvais résultats.</p>
                      <a href="#">Lire plus</a>
                  </div>
              </div>
      
              <div class="news-item">
                  <img src="../../assets/images/news/new_transfer.jpeg" alt="Nouveau transfert">
                  <div class="news-content">
                      <h3>Un nouveau renfort pour l'AS FAR</h3>
                      <p>L'AS FAR a officialisé l'arrivée d'un attaquant international pour renforcer son effectif en vue de la fin de saison.</p>
                      <a href="#">Lire plus</a>
                  </div>
              </div>
      
              <div class="news-item">
                  <img src="../../assets/images/news/cup_results.jpeg" alt="Résultats Coupe">
                  <div class="news-content">
                      <h3>Les demi-finales de la Coupe du Trône dévoilées</h3>
                      <p>Les affiches des demi-finales ont été dévoilées avec un duel explosif entre le MAS et le WAC.</p>
                      <a href="#">Lire plus</a>
                  </div>
              </div>
          </div>
      </div>
      
      <div id="sondage" class="content-section hidden">
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
    
        <div id="admin" class="content-section hidden">
          Espace Administrateur
        </div>
      </section>
    </main>
  </body>
</html>
