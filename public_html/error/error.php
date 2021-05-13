<?
    if(isset($error_code) && isset($error_text)) {
        header("HTTP/1.0 ".$error_code." ".ucfirst($error_text));        
    } else {
        $error_code = "Oeps!";
        $error_text = filter_input(INPUT_GET, 'err', $filter = FILTER_SANITIZE_STRING);        
    }

    if (! $error_text) {
        $error_text = 'onbekend probleem';
    }
    

    require_once '../../includes/variables.php';
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
            <div class="logo"><? include '../../includes/logo.svg'; ?></div>
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