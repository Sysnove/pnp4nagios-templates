<?php
#
# Copyright (c) 2006-2010 Guillaume Subiron (http://www.sysnove.fr)
# Plugin: check_ldap3
#

$ds_name[1] = "Fork rate";
$opt[1] = "--vertical-label \"$UNIT[1]\" --title \"$hostname / $ds_name[1]\" ";
$def[1] = rrd::def("rate", $RRDFILE[1], $DS[1], "AVERAGE" );
$def[1] .= rrd::line1("rate", "#FF0000", "Rate");
$def[1] .= rrd::gprint("rate", array("LAST", "AVERAGE", "MAX"), "%7.2lf $UNIT[1]");

if ($WARN[1] != "") {
    $def[1] .= rrd::hrule( $WARN[1], "#ffff00", "Warning on $WARN[1] $UNIT[1]\\n" );
}
if ($CRIT[1] != "") {
    $def[1] .= rrd::hrule( $CRIT[1], "#ff0000", "Critical on $CRIT[1] $UNIT[1]\\n" );
}

?>

