<?php
// CONFIGS
$uri = $_SERVER['REQUEST_URI'];

if (isset($_GET['library'])) {
    $content = getContent($_GET['library']);

    $nomePasta = $content->nomePasta;
    $pastaRaiz = $content->pastaRaiz;
} else {
    $nomePasta = "Library";
    $pastaRaiz = "./files/";
}

if (isset($_GET['video'])) {
    $videoToPlay = $_GET['video'];
}

// GET DATA
function getContent($pasta)
{
    $conteudoObj = new stdClass();
    $conteudoObj->nomePasta = $pasta;
    $conteudoObj->pastaRaiz = './files/' . $pasta . "/";


    /* PERSONALIZE CONTENT */
    // Add cases to set specific properties for each folder

    switch ($pasta) {
        case "Hentai":
            $conteudoObj->iconeNav = 'fa fa-heart text-danger';
            break;
        case "Cursos":
            $conteudoObj->iconeNav = 'ni ni-book-bookmark text-primary';
            break;
        case "E-books":
            $conteudoObj->iconeNav = 'ni ni-books text-danger';
            break;
        case "Mangás":
            $conteudoObj->iconeNav = 'fa fa-star text-yellow';
            break;
        case "HQs":
            $conteudoObj->iconeNav = 'fa fa-star text-yellow';
            break;
        case "Sample":
            $conteudoObj->iconeNav = 'ni ni-books text-danger';
            break;
        default:
            $conteudoObj->iconeNav = 'fa fa-star text-warning';
            break;
    }

    return $conteudoObj;
}

function getFolders($dir)
{
    $directories = [];

    if (is_dir($dir)) {
        // Abrir o diretório
        if ($dh = opendir($dir)) {
            // Ler o conteúdo do diretório
            while (($file = readdir($dh)) !== false) {
                // Verificar se é uma pasta, ignorando "." e ".."
                if ($file != "." && $file != ".." && is_dir($dir . DIRECTORY_SEPARATOR . $file)) {
                    $directories[] = $file;
                }
            }
            // Fechar o diretório
            closedir($dh);
        }
    }

    // Ordenar as pastas em ordem alfabética
    natsort($directories);

    return $directories;
}

function getVideos($diretorio)
{
    $directory = rtrim("./files/" . $diretorio . "/", '/') . '/';
    $mp4Files = glob($directory . '*.mp4');
    $mkvFiles = glob($directory . '*.mkv');

    if (empty($mp4Files) && empty($mkvFiles)) {
        return [];
    }

    $videoFiles = array_merge($mp4Files, $mkvFiles);
    
    // Ordenar as pastas em ordem alfabética
    natsort($videoFiles);

    return $videoFiles;
}

function getImages($diretorio)
{
    $directory = rtrim("./files/" . $diretorio . "/", '/') . '/';
    $jpgFiles = glob($directory . '*.jpg');
    $jpegFiles = glob($directory . '*.jpeg');
    $pngFiles = glob($directory . '*.png');
    $webpFiles = glob($directory . '*.webp');
    $gifFiles = glob($directory . '*.gif');

    if (empty($jpgFiles) && empty($jpegFiles) && empty($pngFiles) && empty($webpFiles) && empty($gifFiles)) {
        return [];
    }

    $imageFiles = array_merge($jpgFiles, $jpegFiles, $pngFiles, $webpFiles, $gifFiles);
    
    // Ordenar as pastas em ordem alfabética
    natsort($imageFiles);

    return $imageFiles;

}

function getPDFs($diretorio)
{
    $directory = rtrim("./files/" . $diretorio . "/", '/') . '/';
    $pdfFiles = glob($directory . '*.pdf');

    if (empty($pdfFiles)) {
        return [];
    }

    $pdfFiles = array_merge($pdfFiles);

    // Ordenar as pastas em ordem alfabética
    natsort($pdfFiles);

    return $pdfFiles;
}

function getAudios($diretorio)
{
    $directory = rtrim("./files/" . $diretorio . "/", '/') . '/';
    $mp3Files = glob($directory . '*.mp3');

    if (empty($mp3Files)) {
        return [];
    }

    $mp3Files = array_merge($mp3Files);

    // Ordenar as pastas em ordem alfabética
    natsort($mp3Files);

    return $mp3Files;
}



