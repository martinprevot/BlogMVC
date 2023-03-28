    <? session_start();
    $_SESSION["connexion"]=0;?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8" />
      <title><?= $title ?></title>
      <link href="style.css" rel="stylesheet" /> 
   </head>

   <body>

      <?= $content ?>
 <br><br><br>
<?php 
if (!empty($_POST['username']) AND !empty($_POST['password'])) //reçois données rentrée lors de la connexion
 {

$hash=crypt($_POST['password'], '$5$rounds=5000$test$');
$user = Test_connexion($_POST['username'],$hash); 
$_SESSION["id"]=$user["id"];
$_SESSION["nom"]=$user["nom"];
$_SESSION["prenom"]=$user["prenom"];
$_SESSION["email"]=$user["email"];
$_SESSION["login"]=$user["login"];

echo "Vous etes connecté en tant que ".$_SESSION["login"];


}

if (!isset($_SESSION["id"]))
{ ?>
<form method="POST">
    <b>Nom d'utilisateur : </b>
    <input type="text" placeholder="Entrer le nom d'utilisateur" name="username" >
    <br>
    <b>Mot de passe : </b>
    <input type="password" placeholder="Entrer le mot de passe" name="password" >
    <br>
    <input type="submit" id='submit' value='LOGIN' >
</form>
<?php
    } 
else
{
    echo $_SESSION["login"]." bouton déconnexion";
}

 
?>

   </body>
</html>
