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