<form method="post" action="debug.php">
    <input type="checkbox" name="in1">
    <input type="submit" name="sub" value="submit">
</form>

<?php
    if(isset($_POST["in1"]))
        echo $_POST["in1"];
    else 
        echo $_POST["in1"];
?>