<?php
#
# Copyright (c) 2012 Naoya Hashimoto(mrhashnao@gmail.com) (https://github.com/hashnao/pnp4nagios/tree/master/templates)
# Plugin: check_mem
#
$ds_name[1] = "$NAGIOS_AUTH_SERVICEDESC";
$opt[1] = "--vertical-label \"$UNIT[1]\" --title \"$hostname / $servicedesc\" ";

$def[1]  = rrd::def("var1", $RRDFILE[1], $DS[1], "AVERAGE");
$def[1] .= rrd::def("var2", $RRDFILE[2], $DS[2], "AVERAGE");
$def[1] .= rrd::def("var3", $RRDFILE[3], $DS[3], "AVERAGE");
$def[1] .= rrd::def("var4", $RRDFILE[4], $DS[4], "AVERAGE");

$def[1] .= rrd::area("var2", "#ff0000", "Used") ;
$def[1] .= rrd::gprint("var2", array("LAST", "AVERAGE", "MAX"), "%6.2lf");
$def[1] .= rrd::area("var3", "#5a3d99", "Free", $stack=True) ;
$def[1] .= rrd::gprint("var3", array("LAST", "AVERAGE", "MAX"), "%6.2lf");
$def[1] .= rrd::line1("var4", "#e5ca44", "Cache") ;
$def[1] .= rrd::gprint("var4", array("LAST", "AVERAGE", "MAX"), "%6.2lf");
$def[1] .= rrd::line1("var1", "#000000", "Total") ;
$def[1] .= rrd::gprint("var1", array("LAST", "AVERAGE", "MAX"), "%6.2lf");

if ($WARN[1] != "") {
    $def[1] .= rrd::hrule( $WARN[1], "#ffff00", "Warning on $WARN[1] \\n" );
}
if ($CRIT[1] != "") {
    $def[1] .= rrd::hrule( $CRIT[1], "#ff0000", "Critical on $CRIT[1] \\n" );
}

?>
