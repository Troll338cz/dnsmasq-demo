<?php
include 'config_default.php';
$splita = explode(",", $dhcp_range);
$dhcp_range_start = $splita[0];
$dhcp_range_end = $splita[1];
$dhcp_range_netmask = $splita[2];
$dhcp_range_lease = $splita[3];
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body>
	<div class="container">
		<div class="card">
			<div class="col">
				<div class="row" style="margin-top: 1%;">
					<p>Interface: <input type="text" class="form-control"  value="<?php echo $iface; ?>" readonly=""></p>
				</div>
				<div class="row" style="margin-top: 1%;">
					<p>NTP Server: <input type="text" class="form-control"  value="<?php echo $dhcp_option_42; ?>" readonly=""></p>
				</div>
				<div class="row" style="margin-top: 1%;">
					<p>DNS Servers: <input type="text" class="form-control"  value="<?php echo $dhcp_option_dns; ?>" readonly=""></p>
				</div>
				<div class="row" style="margin-top: 1%;">
					<p>Log file: <input type="text" class="form-control"  value="<?php echo $log_facility; ?>" readonly=""></p>
				</div>
				<div class="row" style="margin-top: 1%;">
					<p>DHCP Range: <input type="text" class="form-control"  value="<?php echo "$dhcp_range_start-$dhcp_range_end $dhcp_range_netmask $dhcp_range_lease" ?>" readonly=""></p>
				</div>
				<div class="row" style="margin-top: 1%;">
					<p>Gateway: <input type="text" class="form-control"  value="<?php echo $dhcp_option_router; ?>" readonly=""></p>
				</div>
			</div>
		</div>
    </div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>
