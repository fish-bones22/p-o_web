<?php
  if(isset($_POST['file'])){
      $data = json_decode($_POST['file']);
      $name = $data->name.".pdf";
      $pdf = $data->output;
      $file = fopen("../temp/".$name, 'w'); // open the file path
      fwrite($file, $pdf); //save data
      fclose($file);
  } else {
      echo "No Data Sent";
  }
?>
