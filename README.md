statusLAN
=========

Very simple webpage showing CPU usage of connected hosts.

![Screen](https://github.com/mjamroz/statusLAN/raw/master/screenshot.png)

How To "install"
================

1) Put files from webpage_side somewhere on the web

2) Edit status.php changing remote client IPs

3) Edit ping.py changing uri to your website http://...../status.php

*4) Optionally, put add_host.sh (change url here) and ping.py onto webpage

How To "use"
============

1) install ping.py into cron (for example, using sudo add_host.sh - it should send ping every 5minutes)


License, etc.
=============

Scripts are public domain. Quotes for bottom frame were downloaded from http://amiquote.tumblr.com/ .


TODO
====

Probably for many hosts we get problems with blocking sqlite (provisional hack in the current version is to use random delay for DB update.. huh.)
Could be nicer to store all pings, to plot nice historical hosts usages, but I'm lazy. 
