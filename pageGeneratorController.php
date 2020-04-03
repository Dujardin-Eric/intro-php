<?php
//mise en mémoire tampon de la sortie php
ob_start();

//ouverture de la session
session_start();

/*************************************
 * Fonctions utiles au traitement
*************************************/

function manageUpload(&$message, &$uploadOK, &$filePath){
    $upload = $_FILES["photo"];
    $isValid = $upload["type"] == "image/jpeg" && $upload["error"] == "0";
    $filePath = "img/". uniqid("photo_").".jpg";
    if($isValid){
        $uploadOK = move_uploaded_file($upload["tmp_name"], $filePath);
        if($uploadOK){
            $message = "Upload réussi";
        } else {
            $message = "Echec de l'Upload";
        }
    }
}

function getImageCode($uploadOK, $filePath){
    if($uploadOK){
        $img = "<img src=\"../$filePath\">";
    } else {
        $img = "";
    }
    return $img;
}

function saveHtmlFile($fileName, $title, $img, $text, &$message){
    //inclusion du modèle
    require "templates/article.php";
    //récupération de la mémoire tampon dans une variable
    $htmlCode = ob_get_clean();


    //Enregistrement de la page
    $fileOk = file_put_contents("sorties/$fileName.html", $htmlCode);
    if($fileOk){
        $message .= "Enregistrement réussi <a href=\"sorties/$fileName.html\">Lien vers la page </a>";
        
        //Enregistrement du message dans la session
        session_regenerate_id(true);
        
        $_SESSION["message"] = $message;
        //redirection en cas de succès
        header("localion:pageGenratorController.php");
    } else {
        $message .= "Echec de l'enregistrement";
    }
}

//Les données sont elles postées
$isPosted = filter_has_var(INPUT_POST, "submit");
$hasUpload = isset($_FILES["photo"]["tmp_name"]);

//message de succès ou d'erreur
$message = $_SESSION["message"] ?? "";

//initialisation du test de l'upload
$uploadOK = false;

if($isPosted){
    //récupération des données
    $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING);
    $text = filter_input(INPUT_POST, "text", FILTER_SANITIZE_STRING);
    $fileName = filter_input(INPUT_POST, "fileName", FILTER_SANITIZE_STRING);

    //Chemin de l'image
    $filePath = "";

    //Traitement du fichier téléchargé
    if($hasUpload){
        manageUpload($message, $uploadOK, $filePath);
    }

    $img = getImageCode($uploadOK, $filePath);

    //Génération du code html de la page avec ou sans image
    saveHtmlFile($fileName, $title, $img, $text, $message);

    
}


require "views/pageGenerator.php";