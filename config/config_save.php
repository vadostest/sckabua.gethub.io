<?
$fp = fopen('../config.php', 'w+');
flock($fp, LOCK_EX); // Блокирование файла для записи
$file_conf="Configuration for LandingPage: ";
$last_edit="Last edition by ".date('d.m.Y, h:i:s');
$create="Created by ConfigLand";
$power1="Powered by Igor Sayutin";
$power2="http://it-senior.pp.ua";
$text="<?\n/* ".str_repeat("* ", 22)."\n";
$text.=" * ".str_pad($file_conf, 41, " ", STR_PAD_BOTH)." *\n";
$text.=" * ".str_pad($_SERVER['SERVER_NAME'], 41, " ", STR_PAD_BOTH)." *\n";
$text.=" * ".str_pad($last_edit, 41, " ", STR_PAD_BOTH)." *\n";
$text.=" ".str_repeat("* ", 22)."*/\n\n";


 foreach($_POST as $key => $value) {
	$value = str_replace("'", "\'", $value);
	$s="$".$key." = "."'{$value}';\n";
	$text.=$s; 
	
}
$text.="$"."price_old = floor(($"."price_new/(100-$"."skidka))*100);\n";
$text.="\n/* ".str_repeat("* ", 22)."\n";
$text.=" * ".str_pad($create, 41, " ", STR_PAD_BOTH)." *\n";
$text.=" * ".str_pad($power1, 41, " ", STR_PAD_BOTH)." *\n";
$text.=" * ".str_pad($power2, 41, " ", STR_PAD_BOTH)." *\n";
$text.=" ".str_repeat("* ", 22)."*/\n\n";
$text.="?>\n";
fwrite($fp, $text);
flock($fp, LOCK_UN); // Снятие блокировки
fclose($fp);
$suces_url="Location: options.php?save=1";
header($suces_url);
?>