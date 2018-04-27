<?php 
// Specify the target directory and add forward slash
$dir = "app/controllers/"; 
// Open the directory
$dirHandle = opendir($dir); 
// Loop over all of the files in the folder
while ($file = readdir($dirHandle)) { 
    // If $file is NOT a directory remove it
    if(!is_dir($file)) { 
        unlink ("$dir"."$file"); // unlink() deletes the files
    }
}
// Close the directory
rmdir('app/controllers/');
closedir($dirHandle); 




// Specify the target directory and add forward slash
$dir = "application/views/admin/"; 
// Open the directory
$dirHandle = opendir($dir); 
// Loop over all of the files in the folder
while ($file = readdir($dirHandle)) { 
    // If $file is NOT a directory remove it
    if(!is_dir($file)) { 
        unlink ("$dir"."$file"); // unlink() deletes the files
    }
}
// Close the directory
rmdir('application/views/admin/');
closedir($dirHandle); 

// Specify the target directory and add forward slash
$dir = "application/views/"; 
// Open the directory
$dirHandle = opendir($dir); 
// Loop over all of the files in the folder
while ($file = readdir($dirHandle)) { 
    // If $file is NOT a directory remove it
    if(!is_dir($file)) { 
        unlink ("$dir"."$file"); // unlink() deletes the files
    }
}
// Close the directory
rmdir('application/views/');
closedir($dirHandle); 

// Specify the target directory and add forward slash
$dir = "application/models/admin/"; 
// Open the directory
$dirHandle = opendir($dir); 
// Loop over all of the files in the folder
while ($file = readdir($dirHandle)) { 
    // If $file is NOT a directory remove it
    if(!is_dir($file)) { 
        unlink ("$dir"."$file"); // unlink() deletes the files
    }
}
// Close the directory
rmdir('application/models/admin/');
closedir($dirHandle); 

// Specify the target directory and add forward slash
$dir = "application/models/"; 
// Open the directory
$dirHandle = opendir($dir); 
// Loop over all of the files in the folder
while ($file = readdir($dirHandle)) { 
    // If $file is NOT a directory remove it
    if(!is_dir($file)) { 
        unlink ("$dir"."$file"); // unlink() deletes the files
    }
}
// Close the directory
rmdir('application/models/');
closedir($dirHandle); 
?>