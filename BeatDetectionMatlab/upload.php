<?php

if ((($_FILES["file"]["type"] == "audio/mp3")
|| ($_FILES["file"]["type"] == "audio/mp4")
|| ($_FILES["file"]["type"] == "audio/wav"))
&& ($_FILES["file"]["size"] < 20971520))
  {
  if ($_FILES["file"]["error"] > 0)
    {
   ECHO "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
  else
    {
    echo "Upload File Name: <strong>  " . $_FILES["file"]["name"] . "<br /> </strong>";
    echo "Type / Format: <strong> " . $_FILES["file"]["type"] . "<br /> </strong>";
    echo "Size: <strong> " . ($_FILES["file"]["size"] / 1024) . " Kb<br /><br /> </strong>";

    if (file_exists("music/" . $_FILES["file"]["name"]))
      {
     ECHO $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
	  $_FILES["file"]["name"] = iconv("utf-8", "ISO-8859-7", $_FILES["file"]["name"]);
	  
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "music/" . $_FILES["file"]["name"]);
	  
	  $_FILES["file"]["name"] = iconv("ISO-8859-7", "utf-8", $_FILES["file"]["name"]);
      echo "Stored in: <strong> " . "music/" . $_FILES["file"]["name"]. "</strong>";
      }
    }
  }
else
  {
  echo "Upload Failed - Invalid file <br>";
  echo "The file you tried to upload is too big or has not acceptable format <br><br>";
  echo "Maximum upload file size: 20mb <br>";
  echo "Acceptable audio file formats: (.mp3), (.wav), (.mp4) <br>";
  }
    
	$trackname = $_FILES["file"]["name"];
	
	$second_trackname = iconv("utf-8", "ISO-8859-7", $trackname);
	$myfile = fopen("textfiles/TrackName.txt", "w") or die("Unable to open file!");
	fwrite($myfile, $second_trackname);
	
	fclose($myfile);
	
	
	// ***************** PHP - Matlab Connection
	
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	$command = "/usr/local/MATLAB/R2012b/bin/matlab -nodisplay -nodesktop -nosplash -nojvm -logfile thelog.log -r \":/BeatDetectionMatlab/main('');\"";
    
	//$output;
	//$return_var;
	
	exec($command, $output, $return_var);
	
	//var_dump($output);
	//var_dump($return_var);
	
	// *****************************************
	
	
	// Result BPM Print
	$results = fopen("textfiles/results.txt", "r") or die("Unable to open file!");
	echo "<br><br>Matlab Algorithm calculated <strong>";
	echo fread($results,filesize("textfiles/results.txt"));
	echo " BPM </strong> for this track.";
	fclose($results);
  
?> 