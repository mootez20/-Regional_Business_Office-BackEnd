<?php

 if (extension_loaded('gd')&& function_exists('gd_info')){
     echo "Gd Installed";
    } else {
         echo "GD not installed";
     
 }
 echo phpinfo();
 ?>