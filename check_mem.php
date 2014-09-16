<?php
#
# Copyright (c) 2012 Naoya Hashimoto(mrhashnao@gmail.com) (https://github.com/hashnao/pnp4nagios/tree/master/templates)
# Plugin: check_mem
#

include("style.php");

$ds_name[1] = "$NAGIOS_AUTH_SERVICEDESC";
$max = $ACT[1] + 0.1 * $ACT[1];
$opt[1] = "--vertical-label \"$UNIT[1]\"  -l 0 -u $max --title \"$hostname / $servicedesc\" $colors $options --base 1024 ";

$def[1]  = rrd::def("var1", $RRDFILE[1], $DS[1], "AVERAGE");
$def[1] .= rrd::def("var2", $RRDFILE[2], $DS[2], "AVERAGE");
$def[1] .= rrd::def("var3", $RRDFILE[3], $DS[3], "AVERAGE");
$def[1] .= rrd::def("var4", $RRDFILE[4], $DS[4], "AVERAGE");

//$def[1] .= rrd::area("var3", "#5a3d99", "Free", $stack=True) ;
//$def[1] .= rrd::gprint("var3", array("LAST", "AVERAGE", "MAX"), "%6.2lf");
$def[1] .= rrd::area("var4", $light_gray) ;
$def[1] .= rrd::line2("var4", $secondary_color, "Cache") ;
$def[1] .= rrd::gprint("var4", array("LAST", "AVERAGE", "MAX"), "%6.2lf");
$def[1] .= rrd::area("var2", $gray) ;
$def[1] .= rrd::line2("var2", $main_color, "Memory used") ;
$def[1] .= rrd::gprint("var2", array("LAST", "AVERAGE", "MAX"), "%6.2lf");
$def[1] .= rrd::hrule( $ACT[1], $black, "Total") ;
$def[1] .= rrd::gprint("var1", array("LAST", "AVERAGE", "MAX"), "%6.2lf");

if ($WARN[1] != "") {
    $def[1] .= rrd::hrule( $WARN[1], $warn_color, "Warning on $WARN[1] " );
}
if ($CRIT[1] != "") {
    $def[1] .= rrd::hrule( $CRIT[1], $crit_color, "Critical on $CRIT[1] \\n" );
}

?>
