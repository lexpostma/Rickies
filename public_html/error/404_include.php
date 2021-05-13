<?
    $error_code = "404";
    $error_text = "niet gevonden";
    
    require_once '../includes/variables.php';
    $seoTitle = '👰️❤️🤵';
    $iconPath = '/images/icons/';
?>

<!DOCTYPE HTML>
<html lang="nl">
<?
    include 'error_head.php';
?>

    <body>
        <div id="top"></div>
        <main id="contents">
            <div class="logo"><? include '../includes/logo.svg'; ?></div>
            <header class="error">
                <span class="lined"><?=$error_code?></span>
                    
                <h1>
                    <span><?=$error_text?></span>
                </h1>
            
                <span class="lined"><a href="/"><i class="fas fa-home-heart"></i></a></span>
            </header>
        </main>
    </body>
</html>