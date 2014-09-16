<?php
#
# Copyright (c) 2006-2010 Joerg Linge (http://www.pnp4nagios.org)
# Plugin: check_http
#

include("style.php");

# Response Time
#
$opt[1] = "--vertical-label \"$UNIT[1]\" --title \"Response Times $hostname / $servicedesc\" $options $colors ";
#
#
#
$def[1] =  "DEF:var1=$RRDFILE[1]:$DS[1]:AVERAGE " ;
if ($WARN[1] != "") {
	$def[1] .= "HRULE:$WARN[1]$warn_color ";
}
if ($CRIT[1] != "") {
	$def[1] .= "HRULE:$CRIT[1]$crit_color ";
}
#$def[1] .= "AREA:var1#EACC00:\"$NAME[1] \" " ;
#$def[1] .= rrd::gradient("var1", "66CCFF", "0000ff", "$NAME[1]"); 
$def[1] .= rrd::line2("var1", $main_color, "$NAME[1]");
$def[1] .= rrd::gprint("var1", array("LAST","MAX","AVERAGE"), "%6.2lf $UNIT[1]");

#
# Filesize
#
$opt[2] = "--vertical-label \"$UNIT[2]\" --title \"Size $hostname / $servicedesc\" $options $colors ";
#
#
#
$def[2] =  "DEF:var1=$RRDFILE[2]:$DS[2]:AVERAGE " ;
if ($WARN[2] != "") {
	$def[2] .= "HRULE:$WARN[2]$warn_color ";
}
if ($CRIT[2] != "") {
	$def[2] .= "HRULE:$CRIT[2]$crit_color ";
}
#$def[2] .= rrd::gradient("var1", "66CCFF", "0000ff", "$NAME[2]"); 
$def[2] .= rrd::area("var1", $gray);
$def[2] .= rrd::line2("var1", $main_color, "$NAME[2]");
$def[2] .= rrd::gprint("var1", array("LAST","MAX","AVERAGE"), "%6.2lf %s$UNIT[2]");

?>
