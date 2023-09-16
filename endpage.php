<?php declare(strict_types=1);

require_once ('autoload.php');
try {
    Session::start();
} catch (SessionException $e) {
    header("Location: ErreurPage.php");
    return;
}

//if(!isset($_SESSION["InfosUser"]["ID"]))
//{
//    header("Location: findme.php");
//}

$title = 'C\'est la fin';

$p = new WebPage($title);
$p->appendCssUrl("css/DarkTheme.css");

require_once "Fonctions/EffectNeige.php";
EffectNeige($p);

//Popup de message de confirmation
if (isset($_SESSION["InfosUser"]["alerte"])) {
    require_once "Fonctions/PopupMaker.php";
    PopupMaker($p,$_SESSION["InfosUser"]["alerte"]);
    unset($_SESSION["InfosUser"]["alerte"]);
}

$p->appendContent(<<<HTML
    <br>
    <br>
    <div class="corps">
        <h1>Score des participants</h1>
    </div>
    <br>
    <br>
    <br>
    <div class="corps">
        <br>

HTML
);







    if(isset($_SESSION["InfosUser"]["ID"])) {
        $points = $_SESSION["InfosUser"]["Score"] ?? 0;

        $p->appendContent(<<<HTML
                <h2>Votre score</h2>
                <br>
                <div class="CenterDiv">
                    $points Points
                </div>
                <br/>
                <br>
                <h4>Réessayer?</h4>
                <p>(Tous tes scores sont conservés, et multiplient tes chances au tirage au sort, par le nombre de fois que tu t'es enregistré)</p>
                <li><a href="Geolocalisateur.php">Je réessaie !</a></li>
                <br>
        
        HTML
        );

        $p->appendContent(<<<HTML
                <br/>
                <h1>Merci d'avoir participé!</h1>
                <br/>
                <br>
                <h4>Un commentaire?</h4>
                <form method="POST" action="EspaceRemarque.php">
                   <input type="hidden" name="source" id="source" value="EndPage">
                   <li>
                        <input type="text" name="pseudo" placeholder="Un pseudo au pif (< 29 lettres)" size="29" required /><br />
                        <textarea name="commentaire" placeholder="C'était nul à chier ! X)" rows="5" cols="35" required></textarea><br />
                   </li>
                   <input type="hidden" name="idprofil" value="{$_SESSION['InfosUser']['ID']}">
                   <input type="submit" value="Poster ma remarque" name="submit_commentaire" />
                </form>
                <br/>
        </div>
        <br>
        <br>
        <div class="corps">
            
        HTML
        );
    }

    $p->appendCssUrl("css/ListeDeParticipantss.css");

try {

    $p->appendContent(<<<HTML
    
        <form method="POST" action="endpage.php">
           <select name="ClasserPar" onchange="submit();">
               <option value="">Classer par...</option>
               <option value="Nom">Nom</option>
               <option value="PNom">Prénom</option>
               <option value="Score">Score</option>
           </select>
        </form>
        <br>

    HTML
    );

    $SortInfo='score';
    if(isset($_POST['ClasserPar'])){
        switch ($_POST['ClasserPar']){
            case "Score":
            case "":
                break;
            case "Nom":
                $SortInfo='nom';
                break;
            case "PNom":
                $SortInfo='pnom';
                break;
        }
    }

    $reponse = MyPDO::getInstance()->query("SELECT score,nom,pnom FROM utilisateur ORDER BY $SortInfo DESC");
    $donnees = $reponse -> fetchAll();

    $icount = count($donnees);
    if($icount>2000){
        $icount = 2000;
    }
    for($i = 0; $i < $icount; $i++)
    {
        //echo nl2br ($donnees[$i]['id'] . $donnees[$i]['nom']. "  ");
        $inom = $donnees[$i]['nom'];
        $ipnom = $donnees[$i]['pnom'];

        if(!($ipnom==null && $inom==null)){
            $disp1 = $inom . " " . $ipnom ;
            $disp2 = " " . $donnees[$i]['score'] . " Points"  ;
            $p->appendContent(<<<HTML
                <div class="CenterDiv">
                    <div class="disp12">
                        $disp1
                    </div>
                    <div class="disp22">
                        $disp2
                    </div>
                </div>
            HTML
            );
        }
    }
    $p->appendContent(<<<HTML
        <br>

        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <a href="THE_VOID.php">[WIP] Go to THE VOID</a>


    HTML
    );

    echo $p->toHTML();

} catch (Exception $e) {
    header("Location: ErreurPage.php");
    return;
}