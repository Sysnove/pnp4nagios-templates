<?php
#
# Copyright (c) 2014 Guillaume Subiron (maethor)
# Plugin: check_uptime
#

include("style.php");

$ds_name[1] = "$NAGIOS_AUTH_SERVICEDESC";
$opt[1] = "--vertical-label \"Days\" --title \"Uptime for $hostname\" $options $colors ";

$def[1] = rrd::def("var1", $RRDFILE[2], $DS[2], "AVERAGE");
$def[1] .= rrd::cdef("var1_d", "var1,1440,/");

//$def[1] .= rrd::area("var1_d", "#A2A2A2FF");
$def[1] .= rrd::line2("var1_d", $main_color, "Uptime");
$def[1] .= rrd::gprint("var1_d", "LAST", "%7.0lf days");

?>
