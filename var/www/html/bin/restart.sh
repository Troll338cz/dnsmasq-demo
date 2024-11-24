#!/bin/bash
systemctl stop dnsmasq
sleep 0.5
systemctl start dnsmasq
