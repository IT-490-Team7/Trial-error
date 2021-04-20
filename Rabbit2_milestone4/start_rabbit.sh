#!/bin/bash
STATUS="$(systemctl is-active rabbitmq-server.service)"
serv=rabbitmq-server

if [ "${STATUS}" = "active" ]; then
    echo "$serv is running....."
else 
    echo " $serv is not running... but will start up shortly"
    systemctl start $serv
    echo "Checking status..."
    systemctl status $serv 
    exit 1  
fi