// FOLDERS
function cardPastas($conteudo, $pastaRaiz)
{
    $folders = getFolders($pastaRaiz);

    if (!empty($folders)) {

        echo "
            <div class='row'>
                <div class='col-12'>
                    <div class='card mb-4'>
                        <div class='card-header pb-0'>
                            <h4>Folders</h4><br>
                        </div>
                        <div class='card-body px-0 pt-0 pb-2'>
                            <div class='container-fluid'>
                                <div class='row'>
            ";



        foreach ($folders as $folder) {
            $conteudo = getContent($folder);

            if (!is_null($conteudo)) {
                if (!isset($_GET['library'])) {
                    montarPastasA($conteudo, $pastaRaiz);
                } else {
                    montarPastasB($conteudo, $pastaRaiz);
                }
            }
        }

        echo "
                                </div>
                            </div>
                        </div>
                    </div>
                </div>   
            </div>         
            ";
    }
}

function montarPastasA($conteudo, $pastaRaiz)
{

    if (isset($_GET['library'])) {
        echo "
            <div class='col-sm-6 col-xl-3 col-lg-4'>
                <a href='" . $_SERVER['REQUEST_URI'] . "/" . $conteudo->nomePasta . "'>
                    <div class='card'>
                        <img class='card-img card-image' src='" . $pastaRaiz . $conteudo->nomePasta  . "/cover.jpg'>
                        <div class='card-img-overlay'>
                            <h3 class='card-text text-white card-image-center'>" . $conteudo->nomePasta . "</h3>
                        </div>
                    </div>
                </a>
            </div>
        ";
    } else {
        echo "
            <div class='col-sm-6 col-xl-3 col-lg-4'>
              <a href='index.php?library=" . $conteudo->nomePasta . "'>
                <div class='card'>
                  <img class='card-img card-image' src='" . $pastaRaiz . $conteudo->nomePasta  . "/cover.jpg'>
                  <div class='card-img-overlay'>
                    <h3 class='card-text text-white card-image-center'>" . $conteudo->nomePasta . "</h3>
                  </div>
                </div>
              </a>
            </div>
        ";
    }
}

function montarPastasB($conteudo, $pastaRaiz)
{
    if (file_exists($pastaRaiz . $conteudo->nomePasta  . "/cover.jpg")) {
        echo "
            <div class='col-sm-6 col-md-4 col-lg-3 col-xl-2'>
                <div class='card card-profile mt-md-0 mt-5' style='min-height: 450px'>
                    <a href='" . $_SERVER['REQUEST_URI'] . "/" . $conteudo->nomePasta . "'>
                        <div class='p-3'>
                            <img style='height: 300px; object-fit: cover' class='w-100 border-radius-md' src='" . $pastaRaiz . $conteudo->nomePasta  . "/cover.jpg'>
                        </div>
                    </a>
                    <div class='card-body blur justify-content-center text-center  border-radius-md'>
                        <h6 class='mb-0'>$conteudo->nomePasta</h6>
                        
                        <div class='row justify-content-center text-center'>
                            <div class='col-12 mx-auto'>
                                <h5 class='text-info mb-0'></h5>
                                <small></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>";
    } else {
        echo "
            <div class='col-sm-6 col-md-4 col-lg-3 col-xl-4'>
                
                    <li class='list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg me-2'>
                        <div class='d-flex align-items-center'>
                            <a href='" . $_SERVER['REQUEST_URI'] . "/" . $conteudo->nomePasta . "'>
                                <button class='btn btn-outline-default btn-icon-only btn-rounded mb-0 me-3 btn-md d-flex align-items-center justify-content-center'>
                                    <i class='ni ni-folder-17'></i>
                                </button>
                                <div class='d-flex flex-column'>
                                    <h6 class='mb-1 text-dark text-sm limitar-texto-1-linha'>" . $conteudo->nomePasta . "</h6>
                            </a>
                                </div>
                            
                        </div>             
                    </li>
                
            </div>
                ";


    }
}

