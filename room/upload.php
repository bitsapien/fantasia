<?php
if (isset($_FILES["photoimg"])) {
    // Your Custom PHP Code Here
    $return = json_encode($_FILES["photoimg"]);
    echo $return;
}
?>
