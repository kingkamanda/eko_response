<?php
// $fullname = $POST['fullname'];
// $message = $POST['content'];
//echo "<pre>";
//print_r($_GET);
///echo "</pre>";


//echo "<p>". $_GET['fullname']."</p>";

if ($_POST) {
    echo "Form was submitted";
    $fullname = $_POST['fullname'];
    $message = $_POST['content'];
    echo "Thank you $fullname";

} else {
  header("location:forms.php");
}




?>
<!-- CLASSWORK -->
<!-- <p> Thank you <?php //echo $_GET['fullname']?></p>

<p> your <?php //echo $_GET['message']?> has been recieved

</p> -->

<!-- CORRECTION -->
<p> Thank you <?php echo $_POST['fullname']?></p>

<p> your message has been recieved as follows</p>
<h5><?php echo $_POST['message']?></h5>