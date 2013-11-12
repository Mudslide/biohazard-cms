<?php
$ref = "{imap.seznam.cz:993/imap/ssl}";
$user = "bio.g6.cz";
$pass = "10!=3628800";

imap_timeout(IMAP_OPENTIMEOUT, 120);

$res = imap_open(
 $ref, $user, $pass,
 OP_HALFOPEN, 3
)or die(
 'Cannot connect: ' . imap_last_error()
);

$list = imap_getmailboxes(
 $res, $ref, "*"
)or die(
 'Cannot get folder list:' . imap_last_error()
);

foreach($list as $item){
 echo($item->name);
 echo("<br />");
}