function montarBio($pastaRaiz) {
    echo "
            
    <div class='col-sm-12 col-md-4'>
        <div class='col-12 ps-0 my-auto'>
            <div class='card mb-4'>
                <div class='card-body text-left'>
                    <div class='row'>
                    ";
                    if(file_exists('files/'.$pastaRaiz.'/cover.jpg')) {
                        echo "<div class='col-6'><img src='files/".$pastaRaiz."/cover.jpg' class='w-100 rounded-3'></div>
                        <div class='col-6'>
                        ";
                    } else {
                        echo "<div class='col-12'>";
                    }
                    echo "    
                        
                            <div class='p-md-0 pt-3'>
                                <h5 class='font-weight-bolder mb-0'>". pathinfo($pastaRaiz, PATHINFO_FILENAME) ."</h5>
                                <br>
                                <p class='text-uppercase text-sm font-weight-bold mb-2'>Landscape Architect</p>
                            </div>
                            <p class='mb-4'>Success is not final, failure is not fatal: it is the courage to continue that counts...</p>
                            <button type='button' class='btn btn-facebook btn-simple btn-lg mb-0 pe-3 ps-2'>
                                <i class='fab fa-facebook' aria-hidden='true'></i>
                            </button>
                            <button type='button' class='btn btn-twitter btn-simple btn-lg mb-0 px-2'>
                                <i class='fab fa-twitter' aria-hidden='true'></i>
                            </button>
                            <button type='button' class='btn btn-github btn-simple btn-lg mb-0 px-2'>
                                <i class='fab fa-github' aria-hidden='true'></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>            
       
    </div>
    ";
}




// VIDEOS
function cardVideos($conteudo, $pastaRaiz)
{
    if (!empty($conteudo)) {
        echo "
                <div class='row'>
                    <div class='col-12'>
                        <div class='card mb-4'>
                            <div class='card-header pb-0'>
                                <h4>Videos</h4><br>
                            </div>
                            <div class='card-body px-0 pt-0 pb-2' style='max-height: 800px; overflow-y: auto;'>
                                <div class='container-fluid'>
                                    <div class='row'>
            ";



        montarVideosA($conteudo, $pastaRaiz);

        echo "
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>            
            ";
    }
}

function montarVideosA($files, $nomePasta)
{
    if (!empty($files)) {

        $read_status_file = './files/read_status.txt';
        verificarSeReadExiste();
        $read_status = [];
        if (file_exists($read_status_file)) {
            $read_status = unserialize(file_get_contents($read_status_file));
        }

        foreach ($files as $index => $arquivo) {
            $isRead = isset($read_status[$arquivo]) && $read_status[$arquivo];
            echo "
                    <div class='col-sm-6 col-md-4 col-lg-3'>
                        <div class='video-container'>
                            <div class='video' style='width: 100%;'>
                                
                                    <video 
                                        id='my-video' 
                                        preload='metadata' 
                                        muted
                                        class='video-js' 
                                        data-setup='{ \"fluid\": true }' 
                                        onclick='this.currentTime += this.duration / 10; this.play();' 
                                        onmouseout='this.pause();'>
                                        <source src='{$arquivo}' type='video/mp4'>
                                        Seu navegador não suporta o elemento de vídeo.
                                    </video>
                                    <div class='' style='margin-top: 5px; margin-bottom: 15px'>

                                        <div class='d-flex align-items-center'>
                                            <button onclick='toggleRead(\"" . urlencode($arquivo) . "\")' class='btn ". ($isRead ? 'btn-success' : 'btn-outline-default') ." btn-icon-only btn-rounded mb-0 me-3 btn-sm d-flex align-items-center justify-content-center'>
                                                <i class='ni ni-check-bold text-sm'></i>
                                            </button>
                                            <div class='d-flex flex-column'>
                                            <a href='video_player.php?library={$nomePasta}&video={$arquivo}'>
                                                    <h6 class='mb-1 text-dark text-md limitar-texto-1-linha'>" . pathinfo($arquivo, PATHINFO_FILENAME) . "</h6>
                                            </div>
                                        </div>  
                                </a>
                                
                                </div>
                            </div>
                        </div>
                    </div>
                ";
        }
    }
}

