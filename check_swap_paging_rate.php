
<?php
#
# Copyright (c) 2006-2010 Guillaume Subiron (http://www.sysnove.fr)
# Plugin: check_ldap3
#

$ds_name[0] = "Swap paging rate";
$opt[0] = "--vertical-label \"$UNIT[0]\" --title \"$hostname / $ds_name[0]\" ";
$def[0] = rrd::def("in", $RRDFILE[0], $DS[0], "AVERAGE" );
$def[0] .= rrd::cdef("ininv", "in,-1,*" );
$def[0] .= rrd::def("out", $RRDFILE[1], $DS[1], "AVERAGE" );
$def[0] .= rrd::line1("ininv", "#FF0000", "IN");
$def[0] .= rrd::gprint("in", array("LAST", "AVERAGE", "MAX"), "%7.2lf $UNIT[0]");
$def[0] .= rrd::line1("out", "#00FF00", "OUT");
$def[0] .= rrd::gprint("out", array("LAST", "AVERAGE", "MAX"), "%7.2lf $UNIT[1]");

if ($WARN[0] != "") {
    $def[0] .= rrd::hrule( $WARN[0], "#ffff00", "Warning on $WARN[0] $UNIT[0]\\n" );
    $def[0] .= rrd::hrule( $WARN[0]*-1, "#ffff00");
}
if ($CRIT[0] != "") {
    $def[0] .= rrd::hrule( $CRIT[0], "#ff0000", "Critical on $CRIT[0] $UNIT[0]\\n" );
    $def[0] .= rrd::hrule( $CRIT[0]*-1, "#ffff00");
}
$def[$j] .= rrd::hrule(0, "#606060");

?>

