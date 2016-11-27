<?php
if(!empty($_POST['datum'])){
    $data = $_POST['datum'];
    $name = $_POST['name'];
    $fname = $name.'.pdf'; // name the file
    $file = fopen("../temp/" .$fname, 'w'); // open the file path
    fwrite($file, $data); //save data
    fclose($file);
} else {
    echo "No Data Sent";
}
?>
