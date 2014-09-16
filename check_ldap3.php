<?php
#
# Copyright (c) 2006-2010 Guillaume Subiron (http://www.sysnove.fr)
# Plugin: check_ldap3
#

include("style.php");

$opt[1] = "--vertical-label \"$UNIT[1]\" --title \"Response Times $hostname / $servicedesc\" $colors $options ";

$def[1] =  "DEF:var1=$RRDFILE[1]:$DS[1]:AVERAGE " ;
if ($WARN[1] != "") {
	$def[1] .= "HRULE:$WARN[1]$warn_color ";
}
if ($CRIT[1] != "") {
	$def[1] .= "HRULE:$CRIT[1]$crit_color ";
}

$def[1] .= rrd::line2("var1", $main_color);
$def[1] .= rrd::gprint("var1", array("LAST","MAX","AVERAGE"), "%6.2lf $UNIT[1]");

?>
