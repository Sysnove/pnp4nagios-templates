<?php
#
# Copyright (c) 2009 Gerhard Lausser (gerhard.lausser@consol.de)
# Plugin: check_mysql_health (http://www.consol.com/opensource/nagios/check-mysql-health)
# Release 1.0 2009-03-02
#
# This is a template for the visualisation addon PNP (http://www.pnp4nagios.org)
#
# Revised Naoya Hashimoto(mrhashnao@gmail.com) (https://github.com/hashnao/pnp4nagios/tree/master/templates)
#

include("style.php");

$def[1] = "";
$opt[1] = "";

$defcnt = 1;

#$green = "33FF00E0";
#$yellow = "FFFF00E0";
#$red = "F83838E0";
#$now = "FF00FF";

foreach ($DS as $i) {
    $warning = ($WARN[$i] != "") ? $WARN[$i] : "";
    $warnmin = ($WARN_MIN[$i] != "") ? $WARN_MIN[$i] : "";
    $warnmax = ($WARN_MAX[$i] != "") ? $WARN_MAX[$i] : "";
    $critical = ($CRIT[$i] != "") ? $CRIT[$i] : "";
    $critmin = ($CRIT_MIN[$i] != "") ? $CRIT_MIN[$i] : "";
    $critmax = ($CRIT_MAX[$i] != "") ? $CRIT_MAX[$i] : "";
    $minimum = ($MIN[$i] != "") ? $MIN[$i] : "";
    $maximum = ($MAX[$i] != "") ? $MAX[$i] : "";

    if(preg_match('/^connection_time$/', $NAME[$i])) {
        $ds_name[$defcnt] = "$NAME[$i]";
        $opt[$defcnt] = "--vertical-label \"$UNIT[$i]\" --title \"$hostname / $servicedesc\" $options $colors ";
        $def[$defcnt] = "";
        $def[$defcnt] .= "DEF:connectiontime=$RRDFILE[$i]:$DS[$i]:AVERAGE:reduce=LAST " ;
        $def[$defcnt] .= "LINE2:connectiontime".$main_color.":\" \" ";
        $def[$defcnt] .= "VDEF:vconnetiontime=connectiontime,LAST " ;
        $def[$defcnt] .= "GPRINT:vconnetiontime:\"$NAME[$i] %3.2lf\\n\" ";
        $defcnt++;
    }
    if(preg_match('/^uptime$/', $NAME[$i])) {
        $ds_name[$defcnt] = "$NAME[$i]";
        $opt[$defcnt] = "--vertical-label \"$UNIT[$i]\" --title \"$hostname / $servicedesc\" $options $colors ";
        $def[$defcnt] = "";
        $def[$defcnt] .= "DEF:uptime=$RRDFILE[$i]:$DS[$i]:AVERAGE:reduce=LAST " ;
        $def[$defcnt] .= "LINE2:uptime".$main_color.": ";
        $def[$defcnt] .= "CDEF:uptimed=uptime,86400,/ " ;
        $def[$defcnt] .= "CDEF:uptimew=uptimed,7,/ " ;
        $def[$defcnt] .= "VDEF:vuptime=uptime,LAST " ;
        $def[$defcnt] .= "VDEF:vuptimed=uptimed,LAST " ;
        $def[$defcnt] .= "VDEF:vuptimew=uptimew,LAST " ;
        $def[$defcnt] .= "GPRINT:vuptime:\"%.0lf Seconds \" " ;
        $def[$defcnt] .= "GPRINT:vuptimed:\"%.0lf Days \" " ;
        $def[$defcnt] .= "GPRINT:vuptimew:\"%.0lf Weeks \" " ;
        $defcnt++;
    }
    if(preg_match('/^bufferpool_hitrate_now$/', $NAME[$i])) {
        $ds_name[$defcnt] = "Innodb buffer pool hitrate";
        $opt[$defcnt] = "--vertical-label \"UNIT[$i]\" --title \"Innodb buffer pool hitrate on $hostname\" --upper-limit 100 --lower-limit 0 $options $colors ";
        $def[$defcnt] = "";
        foreach ($DS as $ii) {
          if(preg_match('/^bufferpool_hitrate$/', $NAME[$ii])) {
            $def[$defcnt] .= "DEF:hitrate=$RRDFILE[$ii]:$DS[$ii]:AVERAGE:reduce=LAST " ;
            $def[$defcnt] .= "CDEF:ar=hitrate,$CRIT_MIN[$ii],LE,hitrate,0,GT,INF,UNKN,IF,UNKN,IF,ISINF,hitrate,0,IF ";
            $def[$defcnt] .= "CDEF:ay=hitrate,$WARN_MIN[$ii],LE,hitrate,$CRIT_MIN[$ii],GT,INF,UNKN,IF,UNKN,IF,ISINF,hitrate,0,IF ";
            $def[$defcnt] .= "CDEF:ag=hitrate,100,LE,hitrate,$WARN_MIN[$ii],GT,INF,UNKN,IF,UNKN,IF,ISINF,hitrate,0,IF ";
            #$def[$defcnt] .= "AREA:ag#$green: " ;
            #$def[$defcnt] .= "AREA:ay#$yellow: " ;
            #$def[$defcnt] .= "AREA:ar#$red: " ;
            $def[$defcnt] .= "LINE2:hitrate$main_color:\" \" ";
            $def[$defcnt] .= "VDEF:vhitrate=hitrate,LAST " ;
            $def[$defcnt] .= "GPRINT:vhitrate:\"Hitratio (since epoch) is %3.2lf percent \\n\" ";
          }
          if(preg_match('/^bufferpool_hitrate_now$/', $NAME[$ii])) {
            $def[$defcnt] .= "DEF:hitratenow=$RRDFILE[$ii]:$DS[$ii]:AVERAGE:reduce=LAST " ;
            $def[$defcnt] .= "LINE2:hitratenow$secondary_color:\" \" ";
            $def[$defcnt] .= "VDEF:vhitratenow=hitratenow,LAST " ;
            $def[$defcnt] .= "GPRINT:vhitratenow:\"Hitratio (current) is %3.2lf percent \\n\" ";
          }
        }
        $defcnt++;
    }
    if(preg_match('/^bufferpool_free_waits_rate$/', $NAME[$i])) {
        $ds_name[$defcnt] = "Innodb buffer pool waits rate";
        $opt[$defcnt] = "--vertical-label \"Waits/sec\" --title \"Innodb buffer pool waits on $hostname\" $options $colors ";
        $def[$defcnt] = "";
        $def[$defcnt] .= "DEF:logwait=$RRDFILE[$i]:$DS[$i]:AVERAGE:reduce=LAST " ;
        $def[$defcnt] .= "LINE2:logwait".$main_color.":\" \" ";
        $def[$defcnt] .= "VDEF:vlogwait=logwait,LAST " ;
        $def[$defcnt] .= "GPRINT:vlogwait:\"Rate is %3.2lf Waits / Second \\n\" " ;
        $defcnt++;
    }
    if(preg_match('/^innodb_log_waits_rate$/', $NAME[$i])) {
        $ds_name[$defcnt] = "Innodb log buffer waits rate";
        $opt[$defcnt] = "--vertical-label \"Waits/sec\" --title \"Innodb waits for log buffer $hostname\" $options $colors ";
        $def[$defcnt] = "";
        $def[$defcnt] .= "DEF:logwait=$RRDFILE[$i]:$DS[$i]:AVERAGE:reduce=LAST " ;
        $def[$defcnt] .= "LINE2:logwait".$main_color.":\" \" ";
        $def[$defcnt] .= "VDEF:vlogwait=logwait,LAST " ;
        $def[$defcnt] .= "GPRINT:vlogwait:\"Rate is %3.2lf Waits / Second \\n\" " ;
        $defcnt++;
    }
    if(preg_match('/^long_running_procs$/', $NAME[$i])) {
        $ds_name[$defcnt] = "$NAME[$i]";
        $opt[$defcnt] = "--vertical-label \"$UNIT[$i]\" --title \"$hostname / $servicedesc\" $options $colors ";
        $def[$defcnt] = ""; 
        $def[$defcnt] .= "DEF:longrun=$RRDFILE[$i]:$DS[$i]:AVERAGE:reduce=LAST " ;
        $def[$defcnt] .= "LINE2:longrun".$main_color.":\" \" ";
        $def[$defcnt] .= "VDEF:vlongrun=longrun,LAST " ;
        $def[$defcnt] .= "GPRINT:vlongrun:\"$NAME[$i] %3.2lf\\n\" " ;
        $defcnt++;
        }
    if(preg_match('/^keycache_hitrate_now$/', $NAME[$i])) {
        $ds_name[$defcnt] = "MyISAM key cache hitrate";
        $opt[$defcnt] = "--vertical-label \"$UNIT[$i]\" --title \"MyISAM key cache hitrate on $hostname\" --upper-limit 100 --lower-limit 0 $options $colors ";
        $def[$defcnt] = "";
        foreach ($DS as $ii) {
          if(preg_match('/^keycache_hitrate$/', $NAME[$ii])) {
            $def[$defcnt] .= "DEF:hitrate=$RRDFILE[$ii]:$DS[$ii]:AVERAGE:reduce=LAST " ;
            $def[$defcnt] .= "CDEF:ar=hitrate,$CRIT_MIN[$ii],LE,hitrate,0,GT,INF,UNKN,IF,UNKN,IF,ISINF,hitrate,0,IF ";
            $def[$defcnt] .= "CDEF:ay=hitrate,$WARN_MIN[$ii],LE,hitrate,$CRIT_MIN[$ii],GT,INF,UNKN,IF,UNKN,IF,ISINF,hitrate,0,IF ";
            $def[$defcnt] .= "CDEF:ag=hitrate,100,LE,hitrate,$WARN_MIN[$ii],GT,INF,UNKN,IF,UNKN,IF,ISINF,hitrate,0,IF ";
            #$def[$defcnt] .= "AREA:ag#$green: " ;
            #$def[$defcnt] .= "AREA:ay#$yellow: " ;
            #$def[$defcnt] .= "AREA:ar#$red: " ;
            $def[$defcnt] .= "LINE2:hitrate$main_color:\" \" ";
            $def[$defcnt] .= "VDEF:vhitrate=hitrate,LAST " ;
            $def[$defcnt] .= "GPRINT:vhitrate:\"Hitratio (since epoch) is %3.2lf percent \\n\" ";
          }
          if(preg_match('/^keycache_hitrate_now$/', $NAME[$ii])) {
            $def[$defcnt] .= "DEF:hitratenow=$RRDFILE[$ii]:$DS[$ii]:AVERAGE:reduce=LAST " ;
            $def[$defcnt] .= "LINE2:hitratenow$secondary_color:\" \" ";
            $def[$defcnt] .= "VDEF:vhitratenow=hitratenow,LAST " ;
            $def[$defcnt] .= "GPRINT:vhitratenow:\"Hitratio (current) is %3.2lf percent \\n\" ";
          }
        }
        $defcnt++;
    }
    if(preg_match('/^qcache_lowmem_prunes_rate$/', $NAME[$i])) {
        $ds_name[$defcnt] = "$NAME[$i]";
        $opt[$defcnt] = "--vertical-label \"$UNIT[$i]\" --title \"$hostname / $servicedesc\" --upper-limit 100 --lower-limit 0 $options $colors ";
        $def[$defcnt] = ""; 
        $def[$defcnt] .= "DEF:prunes=$RRDFILE[$i]:$DS[$i]:AVERAGE:reduce=LAST " ;
        $def[$defcnt] .= "LINE2:prunes".$main_color.":\" \" ";
        $def[$defcnt] .= "VDEF:vprunes=prunes,LAST " ;
        $def[$defcnt] .= "GPRINT:vprunes:\"$NAME[$i] %3.2lf\\n\" " ;
        $defcnt++;
        }
    if(preg_match('/^slow_queries_rate$/', $NAME[$i])) {
        $ds_name[$defcnt] = "$NAME[$i]";
        $opt[$defcnt] = "--vertical-label \"$UNIT[$i]\" --title \"$hostname / $servicedesc\" --lower-limit 0 $options $colors ";
        $def[$defcnt] = ""; 
        $def[$defcnt] .= "DEF:prunes=$RRDFILE[$i]:$DS[$i]:AVERAGE:reduce=LAST " ;
        $def[$defcnt] .= "LINE2:prunes".$main_color.":\" \" ";
        $def[$defcnt] .= "VDEF:vprunes=prunes,LAST " ;
        $def[$defcnt] .= "GPRINT:vprunes:\"$NAME[$i] %3.2lf\\n\" " ;
        $defcnt++;
        }
    if(preg_match('/^tablecache_fillrate$/', $NAME[$i])) {
        $ds_name[$defcnt] = "Table cache hitrate";
        $opt[$defcnt] = "--vertical-label \"$UNIT[$i]\" --title \"Table cache hitrate on $hostname\" --upper-limit 100 --lower-limit 0 $options $colors ";
        $def[$defcnt] = "";
        foreach ($DS as $ii) {
          if(preg_match('/^tablecache_hitrate$/', $NAME[$ii])) {
            $def[$defcnt] .= "DEF:hitrate=$RRDFILE[$ii]:$DS[$ii]:AVERAGE:reduce=LAST " ;
            $def[$defcnt] .= "CDEF:ar=hitrate,$CRIT_MIN[$ii],LE,hitrate,0,GT,INF,UNKN,IF,UNKN,IF,ISINF,hitrate,0,IF ";
            $def[$defcnt] .= "CDEF:ay=hitrate,$WARN_MIN[$ii],LE,hitrate,$CRIT_MIN[$ii],GT,INF,UNKN,IF,UNKN,IF,ISINF,hitrate,0,IF ";
            $def[$defcnt] .= "CDEF:ag=hitrate,100,LE,hitrate,$WARN_MIN[$ii],GT,INF,UNKN,IF,UNKN,IF,ISINF,hitrate,0,IF ";
            #$def[$defcnt] .= "AREA:ag#$green: " ;
            #$def[$defcnt] .= "AREA:ay#$yellow: " ;
            #$def[$defcnt] .= "AREA:ar#$red: " ;
            $def[$defcnt] .= "LINE2:hitrate$main_color:\" \" ";
            $def[$defcnt] .= "VDEF:vhitrate=hitrate,LAST " ;
            $def[$defcnt] .= "GPRINT:vhitrate:\"Hitratio is %3.2lf percent \\n\" ";
          }
          if(preg_match('/^tablecache_fillrate$/', $NAME[$ii])) {
            $def[$defcnt] .= "DEF:hitratenow=$RRDFILE[$ii]:$DS[$ii]:AVERAGE:reduce=LAST " ;
            $def[$defcnt] .= "LINE2:hitratenow$secondary_color:\" \" ";
            $def[$defcnt] .= "VDEF:vhitratenow=hitratenow,LAST " ;
            $def[$defcnt] .= "GPRINT:vhitratenow:\"%3.2lf%% of the cache is filled \\n\" ";
          }
        }
        $defcnt++;
    }
    if(preg_match('/^pct_tmp_table_on_disk_now$/', $NAME[$i])) {
        $ds_name[$defcnt] = "Temporary tables created on disk ";
        $opt[$defcnt] = "--vertical-label \"$UNIT[$i]\" --title \"Temporary tables created on disk on $hostname\" --upper-limit 10 --lower-limit 0 $options $colors ";
        $def[$defcnt] = "";
        foreach ($DS as $ii) {
          if(preg_match('/^pct_tmp_table_on_disk$/', $NAME[$ii])) {

            $def[$defcnt] .= "DEF:tmptbldsk=$RRDFILE[$ii]:$DS[$ii]:AVERAGE:reduce=LAST " ;
            $def[$defcnt] .= "CDEF:ag=tmptbldsk,$WARN[$ii],LE,tmptbldsk,0,GT,INF,UNKN,IF,UNKN,IF,ISINF,tmptbldsk,0,IF ";
            $def[$defcnt] .= "CDEF:ay=tmptbldsk,$CRIT[$ii],LE,tmptbldsk,$WARN[$ii],GT,INF,UNKN,IF,UNKN,IF,ISINF,tmptbldsk,0,IF ";
            $def[$defcnt] .= "CDEF:ar=tmptbldsk,100,LE,tmptbldsk,$CRIT[$ii],GT,INF,UNKN,IF,UNKN,IF,ISINF,tmptbldsk,0,IF ";
            #$def[$defcnt] .= "AREA:ag#$green: " ;
            #$def[$defcnt] .= "AREA:ay#$yellow: " ;
            #$def[$defcnt] .= "AREA:ar#$red: " ;
            $def[$defcnt] .= "LINE2:tmptbldsk$main_color:\" \" ";
            $def[$defcnt] .= "VDEF:vtmptbldsk=tmptbldsk,LAST " ;
            $def[$defcnt] .= "GPRINT:vtmptbldsk:\"%3.2lf percent of temp tables were created on disk (since epoch)\\n\" " ;
          }
          if(preg_match('/^pct_tmp_table_on_disk_now$/', $NAME[$ii])) {
            $def[$defcnt] .= "DEF:tmptbldsknow=$RRDFILE[$ii]:$DS[$ii]:AVERAGE:reduce=LAST " ;
            $def[$defcnt] .= "LINE2:tmptbldsknow$secondary_color:\" \" ";
            $def[$defcnt] .= "VDEF:vtmptbldsknow=tmptbldsknow,LAST " ;
            $def[$defcnt] .= "GPRINT:vtmptbldsknow:\"%3.2lf percent of temp tables were created on disk (recently)\\n\" " ;
          }   
        }
        $defcnt++;
    }
    if(preg_match('/^threads_connected$/', $NAME[$i])) {
        $ds_name[$defcnt] = "$NAME[$i]";
        $opt[$defcnt] = "--vertical-label \"$UNIT[$i]\" --title \"$hostname / $servicedesc\" $options $colors ";
        $def[$defcnt] = "";
        $def[$defcnt] .= "DEF:threads=$RRDFILE[$i]:$DS[$i]:AVERAGE:reduce=LAST " ;
        $def[$defcnt] .= "LINE2:threads".$main_color.":\" \" ";
        $def[$defcnt] .= "VDEF:vthreads=threads,LAST " ;
        $def[$defcnt] .= "GPRINT:vthreads:\"$NAME[$i] %3.2lf\\n\" " ;
        $defcnt++;
        }
    if(preg_match('/^threads_running$/', $NAME[$i])) {
        $ds_name[$defcnt] = "$NAME[$i]";
        $opt[$defcnt] = "--vertical-label \"$UNIT[$i]\" --title \"$hostname / $servicedesc\" $options $colors ";
        $def[$defcnt] = "";
        $def[$defcnt] .= "DEF:threads=$RRDFILE[$i]:$DS[$i]:AVERAGE:reduce=LAST " ;
        $def[$defcnt] .= "LINE2:threads".$main_color.":\" \" ";
        $def[$defcnt] .= "VDEF:vthreads=threads,LAST " ;
        $def[$defcnt] .= "GPRINT:vthreads:\"$NAME[$i] %3.2lf\\n\" " ;
        $defcnt++;
        }
    if(preg_match('/^threads_cached$/', $NAME[$i])) {
        $ds_name[$defcnt] = "$NAME[$i]";
        $opt[$defcnt] = "--vertical-label \"$UNIT[$i]\" --title \"$hostname / $servicedesc\" $options $colors ";
        $def[$defcnt] = "";
        $def[$defcnt] .= "DEF:threads=$RRDFILE[$i]:$DS[$i]:AVERAGE:reduce=LAST " ;
        $def[$defcnt] .= "LINE2:threads".$main_color.":\" \" ";
        $def[$defcnt] .= "VDEF:vthreads=threads,LAST " ;
        $def[$defcnt] .= "GPRINT:vthreads:\"$NAME[$i] %3.2lf\\n\" " ;
        $defcnt++;
        }
    if(preg_match('/^threads_created_per_sec$/', $NAME[$i])) {
        $ds_name[$defcnt] = "$NAME[$i]";
        $opt[$defcnt] = "--vertical-label \"$UNIT[$i]\" --title \"$hostname / $servicedesc\" $options $colors ";
        $def[$defcnt] = ""; 
        $def[$defcnt] .= "DEF:sps=$RRDFILE[$i]:$DS[$i]:AVERAGE:reduce=LAST " ;
        $def[$defcnt] .= "LINE2:sps".$main_color.":\" \" ";
        $def[$defcnt] .= "VDEF:vsps=sps,LAST " ;
        $def[$defcnt] .= "GPRINT:vsps:\"$NAME[$i] %3.2lf\\n\" " ;
        $defcnt++;
        }
    if(preg_match('/^connects_aborted_per_sec$/', $NAME[$i])) {
        $ds_name[$defcnt] = "$NAME[$i]";
        $opt[$defcnt] = "--vertical-label \"$UNIT[$i]\" --title \"$hostname / $servicedesc\" $options $colors ";
        $def[$defcnt] = ""; 
        $def[$defcnt] .= "DEF:sps=$RRDFILE[$i]:$DS[$i]:AVERAGE:reduce=LAST " ;
        $def[$defcnt] .= "LINE2:sps".$main_color.":\" \" ";
        $def[$defcnt] .= "VDEF:vsps=sps,LAST " ;
        $def[$defcnt] .= "GPRINT:vsps:\"$NAME[$i] %3.2lf\\n\" " ;
        $defcnt++;
        }
    if(preg_match('/^clients_aborted_per_sec$/', $NAME[$i])) {
        $ds_name[$defcnt] = "$NAME[$i]";
        $opt[$defcnt] = "--vertical-label \"$UNIT[$i]\" --title \"$hostname / $servicedesc\" $options $colors ";
        $def[$defcnt] = ""; 
        $def[$defcnt] .= "DEF:sps=$RRDFILE[$i]:$DS[$i]:AVERAGE:reduce=LAST " ;
        $def[$defcnt] .= "LINE2:sps".$main_color.":\" \" ";
        $def[$defcnt] .= "VDEF:vsps=sps,LAST " ;
        $def[$defcnt] .= "GPRINT:vsps:\"$NAME[$i] %3.2lf\\n\" " ;
        $defcnt++;
        }
    if(preg_match('/^Slots$/', $NAME[$i])) {
        $ds_name[$defcnt] = "Slots";
        $opt[$defcnt] = "--vertical-label \"$UNIT[$i]\" --title \"Slots and OpenSlots\" $options $colors ";
        $def[$defcnt] = "";
        $def[$defcnt] .= "DEF:slots=$rrdfile:$DS[$i]:AVERAGE:reduce=LAST " ;
        $def[$defcnt] .= "LINE2:slots".$color['slots'].":\" \" ";
        $def[$defcnt] .= "VDEF:vslots=slots,LAST " ;
        $def[$defcnt] .= "GPRINT:vslots:\"$NAME[$i] %.0lf\" " ;
        foreach ($DS as $j) {
          if(preg_match('/^OpenSlots$/', $NAME[$j])) {
            $def[$defcnt] .= "DEF:open=$rrdfile:$DS[$j]:AVERAGE:reduce=LAST " ;
            $def[$defcnt] .= "AREA:open".$color['open'].":\" \" ";
            $def[$defcnt] .= "VDEF:vopen=open,LAST " ;
            $def[$defcnt] .= "GPRINT:vopen:\"$NAME[$j] %.0lf\" " ;
          }
        }
        $defcnt++;
    }
    if(preg_match('/^index_usage$/', $NAME[$i])) {
        $ds_name[$defcnt] = "$NAME[$i]";
        $opt[$defcnt] = "--vertical-label \"$UNIT[$i]\" --title \"$hostname / $servicedesc\" --upper-limit 100 --lower-limit 0 $options $colors ";
        $def[$defcnt] = "";
        $def[$defcnt] .= "DEF:indexusage=$RRDFILE[$i]:$DS[$i]:AVERAGE:reduce=LAST " ;
        $def[$defcnt] .= "AREA:indexusage".$gray.": ";
        $def[$defcnt] .= "LINE2:indexusage".$main_color.":\" \" ";
        $def[$defcnt] .= "VDEF:vindexusage=indexusage,LAST " ;
        $def[$defcnt] .= "GPRINT:vindexusage:\"$NAME[$i] %3.2lf\\n\" " ;
        foreach ($DS as $j) {
          if(preg_match('/^index_usage_now$/', $NAME[$j])) {
            $def[$defcnt] .= "DEF:indexusagenow=$rrdfile:$DS[$j]:AVERAGE:reduce=LAST " ;
            $def[$defcnt] .= "LINE2:indexusagenow".$secondary_color.":\" \" ";
            $def[$defcnt] .= "VDEF:vindexusagenow=indexusagenow,LAST " ;
            $def[$defcnt] .= "GPRINT:vindexusagenow:\"$NAME[$j] %.0lf\\n\" " ;
          }
        }
        $defcnt++;
    }
    if(preg_match('/^qcache_hitrate$/', $NAME[$i])) {
        $ds_name[$defcnt] = "$NAME[$i]";
        $opt[$defcnt] = "--vertical-label \"$UNIT[$i]\" --title \"$hostname / $servicedesc\" --upper-limit 100 --lower-limit 0 $options $colors ";
        $def[$defcnt] = "";
        $def[$defcnt] .= "DEF:hitrate=$RRDFILE[$i]:$DS[$i]:AVERAGE:reduce=LAST " ;
        $def[$defcnt] .= "LINE2:hitrate".$main_color.":\" \" ";
        $def[$defcnt] .= "VDEF:vhitrate=hitrate,LAST " ;
        $def[$defcnt] .= "GPRINT:vhitrate:\"$NAME[$i] %3.2lf\\n\" " ;
        foreach ($DS as $j) {
          if(preg_match('/^qcache_hitrate_now$/', $NAME[$j])) {
            $def[$defcnt] .= "DEF:hitratenow=$rrdfile:$DS[$j]:AVERAGE:reduce=LAST " ;
            $def[$defcnt] .= "LINE2:hitratenow".$secondary_color.":\" \" ";
            $def[$defcnt] .= "VDEF:vhitratenow=hitratenow,LAST " ;
            $def[$defcnt] .= "GPRINT:vhitratenow:\"$NAME[$j] %.0lf\\n\" " ;
          }
        }
        $defcnt++;
        foreach ($DS as $k) {
          if(preg_match('/^selects_per_sec$/', $NAME[$k])) {
            $ds_name[$defcnt] = "$NAME[$k]";
            $opt[$defcnt] = "--vertical-label \"$UNIT[$k]\" --title \"$hostname / $servicedesc\" $options $colors ";
            $def[$defcnt] = ""; 
            $def[$defcnt] .= "DEF:sps=$RRDFILE[$k]:$DS[$k]:AVERAGE:reduce=LAST " ;
            $def[$defcnt] .= "LINE2:sps".$main_color.":\" \" ";
            $def[$defcnt] .= "VDEF:vsps=sps,LAST " ;
            $def[$defcnt] .= "GPRINT:vsps:\"$NAME[$k] %3.2lf\\n\" ";
          }   
        }
        $defcnt++;
    }
    if(preg_match('/^tablelock_contention$/', $NAME[$i])) {
        $ds_name[$defcnt] = "$NAME[$i]";
        $opt[$defcnt] = "--vertical-label \"$UNIT[$i]\" --title \"$hostname / $servicedesc\" --upper-limit 10 --lower-limit 0 $options $colors ";
        $def[$defcnt] = "";
        $def[$defcnt] .= "DEF:tbllckcont=$RRDFILE[$i]:$DS[$i]:AVERAGE:reduce=LAST " ;
        $def[$defcnt] .= "LINE2:tbllckcont".$main_color.":\" \" ";
        $def[$defcnt] .= "VDEF:vtbllckcont=tbllckcont,LAST " ;
        $def[$defcnt] .= "GPRINT:vtbllckcont:\"$NAME[$i] %3.2lf\\n\" " ;
        foreach ($DS as $j) {
          if(preg_match('/^tablelock_contention_now$/', $NAME[$j])) {
            $def[$defcnt] .= "DEF:tbllckcontnow=$rrdfile:$DS[$j]:AVERAGE:reduce=LAST " ;
            $def[$defcnt] .= "LINE2:tbllckcontnow".$secondary_color.":\" \" ";
            $def[$defcnt] .= "VDEF:vtbllckcontnow=tbllckcontnow,LAST " ;
            $def[$defcnt] .= "GPRINT:vtbllckcontnow:\"$NAME[$j] %.0lf\\n\" " ;
          }
        }
        $defcnt++;
    }
    if(preg_match('/^thread_cache_hitrate$/', $NAME[$i])) {
        $ds_name[$defcnt] = "$NAME[$i]";
        $opt[$defcnt] = "--vertical-label \"$UNIT[$i]\" --title \"$hostname / $servicedesc\" --upper-limit 100 --lower-limit 0 $options $colors ";
        $def[$defcnt] = "";
        $def[$defcnt] .= "DEF:hitrate=$RRDFILE[$i]:$DS[$i]:AVERAGE:reduce=LAST " ;
        $def[$defcnt] .= "LINE2:hitrate".$main_color.":\" \" ";
        $def[$defcnt] .= "VDEF:vhitrate=hitrate,LAST " ;
        $def[$defcnt] .= "GPRINT:vhitrate:\"$NAME[$i] %3.2lf\\n\" " ;
        foreach ($DS as $j) {
          if(preg_match('/^thread_cache_hitrate_now$/', $NAME[$j])) {
            $def[$defcnt] .= "DEF:hitratenow=$rrdfile:$DS[$j]:AVERAGE:reduce=LAST " ;
            $def[$defcnt] .= "LINE2:hitratenow".$secondary_color.":\" \" ";
            $def[$defcnt] .= "VDEF:vhitratenow=hitratenow,LAST " ;
            $def[$defcnt] .= "GPRINT:vhitratenow:\"$NAME[$j] %.0lf\\n\" " ;
          }
        }
        $defcnt++;
        foreach ($DS as $k) {
          if(preg_match('/^connections_per_sec$/', $NAME[$k])) {
            $ds_name[$defcnt] = "$NAME[$k]";
            $opt[$defcnt] = "--vertical-label \"$UNIT[$k]\" --title \"$hostname / $servicedesc\" $options $colors ";
            $def[$defcnt] = ""; 
            $def[$defcnt] .= "DEF:sps=$RRDFILE[$k]:$DS[$k]:AVERAGE:reduce=LAST " ;
            $def[$defcnt] .= "LINE2:sps".$main_color.":\" \" ";
            $def[$defcnt] .= "VDEF:vsps=sps,LAST " ;
            $def[$defcnt] .= "GPRINT:vsps:\"$NAME[$k] %3.2lf\\n\" ";
          }   
        }
        $defcnt++;
    }
    if(preg_match('/^pct_open_files$/', $NAME[$i])) {
        $ds_name[$defcnt] = "$NAME[$i]";
        $opt[$defcnt] = "--vertical-label \"$UNIT[$i]\" --title \"$hostname / $servicedesc\" --upper-limit 100 --lower-limit 0 $options $colors ";
        $def[$defcnt] = "";
        $def[$defcnt] .= "DEF:threadsrate=$RRDFILE[$i]:$DS[$i]:AVERAGE:reduce=LAST " ;
        $def[$defcnt] .= "AREA:threadsrate".$gray.": ";
        $def[$defcnt] .= "LINE2:threadsrate".$main_color.":\" \" ";
        $def[$defcnt] .= "VDEF:vthreadsrate=threadsrate,LAST " ;
        $def[$defcnt] .= "GPRINT:vthreadsrate:\"$NAME[$i] %3.2lf\\n\" " ;
        $defcnt++;
        foreach ($DS as $j) {
          if(preg_match('/^open_files$/', $NAME[$j])) {
            $ds_name[$defcnt] = "$NAME[$j]";
            $opt[$defcnt] = "--vertical-label \"$UNIT[$j]\" --title \"$hostname / $servicedesc\" $options $colors ";
            $def[$defcnt] = "";
            $def[$defcnt] .= "DEF:openfiles=$rrdfile:$DS[$j]:AVERAGE:reduce=LAST " ;
            $def[$defcnt] .= "LINE2:openfiles".$main_color.":\" \" ";
            $def[$defcnt] .= "VDEF:vopenfiles=openfiles,LAST " ;
            $def[$defcnt] .= "GPRINT:vopenfiles:\"$NAME[$j] %.0lf\\n\" " ;
          }
        }
        $defcnt++;
    }
}
?>
