<?php
#
# Copyright (c) 2006-2010 Guillaume Subiron (http://www.sysnove.fr)
# Plugin: check_ldap3
#

include("style.php");

for ($i=1; $i<=count($DS); $i+=2) {
    $j = ($i+1)/2;
    $ds_name[$j] = explode("_", $NAME[$i])[0];
    $unit = explode("_", $NAME[$i])[2];
    $opt[$j] = "--vertical-label \"$unit\" --title \"$hostname / Interface $ds_name[$j]\" $colors $options ";
    $def[$j] = rrd::def("in", $RRDFILE[$i], $DS[$i], "AVERAGE" );
    $def[$j] .= rrd::cdef("ininv", "in,-1,*" );
    $def[$j] .= rrd::def("out", $RRDFILE[$i+1], $DS[$i+1], "AVERAGE" );
    $def[$j] .= rrd::line2("ininv", $secondary_color, "IN");
    $def[$j] .= rrd::gprint("in", array("LAST", "AVERAGE", "MAX"), "%7.2lf $unit");
    $def[$j] .= rrd::line2("out", $main_color, "OUT");
    $def[$j] .= rrd::gprint("out", array("LAST", "AVERAGE", "MAX"), "%7.2lf $unit");

    if ($WARN[$i] != "") {
        $def[$j] .= rrd::hrule( $WARN[$i], $warn_color, "Warning on $WARN[$i] $unit " );
        $def[$j] .= rrd::hrule( $WARN[$i]*-1, $warn_color);
    }
    if ($CRIT[$i] != "") {
        $def[$j] .= rrd::hrule( $CRIT[$i], $crit_color, "Critical on $CRIT[$i] $unit\\n" );
        $def[$j] .= rrd::hrule( $CRIT[$i]*-1, $crit_color);
    }
    $def[$j] .= rrd::hrule(0, $black);
}

?>

