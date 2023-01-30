<?php
    require './script_php/database-connection.php';
    include './script_php/sessions.php';
?>
<html>
    <head>
        <link rel="stylesheet" href="asset/style.css">
		  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
      <meta charset="utf-8" />
      <link rel="stylesheet" href="asset/event.css">
      <title>Évènement</title>
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
        
        <section class="subscribe coprs-M">
          <div class="eventCont">
            <div class="returnBtnCont">
              <a title="Retour" class="returnBtn" onclick="history.back()">&#60;</a>
            </div>
            
              <div class="titreEvent">Usine</div>
              <div class="eventGrid">
                <img class="imgEvent" src="image/l-usine-geneve.jpg" alt="Image de l'évènement">
                <div class="infoSup">
                  <span class="dateEvent">26 December 2019</span>
                  <div class="adresseEvent">Pl. des Volontaires 4</div>
                  <div class="userEvent"><a href="organisateur.php">D4Ly_du_69</a></div>
                </div>
              </div>
              <div class="blog-slider__content infoCont">
                <div class="txtEvent">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Recusandae voluptate repellendus magni illo ea animi? Lorem ipsum dolor sit amet consectetur, adipisicing elit. Recusandae voluptate repellendus magni illo ea animi? Lorem ipsum dolor sit amet consectetur adipisicing elit. Lorem ipsum dolor sit amet consectetur, adipisicing?</div>
                <a href="map.php" class="btnEvent">TROUVER L' ÉVENEMENT</a>
              </div>
            
          </div>
        </section>
        <hr class="gradient">
        <section class="attends">
            <div class="interaction">
              <div class="comment-form">
                <!-- Comment Avatar -->
                <div >
                  <img class="comment-pp" src="image/david.png" alt="Image de profil">
                </div>
            
                <form class="form" name="form">
                  <div class="form-row">
                    <textarea
                              class="input"
                              ng-model="cmntCtrl.comment.text"
                              placeholder="AJOUTER UN COMMENTAIRE"
                              required></textarea>
                  </div>
                  <div class="form-row">
                    <input type="submit" value="COMMENTER">
                  </div>
                </form>
                <div class="commCont">

                </div>
              </div>
              
            </div>
        </section>
        <?php
          include './script_php/footer.php'
        ?>
		<script>
      var element = document.getElementById("logo")
      var cont = document.querySelector(".eventCont")
			if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
        element.classList.toggle("logo");
        element.classList.toggle("logo-M");
        cont.classList.toggle("eventCont");
        cont.classList.toggle("eventCont-M");
      }
		</script>
    </body>
</html>