<?php 
if(defined('E_DEPRECATED')) {
    error_reporting(E_ALL &~ E_DEPRECATED);
}

if(defined('E_DEPRECATED')) {
    error_reporting(error_reporting() & ~E_DEPRECATED);

}

$week=($_GET['week']);
$datetimenow = date('Y-m-d H:i:s');

//echo "ini";

$weekbefore = $week + 1;
$weekafter = $week - 1;

?>
<a href="#" class="btn btn-info" onclick="getZonaWeek(<?php echo $weekbefore; ?>)"> &lt;&lt;&lt; Minggu Sebelumnya </a>
<a href="#" class="btn btn-info" onclick="getZonaWeek(<?php echo $weekafter; ?>)"> Minggu Setelahnya &gt;&gt;&gt;</a>