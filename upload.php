<?php

// Thank you for downloading! Feel free to use any of this code in your own projects.

error_reporting(E_ERROR);
// Start of uploader.

// Replace "t1" and "t2" with secret keys.
// I recommend a random password generator.
$tokens = array("t1", "t2");

// Replace "img/" with any directory you want.
// Map the dir correctly or the uploader will fail.
$sharexdir = "img/";

// Number of letters and numbers in link. 
$filelength = 6;

// Name generator function.
function RandomName($filelength) {

    // 0-9 and a-z
    // You can make 'a' and 'z' capital if you want, but lowercase looks better in my opinion.
    $names = array_merge(range(0,9), range('a', 'z'));

    for($i=0; $i < $filelength; $i++) {
        $name .= $names[mt_rand(0, count($names) - 1)];
    }
    return $name;

}

// Start of the token check and error logging.
if(isset($_POST['secret']))
{

    // Check if the token is valid.
    if(in_array($_POST['secret'], $tokens))
    {

        // Prepare for uploading to the server.
        $filename = RandomName($filelength);
        $targetfile = $_FILES["sharex"]["name"];
        $filetype = pathinfo($targetfile, PATHINFO_EXTENSION);

        // Move image to directory defined at the top of the file.
        if (move_uploaded_file($_FILES["sharex"]["tmp_name"], $sharexdir.$filename.'.'.$filetype))

        {

            // Send client info.
            $json->status = "OK";
            $json->errormsg = "";
            $json->url = $filename . '.' . $filetype;

        } 

        else 
        
        {

            echo 'Upload failed. Check upload.php and ensure you followed the correct steps.';

        }

    } 
    
    else 
    
    {

        // Bad token.
        echo 'Invalid token.';
        
    }

} 

else 

{

// No post data.
echo 'No post data obtained.';

}

// Send json.
echo(json_encode($json));

// End uploader.
?>