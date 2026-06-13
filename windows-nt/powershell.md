# PowerShell CLI

> `$env:LOCALAPPDATA` \
> `$env:USERPROFILE` ~

### Remove file
`Remove-Item -Recurse -Force <file>`

### Symbolic link
> Warning: filesystem **NTFS** only

create: \
`New-Item -ItemType SymbolicLink -Path "<link>" -Target "<target>"`
- *`Path <link>` symlink file*
- *`Target <target>` real file*

remove: \
`Remove-Item <link>`

### Find
`Get-ChildItem -Path "C:\Users" -Recurse | Select-String -Pattern "helloworld"`

### Set default file extension(?)

### Set environment variable
user: \
`[System.Environment]::SetEnvironmentVariable("CLAUDE_CODE_GIT_BASH_PATH", "$env:USERPROFILE\scoop\apps\git\current\bin\bash.exe", "User")`
system: \
`[System.Environment]::SetEnvironmentVariable("<variable>", "<path>", "Machine")`

---

### Curl
check 404 Not Found: \
`curl.exe -I <url>`

---

### SSH local port forwarding
`ssh -L 8181:localhost:81 <user>@<server>` \
*Browse in web browser: `http://localhost:8181`*

---

### VS Code clean
```
# Extensions file
Remove-Item -Recurse -Force "$env:USERPROFILE\.vscode"

# Data/config
Remove-Item -Recurse -Force "$env:APPDATA\Code"
```