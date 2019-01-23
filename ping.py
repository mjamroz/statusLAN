#!/usr/bin/env python
# Michal Jamroz, public domain
import urllib, urllib2
from subprocess import Popen,PIPE
url = 'http://XXXX.XXXX.pl/status.php'
cpusex=Popen(["grep -c 'processor' /proc/cpuinfo"],shell=True,stdout=PIPE)
cpus,_ = cpusex.communicate()
staex = Popen(["uptime"],stdout=PIPE)
status,_ = staex.communicate()
datex = Popen(["date -Iseconds"],shell=True,stdout=PIPE)
date,_ = datex.communicate()
hostx = Popen(["hostname"],stdout=PIPE)
hostname,_ = hostx.communicate()
values = {'ping' : status.strip(),'cpus':cpus.strip(),'date':date.strip(),'hostname':hostname.strip()}

data = urllib.urlencode(values)
req = urllib2.Request(url, data)
response = urllib2.urlopen(req)
response.read()
