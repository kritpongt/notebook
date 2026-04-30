# PowerShell commands

> Note: `$env:LOCALAPPDATA\`

### Remove file
```
Remove-Item -Recurse -Force <file>
```

### Create Symbolic Link (run as adminstrator)
```
New-Item -ItemType SymbolicLink -Path "<link>" -Target "<target>"
```
`-Path <link>`      symlink file
`-Target <target>`  real file

> Warning: Filesystem **NTFS** Only

### List Symbolic Link in path
```
ls <path> | Where-Object { $_.LinkType -eq "SymbolicLink" }
```

### Remove Symbolic Link
```
Remove-Item <link>
```

## Curl check 404 Not Found
```
curl.exe -I <url>
```

## NPM ui (Nginx Proxy Manager)
```
ssh -L 8181:localhost:81 <user>@<server>
```
Browse in web browser: `http://localhost:8181`

## Install Claude
```
irm https://claude.ai/install.ps1 | iex
```
*`irm` => `Invoke-RestMethod` download script for `.ps1`* \
*`iex` => `Invoke-Expreesion` process script*