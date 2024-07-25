<?php
require_once('./assets/includes/content.php');
?>

<!DOCTYPE html>
<html>
<!-- Head import -->
<?php
include("assets/includes/head.php");
?>


<!-- Header import -->
<?php include("assets/includes/header.php"); ?>

<div class="container-fluid py-4">
  <div class="row">

    <?php
    $folders = getFolders($pastaRaiz);
    cardPastas($conteudo, $pastaRaiz);
    ?>

    <?php
    montarBio($nomePasta);
    ?>

    <?php
    $filesPDF = getPDFs($nomePasta);
    cardPDFs($filesPDF, $nomePasta);
    ?>

    <?php
    $filesVideo = getVideos($nomePasta);
    cardVideos($filesVideo, $nomePasta);
    ?>

  </div>
</div>

<!-- Footer import -->
<?php include("assets/includes/footer.php"); ?>

</body>

</html>

<script>
function toggleRead(file) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'toggle_read.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            location.reload();
        }
    };
    xhr.send('file=' + encodeURIComponent(file));
}
</script>