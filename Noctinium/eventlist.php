<?php
    require './script_php/database-connection.php';
    require './script_php/sessions.php';
?>
<html>
    <head>
      <link rel="stylesheet" href="asset/style.css">
      <link rel="stylesheet" href="asset/eventlist.css">
		  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
      <meta charset="utf-8" />
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"/>
      <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
      <title>Évènements</title>
      <link rel="icon" href="image/logo_noctinium_16x16.png">
    </head>
    <body>
        <header>
            <a href="index.php"><img class="logo" id="logo" src="image/logo_noctinium.png" alt="Logo"></a>
            <nav>
                <li><a href="index.php">Accueil</a></li>
                <li class="active"><a href="eventlist.php">Évènements</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="propos.php">A propos</a></li>
                <li><a href="faq.php">FAQ</a></li>
                <li><a href="<?php 
				if($logged_in == true){
					echo("compte.php");
				}else{
					echo("connexion.php");
				};?>"><?php 
				if($logged_in == true){
					echo("Compte");
				}else{
					echo("Connexion");
				};?></a></li>
            </nav>
        </header>
        <section class="content content-small">
            <div class="container">
                <h1 class="gradient-text">Liste des évènements</h1>
            </div>
        </section>
        <hr class="gradient">
        <section class="eventlist">
          <div class="searchCont">
            <div class="filtreCont">
              <a class="openFiltre" onclick="filtreMenu()">Filtres &#9776;</a>
            </div>
            <div class="searchBarCont">
              <form class="searchBar" action="script/search.php">
                <input type="text" class="search insc-form" id="search" placeholder="RECHERCHE ..." name="search" value="">
                <button class="searchBtn" id="searchBtn" type="submit"><i class="fa fa-search"></i></button>
              </form>
            </div>
            <div class="newEventCont">
              <?php
                if($logged_in == true){
                  $today = date('Y-m-d H:i:s');
                  $test_param['user_id'] = $_SESSION['user_id'];
                  $test_param['today'] = $today;
                  $test_num_event = "SELECT event_id FROM events WHERE event_user_id = :user_id AND event_datetime > :today;";
                  $test_num_event_user = $pdo->prepare($test_num_event);
                  $test_num_event_user->execute($test_param);
                  if($_SESSION['user_typesubscription'] == 1){
                    if($test_num_event_user->rowCount() < 4){
                      echo('<a href="eventAdd.php" id="newEvent" class="newEvent">Ajouter</a>');
                    }else{
                      echo ("Nombre maximum d'évènements atteint (4)");
                    }
                  }elseif($_SESSION['user_typesubscription'] == 2){
                    if($test_num_event_user->rowCount() < 8){
                      echo('<a href="eventAdd.php" id="newEvent" class="newEvent">Ajouter</a>');
                    }else{
                      echo ("Nombre maximum d'évènements atteint (8)");
                    }
                  }elseif($_SESSION['user_typesubscription'] == 3){
                    if($test_num_event_user->rowCount() < 16){
                      echo('<a href="eventAdd.php" id="newEvent" class="newEvent">Ajouter</a>');
                    }else{
                      echo ("Nombre maximum d'évènements atteint (16)");
                    }
                  }elseif($_SESSION['user_typesubscription'] == 4){
                    echo('<a href="eventAdd.php" id="newEvent" class="newEvent">Ajouter</a>');
                  }
                }else{
                  echo ("Connectez-vous pour créer un évènement");
                }
              ?>
            </div>
          </div>
        <div id="main" class="main-f">
          <div id="mySidenav" class="sidenav">
            <h2>Filtres</h2>
            <form action="script_php/filtres.php">
              <h3>Musique:</h3>
              <div class="typeCont">
                <select name="musique" id="musique" class="form-control">
                      <option value="">--Veuillez choisir un style de musique--</option>
                      <option value="1">Techno</option>
                      <option value="2">House</option>
                      <option value="3">Électro</option>
                      <option value="4">Rap</option>
                      <option value="5">Latino</option>
                      <option value="6">Années 80</option>
                      <option value="7">Années 90</option>
                      <option value="8">Années 2000</option>
                      <option value="9">Punk</option>
                      <option value="10">Rock</option>
                      <option value="11">Jazz</option>
                      <option value="12">Blues</option>
                      <option value="13">All Styles</option>
                      <option value="14">Autres</option>
                </select>
              </div>
              <h3>Type d'évènement:</h3>
              <div class="typeCont">
                <select name="type" id="type" class="form-control">
                    <option value="">--Veuillez choisir un type d'évènement--</option>
                      <option value="1">Before</option>
                      <option value="2">After</option>
                      <option value="3">Soirée</option>
                      <option value="4">Concert/Showcase</option>
                      <option value="5">Open Mic/Karaoké</option>
                      <option value="6">Autres</option>
                </select>
              </div>
              <h3>Date de l'évènement:</h3>
              <div class="typeCont">
                <div class="form-group-insc">
                  <div class="col-sm-12">
                    <input type="date" class="filtreDate insc-form" id="adresse_cachee" name="date_event" value="">
                  </div>
                </div>
              </div>
              <h3>Organisateurs:</h3>
              <div class="typeCont">
                <select name="orga" id="type" class="form-control">
                    <option value="">--Veuillez choisir un type d'organisateur--</option>
                      <option value="1">Particuliers</option>
                      <option value="2">Associations</option>
                      <option value="3">Professionnels</option>
                </select>
              </div>
              <h3>Heure de début:</h3>
              <div class="typeCont">
                <input type="radio" id="HeureDebut" name="ordre" value="1"><label for="HeureDebut"> Ordre croissant</label><br>
                <input type="radio" id="HeureFin" name="ordre" value="2"><label for="HeureFin"> Ordre décroissant</label><br>
              </div>
              <input class="filtreBtn" type="submit" value="FILTRER">
            </form>
          </div>
        <div class="eventCont">
        <?php
        $today = date('Y-m-d H:i:s', strtotime(' -6 hours'));
        $event_param['today'] = $today;
        if(isset($_GET['filtre'])){
          if($_GET['filtre'] == 1){
            $sql = "SELECT event_id, event_title, event_datetime, event_description, event_music, event_type, event_imageevent_id FROM events WHERE ";
            if(isset($_GET['date'])){
              if($_GET['date'] >= $today){
                $event_param['today'] = $_GET['date'];
                $sql .= " event_datetime = :today";
              }else{
                $sql .= " event_datetime > :today";
              }
            }else{
              $sql .= " event_datetime > :today";
            }
            if(isset($_GET['music'])){
              if(1 <= $_GET['music'] and $_GET['music'] <= 14){
                $sql .= " AND event_music = ".$_GET['music'];
              }
            }
            if(isset($_GET['type'])){
              if(1 <= $_GET['type'] and $_GET['type'] <= 6){
                $sql .= " AND event_type = ".$_GET['type'];
              }
            }
            if(isset($_GET['orga'])){
              if(1 <= $_GET['orga'] and $_GET['orga'] <= 3){
                $sql .= " AND event_user_type = ".$_GET['orga'];
              }
            }
            if(isset($_GET['ordre'])){
              if($_GET['ordre'] == 1){
                $sql .= " ORDER BY event_datetime ASC;";
              }elseif($_GET['ordre'] == 2){
                $sql .= " ORDER BY event_datetime DESC;";
              }
            }else{
              $sql .= " ORDER BY event_datetime ASC;";
            }
          }else{
            $sql = "SELECT event_id, event_title, event_datetime, event_description, event_music, event_type, event_imageevent_id FROM events WHERE event_datetime > :today AND event_private = 0 ORDER BY event_datetime ASC";
          }
        }elseif(isset($_GET['search'])){
          $event_param['search'] = urldecode($_GET['search']);
          $event_param['masked'] = $today;
          $sql = "SELECT event_id, event_title, event_datetime, event_description, event_music, event_type, event_imageevent_id FROM events WHERE event_datetime > :today AND event_private = 0 AND event_title LIKE :search OR event_description LIKE :search OR event_location LIKE :search ORDER BY event_datetime ASC";
        }else{
          $sql = "SELECT event_id, event_title, event_datetime, event_description, event_music, event_type, event_imageevent_id FROM events WHERE event_datetime > :today AND event_private = 0 ORDER BY event_datetime ASC";
        }
          $statement = $pdo->prepare($sql);
          $statement->execute($event_param);
          if($statement->rowCount() <= 0){
            echo ('<div class="noEvent" style="text-align: center;font-size: 1.5rem;">Aucun évènement disponible.</div>');
          }else{
            $event = $statement->fetchAll();
            if(isset($_GET['page'])){
              if($_GET['page'] > 0){
                $page = $_GET['page'];
              }else{
                $page = 1;
              }
            }else{
              $page = 1;
            }
            for($i=(($page-1)*10); $i<($page*10) && $i < $statement->rowCount();$i++){
              $event_text = str_split($event[$i]['event_description'], 350);
              $event_descr = $event_text[0];
              $event_descri = str_replace("<"," ", $event_descr);
              $event_desc = str_replace(">"," ", $event_descri);
              if(strlen($event_desc) == 350){
                $event_desc .= "[...]";
              }
              if($event[$i]['event_music'] == 1){
                $event_music = "Techno";
              }elseif($event[$i]['event_music'] == 2){
                $event_music = "House";
              }elseif($event[$i]['event_music'] == 3){
                $event_music = "Électro";
              }elseif($event[$i]['event_music'] == 4){
                $event_music = "Rap";
              }elseif($event[$i]['event_music'] == 5){
                $event_music = "Latino";
              }elseif($event[$i]['event_music'] == 6){
                $event_music = "Années 80";
              }elseif($event[$i]['event_music'] == 7){
                $event_music = "Années 90";
              }elseif($event[$i]['event_music'] == 8){
                $event_music = "Années 2000";
              }elseif($event[$i]['event_music'] == 9){
                $event_music = "Punk";
              }elseif($event[$i]['event_music'] == 10){
                $event_music = "Rock";
              }elseif($event[$i]['event_music'] == 11){
                $event_music = "Jazz";
              }elseif($event[$i]['event_music'] == 12){
                $event_music = "Blues";
              }elseif($event[$i]['event_music'] == 13){
                $event_music = "All Styles";
              }elseif($event[$i]['event_music'] == 14){
                $event_music = "Autres";
              }
              if($event[$i]['event_type'] == 1){
                $event_type = "Before";
              }elseif($event[$i]['event_type'] == 2){
                $event_type = "After";
              }elseif($event[$i]['event_type'] == 3){
                $event_type = "Soirée";
              }elseif($event[$i]['event_type'] == 4){
                $event_type = "Concert/Showcase";
              }elseif($event[$i]['event_type'] == 5){
                $event_type = "Open Mic/Karaoké";
              }elseif($event[$i]['event_type'] == 6){
                $event_type = "Autres";
              }
              echo ('<div class="event-presentation">
                    <div>
                    <img src="image/nightclub-crowd-smoke-machine.jpg" alt="" class="imgEvent">
                    </div>
                    <div class="eventInfo">
                    <div class="eventBottom">
                    <div class="eventDate">'.$event[$i]['event_datetime'].'</div>
                    <div class="musiqueEvent">'.$event_music.'</div>
                    </div>
                    <div class="eventTitle">'.$event[$i]['event_title'].'</div>
                    <div class="eventText">'.$event_desc.'</div>
                    <div class="eventBottom">
                    <div>
                    <a href="event.php?event='.$event[$i]['event_id'].'"><button class="btnEvent">Voir l\'évènement</button></a>
                    </div>
                    <div class="typeEvent">'.$event_type.'</div>
                    </div>
                    </div>
                    </div>');
            }
            if($statement->rowCount()>10){
              if($page == 1){
                echo("<div class=\"gridComm\"><div></div><div class=\"pageNum\">Page ".$page."</div><a class=\"pageBtn\" href=\"eventlist.php?page=". $page+1 ."\" >&rarr;</a></div>");
              }elseif($page > 1 && $i < $statement->rowCount()){
                echo("<div class=\"gridComm\"><a class=\"pageBtn\" href=\"eventlist.php?page=". $page-1 ."\" >&larr;</a><div class=\"pageNum\">Page ".$page."</div>
                <a class=\"pageBtn\" href=\"eventlist.php?page=". $page+1 ."\" >&rarr;</a></div>");
              }else{
                echo("<div class=\"gridComm\"><a class=\"pageBtn\" href=\"eventlist.php?page=". $page-1 ."\" >&larr;</a><div class=\"pageNum\">Page ".$page."</div><div></div></div>");
              }
            }
          }
        ?>
        </div>
        </div>
        </section>
        <?php
          include './script_php/footer.php'
        ?>
        <button id="btnretour" onclick="topScroll()"> &#8613; </button>
		<script>
			var swiper = new Swiper('.blog-slider', {
    spaceBetween: 30,
    effect: 'fade',
    loop: true,
    mousewheel: {
      invert: false,
    },
    // autoHeight: true,
    pagination: {
      el: '.blog-slider__pagination',
      clickable: true,
    }
  });
		</script>
    <script>
      var element = document.getElementById("logo")
      var search = document.getElementById("search")
      var searchBtn = document.getElementById("searchBtn")
			if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
        element.classList.toggle("logo");
        element.classList.toggle("logo-M");
        search.classList.toggle("search");
        search.classList.toggle("search-M");
        searchBtn.classList.toggle("searchBtn");
        searchBtn.classList.toggle("searchBtn-M");
      }else{
        let retour = document.getElementById("btnretour");

        window.onscroll = function() {scroll()};

        function scroll() {
          if (document.body.scrollTop > 475 || document.documentElement.scrollTop > 475) {
            retour.style.display = "block";
          } else {
            retour.style.display = "none";
          }
        }

        function topScroll() {
          document.body.scrollTop = 0;
          document.documentElement.scrollTop = 0;
        }
      }
      var verif = false
      var menu = document.getElementById("mySidenav")
      var main = document.getElementById("main")
      function filtreMenu(){
        if(verif == false){
          main.classList.toggle("main")
          main.classList.toggle("main-f")
          if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
            menu.style.width = "400%";
          }else{
            menu.style.width = "100%";
          }
          verif = true;
        } else {
          menu.style.width = "0";
          verif = false
          setTimeout(closefiltre, 350);
          function closefiltre(){
            main.classList.toggle("main-f")
            main.classList.toggle("main")
          }
        }
      }
    </script>
    </body>
</html>
