<?php

include("style.php");
 
#$color = array(
#        'read' => '#5a3d99',
#        'write' => '#ff0000',
#        'wait' => '#e5ca44',
#        );


$opt[1] = "--vertical-label \"PHP-FPM procs\" --title \"Server $hostname\" $options $colors ";
$ds_name[1] = "PHP-FPM Procs";

$def[1] = rrd::def("idle", $RRDFILE[2], $DS[2]);
$def[1] .= rrd::def("active", $RRDFILE[3], $DS[3]);
$def[1] .= rrd::cdef("total", "active,idle,+");
$def[1] .= rrd::line2("active", $main_color, "Active") ;
$def[1] .= rrd::gprint("active", array("LAST", "AVERAGE", "MAX"), "%.0lf") ;
$def[1] .= rrd::line2("total", $black, "Total") ;
$def[1] .= rrd::gprint("total", array("LAST", "AVERAGE", "MAX"), "%.0lf") ;

$opt[2] = "--vertical-label \"PHP-FPM queue\" --title \"Server $hostname\" $options $colors ";
$ds_name[2] = "PHP-FPM listen queue";

$def[2] = rrd::def("queue", $RRDFILE[1], $DS[1]);
$def[2] .= rrd::line2("queue", $main_color, "Requests");
$def[2] .= rrd::gprint("queue", array("LAST", "AVERAGE", "MAX"), "%.0lf");
 
?>
