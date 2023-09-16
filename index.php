<?php declare(strict_types=1);
//ob_start();
require_once('autoload.php');



try {
    Session::start();
} catch (SessionException $e) {
    header("Location: ErreurPage.php");
    return null;
}

if(!isset($_SESSION["InfosUser"]["ID"])) {

    if (!isset($_SESSION["InfosUser"]["VerifGeoloc"])) {
        header("Location: findme.php");
        return;
    } else if (!$_SESSION["InfosUser"]["VerifGeoloc"]) {
        header("Location: findme.php");
        return;
    }


    session_destroy();
}


try {
    Session::start();
} catch (SessionException $e) {
    header("Location: ErreurPage.php");
    return;
}
$title = 'Bienvenue';
$p = new WebPage($title);

//initialise toute les données de sessions
if(!isset($_SESSION["InfosUser"]))
{
    $_SESSION["InfosUser"]= [];
}

if(!isset($_SESSION["InfosUser"]["CheckQCM1"]))
{
    $_SESSION["InfosUser"]["CheckQCM1"]= false;
}
if(!isset($_SESSION["InfosUser"]["CheckQCM2"]))
{
    $_SESSION["InfosUser"]["CheckQCM2"]= false;
}
if(!isset($_SESSION["InfosUser"]["CheckQCM3"]))
{
    $_SESSION["InfosUser"]["CheckQCM3"]= false;
}
if(!isset($_SESSION["InfosUser"]["CheckQCM4"]))
{
    $_SESSION["InfosUser"]["CheckQCM4"]= false;
}
if(!isset($_SESSION["InfosUser"]["CheckQCM5"]))
{
    $_SESSION["InfosUser"]["CheckQCM5"]= false;
}
if(!isset($_SESSION["InfosUser"]["Score"]))
{
    $_SESSION["InfosUser"]["Score"]= 0;
}
if(!isset($_SESSION["InfosUser"]["numQCM"]))
{
    $_SESSION["InfosUser"]["numQCM"] = 0;
}
if(!isset($_SESSION["InfosUser"]["QCMFini"]))
{
    $_SESSION["InfosUser"]["QCMFini"]= [];
}

// si le visiteur est nouveau, lui creer une session
if(!isset($_SESSION["InfosUser"]["ID"]) or $_SESSION["InfosUser"]["QCMFini"] == []) {

    try {
        $idbd = MyPDO::getInstance()->prepare(<<<SQL
            SELECT MAX(id) 
            FROM utilisateur;
        SQL
        );
        $idbd->execute();
        $idbd->setFetchMode(PDO::FETCH_NUM);
        $idmax = $idbd->fetchAll();
            $stmt = MyPDO::getInstance()->prepare(<<<SQL
                INSERT INTO utilisateur (id)
                value (:id)
            SQL
            );
            $iduser=(int)$idmax[0][0] + 1;
            $stmt->execute(['id' => $iduser]);
            $_SESSION["InfosUser"]["ID"] = $iduser;




        // Ajout du n° d'identité


        $reponse = MyPDO::getInstance()->query("SELECT identitee FROM utilisateur");
        $donnees = $reponse -> fetchAll();
        $jcount = count($donnees);
        

        $i = 1;
        $numidentValide = 0;
        while ($i <= 100):
            $numident = rand(100000000,999999999);

            for($j = 0; $j < $jcount; $j++){
                $numbdd = $donnees[$j]['identitee'];
                if($numbdd != $numident){
                    $numidentValide = $numident;
                    break 2;
                }
            }
            $i++;
        endwhile;

        $req = MyPDO::getInstance()->prepare(<<<SQL
            update Utilisateur 
            set identitee = :identitee, temps_abs = :temps_abs
            where id = :id
        SQL
        );
        $req->execute([
            'id'=> $_SESSION["InfosUser"]["ID"],
            'identitee' => $numidentValide,
            'temps_abs' => microtime(true)
        ]);
        $_SESSION["InfosUser"]["IDent"] = $numidentValide;
    } catch (Exception $e) {
        header("Location: ErreurPage.php");
        return;
    }

}
//todo random du premier QCM
$p->appendCssUrl("css/DarkTheme.css");
$p->appendContent(<<<HTML
        <div class="attention">
        NE PAS FERMER VOTRE NAVIGATEUR INTERNET, SOUS PEINE DE RECOMENCEMENT DU JEU. <br>
        (Votre navigateur peut etre mis en veille, mais sa fermeture entraîne l'effacement totale de vos informations.)
        </div>
        
        <div class="corps">
            <h1>Bienvenue</h1>
        </div>
        <div class="corps">
            <h2>Merci de participer à ce magnifique jeu concours au travers de la game'in Reims.</h2>
                <form action="PageMere.php">
                    <button type = "submit">Continuer</button>
                </form>
        </div>
        
        <div>
            <a href="THE_VOID.php">Go to THE VOID</a>
        </div>

HTML
);

// Sinon le rediriger sur la derniere page ou il etait
//TODO

try {
    echo $p->toHTML();
} catch (Exception $e) {
    header("Location: ErreurPage.php");
    return;
}
//ob_end_flush();