<?php
include 'config_default.php';

if (isset($_POST)) {
	$data = json_decode(file_get_contents('php://input'), true);

	$dhcp_option_42 = $data['settings_ntp'];
	$dhcp_option_dns = $data['settings_dns'];
	// 192.168.1.2,192.168.1.254,255.255.255.0,12h
	//$dhcp_range = $data['settings_dhcp_st'].",".$data['settings_dhcp_en'].",".$data['settings_dhcp_ms'].",".$data['settings_dhcp_ls'];
	$dhcp_range = $data['settings_dhcp_st'].",".$data['settings_dhcp_en'].",".$data['settings_dhcp_ls'];
	$dhcp_option_router = $data['settings_dhcp_gw'];

//        echo  "port=0\n";
//        echo  "interface=$iface\n";
//        echo  "enable-ra\n";
//        echo  "dhcp-option=42,$dhcp_option_42\n";
//        echo  "log-facility=$log_facility\n";
//        echo  "dhcp-range=$dhcp_range\n";
//        echo  "dhcp-option=option:router,$dhcp_option_router\n";
//        echo  "dhcp-option=option:dns-server,$dhcp_option_dns\n";
//        echo  "dhcp-authoritative\n";


	$newconfig = fopen("newconfig", "w+");
	fwrite($newconfig, "port=0\n");
	fwrite($newconfig, "interface=$iface\n");
	fwrite($newconfig, "enable-ra\n");
	fwrite($newconfig, "dhcp-option=42,$dhcp_option_42\n");
	fwrite($newconfig, "log-facility=$log_facility\n");
	fwrite($newconfig, "dhcp-range=$dhcp_range\n");
	fwrite($newconfig, "dhcp-option=option:router,$dhcp_option_router\n");
	fwrite($newconfig, "dhcp-option=option:dns-server,$dhcp_option_dns\n");
	fwrite($newconfig, "dhcp-authoritative\n");
	fclose($newconfig);

        $newconfig = fopen("config_default.php", "w+");
        fwrite($newconfig, "<?php\n");
        fwrite($newconfig, "\$iface = 'enp0s8';\n");
        fwrite($newconfig, "\$dhcp_option_42 = '$dhcp_option_42';\n");
        fwrite($newconfig, "\$log_facility = '$log_facility';\n");
        fwrite($newconfig, "\$dhcp_range = '$dhcp_range';\n");
        fwrite($newconfig, "\$dhcp_option_router = '$dhcp_option_router';\n");
        fwrite($newconfig, "\$dhcp_netmask = '$data[settings_dhcp_ms]';\n");
        fwrite($newconfig, "\$dhcp_option_dns = '$dhcp_option_dns';\n");
        fwrite($newconfig, "\$dhcp_subnet = '$data[settings_gui_netmaskindex]';\n");
        fwrite($newconfig, "\$dhcp_lease = '$data[settings_gui_leaseindex]';\n");
        fwrite($newconfig, "?>\n");
        fclose($newconfig);

} else  {
    die("POST request required");
}
?>
