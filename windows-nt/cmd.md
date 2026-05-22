### Disable automatic running service
run cmd as administrator:
```
net stop <service>
```
msconfig > services tab > <service_name> > properties

### Set default file ext
`assoc .ts=` \
`reg delete "HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Explorer\FileExts\.ts\UserChoice" /f`