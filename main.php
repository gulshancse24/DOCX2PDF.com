<?php

use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;

function transliterate($input){
    $gost = array(
        "а"=>"a","б"=>"b","в"=>"v","г"=>"g","д"=>"d",
        "е"=>"e", "ё"=>"yo","ж"=>"j","з"=>"z","и"=>"i",
        "й"=>"i","к"=>"k","л"=>"l", "м"=>"m","н"=>"n",
        "о"=>"o","п"=>"p","р"=>"r","с"=>"s","т"=>"t",
        "у"=>"y","ф"=>"f","х"=>"h","ц"=>"c","ч"=>"ch",
        "ш"=>"sh","щ"=>"sh","ы"=>"i","э"=>"e","ю"=>"u",
        "я"=>"ya",
        "А"=>"A","Б"=>"B","В"=>"V","Г"=>"G","Д"=>"D",
        "Е"=>"E","Ё"=>"Yo","Ж"=>"J","З"=>"Z","И"=>"I",
        "Й"=>"I","К"=>"K","Л"=>"L","М"=>"M","Н"=>"N",
        "О"=>"O","П"=>"P","Р"=>"R","С"=>"S","Т"=>"T",
        "У"=>"Y","Ф"=>"F","Х"=>"H","Ц"=>"C","Ч"=>"Ch",
        "Ш"=>"Sh","Щ"=>"Sh","Ы"=>"I","Э"=>"E","Ю"=>"U",
        "Я"=>"Ya",
        "ь"=>"","Ь"=>"","ъ"=>"","Ъ"=>"",
        "ї"=>"j","і"=>"i","ґ"=>"g","є"=>"ye",
        "Ї"=>"J","І"=>"I","Ґ"=>"G","Є"=>"YE"
    );
    return strtr($input, $gost);
}

require_once 'vendor/autoload.php';

$objReader = IOFactory::createReader();
$contents=$objReader->load($_FILES['file']['tmp_name']);

$rendername = Settings::PDF_RENDERER_TCPDF;

$renderLibrary="TCPDF";
$renderLibraryPath=''.$renderLibrary;
if(!Settings::setPdfRenderer($rendername,$renderLibrary)){
	die("Provide Render Library And Path");
}
$renderLibraryPath=''.$renderLibrary;
$objWriter = IOFactory::createWriter($contents,'PDF');

$filename = str_replace( 'docx', 'pdf', $_FILES['file']['name']);

$objWriter->setFont('DejaVuSans');
$objWriter->save($filename);

$download_file = realpath($filename);

$name = str_replace( '.pdf', '',$filename);
$newname = transliterate($name);

header('HTTP/1.1 200 OK');
header('Content-type: application/pdf; charset utf8');
header("Content-Length: ".filesize($download_file));
header('Content-Disposition: attachment; filename=' . $newname . '.pdf');
readfile($download_file);
?>