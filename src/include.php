<?php
// print_r($_SERVER); exit();
define("SRC", dirname(__FILE__));
define("ROOT", dirname(SRC));
define("SP", DIRECTORY_SEPARATOR);
define("CONFIG", ROOT.SP."config"); 
define("VIEWS", ROOT.SP."views"); 
define("MODEL", ROOT.SP."model");
define("BASE_URL", dirname(dirname($_SERVER['SCRIPT_NAME'])));
define("TVA", 20);
// import du model
require CONFIG.SP."config.php";
require MODEL.SP."DataLayer.class.php";

$model = new DataLayer();
$category = $model->getCategory();

// $data = $model->getCustomer(30);
// print_r($data); exit();



// les fonctions appelée par le controller
require "functions.php";


?>