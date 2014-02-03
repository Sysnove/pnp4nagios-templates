<?php
#
# Copyright (c) 2006-2010 Guillaume Subiron (http://www.sysnove.fr)
# Plugin: check_ldap3
#

for ($i=1; $i<=count($DS); $i+=2) {
    $j = ($i+1)/2;
    $ds_name[$j] = explode("_", $NAME[$i])[0];
    $unit = explode("_", $NAME[$i])[2];
    $opt[$j] = "--vertical-label \"$unit\" --title \"$hostname / Interface $ds_name[$j]\" ";
    $def[$j] = rrd::def("in", $RRDFILE[$i], $DS[$i], "AVERAGE" );
    $def[$j] .= rrd::cdef("ininv", "in,-1,*" );
    $def[$j] .= rrd::def("out", $RRDFILE[$i+1], $DS[$i+1], "AVERAGE" );
    $def[$j] .= rrd::line1("ininv", "#FF0000", "IN");
    $def[$j] .= rrd::gprint("in", array("LAST", "AVERAGE", "MAX"), "%7.2lf $unit");
    $def[$j] .= rrd::line1("out", "#00FF00", "OUT");
    $def[$j] .= rrd::gprint("out", array("LAST", "AVERAGE", "MAX"), "%7.2lf $unit");

    if ($WARN[$i] != "") {
        $def[$j] .= rrd::hrule( $WARN[$i], "#ffff00", "Warning on $WARN[$i] $unit\\n" );
        $def[$j] .= rrd::hrule( $WARN[$i]*-1, "#ffff00");
    }
    if ($CRIT[$i] != "") {
        $def[$j] .= rrd::hrule( $CRIT[$i], "#ff0000", "Critical on $CRIT[$i] $unit\\n" );
        $def[$j] .= rrd::hrule( $CRIT[$i]*-1, "#ffff00");
    }
    $def[$j] .= rrd::hrule(0, "#606060");
}

?>

