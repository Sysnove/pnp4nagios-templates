<?php

$j = 1;

for ($i=1; $i<=count($DS); $i+=3) {

    $ds_name[$j] = explode("_", $LABEL[$i])[1];

    if ($ds_name[$j] == "/dev/sr0") {
        continue;
    }

    $u = $UNIT[$i];
    $opt[$j] = "--vertical-label \"$u\" --title \"$hostname / Transactions $ds_name[$j]\" ";
    $def[$j] = rrd::def("tps", $RRDFILE[$i], $DS[$i], "AVERAGE");
    $def[$j] .= rrd::line1("tps", "#0000FF", "tps");
    $def[$j] .= rrd::gprint("tps", array("LAST", "AVERAGE", "MAX"), "%7.2lf $u");

    $j++;

    $u = $UNIT[$i+1];
    $ds_name[$j] = explode("_", $LABEL[$i+1])[1];
    $opt[$j] = "--vertical-label \"$u\" --title \"$hostname / I/O $ds_name[$j]\" ";
    $def[$j] = rrd::def("read", $RRDFILE[$i+1], $DS[$i+1], "AVERAGE");
    $def[$j] .= rrd::line1("read", "#00FF00", "read");
    $def[$j] .= rrd::gprint("read", array("LAST", "AVERAGE", "MAX"), "%7.2lf $u");
    $def[$j] .= rrd::def("write", $RRDFILE[$i+2], $DS[$i+2], "AVERAGE");
    $def[$j] .= rrd::cdef("writeinv", "write,-1,*");
    $def[$j] .= rrd::line1("writeinv", "#FF0000", "write");
    $def[$j] .= rrd::gprint("write", array("LAST", "AVERAGE", "MAX"), "%7.2lf $u");
    $def[$j] .= rrd::hrule(0, "#606060");

    $j++;
}

?>
