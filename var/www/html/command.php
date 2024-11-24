<?php
include 'config_default.php';
if (isset($_GET['command'])) {
	$cmd = $_GET['command'];
	switch($cmd){
		case 'status':
			$cmdout = explode("\t",exec('systemctl status dnsmasq | tr \'\n\' \'\t\' > /tmp/cmd && cat /tmp/cmd && rm /tmp/cmd'));
			echo htmlspecialchars(base64_encode(join("\n", $cmdout)));
		break;
		case 'stop':
			exec('sudo /var/www/html/bin/stop.sh');
			$cmdout = explode("\t",exec('systemctl status dnsmasq | tr \'\n\' \'\t\' > /tmp/cmd && cat /tmp/cmd && rm /tmp/cmd'));
			echo htmlspecialchars(base64_encode(join("\n", $cmdout)));
		break;
		case 'start':
			exec('sudo /var/www/html/bin/start.sh');
			$cmdout = explode("\t",exec('systemctl status dnsmasq | tr \'\n\' \'\t\' > /tmp/cmd && cat /tmp/cmd && rm /tmp/cmd'));
			echo htmlspecialchars(base64_encode(join("\n", $cmdout)));
		break;
		case 'restart':
			exec('sudo /var/www/html/bin/restart.sh');
			$cmdout = explode("\t",exec('systemctl status dnsmasq | tr \'\n\' \'\t\' > /tmp/cmd && cat /tmp/cmd && rm /tmp/cmd'));
			echo htmlspecialchars(base64_encode(join("\n", $cmdout)));
		break;
		case 'applyconfig':
			exec("sudo /var/www/html/bin/applyconfig.sh $iface $dhcp_option_router $dhcp_netmask");
			$cmdout = explode("\t",exec('systemctl status dnsmasq | tr \'\n\' \'\t\' > /tmp/cmd && cat /tmp/cmd && rm /tmp/cmd'));
			echo htmlspecialchars(base64_encode(join("\n", $cmdout)));
		break;
		case 'clearlog':
			exec('sudo /var/www/html/bin/clearlog.sh');
			$cmdout = explode("\t",exec('systemctl status dnsmasq | tr \'\n\' \'\t\' > /tmp/cmd && cat /tmp/cmd && rm /tmp/cmd'));
			echo htmlspecialchars(base64_encode(join("\n", $cmdout)));
		break;
		case 'getlog':
			$loglast50 = explode("\t",exec('tail --lines=50 /var/log/dnsmasq.log | tr \'\n\' \'\t\''));
			echo htmlspecialchars(base64_encode(join("\n", $loglast50)));
		break;
		default:
		echo "Unknown command";
	}
} else {
    echo "Missing argument";
}
?>
