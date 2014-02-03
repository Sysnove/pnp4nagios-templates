<?php
#
# Template for check_swap
# Copyright (c) 2006-2010 Joerg Linge (http://www.pnp4nagios.org)
#
# RRDtool Options
$opt[1] = "-X 0 --vertical-label MB -l 0 -u $MAX[1] --title \"Swap usage $hostname / $servicedesc\" ";
#
#
# Graphen Definitions
$def[1] = "DEF:var1=$RRDFILE[1]:$DS[1]:AVERAGE "; 
$def[1] .= rrd::cdef("inv", $MAX[1].",var1,-");
$def[1] .= "AREA:inv#c6c6c6:\"$servicedesc\" "; 
$def[1] .= "LINE1:inv#003300: "; 
$def[1] .= "GPRINT:inv:LAST:\"%6.2lf MB currently used\" ";
$def[1] .= "GPRINT:inv:MAX:\"%6.2lf MB max used\" ";
$def[1] .= "GPRINT:inv:AVERAGE:\"%6.2lf MB average used\\n\" ";

if ($MAX[1] != "") {  
	$def[1] .= "HRULE:$MAX[1]#003300:\"Capacity $MAX[1] MB \\n\" ";
}

if ($WARN[1] != "") {
    $warn = $MAX[1] - $WARN[1];
    $def[1] .= rrd::hrule( $warn, "#ffff00", "Warning  on $warn \\n" );
}
if ($CRIT[1] != "") {
    $crit = $MAX[1] - $CRIT[1];
    $def[1] .= rrd::hrule( $crit, "#ff0000", "Critical  on $crit \\n" );
}

?>
