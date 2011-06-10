<?php
mb_internal_encoding('UTF-8'); // always needed before mb_ functions, check note below
if(!file_exists("languages/utf8converted")){
  if(isset($_GET['utf8encode'])&&$_GET['utf8encode']=="true"){
    foreach (glob("languages/*.php") as $filename) {
      if($filename!="languages/ru.php"){
        $contents = file($filename);
        for($i=0;$i<count($contents);$i++ ){
          $contents[$i] = preg_replace("/ISO\-8859\-1/i","UTF-8",$contents[$i]);
          // before re-encoding, check if already utf-8 encoded...
          if (mb_strlen($contents[$i]) != strlen($contents[$i])) {
            $contents[$i] = utf8_encode($contents[$i]);
          }
        }
        $contents = implode("",$contents);
        $handle = fopen($filename, "w");
        fwrite($handle,$contents);
        fclose($handle);
      }
    }
    $h = fopen("languages/utf8converted","w");
    fclose($h);
  }
  else { echo "<button onclick='location.href=\"index.php?utf8encode=true\"'>CONVERT FLATNUX LANGUAGE FILES TO UTF-8 AND SET CHARSET TO UTF-8</button>"; }
}
else{ 
  if(isset($_GET["cleanup"])&&$_GET["cleanup"]=="true"){
    unlink("languages/utf8converted");
    unlink("include/autoexec.d/fnx_convert_encoding.php");
  }
  else { echo "<button onclick='location.href=\"index.php?cleanup=true\"'>UTF-8 ENCODING COMPLETE! NOW CLEAN UP</button>"; } 
}
?>