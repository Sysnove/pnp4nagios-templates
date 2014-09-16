
<?php
#
# Copyright (c) 2006-2010 Guillaume Subiron (http://www.sysnove.fr)
# Plugin: check_ldap3
#

include("style.php");

$ds_name[1] = "Swap paging rate";
$opt[1] = "--vertical-label \"$UNIT[1]\" --title \"$hostname / $ds_name[1]\" $options $colors ";
$def[1] = rrd::def("in", $RRDFILE[1], $DS[1], "AVERAGE" );
$def[1] .= rrd::cdef("ininv", "in,-1,*" );
$def[1] .= rrd::def("out", $RRDFILE[2], $DS[2], "AVERAGE" );
$def[1] .= rrd::line2("ininv", $main_color, "IN");
$def[1] .= rrd::gprint("in", array("LAST", "AVERAGE", "MAX"), "%7.2lf $UNIT[1]");
$def[1] .= rrd::line2("out", $secondary_color, "OUT");
$def[1] .= rrd::gprint("out", array("LAST", "AVERAGE", "MAX"), "%7.2lf $UNIT[2]");

if ($WARN[1] != "") {
    $def[1] .= rrd::hrule( $WARN[1], $warn_color, "Warning on $WARN[1] $UNIT[1] " );
    $def[1] .= rrd::hrule( $WARN[1]*-1, $warn_color);
}
if ($CRIT[1] != "") {
    $def[1] .= rrd::hrule( $CRIT[1], $crit_color, "Critical on $CRIT[1] $UNIT[1]\\n" );
    $def[1] .= rrd::hrule( $CRIT[1]*-1, $crit_color);
}
$def[1] .= rrd::hrule(0, "#606060");

?>

