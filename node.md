# Node commands

## Process Manager 2

### List
```
pm2 list
```

### Logs
```
pm2 logs

pm2 logs <service>
```
*`--err`, `--out`* \
*`--timestamp`* \
*`--lines 100`*

*/root/.pm2/pm2.log* **(System log)** \
*/root/.pm2/logs/<service_name>-error-0.log* **(Error log)**\
*/root/.pm2/logs/<service_name>-out-0.log* **(Output/console log)**

### Start/stop/restart
```
pm2 start <id-or-name>

pm2 stop <id-or-name>

pm2 restart <id-or-name>
```
