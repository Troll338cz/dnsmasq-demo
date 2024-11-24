<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
		<link href="/terminal.css" media="all" rel="stylesheet" type="text/css">
		<title>Main panel</title>
	</head>
	<body>
		<div style="flex-basis:0; flex-grow: 1; border: 1px solid #000066; padding: 10px;">
			<div>
<?php
$dhcpserveruptime = substr(explode(";", exec('systemctl status dnsmasq.service | grep "Active:"'))[1], 0, -4);
echo '<p>DHCP Server uptime: ' . htmlspecialchars($dhcpserveruptime) . '</p>';?>

			<button class="button" id="btn_apply">
			  <span class="lable">💾 Apply Config</span>
			</button>
			<button class="button" id="btn_status">
			  <span class="lable">❗ Status</span>
			</button>
			<button class="button" id="btn_stop">
			  <span class="lable">🛑 Stop</span>
			</button>
			<button class="button" id="btn_start">
			  <span class="lable">✅ Start</span>
			</button>
			<button class="button" id="btn_restart">
			  <span class="lable">↶ Restart</span>
			</button>
			<button class="button" id="btn_clearlog">
			  <span class="lable">📰 Delete log</span>
			</button>
			<button class="button" id="btn_showlog">
			  <span class="lable">📰 Show log</span>
			</button>
<?php
$clientcount = explode(" ",exec("wc -l /var/lib/misc/dnsmasq.leases"))[0];
echo '<a href="/leases.php">Client count: ' . htmlspecialchars($clientcount) . '</a>';?>

			<p>DHCP Settings <a href="/setting_ro.php">View</a> <a href="/setting_rw.php">Edit</a></p>
			</div>
			<p style="margin-bottom: 0px;">Last 50 log messages</p>
			<div style="display:flex; flex-direction:row; align-items:center;"></div>
				<div id="term_frame">
					<pre id="term_green">
					</pre>
				</div>
			</div>
		</div>
		<script>
			document.querySelector("#btn_apply").addEventListener("click", bapp)
			function bapp(event) {
				event.preventDefault();
				fetch("/command.php?command=applyconfig", {
				  method: "GET",
				}).then(res => {
				  //console.log("post response:", res.text());
				  return res.text();
				}).then(body => {
				  document.getElementById("term_green").innerHTML = atob(body);
				});

			}
			document.querySelector("#btn_status").addEventListener("click", bstatus)
			function bstatus(event) {
				event.preventDefault();
				fetch("/command.php?command=status", {
				  method: "GET",
				}).then(res => {
				  //console.log("post response:", res.text());
				  return res.text();
				}).then(body => {
				  document.getElementById("term_green").innerHTML = atob(body);
				});
			}
			document.querySelector("#btn_stop").addEventListener("click", bstp)
			function bstp(event) {
				event.preventDefault();
				fetch("/command.php?command=stop", {
				  method: "GET",
				}).then(res => {
				  //console.log("post response:", res.text());
				  return res.text();
				}).then(body => {
				  document.getElementById("term_green").innerHTML = atob(body);
				});
			}
			document.querySelector("#btn_start").addEventListener("click", bstart)
			function bstart(event) {
				event.preventDefault();
				fetch("/command.php?command=start", {
				  method: "GET",
				}).then(res => {
				  //console.log("post response:", res.text());
				  return res.text();
				}).then(body => {
				  document.getElementById("term_green").innerHTML = atob(body);
				});
			}
			document.querySelector("#btn_restart").addEventListener("click", bres)
			function bres(event) {
				event.preventDefault();
				fetch("/command.php?command=restart", {
				  method: "GET",
				}).then(res => {
				  //console.log("post response:", res.text());
				  return res.text();
				}).then(body => {
				  document.getElementById("term_green").innerHTML = atob(body);
				});
			}
			document.querySelector("#btn_clearlog").addEventListener("click", bclr)
			function bclr(event) {
				fetch("/command.php?command=clearlog", {
				  method: "GET",
				}).then(res => {});
				document.getElementById("term_green").innerHTML = "Log file cleared.";
				//location.reload();
				event.preventDefault();
			}
			document.querySelector("#btn_showlog").addEventListener("click", refreshlog)
			function refreshlog() {
				//event.preventDefault();
				fetch("/command.php?command=getlog", {
				  method: "GET",

				}).then(res => {
				  //console.log("post response:", res.text());
				  return res.text();
				}).then(body => {
				  document.getElementById("term_green").innerHTML = atob(body);
				});
			}
		</script>
		<script>
			refreshlog();
		</script>
	</body>
</html>


