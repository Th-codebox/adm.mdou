<?php
echo "11111";
 function extensionFunctions($ext) 
 { 
     $extFuncs = get_extension_funcs($ext); 
     while(list($fid, $fname) = each($extFuncs)) 
     { 
         echo " - " . ($fid + 1) . " $fname <br>"; 
     } 
 } 
 echo "| <a href='$_SERVER[PHP_SELF]'>Extensions Only</a> | <a href='$_SERVER[PHP_SELF]?expand=*'>Expand functions</a> |<br>"; 
 $loaded = get_loaded_extensions(); 
 while(list($id, $name) = each($loaded)) { 
     echo "<b>" . ($id + 1) . ". <a href='$_SERVER[PHP_SELF]?expand=$name#$name'><span id=$name>$name</span></a></b><br>"; 
     $expand = $_GET['expand'];  
     if(isset($expand)) {  
          if($expand == $name || $expand == "*") {  
             extensionFunctions($name);  
          }  
     }  
 } 



print_r(get_loaded_extensions());

	phpinfo();

	
?>
