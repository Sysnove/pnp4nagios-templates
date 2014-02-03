<?php
 
$colors = array(
        'read' => '#5a3d99',
        'write' => '#ff0000',
        'wait' => '#e5ca44',
        );


$opt[1] = "--vertical-label \"Nginx Requests\" --title \"Server $hostname\" ";
$ds_name[1] = "Nginx Requests";

$def[1] = rrd::def("var5", $RRDFILE[5], $DS[5]);
$def[1] .= rrd::def("var6", $RRDFILE[6], $DS[6]);
$def[1] .= rrd::gradient("var5", "#66CCFFdd", "0000ffdd", "ReqPerSec");
$def[1] .= rrd::gprint("var5", array("LAST", "AVERAGE", "MAX"), "%.3lf");
$def[1] .= rrd::line1("var5", "#000000");
$def[1] .= rrd::gradient("var6", "#ff5c00dd", "#ffdc00dd", "ConnPerSec");
$def[1] .= rrd::gprint("var6", array("LAST", "AVERAGE", "MAX"), "%.3lf");
$def[1] .= rrd::line1("var6", "#000000");

$opt[2] = "--vertical-label \"Req/Conn\" --title \"Server $hostname\" ";
$ds_name[2] = "Nginx Requests";

$def[2] = rrd::def("var7", $RRDFILE[7], $DS[7]);
$def[2] .= rrd::line1("var7", "#000000", "ReqPerConn ");
$def[2] .= rrd::gprint("var7", array("LAST", "AVERAGE", "MAX"), "%.3lf");

$opt[3] = "--vertical-label \"Threads\"  --title \"Nginx Statistics\" ";
$ds_name[3] = "Nginx Thread Statistics";

$def[3] = rrd::def("var1", $RRDFILE[1], $DS[1]);
$def[3] .= rrd::def("var2", $RRDFILE[2], $DS[2]);
$def[3] .= rrd::def("var3", $RRDFILE[3], $DS[3]);
$def[3] .= rrd::def("var4", $RRDFILE[4], $DS[4]);
$def[3] .= rrd::area("var3", $colors["wait"], "Waiting");
$def[3] .= rrd::gprint("var3", array("LAST", "AVERAGE", "MAX"), "%.0lf");
$def[3] .= rrd::area("var1", $colors["read"], "Reading", $stack=True);
$def[3] .= rrd::gprint("var1", array("LAST", "AVERAGE", "MAX"), "%.0lf");
$def[3] .= rrd::area("var2", $colors["write"], "Writing", $stack=True);
$def[3] .= rrd::gprint("var2", array("LAST", "AVERAGE", "MAX"), "%.0lf");
$def[3] .= rrd::line1("var4", "#000000", "Total Active");
$def[3] .= rrd::gprint("var4", array("LAST", "AVERAGE", "MAX"), "%.0lf");
 
?>
