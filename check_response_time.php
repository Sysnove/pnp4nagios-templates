<?php
#
# Copyright (c) 2006-2010 Joerg Linge (http://www.pnp4nagios.org)
#

include("style.php");

$opt[1] = "--vertical-label \"Response Time\"  --title \"Response Time For $hostname / $servicedesc\" $options $colors ";


$def[1] =  "DEF:var1=$RRDFILE[1]:$DS[1]:AVERAGE " ;
$def[1] .= rrd::line2("var1", $main_color, "Response Times");
$def[1] .= "GPRINT:var1:LAST:\"%3.4lg %s$UNIT[1] LAST \" "; 
$def[1] .= "GPRINT:var1:MAX:\"%3.4lg %s$UNIT[1] MAX \" "; 
$def[1] .= "GPRINT:var1:AVERAGE:\"%3.4lg %s$UNIT[1] AVERAGE \" "; 
?>
