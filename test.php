<!DOCTYPE html>
<html>
<body>

<?php
$date1=date_create("2013-03-15 22:00");
$date2=date_create("2013-03-18 23:00");
$diff=date_diff($date1,$date2);
echo $diff->format("%R%a days");
echo date("y/m/d");
?>

</body>
</html>