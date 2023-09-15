#!/usr/local/bin/perl

use CGI;
$q = new CGI;

if ( $ENV{HTTP_USER_AGENT} =~ /Mozilla/i ){
			print $q->header;
                        print "このページは携帯端末専用です。";
} else {
      print "Location:/i-bmail/entry.pl\n\n";
}
