<?php declare(strict_types=1);

require_once ('autoload.php');
Session::start();

if(!isset($_SESSION["InfosUser"]["ID"]))
{
    header("Location: findme.php");
}

if($_SESSION["InfosUser"]["CheckQCM1"]==false) {
    $num = $_SESSION["InfosUser"]["numQCM"];

    $title = "Bienvenue au QCM n°{$num}";
    $p = new WebPage($title);

    $stmt = MyPDO::getInstance()->prepare(<<<SQL
SELECT intitule,id
FROM QUESTION
SQL

);
    $stmt->execute();
    $quest = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $questQCM = array_rand($quest,4);
$quest1 = $quest[$questQCM[0]]["intitule"];
    $quest2 = $quest[$questQCM[1]]["intitule"];
    $quest3 = $quest[$questQCM[2]]["intitule"];
    $quest4 = $quest[$questQCM[3]]["intitule"];
    if(!isset($_SESSION["InfosUser"]["QCM1Q1"])) {
        $_SESSION["InfosUser"]["QCM1ID1"] = $quest[$questQCM[0]]["id"];
        $_SESSION["InfosUser"]["QCM1ID2"] = $quest[$questQCM[1]]["id"];
        $_SESSION["InfosUser"]["QCM1ID3"] = $quest[$questQCM[2]]["id"];
        $_SESSION["InfosUser"]["QCM1ID4"] = $quest[$questQCM[3]]["id"];
        $_SESSION["InfosUser"]["QCM1Q1"] = $quest1;
        $_SESSION["InfosUser"]["QCM1Q2"] = $quest2;
        $_SESSION["InfosUser"]["QCM1Q3"] = $quest3;
        $_SESSION["InfosUser"]["QCM1Q4"] = $quest4;
    }
    $stmt1 = MyPDO::getInstance()->prepare(<<<SQL
Select intitule,VoF
from reponse
where idQuestion = :id
SQL

    );
    $stmt1->bindParam('id',$_SESSION["InfosUser"]["QCM1ID1"]);
    $stmt1->execute();
    $repQ1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

    $stmt2 = MyPDO::getInstance()->prepare(<<<SQL
Select intitule,VoF
from reponse
where idQuestion = :id
SQL

    );
    $stmt2->bindParam('id',$_SESSION["InfosUser"]["QCM1ID2"]);
    $stmt2->execute();
    $repQ2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);


    $stmt3 = MyPDO::getInstance()->prepare(<<<SQL
Select intitule,VoF
from reponse
where idQuestion = :id
SQL

    );
    $stmt3->bindParam('id',$_SESSION["InfosUser"]["QCM1ID3"]);
    $stmt3->execute();
    $repQ3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);

    $stmt4 = MyPDO::getInstance()->prepare(<<<SQL
Select intitule,VoF
from reponse
where idQuestion = :id
SQL

    );
    $stmt4->bindParam('id',$_SESSION["InfosUser"]["QCM1ID4"]);
    $stmt4->execute();
    $repQ4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);
    $p->appendContent(<<<HTML
 
 <div id="page-wrap">
 
 <h1>Simple Quiz Built On PHP</h1>
 
 <form action="resultQCM1.php" method="post" id="quiz">
 
            <ol>
            
                <li>
                
                    <h3>{$_SESSION["InfosUser"]["QCM1Q1"]}</h3>
                    
                    <div>
                        <input type="radio" name="question-1-answers" id="question-1-answers-A" value="{$repQ1[0]["VoF"]}" />
                        <label for="question-1-answers-A">{$repQ1[0]["intitule"]} </label>
                    </div>
                    
                    <div>
                        <input type="radio" name="question-1-answers" id="question-1-answers-B" value="{$repQ1[1]["VoF"]}" />
                        <label for="question-1-answers-B">{$repQ1[1]["intitule"]}</label>
                    </div>
                    
                    <div>
                        <input type="radio" name="question-1-answers" id="question-1-answers-C" value="{$repQ1[2]["VoF"]}" />
                        <label for="question-1-answers-C">{$repQ1[2]["intitule"]}</label>
                    </div>
                    
                    <div>
                        <input type="radio" name="question-1-answers" id="question-1-answers-D" value="{$repQ1[3]["VoF"]}" />
                        <label for="question-1-answers-D">{$repQ1[3]["intitule"]}</label>
                    </div>
                
                </li>
                
                <li>
                
                    <h3>{$_SESSION["InfosUser"]["QCM1Q2"]}</h3>
                    
                    <div>
                        <input type="radio" name="question-2-answers" id="question-2-answers-A" value="{$repQ2[0]["VoF"]}" />
                        <label for="question-2-answers-A">{$repQ2[0]["intitule"]}</label>
                    </div>
                    
                    <div>
                        <input type="radio" name="question-2-answers" id="question-2-answers-B" value="{$repQ2[1]["VoF"]}" />
                        <label for="question-2-answers-B">{$repQ2[1]["intitule"]}</label>
                    </div>
                    
                    <div>
                        <input type="radio" name="question-2-answers" id="question-2-answers-C" value="{$repQ2[2]["VoF"]}" />
                        <label for="question-2-answers-C">{$repQ2[2]["intitule"]}</label>
                    </div>
                    
                    <div>
                        <input type="radio" name="question-2-answers" id="question-2-answers-D" value="{$repQ2[3]["VoF"]}" />
                        <label for="question-2-answers-D">{$repQ2[3]["intitule"]}</label>
                    </div>
                
                </li>
                
                <li>
                
                    <h3>{$_SESSION["InfosUser"]["QCM1Q3"]}</h3>
                    
                    <div>
                        <input type="radio" name="question-3-answers" id="question-3-answers-A" value="{$repQ3[0]["VoF"]}" />
                        <label for="question-3-answers-A">{$repQ3[0]["intitule"]}</label>
                    </div>
                    
                    <div>
                        <input type="radio" name="question-3-answers" id="question-3-answers-B" value="{$repQ3[1]["VoF"]}" />
                        <label for="question-3-answers-B">{$repQ3[1]["intitule"]}</label>
                    </div>
                    
                    <div>
                        <input type="radio" name="question-3-answers" id="question-3-answers-C" value="{$repQ3[2]["VoF"]}" />
                        <label for="question-3-answers-C">{$repQ3[2]["intitule"]}</label>
                    </div>
                    
                    <div>
                        <input type="radio" name="question-3-answers" id="question-3-answers-D" value="{$repQ3[3]["VoF"]}" />
                        <label for="question-3-answers-D">{$repQ3[3]["intitule"]}</label>
                    </div>
                
                </li>
                
                <li>
                
                    <h3>{$_SESSION["InfosUser"]["QCM1Q4"]}</h3>
                    
                    <div>
                        <input type="radio" name="question-4-answers" id="question-4-answers-A" value="{$repQ4[0]["VoF"]}" />
                        <label for="question-4-answers-A">{$repQ4[0]["intitule"]}</label>
                    </div>
                    
                    <div>
                        <input type="radio" name="question-4-answers" id="question-4-answers-B" value="{$repQ4[1]["VoF"]}" />
                        <label for="question-4-answers-B">{$repQ4[1]["intitule"]}</label>
                    </div>
                    
                    <div>
                        <input type="radio" name="question-4-answers" id="question-4-answers-C" value="{$repQ4[2]["VoF"]}" />
                        <label for="question-4-answers-C">{$repQ4[2]["intitule"]}</label>
                    </div>
                    
                    <div>
                        <input type="radio" name="question-4-answers" id="question-4-answers-D" value="{$repQ4[3]["VoF"]}" />
                        <label for="question-4-answers-D">{$repQ4[3]["intitule"]}</label>
                    </div>
                
                </li>
            
            </ol>
            
            <input type="submit" value="Submit" class="submitbtn" />
 
 </form>
 
 </div>
 

HTML
    );


    echo $p->toHTML();
}

else
{
    header("Location: redirect.php");

}
/*
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Refresh"/>
</head>
<h1 style="text-align: center;">Scanner le Qr Code du prochain stand</h1>
<hr>

<script src="js/html5-qrcode.min.js"></script>
<style>
  .result{
    background-color: green;
    color:#fff;
    padding:20px;
  }
  .row{
    display:flex;
}
</style>


<div class="row">
  <div class="col">
    <div style="width:500px;" id="reader"></div>
  </div>
  <div class="col" style="padding:30px;">
    <div id="result"></div>
  </div>
</div>


<script type="text/javascript">
function onScanSuccess(qrCodeMessage) {
//    document.getElementById('result').innerHTML = '<p>Vers <a href='+qrCodeMessage+' >stand 2</a>.</p>';
    document.getElementById('result').innerHTML = '<meta http-equiv="refresh" content="0; URL='+qrCodeMessage+'">';
}

function onScanError(errorMessage) {
    //handle scan error
}

var html5QrcodeScanner = new Html5QrcodeScanner(
    "reader", { fps: 10, qrbox: 250 });
html5QrcodeScanner.render(onScanSuccess, onScanError);

</script>
</html>*/