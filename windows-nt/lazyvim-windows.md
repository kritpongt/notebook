# Installation lazyvim on windows

### Install scoop [#scoop][ref1]
Open a PowerShell terminal (v5.1+) and then run:
```
Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser
Invoke-RestMethod -Uri https://get.scoop.sh | Invoke-Expression
```
`scoop install git luarocks`

`scoop bucket add versions` \
`scoop install versions/mingw-winlibs-llvm-ucrt`

### neovim
`scoop install neovim`

### Fonts
`scoop bucket add nerd-fonts`
- `scoop install nerd-fonts/UbuntuSans-NF-Mono` Ubuntu Sans Mono
- `scoop install nerd-fonts/NerdFontsSymbolsOnly` Symbols Nerd Font Mono

### lazyvim [#lazyvim][ref2]
Make a backup files:
```
Move-Item $env:LOCALAPPDATA\nvim $env:LOCALAPPDATA\nvim.bak
Move-Item $env:LOCALAPPDATA\nvim-data $env:LOCALAPPDATA\nvim-data.bak
```

Clone the starter:
```
git clone https://github.com/LazyVim/starter $env:LOCALAPPDATA\nvim
```

Remove the `.git` folder:
```
Remove-Item -Recurse -Force $env:LOCALAPPDATA\nvim\.git 
```
and then `nvim` to start.

> Troubleshoot:
> - `:checkhealth` run all healthchecks

### Install plugins

`scoop install tree-sitter` \
`scoop intsall ripgrep` \
`scoop intsall fd`


------------------------------------------------------------

> Tips:
> - Key-mapping check
>   1. `insert mode`
>   2. `ctrl+q` and then press the key
> - Debugging Pattern in autocmd({ "FileType" })
>   1. cursor to target
>   2. `:lua print(vim.bo.filetype)`
> - Open nvim without any plugin manager
>   1. `nvim -n NONE`
> - Runtime files
> 	1. `:e $VIMRUNTIME`

[ref1]: https://scoop.sh
[ref2]: https://www.lazyvim.org/installation