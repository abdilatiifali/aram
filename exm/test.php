<?php 
$printer = "Onyx Printer"; 
if($ph = printer_open($printer)) 
{ 
   // Get file contents 
   echo '<br/> Printer option 1 Connected...<br/>';
  /* $fh = fopen("filename.ext", "rb"); 
   $content = fread($fh, filesize("filename.ext")); 
   fclose($fh); 
        
   // Set print mode to RAW and send PDF to printer 
   printer_set_option($ph, PRINTER_MODE, "RAW"); 
   printer_write($ph, $content); 
   printer_close($ph); */
} 
else "Couldn't connect..."; 

$printer = "C:\Onyx Printer"; 
if($ph = printer_open($printer)) 
{ 
   // Get file contents 
   echo '<br/> Printer option 3 Connected...<br/>';
  /* $fh = fopen("filename.ext", "rb"); 
   $content = fread($fh, filesize("filename.ext")); 
   fclose($fh); 
        
   // Set print mode to RAW and send PDF to printer 
   printer_set_option($ph, PRINTER_MODE, "RAW"); 
   printer_write($ph, $content); 
   printer_close($ph); */
} 
else "Couldn't connect..."; 


$printer = "C:\OnyxPrinter\DLFiles\gaadiidka.onx"; 
if($ph = printer_open($printer)) 
{ 
   // Get file contents 
   echo '<br/> Printer option 3 Connected...<br/>';
   /*$fh = fopen("filename.ext", "rb"); 
   $content = fread($fh, filesize("filename.ext")); 
   fclose($fh); 
        
   // Set print mode to RAW and send PDF to printer 
   printer_set_option($ph, PRINTER_MODE, "RAW"); 
   printer_write($ph, $content); 
   printer_close($ph); */
} 
else "Couldn't connect..."; 



?>