function montarVideosB($files, $nomePasta)
{
    if (!empty($files)) {
        $output = "";
        foreach ($files as $index => $arquivo) {
            $output .= "
                    <div class='col-12'>
                        <div class='video-container' style='margin-bottom: 10px;'>
                            <div class='video' style='width: 100%;'>
                                <a href='video_player.php?library={$nomePasta}&video={$arquivo}'>
                                    <video 
                                        id='my-video' 
                                        preload='metadata' 
                                        muted
                                        class='video-js' 
                                        data-setup='{ \"fluid\": true }' 
                                        onmouseenter='this.currentTime += this.duration / 10; this.play();' 
                                        onmouseout='this.pause();'>
                                        <source src='{$arquivo}' type='video/mp4'>
                                        Seu navegador não suporta o elemento de vídeo.
                                    </video>
                                </a>
                                <br><br>
                            </div>
                        </div>
                    </div>
                    
                ";
        }
        return $output;
    }
    return "";
}



// Audios
function cardAudios($conteudo, $pastaRaiz)
{
    if (!empty($conteudo)) {
        $lidos = calcReadFiles(getAudios($pastaRaiz));
        $totalItens = sizeof($conteudo);



        echo "   
            <div class='col-12'>
                <div class='card mb-4'>
                    <div class='card-header pb-0'>
                        <h4>Audios</h4>

                        <div class='progress-wrapper'>
                            <div class='progress-info'>
                            <div class='progress-percentage text-end'>
                                <span class='text-sm font-weight-bold'>" . $lidos . " / " . $totalItens . "</span>
                            </div>
                            </div>
                            <div class='progress'>
                            <div class='progress-bar bg-success' role='progressbar' aria-valuenow='60' aria-valuemin='0' aria-valuemax='100' style='width: ";
        echo ($totalItens > 0) ? ($lidos / $totalItens) * 100 : 0;
        echo "%;'></div>
                            </div>
                        </div>
                    </div>
                    <div class='card-body px-0 pt-0 pb-2' style='max-height: 400px; overflow-y: auto;' >
                        <div class='container-fluid' >
                        
                            
            ";



        montarAudios($conteudo, $pastaRaiz);

        echo "
                            
                            
                        </div>
                    </div>
                </div>  
            </div>          
            ";
    }
}

function montarAudios($files, $nomePasta)
{
    if (!empty($files)) {
        echo "<div class='card-body row '>";

        $read_status_file = './files/read_status.txt';
        verificarSeReadExiste();
        $read_status = [];
        if (file_exists($read_status_file)) {
            $read_status = unserialize(file_get_contents($read_status_file));
        }

        foreach ($files as $index => $arquivo) {
            $isRead = isset($read_status[$arquivo]) && $read_status[$arquivo];
            echo "
                <ul class='list-group d-flex flex-row flex-wrap col-lg-4 col-md-12'>  
                    <li class='list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg me-2'>
                        <div class='d-flex align-items-center'>
                            <button onclick='toggleRead(\"" . urlencode($arquivo) . "\")' class='btn ". ($isRead ? 'btn-success' : 'btn-outline-default') ." btn-icon-only btn-rounded mb-0 me-3 btn-sm d-flex align-items-center justify-content-center'>
                                <i class='ni ni-check-bold'></i>
                            </button>
                            <div class='d-flex flex-column'>
                                
                                    <h6 class='mb-1 text-dark text-sm limitar-texto-1-linha'>" . pathinfo($arquivo, PATHINFO_FILENAME) . "</h6>
                                
                                <span class='text-xs'>
                                    <audio controls>
                                        <source src='".$arquivo."' type='audio/mpeg'>
                                    </audio>
                                </span>    
                            </div>
                        </div>             
                    </li>
                </ul>
                ";
        }

        echo "</div>";
    }
}

function cardImages($conteudo, $pastaRaiz)
{
    if (!empty($conteudo)) {
        echo "
                <div class='row'>
                    <div class='col-12'>
                        <div class='card mb-4'>
                            <div class='card-header pb-0'>
                                <h4>Images</h4><br>
                            </div>
                            <div class='card-body px-0 pt-0 pb-2' style='max-height: 800px; overflow-y: auto;'>
                                <div class='container-fluid'>
                                    <div class='row'>
                                        <div class='grid'>
            ";



        montarImages($conteudo, $pastaRaiz);

        echo "
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>            
            ";
    }
}

