<div id="actualite" class="content-section overflow-auto w-[95%] h-[80vh]">
        <h2>Dernières Actualités</h2>

        <div class="news-container">
          <?php
          require_once __DIR__ . '/../../../controller/NewsController.php';

          $news = NewsController::index();
          if (empty($news)) {
            echo "Aucune actualité disponible.";
          } else {
            foreach ($news as $newsItem):
                if ($newsItem[News::$status] == 'draft') {
                  continue;
                }
              ?>

              <div class="w-full mx-auto bg-white rounded-xl overflow-hidden shadow-md mb-4 hover:shadow-lg transition-shadow duration-300 border border-gray-100">
                <!-- Image and Status Badge -->
                <div class="flex flex-col md:flex-row">
                  <div class="relative md:w-1/3 overflow-hidden group">
                    <img
                      src="<?php echo isset($newsItem['image']) ? $newsItem['image'] : 'http://efoot/logo?file=img-placeholder.png&dir=image_placeholder'; ?>"
                      alt="Article actualite image" class="w-full h-40 md:h-48 object-cover object-center transform transition-transform duration-500 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute top-2 right-2 bg-gradient-to-r from-green-500 to-green-600 text-white px-2 py-0.5 rounded-full text-xs font-medium shadow-sm">
                      <?php echo $newsItem[News::$status] ?>
                    </div>
                  </div>

                  <!-- Article Content -->
                  <div class="p-4 md:w-2/3 flex flex-col justify-between">
                    <div>
                      <div class="flex items-center justify-between mb-2">
                        <span class="bg-green-50 text-green-700 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                          <?php echo $newsItem[News::$category] ?>
                        </span>
                        <time class="text-gray-500 text-xs flex items-center">
                          <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                          </svg>
                          <?php echo $newsItem[News::$date] ?>
                        </time>
                      </div>

                      <h1 class="text-lg font-bold text-gray-800 mb-2 hover:text-green-600 transition-colors">
                        <?php echo $newsItem[News::$title] ?>
                      </h1>

                      <div class="prose max-w-none text-gray-600 text-sm line-clamp-2">
                        <p><?php echo $newsItem[News::$content] ?></p>
                      </div>
                    </div>

                    <div class="mt-3 pt-2 border-t border-gray-100 flex justify-between items-center">
                      <button
                        class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white text-xs font-medium py-1.5 px-3 rounded-lg transition duration-300 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                        </svg>
                        Share
                      </button>

                      <div class="flex space-x-3">
                        <button id="bookmark-btn-<?php echo $newsItem[News::$id] ?>" class="text-gray-400 hover:text-green-600 transition-colors" aria-label="Bookmark">
                          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-bookmark">
                            <path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"></path>
                          </svg>
                        </button>
                        <button id="like-btn-<?php echo $newsItem[News::$id] ?>" class="text-gray-400 hover:text-green-600 transition-colors" aria-label="Like">
                          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-heart">
                            <path
                              d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z">
                            </path>
                          </svg>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <script>
                // JavaScript for interactive elements
                document.addEventListener('DOMContentLoaded', function () {
                  // Bookmark button functionality
                  const bookmarkBtn = document.getElementById('bookmark-btn-<?php echo $newsItem[News::$id] ?>');
                  let bookmarked = false;

                  bookmarkBtn.addEventListener('click', function () {
                    bookmarked = !bookmarked;
                    if (bookmarked) {
                      bookmarkBtn.querySelector('svg').setAttribute('fill', 'currentColor');
                      bookmarkBtn.classList.replace('text-green-600', 'text-green-800');
                    } else {
                      bookmarkBtn.querySelector('svg').setAttribute('fill', 'none');
                      bookmarkBtn.classList.replace('text-green-800', 'text-green-600');
                    }
                  });

                  // Like button functionality
                  const likeBtn = document.getElementById('like-btn-<?php echo $newsItem[News::$id] ?>');
                  let liked = false;

                  likeBtn.addEventListener('click', function () {
                    liked = !liked;
                    if (liked) {
                      likeBtn.querySelector('svg').setAttribute('fill', 'currentColor');
                      likeBtn.classList.replace('text-green-600', 'text-green-800');
                    } else {
                      likeBtn.querySelector('svg').setAttribute('fill', 'none');
                      likeBtn.classList.replace('text-green-800', 'text-green-600');
                    }
                  });
                });
              </script>
            <?php endforeach;
          } ?>
          <!--       
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
              </div> -->
        </div>
      </div>