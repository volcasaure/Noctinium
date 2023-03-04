<?php
    require './script_php/database-connection.php';
    require './script_php/sessions.php';
?>
<html>
    <head>
        <link rel="stylesheet" href="asset/style.css">
		  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,300" rel="stylesheet" type="text/css">
      <meta charset="utf-8" />
      <title>Contact</title>
      <link rel="icon" href="image/logo_noctinium.ico">
    </head>
    <body>
        <header>
            <a href="index.php"><img class="logo" id="logo" src="image/logo_noctinium.webp" alt="Logo"></a>
            <nav id="computer">
              <li><a href="index.php">Accueil</a></li>
              <li><a href="eventlist.php">Évènements</a></li>
              <li class="active"><a href="contact.php">Contact</a></li>
              <li><a href="propos.php">À propos</a></li>
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
            <nav id="mobile" class="hidden">
                <ul>
                    <li class="bread"><a class="burger" onclick="openNav()">Menu &#9776;</a></li>
                </ul>
            </nav>
        </header>
        <?php
          if(isset($_GET['sent'])){
            if($_GET['sent'] == 1){
              echo ('<div id="error" class="okCont"><div id="okMessage" class="okMessage"><h1>Merci</h1><br>Votre de demande de contact a été envoyée.<br><button onclick="closeError()">Continuer</button></div></div>');
            }
            if($_GET['sent'] == 2){
              if(isset($_GET['date'])){
                if($_GET['date'] == 1){
                  echo ('<div id="error" class="errorCont"><div id="errorMessage" class="okMessage"><h1>Erreur</h1><br>Une erreur est survenue, veuillez réessayer.<br><button onclick="closeError()">Continuer</button></div></div>');
                }
              }
            }
          }
        ?>
        <div id="menuBack" class="menuBack" onclick="closeNav()">
            <div id="sidemenu" class="menu">
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                <a href="index.php">Accueil</a>
                <a href="eventlist.php">Évènements</a>
                <a href="contact.php">Contact</a>
                <a href="propos.php">À propos</a>
                <a href="faq.php">FAQ</a>
                <a href="<?php 
                if($logged_in == true){
                    echo("compte.php");
                }else{
                    echo("connexion.php");
                };?>"><?php 
                if($logged_in == true){
                    echo("Compte");
                }else{
                    echo("Connexion");
                };?></a>
            </div>
        </div>
        <section class="content content-small">
            <div class="container">
                <h1 class="gradient-text">Contact</h1>
            </div>
        </section>
        <hr class="gradient">
        <section class="subscribe">
            <div class="contact">
  
  <div id="contactForm" class="contact-wrapper">
  
  <!-- Left contact page --> 
    
    <form id="contact-form" class="form-horizontal" role="form" method="POST" action="./script_php/contact_mail.php">
       
      <div class="form-group">
        <div class="col-sm-12">
          <input type="text" class="form-control switch" id="name" placeholder="NAME" name="name" value="" required autofocus>
        </div>
      </div>

      <div class="form-group">
        <div class="col-sm-12">
          <input type="email" class="form-control switch" id="email" placeholder="EMAIL" name="email" value="" required>
        </div>
      </div>

      <textarea id="message" class="form-control switch" rows="10" placeholder="MESSAGE" name="message" required></textarea>
      
      <button class="btn btn-primary send-button gradient" id="submit" type="submit" value="SEND">
        <div class="alt-send-button">
          <i class="fa fa-paper-plane"></i><span class="send-text">Envoyer</span>
        </div>
      
      </button>
      
    </form>
    
  <!-- Left contact page --> 
      <div id="spacer" class="spacer hidden"></div>
      <div class="direct-contact-container">

        <ul class="contact-list">
          <li class="list-item"><i class="fa fa-map-marker fa-2x"><span class="contact-text place">Genève</span></i></li>
          
          <li class="list-item"><i class="fa fa-phone fa-2x"><span class="contact-text phone"><a href="tel:079 895 14 84" title="Give me a call">079 895 14 84</a></span></i></li>
          
          <li class="list-item"><i class="fa fa-envelope fa-2x"><span class="contact-text gmail"><a href="mailto:#" title="Send me an email">contact@noctinium.com</a></span></i></li>
          
        </ul>

        <hr>
        <ul class="social-media-list">
          <li onclick="android()"><a href="#" target="_blank" class="contact-icon">
            <i class="fa fa-social fa-android" aria-hidden="true"></i></a>
          </li>
          <li onclick="apple()"><a href="#" target="_blank" class="contact-icon">
            <i class="fa fa-social fa-apple" aria-hidden="true"></i></a>
          </li>
          <li onclick="twitter()"><a href="https://twitter.com/NoctiniumGE" target="_blank" class="contact-icon">
            <i class="fa fa-social fa-twitter" aria-hidden="true"></i></a>
          </li>
          <li onclick="insta()"><a href="https://www.instagram.com/noctiniumge" target="_blank" class="contact-icon">
            <i class="fa fa-social fa-instagram" aria-hidden="true"></i></a>
          </li>       
        </ul>
        <hr>

        <div class="copyright">&copy; ALL OF THE RIGHTS RESERVED</div>

      </div>
    
  </div>
  
</div>
        </section>
        <?php
          include './script_php/footer.php'
        ?>
    <script>
      var element = document.getElementById("logo");
      var formCont = document.getElementById("contactForm");
      var spacer = document.getElementById("spacer");
      var formN = document.getElementById("name");
      var formE = document.getElementById("email");
      var formM = document.getElementById("message");
      var contact = document.getElementById("contact-form")
			if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
        element.classList.toggle("logo");
        element.classList.toggle("logo-M");
        formCont.classList.toggle("contact-wrapper");
        formCont.classList.toggle("contact-wrapper-M");
        spacer.classList.toggle("hidden");
        formN.classList.toggle("form-control");
        formN.classList.toggle("form-control-M");
        formE.classList.toggle("form-control");
        formE.classList.toggle("form-control-M");
        formM.classList.toggle("form-control");
        formM.classList.toggle("form-control-M");
        contact.style.margin = "0px"
      }

      function twitter(){
        window.open("https://twitter.com/NoctiniumGE");
      }

      function insta(){
        window.open("https://www.instagram.com/noctiniumge");
      }

      function apple(){
        window.open("soon.php");
      }

      function android(){
        window.open("soon.php");
      }
		</script>
    <script>
        if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
            document.getElementById("computer").classList.toggle("hidden");
            document.getElementById("mobile").classList.toggle("hidden");
        }
        function openNav() {
            document.getElementById("sidemenu").style.width = "40%";
            document.getElementById("menuBack").style.visibility = "visible";
            
        }

        function closeNav() {
            document.getElementById("sidemenu").style.width = "0";
            document.getElementById("menuBack").style.visibility = "hidden";
        }
    </script>
    <script>
      function closeError() {
        var error = document.getElementById("error");
        var errorMessage = document.getElementById("errorMessage");
        error.classList.toggle("hidden");
      }; 
    </script>
    </body>
</html>
