<?php
#
# Copyright (c) 2014 Guillaume Subiron (maethor)
# Plugin: check_uptime
#

include("style.php");

$ds_name[1] = "Ceph Space";
$total = $MAX[1];
$opt[1] = "--vertical-label \"Bytes\" -l 0 -u $total --title \"Space used\" $options $colors --base 1024 ";

$def[1] = rrd::def("var1", $RRDFILE[1], $DS[1], "AVERAGE");
$def[1] .= rrd::area("var1", $gray);
$def[1] .= rrd::line2("var1", $main_color, "Space used");
$def[1] .= rrd::gprint("var1", "LAST", "%7.0lf $UNIT[1]\\n");
$def[1] .= rrd::hrule($total, $black, "Total space\: $total $UNIT[1]");


$ds_name[2] = "Ceph Degrated Objects";
$total = $MAX[2];
$opt[2] = "--vertical-label \"Objects\" -l 0 -u $total --title \"Degrated objects\" $options $colors ";

$def[2] = rrd::def("var1", $RRDFILE[2], $DS[2], "AVERAGE");
$def[2] .= rrd::area("var1", $gray);
$def[2] .= rrd::line2("var1", $main_color, "Degrated");
$def[2] .= rrd::gprint("var1", array("LAST", "MAX", "AVERAGE"), "%7.0lf $UNIT[2]") ;
$def[2] .= rrd::hrule($total, $black, "Total objects\: $total $UNIT[2]");


$ds_name[3] = "Ceph Recovery (bytes)";
$opt[3] = "--vertical-label \"$UNIT[3]\" --title \"Recovery\" $options $colors ";

$def[3] = rrd::def("var1", $RRDFILE[3], $DS[3], "AVERAGE");
$def[3] .= rrd::line2("var1", $main_color, "recovery");
$def[3] .= rrd::gprint("var1", array("LAST", "MAX", "AVERAGE"), "%7.0lf $UNIT[3]") ;


$ds_name[4] = "Ceph Recovery (objects)";
$opt[4] = "--vertical-label \"$UNIT[4]\" --title \"Recovery\" $options $colors ";

$def[4] = rrd::def("var1", $RRDFILE[4], $DS[4], "AVERAGE");
$def[4] .= rrd::line2("var1", $main_color, "recovery");
$def[4] .= rrd::gprint("var1", array("LAST", "MAX", "AVERAGE"), "%7.0lf $UNIT[4]") ;


$ds_name[5] = "Ceph IOs";
$opt[5] = "--vertical-label \"Bytes/s\" --title \"IO/s\" $options $colors ";

$def[5] = rrd::def("write", $RRDFILE[5], $DS[5], "AVERAGE");
$def[5] .= rrd::def("read", $RRDFILE[6], $DS[6], "AVERAGE");
$def[5] .= rrd::cdef("readinv", "read,-1,*" );
$def[5] .= rrd::hrule(0, $black);
$def[5] .= rrd::line2("write", $main_color, "Write");
$def[5] .= rrd::gprint("write", array("LAST", "MAX", "AVERAGE"), "%7.0lf $UNIT[5]") ;
$def[5] .= rrd::line2("readinv", $secondary_color, "Read");
$def[5] .= rrd::gprint("read", array("LAST", "MAX", "AVERAGE"), "%7.0lf $UNIT[6]") ;

$ds_name[6] = "Ceph Transactions";
$opt[6] = "--vertical-label \"io/s\" --title \"Transactions\" $options $colors ";

$def[6] = rrd::def("var1", $RRDFILE[7], $DS[7], "AVERAGE");
$def[6] .= rrd::line2("var1", $main_color, $LABEL[7]);
$def[6] .= rrd::gprint("var1", array("LAST", "MAX", "AVERAGE"), "%7.0lf $UNIT[7]") ;

$ds_name[7] = "Ceph PG States";
$opt[7] = "--vertical-label \"PGs\" -l 0 -u $ACT[8] --title \"PG states\" $options $colors ";

