<?php
include 'config_default.php';
$splita = explode(",", $dhcp_range);
$dhcp_range_start = $splita[0];
$dhcp_range_end = $splita[1];
$dhcp_range_netmask = $dhcp_netmask;
$dhcp_range_lease = $splita[2];
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body>
	<div class="container">
		<div class="card">
			<div class="col">
				<div class="row" style="margin-top: 1%;">
					<p>Interface:* <input type="text" class="form-control"  value="<?php echo $iface; ?>" readonly=""></p>
				</div>
				<div class="row" style="margin-top: 1%;">
					<p>NTP Server:
					<input type="text" class="form-control" id="in_ntp" oninput="return calcIPValid(this);" value="<?php echo $dhcp_option_42; ?>"></p>
				</div>
				<div class="row" style="margin-top: 1%;">
					<p>DNS Server:
					<input type="text" class="form-control" id="in_dns" oninput="return calcIPValid(this);" value="<?php echo $dhcp_option_dns; ?>"></p>
				</div>
				<div class="row" style="margin-top: 1%;">
					<p>Log file:* <input type="text" class="form-control"  value="<?php echo $log_facility; ?>" readonly=""></p>
				</div>
				<div class="row" style="margin-top: 1%;">
					<h3>DHCP Settings:</h3>
					<p>DHCP Start:<input type="text" class="form-control" id="in_dhcp_start" oninput="return calcNet();" value="<?php echo "$dhcp_range_start" ?>"></p>
					<p>DHCP End:*<input type="text" class="form-control"  id="in_dhcp_end" value="<?php echo "$dhcp_range_end" ?>" readonly=""></p>
					<p>DHCP Netmask:
					<select name="csubnet" id="csubnet" onchange="return calcNet();">
						<option value="1">255.255.255.0 /24</option>
						<option value="2">255.255.254.0 /23</option>
						<option value="3">255.255.252.0 /22</option>
						<option value="4">255.255.248.0 /21</option>
						<option value="5">255.255.240.0 /20</option>
						<option value="6">255.255.224.0 /19</option>
						<option value="7">255.255.192.0 /18</option>
						<option value="8">255.255.128.0 /17</option>
						<option value="9">255.255.0.0 /16</option>
					</select>
					</p>
					<p>DHCP Lease:
					<select name="clease" id="clease">
						<option value="1">1h</option>
						<option value="2">12h</option>
						<option value="3">24h</option>
					</select>
					</p>
				</div>
				<div class="row" style="margin-top: 1%;">
					<p>Gateway:* <input type="text" class="form-control" id="in_dhcp_gateway" value="<?php echo $dhcp_option_router; ?>" readonly=""></p>
				</div>
				<div class="Row">
					<button class="btn btn-primary" id="apply_set">Apply</button>
				</div>
			</div>
		</div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script>
    var nval = "<?php echo "$dhcp_subnet" ?>";
    var lval = "<?php echo "$dhcp_lease" ?>";
    var nsel = document.getElementById('csubnet');
    var lsel = document.getElementById('clease');
    for(var i, j = 0; i = nsel.options[j]; j++) {
      if(i.value == nval) {
        nsel.selectedIndex = j;
        break;
      }
    }
    for(var i, j = 0; i = lsel.options[j]; j++) {
      if(i.value == lval) {
        lsel.selectedIndex = j;
        break;
      }
    }
    </script>
    <script>
	function checkIpAddress(ip) {
		const ipv4Pattern = /^(\d{1,3}\.){3}\d{1,3}$/;
		//const ipv6Pattern = /^([0-9a-fA-F]{1,4}:){7}[0-9a-fA-F]{1,4}$/;
		return ipv4Pattern.test(ip); //|| ipv6Pattern.test(ip);
	}
	function IndexNetMask(netmask) {
		// 			24		23		22		21			20		19		18		17		16
		const netmasks = ["255.255.255.0", "255.255.254.0", "255.255.252.0", "255.255.248.0", "255.255.240.0", "255.255.224.0", "255.255.192.0", "255.255.128.0", "255.255.0.0"];
		return netmasks[netmask-1];
	}
	function IndexLease(lease) {
		const leases = ["1h","12h","24h"];
		return leases[lease-1];
	}
	function calcNet() {
		var tmp = document.getElementById("in_dhcp_start").value;

		if(!checkIpAddress(tmp)){
			document.getElementById("in_dhcp_start").classList.add("is-invalid");
			document.getElementById('apply_set').disabled = true;
			document.getElementById("in_dhcp_gateway").value  = "-.-.-.-";
			document.getElementById("in_dhcp_end").value = "-.-.-.-";
		}
		else {
			document.getElementById("in_dhcp_start").classList.remove("is-invalid");
			document.getElementById('apply_set').disabled = false;

			tmp = tmp.split(".");
			const netmask = document.getElementById('csubnet').value;
			// 			24		23		22		21			20		19		18		17		16
			const netmasks = ["255.255.255.0", "255.255.254.0", "255.255.252.0", "255.255.248.0", "255.255.240.0", "255.255.224.0", "255.255.192.0", "255.255.128.0", "255.255.0.0"];
			const octets = netmasks[netmask-1].split(".");

			if(Number(tmp[3]) < 2 || Number(tmp[3]) == 255 ) {
				tmp[3]="2";
				document.getElementById("in_dhcp_start").value = tmp.join(".");
			}

			tmp[3]="1";
			document.getElementById("in_dhcp_gateway").value = tmp.join(".");

			tmp[3]="254";
			tmp[2]=Number(tmp[2])+(255-Number(octets[2]));
			if(Number(tmp[2]) > 254) {
				tmp[2]=Number(tmp[2])-255;
				tmp[1]=Number(tmp[1])+1;
			}
			document.getElementById("in_dhcp_end").value = tmp.join(".");
		}
	}
	function calcIPValid(elem) {
		var tmp = elem.value;

		if(!checkIpAddress(tmp)){
			elem.classList.add("is-invalid");
			document.getElementById('apply_set').disabled = true;
		}
		else {
			elem.classList.remove("is-invalid");
			document.getElementById('apply_set').disabled = false;
		}
	}
	document.querySelector("#apply_set").addEventListener("click", bc)
	function bc(event) {
		event.preventDefault();
		console.log("========= Input test:");
		console.log("NTP = " + checkIpAddress(document.getElementById("in_ntp").value));
		console.log("DNS = " + checkIpAddress(document.getElementById("in_dns").value));
		console.log("DHCP Start = " + checkIpAddress(document.getElementById("in_dhcp_start").value));
		console.log("DHCP End = " + checkIpAddress(document.getElementById("in_dhcp_end").value));
		console.log("DHCP Gateway = " + checkIpAddress(document.getElementById("in_dhcp_gateway").value));
		console.log("DHCP Mask = " + document.getElementById('csubnet').value); // nval
		console.log("DHCP Lease = " + document.getElementById('clease').value); // lval

		let data = {settings_ntp: document.getElementById("in_ntp").value,
		settings_ntp: document.getElementById("in_ntp").value,
		settings_dns: document.getElementById("in_dns").value,
		settings_dhcp_st: document.getElementById("in_dhcp_start").value,
		settings_dhcp_en: document.getElementById("in_dhcp_end").value,
		settings_dhcp_ms: IndexNetMask(document.getElementById("csubnet").value),
		settings_dhcp_ls: IndexLease(document.getElementById("clease").value),
		settings_dhcp_gw: document.getElementById("in_dhcp_gateway").value,
		settings_gui_netmaskindex: document.getElementById("csubnet").value,
		settings_gui_leaseindex: document.getElementById("clease").value
		};

		fetch("/TEST_postjson_to_config.php", {
		  method: "POST",
		  headers: {'Content-Type': 'application/json'}, 
		  body: JSON.stringify(data)
		}).then(res => {
		  console.log("post response:", res);
		  window.location.replace("../");
		});
	}
    </script>
  </body>
</html>