function montarImages($files, $nomePasta)
{
    if (!empty($files)) {
        foreach ($files as $index => $arquivo) {
            echo "
                    <div class='grid-item'>
                        <a data-toggle='modal' >
                            <a href='". $arquivo ."'><img class='' width='100%' src='".$arquivo ."'></a>
                        </a>
                    </div>
                ";
        }
    }
}


// PDFs
function cardPDFs($conteudo, $pastaRaiz)
{
    if (!empty($conteudo)) {
        $lidos = calcReadFiles(getPDFs($pastaRaiz));
        $totalItens = sizeof($conteudo);



        echo "   
            <div class='col-sm-12 col-md-12 col-lg-8'>
                <div class='card mb-4'>
                    <div class='card-header pb-0'>
                        <h4>PDFs</h4>
                        
                        <div class='progress-wrapper'>
                            <div class='progress-info'>
                            <div class='progress-percentage text-end'>
                                <span class='text-sm font-weight-bold'>" . $lidos . " / " . $totalItens . "</span>
                            </div>
                            </div>
                            <div class='progress'>
                            <div class='progress-bar bg-success' role='progressbar' aria-valuenow='60' aria-valuemin='0' aria-valuemax='100' style='width: ";
        echo ($totalItens > 0) ? ($lidos / $totalItens) * 100 : 0;
        echo "%;'></div>
                            </div>
                        </div>
                    </div>
                    <div class='card-body px-0 pt-0 pb-2'>
                        <div class='container-fluid'>
                        
                            
            ";



        montarPDFs($conteudo, $pastaRaiz);

        echo "
                            
                            
                        </div>
                    </div>
                </div>  
            </div>          
            ";
    }
}

function montarPDFs($files, $nomePasta)
{
    if (!empty($files)) {
        echo "<div class='card-body row ' style='max-height: 600px; overflow-y: auto;'>";

        $read_status_file = './files/read_status.txt';
        verificarSeReadExiste();
        $read_status = [];
        if (file_exists($read_status_file)) {
            $read_status = unserialize(file_get_contents($read_status_file));
        }

        foreach ($files as $index => $arquivo) {
            $isRead = isset($read_status[$arquivo]) && $read_status[$arquivo];
            echo "
                <ul class='list-group d-flex flex-row flex-wrap col-lg-6 col-md-12'>  
                    <li class='list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg me-2'>
                        <div class='d-flex align-items-center'>
                            <button onclick='toggleRead(\"" . urlencode($arquivo) . "\")' class='btn ". ($isRead ? 'btn-success' : 'btn-outline-default') ." btn-icon-only btn-rounded mb-0 me-3 btn-sm d-flex align-items-center justify-content-center'>
                                <i class='ni ni-check-bold'></i>
                            </button>
                            <div class='d-flex flex-column'>
                                <a href='pdf_viewer.php?file=" . urlencode($arquivo) . "'>
                                    <h6 class='mb-1 text-dark text-sm limitar-texto-1-linha'>" . pathinfo($arquivo, PATHINFO_FILENAME) . "</h6>
                                </a>
                                <span class='text-xs'>27 March 2020, at 12:30 PM</span>    
                            </div>
                        </div>             
                    </li>
                </ul>
                ";
        }

        echo "</div>";
    }
}

function calcReadFiles($arquivos)
{
    
    $read_status_file = './files/read_status.txt'; // Arquivo que armazena o estado de leitura
    verificarSeReadExiste();
    
    // Lê o estado de leitura dos arquivos
    $read_status = [];
    if (file_exists($read_status_file)) {
        $read_status = unserialize(file_get_contents($read_status_file));
    }

    //$todosArquivos = getPDFs($dir);
    $todosArquivos = $arquivos;

    $itensLidos = 0;

    foreach ($todosArquivos as $arquivo) {
        if (isset($read_status[$arquivo]) && $read_status[$arquivo]) {
            $itensLidos++;
        }
    }

    return $itensLidos;
}

function verificarSeReadExiste()
{
    $filename = './files/read_status.txt';

    if (!file_exists($filename)) {
        $file = fopen($filename, 'w');
    }
}