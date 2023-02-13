<?php
	require 'database-connection.php';
    require 'sessions.php';

    date_default_timezone_set('Europe/Zurich');

	$sql = "INSERT INTO events (event_title, event_datetime, event_location, event_description, event_music,
     event_type, event_private, event_maskedlocation, event_price, event_creation, event_user_id, event_imageevent_id)
				VALUES (:event_title, :event_datetime, :event_location, :event_description, :event_music,
     :event_type, :event_private, :event_maskedlocation, :event_price, :event_creation, :event_user_id, :event_imageevent_id)";
	
    if($_SESSION['logged_in'] != true){
		header('Location: ../connexion.php');
		exit;
	}

	if (isset($_POST['nom_event']) and isset($_POST['date_event']) and isset($_POST['description_event']) 
    and isset($_POST['adresse_event']) and isset($_POST['musique']) and isset($_POST['type']) and isset($_POST['conditions'])){
        if($_POST['musique'] == ""){
            header("Location: ../eventAdd.php?error=1&music=1");
            exit;
        }
        if($_POST['type'] == ""){
            header("Location: ../eventAdd.php?error=1&type=1");
            exit;
        }
        function geocode($address){
            $addresse = urlencode($address);
        
            $url = "https://nominatim.openstreetmap.org/?addressdetails=1&q=$addresse&format=json&limit=1";
        
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_REFERER, $url);
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.86 Safari/537.36");
        
            $result = curl_exec($ch);
        
            curl_close($ch);
        
            return json_decode($result, true);
        }
        $response = geocode($_POST['adresse_event']);

        //Récupération des coordonnées GPS
        $lat = $response[0]['lat'];
        $lon = $response[0]['lon'];
        if($lat and $lon){
            $today = date('Y-m-d H:i:s');
            $date_masked = $_POST['date_event'];
            $date_int = str_replace("T"," ",$date_masked);
            $date_int .= ":00";
            if($date_int >= $today){
                if($_POST['date_event_mask'] == ""){
                    $testmasked = true;
                }else{
                    if($_POST['date_event'] >= $_POST['date_event_mask']){
                        $testmasked = true;
                    }else{
                        $testmasked = false;
                    }
                }
                if($testmasked){
                    $event['event_title'] = $_POST['nom_event'];
                    $event['event_datetime'] = $_POST['date_event'];
                    $event['event_location'] = $_POST['adresse_event'];
                    $event['event_description'] = $_POST['description_event'];
                    $event['event_music'] = $_POST['musique'];
                    $event['event_type'] = $_POST['type'];
                    $event['event_user_id'] = $_SESSION['user_id'];
                    $event['event_creation'] = date('Y-m-d H:i:s');
                    if ($_POST['date_event_mask'] == "") {
                        $event['event_maskedlocation'] = date('Y-m-d H:i:s');
                    }else{
                        $event['event_maskedlocation'] = $_POST['date_event_mask'];
                    }
                    if (isset($_POST['private'])) {
                        $event['event_private'] = 1;
                    }else{
                        $event['event_private'] = 0;
                    }
                    if ($_POST['prix_event'] == "") {
                        $event['event_price'] = 0;
                    }else{
                        $event['event_price'] = $_POST['prix_event'];
                    }

                    if ($_FILES['img_event']['name'] != "") {
                        $moved         = false;                                        // Initialize
                        $message       = '';                                           // Initialize
                        $error         = '';                                           // Initialize
                        $upload_path   = '../imageevent/';                                   // Upload path
                        $max_size      = 5242880;                                      // Max file size
                        $allowed_types = ['image/jpeg', 'image/png', 'image/gif',];    // Allowed file types
                        $allowed_exts  = ['jpeg', 'jpg', 'png', 'gif',];               // Allowed file extensions
                
                        function create_filename($filename, $upload_path)              // Function to make filename
                        {
                            $basename   = pathinfo($filename, PATHINFO_FILENAME);      // Get basename
                            $extension  = pathinfo($filename, PATHINFO_EXTENSION);     // Get extension
                            $basename   = preg_replace('/[^A-z0-9]/', '-', $basename); // Clean basename
                            $i          = 0;                                           // Counter
                            while (file_exists($upload_path . $filename)) {            // If file exists
                                $i        = $i + 1;                                    // Update counter 
                                $filename = $basename . '-' . $i . '.' . $extension;         // New filepath
                            }
                            return $filename;                                          // Return filename
                        }
                        $error = ($_FILES['img_event']['error'] === 1) ? 'too big ' : '';  // Check size error
                
                        if ($_FILES['img_event']['error'] == 0) {                          // If no upload errors
                            $error  .= ($_FILES['img_event']['size'] <= $max_size) ? '' : 'too big '; // Check size
                            // Check the media type is in the $allowed_types array
                            $type   = mime_content_type($_FILES['img_event']['tmp_name']);        
                            $error .= in_array($type, $allowed_types) ? '' : 'wrong type ';
                            // Check the file extension is in the $allowed_exts array
                            $ext    = strtolower(pathinfo($_FILES['img_event']['name'], PATHINFO_EXTENSION));
                            $error .= in_array($ext, $allowed_exts) ? '' : 'wrong file extension ';
                    
                            // If there are no errors create the new filepath and try to move the file
                            if (!$error) {
                            $filename    = create_filename($_FILES['img_event']['name'], $upload_path);
                            $destination = $upload_path . $filename;
                            $moved       = move_uploaded_file($_FILES['img_event']['tmp_name'], $destination);
                            }
                        }
                        if ($moved === true) {                                            // If it moved
                            $imgAdded = "INSERT INTO imageevent (imageevent_url)
                                        VALUES (:imageevent_url);";
                            
                            $img_add['imageevent_url'] = "imageevent/". $filename;
                            
                            $statement = $pdo->prepare($imgAdded);
                            $statement->execute($img_add);

                            $event['event_imageevent_id'] = $pdo->lastInsertId();

                        } else {           
                            $event['event_imageevent_id'] = 1;
                        }
                    }else{
                        $event['event_imageevent_id'] = 1;
                    }

                    $event_add = $pdo->prepare($sql);
                    $event_add->execute($event);

                    $event_id = $pdo->lastInsertId();

                    header('Location: ../event.php?event='. $event_id .'');
                    exit;
                }else{
                    header('Location: ../eventAdd.php?error=1&masked=1');
                }
            }else{
                header('Location: ../eventAdd.php?error=1&date=1');
                exit;
            }
        }else{
            header('Location: ../eventAdd.php?error=1&address=1');
            exit;
        }
	}else{
		header('Location: ../error.php');
		exit;
	}
	
?>