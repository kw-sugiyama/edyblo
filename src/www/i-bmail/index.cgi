#!/usr/local/bin/perl

use CGI;
$q = new CGI;

if ( $ENV{HTTP_USER_AGENT} =~ /Mozilla/i ){
			print $q->header;
                        print "���̃y�[�W�͌g�ђ[����p�ł��B";
} else {
      print "Location:/i-bmail/entry.pl\n\n";
}
