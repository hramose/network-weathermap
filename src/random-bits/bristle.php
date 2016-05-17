<?php

    $cacti_root = "/var/www/docs/cacti";

    @include_once($cacti_root . "/include/global.php");
    @include_once($cacti_root . "/include/config.php");

    $target_format = "";
    $infourl_format = "";
    $overlib_format = "";

#
# change these three and then run this.
# run the result through cacti-integrate to fill in the TARGETS etc.
#   Change the

    $switchname = "sw1";
    $nports = 48;
    $cacti_host_id = 17;
    $interfacepattern = "Gi0/%d";


    printf("# generated by bristle.php - %d ports\n# First, the actual switch node. Give this an ICON\nNODE %s\n\tPOSITION 400 400\n\n", $nports, $switchname);

    for ($n = 1; $n <= $nports; $n++) {
        $nodename = sprintf("%s_p%d", $switchname, $n);
        $linkname = sprintf("%s_%s", $switchname, $nodename);

        $halfway = $nports / 2; // the midpoint of a side
        $quarter = $halfway / 2; // the midpoint of a side
        $voffset = 40; // the length of the bristle
        $voffset2 = 13; // the inside offset of the bristle

        if ($n > $halfway) {
            $offset = ($n - 24 - 1 - $quarter) * 8;
        } else {
            // The first 24 ports grow up instead of down
            $offset = ($n - 1 - $quarter) * 8;
            $voffset = -$voffset;
            $voffset2 = -$voffset2;
        }


        $target = "tgt?";
        $infourl = "info?";
        $overliburl = "over?";

        printf("NODE %s\n\tPOSITION %s %d %d\n\tSET cacti_id %d\n\n",
            $nodename, $switchname, $offset, $voffset, $cacti_host_id);

        printf("LINK %s\n\tNODES %s:%d:%d %s\n\tBWLABEL none\n\tWIDTH 2\n\tARROWSTYLE compact\n\tOUTLINECOLOR none\n", $linkname, $switchname, $offset, $voffset2, $nodename
        );

        $interfacename = sprintf($interfacepattern, $n);

        print "\tSET out_interface $interfacename";

#       printf("\tINFOURL %s\n\tOVERLIBGRAPH %s\n\tTARGET %s\n", $infourl, $overliburl, $target );
        print "\n\n";

    }
    print "# Now run this output through cacti-integrate.php to add all the INFOURL and TARGET lines";

