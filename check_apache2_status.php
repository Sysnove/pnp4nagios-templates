<?php

include("style.php");
 
$color = array(
        'read' => '#5a3d99',
        'write' => '#ff0000',
        'wait' => '#e5ca44',
        );

$opt[1] = "--vertical-label \"Days\" --title \"$hostname / Apache2 Uptime\" $options $colors ";
$ds_name[1] = "Apache2 Uptime";

$def[1] = rrd::def("var1", $RRDFILE[1], $DS[1]);
$def[1] .= rrd::cdef("var1_d", "var1,1440,/");
$def[1] .= rrd::line2("var1_d", $main_color, "Uptime");
$def[1] .= rrd::gprint("var1_d", array("LAST", "AVERAGE", "MAX"), "%7.0lf days");

$opt[2] = "--vertical-label \"Req/Sec\" --title \"$hostname / Apache2 Requests\" $options $colors ";
$ds_name[2] = "Apache2 Requests";

$def[2] = rrd::def("var2", $RRDFILE[2], $DS[2]);
$def[2] .= rrd::line2("var2", $main_color, "ReqPerSec");
$def[2] .= rrd::gprint("var2", array("LAST", "AVERAGE", "MAX"), "%.3lf");

$opt[3] = "--vertical-label \"Bytes/Sec\" --title \"$hostname / Apache2 Traffic\" $options $colors ";
$ds_name[3] = "Apache2 Traffic";

$def[3] = rrd::def("var3", $RRDFILE[3], $DS[3]);
$def[3] .= rrd::line2("var3", $main_color, "BytesPerSec");
$def[3] .= rrd::gprint("var3", array("LAST", "AVERAGE", "MAX"), "%.3lf");


$opt[4] = "--vertical-label \"Workers\" --title \"$hostname / Apache2 Workers\" $options $colors ";
$ds_name[4] = "Apache2 Workers";

$def[4] = rrd::def("active", $RRDFILE[4], $DS[4]);
$def[4] .= rrd::def("idle", $RRDFILE[5], $DS[5]);
$def[4] .= rrd::cdef("total", "active,idle,+");
$def[4] .= rrd::line2("active", $main_color, "Active") ;
$def[4] .= rrd::gprint("active", array("LAST", "AVERAGE", "MAX"), "%.0lf") ;
$def[4] .= rrd::line2("total", $black, "Total") ;
$def[4] .= rrd::gprint("total", array("LAST", "AVERAGE", "MAX"), "%.0lf") ;
 
?>
