# Dnsmasq DHCP Server panel demo
Simple PHP powered panel for configuring basic DHCP functions 
This is a Proof-of-Concept, not well made, not secure.

## Dependencies
**Debian 11**
```
apt install apache2 php dnsmasq iptables iptables-persistent sudo
```

## TODO
* Apply correct settings on startup 
* Save config of /etc/network/interfaces
* Proper security and input validation (only basic checks present)
* Replace bash code with binaries or CGI
* Detect conflicts with WAN interface configuration
* Support static DHCP leases
