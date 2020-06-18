<?php
    include("config/setup.php");
    include("user/check.php");
    setup_db();
    session_start();

    if (isset($_SESSION['loggued_user']) && $_SESSION['loggued_user'] !== "")
      if (check_reboot($_SESSION['loggued_user']))
        $_SESSION['loggued_user'] = "";

?>

<!DOCTYPE html">
<html>
    <head>
            <meta charset="utf-8" />
            <title>Camagru</title>
            <link rel="stylesheet" type="text/css" href="css/camagru.css">
    </head>
<body>
    <?php
        if (isset($_SESSION['loggued_user']) && $_SESSION['loggued_user'] !== ""){
          echo '<div id="loggued_user">';
          echo "Connected: " . $_SESSION['loggued_user'];
          echo '<form action="user/logout.php">';
          echo '<button class="button">Log Out!</button>';
          echo '</form>';
          echo '</div>';
        }
    ?>
    <div class="hed">Camagru</div>
    <br/>
    <div class="container">
        <ul>
            <li><span class="left_span"></span><span class="right_span"></span><a href="index.php" style="color:white; display:block;">Home</a></li>
            <li><span class="left_span"></span><span class="right_span"></span><a href="user/login.php" style="color:white; display:block;">Sign in/up</a></li>
            <li><span class="left_span"></span><span class="right_span"></span><a href="user/account.php" style="color:white; display:block;">My account</a></li>
		    </ul>
	  </div>
    <br/><br/>
    <div class="main">
      <video id="player" autoplay></video>
      <div class="button_pic">
        <label> Choose your picture <input id="image_upload" type="file"></label>
        <button id="snap">Capture</button>
      </div>
      <canvas id="canvas" width="350px" height="350px"></canvas>
      <div id="filters_div">
        <img class="filters" src="model/mario.png" name ="mario.png" id="image" width="20%" height="20%"/>
        <img class="filters" src="model/goku.png" name ="goku.png" id="image" width="20%" height="20%"/>
        <img class="filters" src="model/sonic.png" name ="sonic.png" id="image" width="20%" height="20%"/>
        <img class="filters" src="model/ichigo.png" name ="ichigo.png" id="image" width="20%" height="20%" />
        <img class="filters" src="model/cadre_blue.png" name ="cadre_blue.png" id="cadre" width="20%" height="20%" />
        <img class="filters" src="model/cadre1.png" name ="cadre1.png" id="cadre" width="20%" height="20%"/>
        <img class="filters" src="model/cadre2.png" name ="cadre2.png" id="cadre" width="20%" height="20%" />
        <img class="filters" src="model/cadre3.png" name ="cadre3.png" id="cadre" width="20%" height="20%" />
      </div>
      <button id="upload">Add To Galerie</button>
      <script>


        const player = document.getElementById('player');
        let cacheCanvas = null;
        let cacheSticker = null;
        let imgcadre = null;
        const canvas = document.getElementById('canvas');
        const context = canvas.getContext('2d');
        const capturePicture = document.getElementById('snap');
        const fileinput = document.getElementById('image_upload');
        const captureFilter = document.getElementById('upload');
        const filterImages = document.getElementsByClassName('filters');
        
        for (let image of filterImages) {
            image.addEventListener('click', () => {
              var t = new Image();
              t.onload = function() {
                context.drawImage(t, 0, 0);
                if (image.id === "image")
                  context.drawImage(image, 0, 15, canvas.width/3, canvas.height/2);
                else if (image.id === "cadre")
                  context.drawImage(image, 0, 0, canvas.width, canvas.height);
                cacheSticker = image.src;
                imgcadre = image.id;
              };
              if (cacheCanvas)
                t.src = cacheCanvas;
            })
        }
        const constraints = {
          video: true,
        };
        
        captureFilter.addEventListener('click', () => {
          if (cacheCanvas && cacheSticker)  
            fetch(cacheCanvas).then(res => res.blob())
              .then(blob => {
                fetch(cacheSticker).then(res => res.blob())                  
                  .then(blobSticker => {
                    var formData = new FormData();
                    formData.append("image", blob);
                    formData.append("sticker", blobSticker);
                    formData.append("name", name_file);
                    formData.append("imgcadre", imgcadre);
                    var request = new XMLHttpRequest();
                    request.open("POST", "http://localhost:8080/camagru/user/upload.php");
                    request.send(formData);
                    window.location.reload(true);
                  })
              })
        });
        
        fileinput.addEventListener('change', () => {
          var img = new Image;
          img.src = URL.createObjectURL(fileinput.files[0]);
          img.onload = function() {
              context.drawImage(img, 0, 0, canvas.width, canvas.height);
              cacheCanvas = canvas.toDataURL();
              name_file = fileinput.files[0].name;
              console.log(fileinput.files[0]);
          }
        });

        capturePicture.addEventListener('click', () => {
          // Draw the video frame to the canvas
          context.drawImage(player, 0, 0, canvas.width, canvas.height);
          cacheCanvas = canvas.toDataURL();
          name_file = "camera";
        });
        
        // Attach the video stream to the video element and autoplay
        navigator.mediaDevices.getUserMedia(constraints)
          .then((stream) => {
            player.srcObject = stream;
          });
      </script>
    </div>
    <div class="galerie">Galerie</div>
    <BR/>
    <div class="pictures_bigdiv">
		  <?php
          include("config/display_pictures.php");
          if (isset($_SESSION['loggued_user']) && $_SESSION['loggued_user'] !== "")
            get_pictures($_SESSION['loggued_user']);
          else
            get_pictures("");
		  ?>
	  </div>
</body>
</html>
