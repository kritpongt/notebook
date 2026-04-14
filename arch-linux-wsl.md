# Install arch linux on windows

> [arch linux wiki][ref1]

- `wsl --list --online` list wsl distro.
- `wsl --update` update to the latest version.

> [installation for older version of wsl](#manual-installation-for-older-verions-of-wsl)

### Installation

`wsl --install archlinux`

`wsl.exe -d archlinux` start arch linux.

### Add a new user and set the password

`# useradd -m -G wheel <user>`
- `-m` create home directory `/home/username` (--create-home)
- `-G` addition groups (--groups)
- `wheel` administration group. can be used to give access to the `sudo` utility

`# passwd <user>` set password

### Config sudo

`# pacman -Syu sudo nvim`

`# EDITOR=nvim visudo` and then uncomment `%wheel ALL=(ALL:ALL) ALL`

### Set default user

`/etc/wsl.conf` file append the following:
```
[user]
default=<user>
```

### Install packages

`git`, `zsh`, `fzf`

`# nvim ~/.zshrc` install zinit (plugin manager for zsh). append the following:
```
ZINIT_HOME="${XDG_DATA_HOME:-${HOME}/.local/share}/zinit/zinit.git"
[ ! -d $ZINIT_HOME ] && mkdir -p "$(dirname $ZINIT_HOME)"
[ ! -d $ZINIT_HOME/.git ] && git clone https://github.com/zdharma-continuum/zinit.git "$ZINIT_HOME"
source "${ZINIT_HOME}/zinit.zsh"
```
`# exec zsh` reload zsh and then `# zinit zstatus` check status.

append the following:
```
zinit light zsh-users/zsh-completions
zinit light zsh-users/zsh-autosuggestions
zinit light zsh-users/zsh-syntax-highlighting
zinit light Aloxaf/fzf-tab

autoload -Uz compinit && compinit
zinit cdreplay -q

zstyle ':completion:*' matcher-list 'm:{a-z}={A-Za-z}'
zstyle ':completion:*' menu no
zstyle ':fzf-tab:complete:cd:*' fzf-preview 'ls $realpath'

setopt appendhistory
setopt sharehistory
setopt hist_ignore_space
setopt hist_ignore_all_dups
setopt hist_save_no_dups

bindkey '^l' autosuggest-accept

eval "$(fzf --zsh)"
```

### Nerd font (only symbols)


## WSL Commands

`wsl -l -v` 
- `-l` list (--list)
- `-v` detailed information (--verbose)

`wsl --terminate archlinux` turn off archlinux

## Manual installation for older versions of wsl

> [install manual][ref2]

`wsl --install` for simplicity. and then restart pc.

#### 1. enable the WSL (PowerShell > Run as Administrator)
```
dism.exe /online /enable-feature /featurename:Microsoft-Windows-Subsystem-Linux /all /norestart
```
#### 2. enable virtual machine feature
```
dism.exe /online /enable-feature /featurename:VirtualMachinePlatform /all /norestart
```
and then, restart pc.
#### 3. update package linux kernel
> [download the latest package][ref3]

#### 4. set wel 2 as default version
```
wsl --set-default-version 2
```


[ref1]: https://wiki.archlinux.org/title/Install_Arch_Linux_on_WSL
[ref2]: https://learn.microsoft.com/en-us/windows/wsl/install-manual
[ref3]: https://learn.microsoft.com/en-us/windows/wsl/install-manual#step-4---download-the-linux-kernel-update-package
[zinit]: https://github.com/zdharma-continuum/zinit