# Linux Commands

## System Info

### Operation system
`cat /etc/os-release` OS \
`uname -a` Kernel & Architecture \
`uptime` uptime + load average

### Boot logs
`sudo journalctl --list-boots` columns: | idx | boot_id | *first_entry* | *last_entry* |

---

## Resources

### CPU
`mpstat 1` per-core usage (needs sysstat)

process order by desc cpu usage: \
`ps aux --sort=-%cpu | head -11`

### Memory
`free -h`
- *`-h` human readable*

`top`

`ps aux --sort=-%mem | head` top by mem

logs process: \
`sudo ls -l /proc/<pid>/fd | grep -i log`

logs mem: \
`grep -E "VmHWM|VmRSS|VmPeak|VmSize" /proc/<pid>/status`

clear cache: \
`free -h` \
`sudo sync && sudo sh -c "echo 1 > /proc/sys/vm/drop_caches"` \
`free -h`

### Disk
`df -h` disk free per mount \
`df -ih` inodes

`du -sh /var/log/* | sort -rh | head` biggest dirs \
`du -ah /var | sort -rh | head -20` bigest files
- du (disk usage):
	- *`-s` summary*
	- *`-a` all include files*
- sort:
	- *`-r` reverse sort*

---

## Process

`pgrep -f <keyword>` find by keyword (e.g. nginx)

kill: \
`kill -15 <pid>` graceful (SIGTERM) \
`kill -9 <pid>` force (SIGKILL) \
`pkill -f <keyword>` kill by keyword

---

## Services (systemd)

`systemctl status <svc>` \
`systemctl restart <svc>` \
`systemctl reload <svc>` \
`systemctl enable --now <svc>` start + enable on boot

logs: \
`journalctl -u <svc> -f` follow service log \
`journalctl -u <svc> -since "1 hour ago"` \
`journalctl -p err -b` errors this boot

---

## Network

`sudo ss -tlnp` listening ports \
`ss -tnp` active connections \
`curl -I <https://host>` header only \
`ping -c4 <host>` \
`dig <host> +short` *(or `nslookup <host>`)*

---

## Files & Permissions

`chmod 644 <file>` / `chmod +x <script>` \
`chown <user>:<group> <file>`

`ln -s <target> <link>` symlink

---

## Logs

### List logs
`sudo ls -lhtr /var/log/ | tail -20`
- *`-l` long format*
- *`-h` human readable*
- *`-tr` time revers sort*

filter by month: \
`sudo ls -lhtr /var/log/ | awk '$6 == "Mar" || $6 == "Apr"'`

### Live tail
`tail -f /var/log/syslog` \
`journalctl -f` all systemd logs live

### sysstat (sar)
`sar -r -f /var/log/sysstat/<sa*>`

### atop
`atop -r /var/log/atop/<atop_*>`

keybind:
- `m` memory view
- `t` / `T` time previous, next

mem peak: \
`atop -r /var/log/atop/<atop_*> -P MEM 2>/dev/null | awk '{print $3, $6}' | sort -k2 -rh | head -5`

---

## Search

### grep
`grep -rn "helloworld" /home`
- *`-r` recursive*
- *`-n` line number*
- *`-i` case-insensitive*
- *`-c` count match*
- *`-l` file name, exclude content*
- *`--include="*.<ext>"` filter file extension*

`grep -n "POST" /var/log/access.log | grep "500"`
- *`-A<n>`, `-B<n>`, `-C<n>` context*
- *`-E` extended regex*

### find
`find /home -name "*.log"` by name \
`find /var/log -type f -mtime -1` modified last 24h \
`find / -size +100M` files over 100MB

---

## Database

### PostgreSQL
`psql --version` \
`psql -U <user> -d <db>` connect

log dir: \
`/var/log/postgresql`

### MySQL
`mysql --version` \
`mysql -u <user> -p` connect

---

## Nginx

### validation & reload
`sudo nginx -t` \
`sudo systemctl reload nginx`

### config
`/etc/nginx/nginx.conf` main

### access log
`sudo ls -lhtr /var/log/nginx/`

filter by month: \
`sudo ls -lhtr /var/log/nginx | awk '$6 == "May"'`

top 10 ip access: \
`sudo awk '{print $1}' /var/log/nginx/access.log | sort | uniq -c | sort -rn | head -10`

first hit by ip: \
`grep "<ip>" /var/log/nginx/access.log | head -1`

request by ip | date | url | times |:
```bash
{
  zcat /var/log/nginx/access.log.*.gz 2>/dev/null
  cat /var/log/nginx/access.log
} | grep "<ip>" \
  | awk '{
      split($4, d, ":")
      gsub(/\[/, "", d[1])
      print d[1], $7, $9
    }' \
  | sort | uniq -c | sort -rn
```

---

## PHP-FPM

### log `.gz`
sort by time: \
`sudo zgrep -hiE "error|warning|fatal" /var/log/php8.2-fpm.log.*.gz | sort -k1.9,1.12 -k1.5,1.7M -k1.2,1.3 -k2` sort time \
`sudo zcat $(sudo ls -tr /var/log/php8.2-fpm.log.*.gz) | grep -iE "error|warning|fatal"`

### log real-time
`tail -f /var/log/php8.2-fpm.log` \
`tail -f /var/log/php8.2-fpm.log | grep -iE "error|warning|fatal"`