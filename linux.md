# Linux Commands

### Operation system
`cat /etc/os-release` OS \
`uname -a` Kernal Architecture

### Boot logs
`sudo journalctl --list-boots` | idx | boot_id | *first_entry* | *last_entry* |

### List logs
`sudo ls -lhtr /var/log/ | tail -20` \
`sudo ls -lhtr /var/log/ | awk '$6 == "Mar" || $6 == "Apr"'`

### Memory overview
`free -h`
- *`-h` human readable*

`top`, `htop`

process order by desc usage: \
`ps aux --sort=-%mem | head -11`

logs process: \
`sudo ls -l /proc/<pid>/fd | grep -i log`

logs mem: \
`grep -E "VmHWM|VmRSS|VmPeak|VmSize" /proc/<pid>/status`

## Database

### PostgreSQL:
`psql --version`

`/var/log/postgresql`

### MySQL:
`mysql --version`

## Nginx

### Access log
List logs: \
`sudo ls -lhtr /var/log/nginx/`
- `-h` human readable
- `-tr` time reverse sort

Top 10 ip: \
`sudo awk '{print $1}' /var/log/nginx/access.log | sort | uniq -c | sort -rn | head -10`

`grep "<ip>" /var/log/nginx/access.log | head -1`

Display request by ip | date | url | times |:
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

## PHP-FPM

### log `.gz`
`sudo zgrep -hiE "error|warning|fatal" /var/log/php8.2-fpm.log.*.gz | sort -k1.9,1.12 -k1.5,1.7M -k1.2,1.3 -k2` sort time \
`sudo zcat $(sudo ls -tr /var/log/php8.2-fpm.log.*.gz) | grep -iE "error|warning|fatal"`