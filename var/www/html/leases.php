<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
		<link href="/terminal.css" media="all" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div style="flex-basis:0; flex-grow: 1; border: 1px solid #000066; padding: 10px;">
			<div style="display:flex; flex-direction:row; align-items:center;"></div>
				<div id="term_frame">
					<pre id="term_yellow">
<?php
echo "Lease Expires\t\tClient MAC\t\tClient IP\tHostname\tClient ID (0x61)\n";
?>
					</pre>
					<pre id="term_green">
<?php
$raw  = (file_get_contents("/var/lib/misc/dnsmasq.leases"));
$splita = explode("\n", $raw);
for ($i = 0; $i < sizeof($splita); ++$i) {
   $splitb = explode(" ", $splita[$i]);
   for ($n = 0; $n < sizeof($splitb); ++$n) {
     if(is_numeric($splitb[$n])) {
         $splitb[$n] = gmdate("Y-m-d H:i:s", $splitb[$n]);
     }
   }
   $splita[$i] = join("\t", $splitb);
}
echo htmlspecialchars(join("\n",$splita));
?>
					</pre>
				</div>
			</div>
		 </div>
	</body>
</html>


