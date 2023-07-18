<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="shortcut icon" href="icon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <title>Kovil - Galeria</title>
</head>
<body>
    <header>
        <div class="container">
            <h1 class="title">Kovil Gaming</h1> <!--Entendo que esteja possa estar curioso com as frases, mas não faça perder a graça, fofinho.-->
            <?php 
            $phrases = [
                'Lá conquista és bela',
                'Não tenha medo do escuro?!’ É claro que você deveria ter medo do escuro se você sabia o que tinha ali dentro!',
                'O que está feito, está feito. O que interessa é que estamos juntos. Agora cale a boca e beba a sua cerveja',
                'Todo mundo mente!',
                'Você não pode controlar suas emoções… apenas suas ações',
                'O conhecimento é uma arma. Arme-se bem antes de ir para a batalha.',
                'Um líder deve aprender que palavras conquistam coisas que muitas espadas não conseguem.',
                'Eu só estou cansado de tanta falta de sorte.',
                'Estranho é você acordar todo dia com vontade de mudar sua vida, e no final acabar fazendo a mesma merda de sempre.',
                'Dias ruins são necessários para que os dias bons possam valer a pena.',
                'Às vezes você tem que fazer o que é melhor pra você, mesmo que isso magoe aqueles que você ama.',
                'O erro de todo plano é achar que tudo vai dar certo!',
                'Só vemos as consequências quando elas estão diante dos nossos narizes.',
                'O amor é uma boa razão para que tudo fracasse.',
                'As pessoas passam anos na escola para ter um salário, que, no melhor dos casos, não passa de um salário de merda.',
                'Como no xadrez, há vezes em que, para ganhar, é preciso sacrificar uma peça.',
                'Algumas vezes a fruta proibida é a mais doce, não é?',
                'Quase morrer não muda nada. Morrer muda tudo!',
                'A dor nos faz tomar decisões erradas. O medo dela também.',
                'Bizarro é algo bom. O comum tem milhares de explicações. O Bizarro dificilmente tem alguma.',
                'Você não pode pular direto para o final, a jornada é a melhor parte.',
                'Ninguém acha que vai acontecer, até que acontece.',
                'Às vezes, são as imperfeições que tornam as coisas perfeitas.'
            ];
            $randomPhrase = $phrases[array_rand($phrases)];
            echo '<h2 class="subtitle">' . $randomPhrase . '</h2>';
            ?>
            <nav>
                <ul>
                    <li><a href="index.html">Início</a></li>
                    <li><a href="#">Jogos</a></li>
                    <li><a href="#">Galeria</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <section>
            <!--Para de olhar o codigo seu noia-->
            <h1 class="photos">Galeria</h1>
            <?php
            $targetDir = 'uploads/';
            $fileCount = count(scandir($targetDir)) - 2; 
            echo '<p class="file-count">Total: ' . $fileCount . '</p>';
            ?>
            <div class="upload-container">
                <form action="upload.php" method="POST" enctype="multipart/form-data">
                    <div class="upload-wrapper">
                        <div class="upload-info">
                            <p class="upload">Fazer upload</p>
                            <label for="media-upload" class="upload-icon">
                                <i class="material-icons">cloud_upload</i>
                            </label>
                            <span id="filename"></span>
                        </div>
                        <input type="file" name="media" id="media-upload" accept="image/*,video/*" style="display: none;">
                        <input type="submit" value="Upload" class="upload-button">
                    </div>
                </form>
            </div>

            <div class="photos-container">
                <?php
                $thumbnailDir = 'thumbnails/';

                $files = scandir($targetDir);

                $files = array_diff($files, array('.', '..'));

                usort($files, function ($a, $b) use ($targetDir) {
                    $fileA = $targetDir . $a;
                    $fileB = $targetDir . $b;
                    return filemtime($fileB) - filemtime($fileA);
                });

                foreach ($files as $file) {
                    $filePath = $targetDir . $file;
                    echo '<div class="photo-item">';
                    $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
                    if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
                        echo '<img src="' . $filePath . '" alt="Photo" class="open-modal" data-src="' . $filePath . '">';
                    } elseif (in_array($fileExtension, ['mp4', 'mov', 'avi', 'wmv'])) {
                        $thumbnailPath = $thumbnailDir . pathinfo($file, PATHINFO_FILENAME) . '.jpg';
                        if (!file_exists($thumbnailPath)) {
                            generateVideoThumbnail($filePath, $thumbnailDir);
                        }
                        echo '<div class="video-thumbnail">';
                        echo '<video src="' . $filePath . '" controls class="open-modal" data-src="' . $filePath . '" poster="' . $thumbnailPath . '">';
                        echo '</video>';
                        echo '</div>';
                    }
                    echo '</div>';
                }

                function generateVideoThumbnail($videoPath, $thumbnailDir) {
                    $ffmpegPath = 'ffmpeg\bin\ffmpeg.exe';

                    $thumbnailFileName = pathinfo($videoPath, PATHINFO_FILENAME) . '.jpg';

                    $thumbnailPath = $thumbnailDir . $thumbnailFileName;

                    $thumbnailTime = '00:00:02';

                    $command = "{$ffmpegPath} -i \"{$videoPath}\" -ss {$thumbnailTime} -vframes 1 \"{$thumbnailPath}\" 2>&1";

                    $output = shell_exec($command);

                    if (strpos($output, 'Error') !== false) {
                        echo "Erro ao gerar miniatura do vídeo: " . $output;
                    }
                }
                ?>
            </div>
        </section>
    </main>

    <footer>
        <div><h3>Divisão de ma<strong>lucas</strong></h3></div>
    </footer>

    <div class="modal-container">
        <div class="modal-content">
            <img class="modal-image">
            <div class="modal-buttons">
                <button class="close-button"><i class="material-icons">close</i></button>
                <a class="download-button" download><i class="material-icons">cloud_download</i></a>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
