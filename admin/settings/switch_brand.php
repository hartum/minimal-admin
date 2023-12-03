<?php
//--- RETRIEVES THE VARIABLES --
$brandImage = $_POST["image_attachment_url"];
$JSON_file = $_POST["json_path"];
//--- RETRIEVE JSON FILE ---
$jsonString = file_get_contents($JSON_file);
$jsonData = json_decode($jsonString, true);
//--- CHANGE brandImage VALUE ---
$jsonData["brandImage"] = $brandImage;
//--- REWRITE FILE WITH NEW VALUE ---
$jsonString = json_encode($jsonData, JSON_PRETTY_PRINT);
$fp = fopen($JSON_file, 'w');
fwrite($fp, $jsonString);
fclose($fp);
//--- REDIRECT TO PREVIOUS PAGE
if (isset($_SERVER["HTTP_REFERER"])) {
    header("Location: " . $_SERVER["HTTP_REFERER"]);
}
?>