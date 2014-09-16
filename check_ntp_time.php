<?php
#
# Contributed by Mathias Kettner
# Plugin: check_ntp
#

include("style.php");

$range = $CRIT[1];

$opt[1] = "--vertical-label 'offset (s)' -l -$range  -u $range --title '$hostname: NTP time offset' $colors $options ";

$warn_ms = $WARN[1] * 1000.0;
$crit_ms = $CRIT[1] * 1000.0;

$def[1] = "DEF:offset=$RRDFILE[1]:$DS[1]:MAX "; 
$def[1] .= "CDEF:ms=offset,1000,* ";
$def[1] .= "CDEF:msabs=ms,ABS ";
$def[1] .= "AREA:offset#00ffc6: "; 
$def[1] .= "LINE2:offset$main_color:\"Time offset \" "; 
$def[1] .= "GPRINT:ms:LAST:\"current\: %.1lf ms\" ";
$def[1] .= "GPRINT:msabs:MAX:\"max\: %.1lf ms \" ";
$def[1] .= "GPRINT:msabs:AVERAGE:\"avg\: %.1lf ms \\n\" ";

$def[1] .= "HRULE:$WARN[1]$warn_color:\"\" ";
$def[1] .= "HRULE:-$WARN[1]$warn_color:\"Warning\\: +/- $warn_ms ms \" ";
$def[1] .= "HRULE:$CRIT[1]$crit_color:\"\" ";       
$def[1] .= "HRULE:-$CRIT[1]$crit_color:\"Critical\\: +/- $crit_ms ms \\n\" ";       
?>
