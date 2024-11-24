#!/bin/bash
systemctl stop dnsmasq

busybox ifconfig "$1" netmask "$3" "$2"

echo "$1" "$3" "$2" > /tmp/a

iptables -t nat -F
iptables -A PREROUTING -t nat -p tcp -i enp0s3 --dport 10000 -j DNAT --to-destination 10.10.10.2:10000
iptables -t nat -A POSTROUTING -s 10.10.10.1/30 -o enp0s3 -j MASQUERADE
iptables -t nat -A POSTROUTING -s "$2"/24 -o enp0s3 -j MASQUERADE

iptables-save > /etc/iptables/rules.v4

cat /var/www/html/newconfig > /etc/dnsmasq.conf

sleep 0.5
systemctl start dnsmasq
