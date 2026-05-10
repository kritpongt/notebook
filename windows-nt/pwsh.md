## Powershell 7

### Installation
winget: \
`winget install --id Microsoft.PowerShell --source winget`

> *uninstall: `winget uninstall --id <id>`*

### Version
- `$PSVersionTable`
- `host`

### Profile file
`echo $PROFILE`

## Plugins (packages)
starship: ($env:APPDATA\starship.toml)\
`winget install --id Starship.Starship`

zoxide: \
`winget install --id ajeetdsouza.zoxide`

## PS packages ([psgallery][ref1])
post-git: \
`Install-Module -Name posh-git -Scope CurrentUser`

PSFzf: \
`Install-Module -Name PSFzf -Scope CurrentUser` \
*dependency: `fzf`*


[ref1]: https://www.powershellgallery.com/packages