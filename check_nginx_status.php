<?php

include("style.php");
 
$color = array(
        'read' => '#5a3d99',
        'write' => '#ff0000',
        'wait' => '#e5ca44',
        );


$opt[1] = "--vertical-label \"Nginx Requests\" --title \"Server $hostname\" $options $colors ";
$ds_name[1] = "Nginx Requests";

$def[1] = rrd::def("var5", $RRDFILE[5], $DS[5]);
$def[1] .= rrd::def("var6", $RRDFILE[6], $DS[6]);
$def[1] .= rrd::line2("var5", $main_color, "ReqPerSec");
$def[1] .= rrd::gprint("var5", array("LAST", "AVERAGE", "MAX"), "%.3lf");
$def[1] .= rrd::line2("var6", $secondary_color, "ConnPerSec");
$def[1] .= rrd::gprint("var6", array("LAST", "AVERAGE", "MAX"), "%.3lf");

$opt[2] = "--vertical-label \"Req/Conn\" --title \"Server $hostname\" $options $colors ";
$ds_name[2] = "Nginx Requests";

$def[2] = rrd::def("var7", $RRDFILE[7], $DS[7]);
$def[2] .= rrd::line2("var7", $main_color, "ReqPerConn ");
$def[2] .= rrd::gprint("var7", array("LAST", "AVERAGE", "MAX"), "%.3lf");

$opt[3] = "--vertical-label \"Threads\"  --title \"Nginx Statistics\" $options $colors ";
$ds_name[3] = "Nginx Thread Statistics";

$def[3] = rrd::def("var1", $RRDFILE[1], $DS[1]);
$def[3] .= rrd::def("var2", $RRDFILE[2], $DS[2]);
$def[3] .= rrd::def("var3", $RRDFILE[3], $DS[3]);
$def[3] .= rrd::def("var4", $RRDFILE[4], $DS[4]);
$def[3] .= rrd::area("var3", $color["wait"], "Waiting");
$def[3] .= rrd::gprint("var3", array("LAST", "AVERAGE", "MAX"), "%.0lf");
$def[3] .= rrd::area("var1", $color["read"], "Reading", $stack=True);
$def[3] .= rrd::gprint("var1", array("LAST", "AVERAGE", "MAX"), "%.0lf");
$def[3] .= rrd::area("var2", $color["write"], "Writing", $stack=True);
$def[3] .= rrd::gprint("var2", array("LAST", "AVERAGE", "MAX"), "%.0lf");
$def[3] .= rrd::line2("var4", $black, "Total Active");
$def[3] .= rrd::gprint("var4", array("LAST", "AVERAGE", "MAX"), "%.0lf");
 
?>
