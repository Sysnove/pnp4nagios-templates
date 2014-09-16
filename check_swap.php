<?php
#
# Copyright (c) 2014 Guillaume Subiron (maethor)
# Plugin: check_swap
#

include("style.php");

# RRDtool Options
$max = $MAX[1] + 0.1 * $MAX[1];
$opt[1] = "-X 0 --vertical-label MB -l 0 -u $max --title \"Swap usage $hostname / $servicedesc\" $options $colors --base 1024 ";
#
#
# Graphen Definitions
$def[1] = "DEF:var1=$RRDFILE[1]:$DS[1]:AVERAGE "; 
$def[1] .= rrd::cdef("inv", $MAX[1].",var1,-");
$def[1] .= rrd::area("inv", $gray);
//$def[1] .= "AREA:inv#c6c6c6:\"$servicedesc\" "; 
//$def[1] .= "LINE1:inv#003300: "; 
$def[1] .= rrd::line2("inv", $main_color,  "Swap used");
$def[1] .= rrd::gprint("inv", "LAST", "%6.2lf MB Last");
$def[1] .= rrd::gprint("inv", "MAX", "%6.2lf MB Max");
$def[1] .= rrd::gprint("inv", "AVERAGE", "%6.2lf MB Average\\n");
//$def[1] .= "GPRINT:inv:LAST:\"%6.2lf MB cur\" ";
//$def[1] .= "GPRINT:inv:MAX:\"%6.2lf MB max used\" ";
//$def[1] .= "GPRINT:inv:AVERAGE:\"%6.2lf MB avg\\n\" ";

if ($MAX[1] != "") {  
	//$def[1] .= "HRULE:$MAX[1]#003300:\"Capacity $MAX[1] MB\" ";
    $def[1] .= rrd::hrule( $MAX[1], $black, "Capacity $MAX[1] MB" );
}

if ($WARN[1] != "") {
    $warn = $MAX[1] - $WARN[1];
    $def[1] .= rrd::hrule( $warn, $warn_color, "Warning on $warn MB" );
}
if ($CRIT[1] != "") {
    $crit = $MAX[1] - $CRIT[1];
    $def[1] .= rrd::hrule( $crit, $crit_color, "Critical on $crit MB" );
}

?>
