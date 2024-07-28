<?php
require_once('./assets/includes/content.php');
?>

<!DOCTYPE html>
<html>
<!-- Head import -->
<?php
include("assets/includes/head.php");
?>

<body class="g-sidenav-show bg-gray-100">
  <!-- Header import -->
  <?php include("assets/includes/header.php"); ?>

  <div class="container-fluid py-4">
    <div class="row">
      <div class="col-10">
        <div class="card mb-4">
          <div class="card-header pb-0">
          </div>
          <div class="card-body px-0 pt-0 pb-2">

            <!-- Content START -->

            <div class='container-fluid'>
              <div class='row'>
              <h6><?php echo pathinfo($videoToPlay, PATHINFO_FILENAME); ?></h6>
                <video id="myPlayer" class="video-js vjs-16-9" style="margin-bottom: 10px;" preload="auto" data-setup='{ "fill": true }' onended="playRandomVideo()" controls nativeControlsForTouch autofocus autoplay>
                  <source src="<?php echo $videoToPlay; ?>" type="video/mp4">
                  Seu navegador não suporta o elemento de vídeo.
                </video>
                
              </div>
            </div>
            <!-- Content END -->
          </div>
        </div>
      </div>

      <div class="col-2" style="max-height: 700px; overflow-y: auto;">
        <div class="card mb-4">
          <div class="card-header pb-0">

          </div>
          <div class="card-body px-0 pt-0 pb-2">

            <!-- Content START -->

            <div class='container-fluid'>
              <div class='row'>
                <h6>More videos...</h6>
                <?php
                // Videos
                $filesVideo = getVideos($nomePasta);
                echo montarVideosB($filesVideo, $nomePasta);
                ?>

              </div>
            </div>
            <!-- Content END -->
          </div>
        </div>
      </div>


    </div>
  </div>

  <!-- Footer import -->
  <?php require_once("assets/includes/footer.php"); ?>
</body>

</html>

<script>
  const files = <?php echo json_encode($filesVideo); ?>;
  const player = videojs(document.getElementById("myPlayer"), { 
    plugins: {
        hotkeys: {
            volumeStep: 0.1,
            seekStep: 15,
            enableInactiveFocus : false,
            //alwaysCaptureHotkeys: true
        },
    },
  });
   
  function playRandomVideo() {
      const index = getRandomInt(<?php echo json_encode(sizeof($filesVideo)); ?>);
      player.src({
          src: files[index],
          type: 'video/mp4'
      });
      player.play();                        
  }

  function getRandomInt(max) {
    return Math.floor(Math.random() * max);
  }

</script>