$def[7] = rrd::def("active_clean", $RRDFILE[9], $DS[9], "AVERAGE");
$def[7] .= rrd::def("active_remapped", $RRDFILE[10], $DS[10], "AVERAGE");
$def[7] .= rrd::def("active_degrated", $RRDFILE[11], $DS[11], "AVERAGE");
$def[7] .= rrd::def("stale", $RRDFILE[12], $DS[12], "AVERAGE");
$def[7] .= rrd::def("inactive", $RRDFILE[13], $DS[13], "AVERAGE");
$def[7] .= rrd::def("unclean", $RRDFILE[14], $DS[14], "AVERAGE");
$def[7] .= rrd::def("down", $RRDFILE[15], $DS[15], "AVERAGE");

$def[7] .= "COMMENT:\"\\t\\t\\t\\t\\t\\tLAST\\t\\t\\tAVERAGE\\t\\tMAX\\n\" " ;

$def[7] .= rrd::line2( "active_clean", $main_color, $LABEL[9]);
$def[7] .= rrd::gprint("active_clean", "LAST",    "\\t\\t   %7.0lf") ;
$def[7] .= rrd::gprint("active_clean", "AVERAGE", "\\t%7.0lf") ;
$def[7] .= rrd::gprint("active_clean", "MAX",     "\\t%7.0lf \\n") ;
$def[7] .= rrd::line2( "active_remapped", "#0C64E8", $LABEL[10]);
$def[7] .= rrd::gprint("active_remapped", "LAST",    "\\t\\t%7.0lf") ;
$def[7] .= rrd::gprint("active_remapped", "AVERAGE", "\\t%7.0lf") ;
$def[7] .= rrd::gprint("active_remapped", "MAX",     "\\t%7.0lf \\n") ;
$def[7] .= rrd::line2( "active_degrated", "#E80C3E", $LABEL[11]);
$def[7] .= rrd::gprint("active_degrated", "LAST",    "\\t\\t%7.0lf") ;
$def[7] .= rrd::gprint("active_degrated", "AVERAGE", "\\t%7.0lf") ;
$def[7] .= rrd::gprint("active_degrated", "MAX",     "\\t%7.0lf \\n") ;
$def[7] .= rrd::line2( "stale", "#008000", $LABEL[12]);
$def[7] .= rrd::gprint("stale", "LAST",    "\\t\\t\\t    %7.0lf") ;
$def[7] .= rrd::gprint("stale", "AVERAGE", "\\t%7.0lf") ;
$def[7] .= rrd::gprint("stale", "MAX",     "\\t%7.0lf \\n") ;
$def[7] .= rrd::line2( "inactive", $secondary_color, $LABEL[13]);
$def[7] .= rrd::gprint("inactive", "LAST",    "\\t\\t\\t %7.0lf") ;
$def[7] .= rrd::gprint("inactive", "AVERAGE", "\\t%7.0lf") ;
$def[7] .= rrd::gprint("inactive", "MAX",     "\\t%7.0lf \\n") ;
$def[7] .= rrd::line2( "unclean", "#1CC8E8", $LABEL[14]);
$def[7] .= rrd::gprint("unclean", "LAST",    "\\t\\t\\t  %7.0lf") ;
$def[7] .= rrd::gprint("unclean", "AVERAGE", "\\t%7.0lf") ;
$def[7] .= rrd::gprint("unclean", "MAX",     "\\t%7.0lf \\n") ;
$def[7] .= rrd::line2( "down", "#E80C8C", $LABEL[15]);
$def[7] .= rrd::gprint("down", "LAST",    "\\t\\t\\t     %7.0lf") ;
$def[7] .= rrd::gprint("down", "AVERAGE", "\\t%7.0lf") ;
$def[7] .= rrd::gprint("down", "MAX",     "\\t%7.0lf \\n") ;
$def[7] .= rrd::hrule($ACT[8], $black, "Total pgs\: $ACT[8]");

?>
