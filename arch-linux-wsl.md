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

`git`, `zsh`, `fzf`, \
`base-devel`, `tree-sitter-cli`, `fd`, `ripgrep`, `luarocks`, `rust`

### Install ohmyzsh (plugin manager)
> [installation ohmyzsh with curl][ref4]

`starship` \
config file: `~/.config/starship.toml`

`zoxide`

`tmux` \
config file:

Plugins:
- [zsh-fzf-tab][ref5]
- [zsh-system-clipboard][ref6]
- [zsh-syntax-highlights][ref7]

## Link win32yank from windows to wsl
Windows:
```
scoop install win32yank

scoop which win32yank
```
WSL:
```
sudo ln -s "/mnt/c/Users/<user_name>/scoop/apps/.." /usr/local/bin/win32yank.exe
sudo chmod +x /usr/local/bin/win32yank.exe
```

## Install zinit (plugin manager)
append the following to `.zshrc` file:
```
ZINIT_HOME="${XDG_DATA_HOME:-${HOME}/.local/share}/zinit/zinit.git"
[ ! -d $ZINIT_HOME ] && mkdir -p "$(dirname $ZINIT_HOME)"
[ ! -d $ZINIT_HOME/.git ] && git clone https://github.com/zdharma-continuum/zinit.git "$ZINIT_HOME"
source "${ZINIT_HOME}/zinit.zsh"

zinit light zsh-users/zsh-completions
zinit light zsh-users/zsh-autosuggestions
zinit light zsh-users/zsh-syntax-highlighting
zinit light Aloxaf/fzf-tab

autoload -Uz compinit && compinit
zinit cdreplay -q

zstyle ':completion:*' matcher-list 'm:{a-z}={A-Za-z}'
zstyle ':completion:*' menu no
zstyle ':fzf-tab:complete:cd:*' fzf-preview 'ls $realpath'
zstyle ':fzf-tab:complete:kill:*' fzf-preview 'ps --pid=$word -o cmd --no-header -w -w'

setopt appendhistory
setopt sharehistory
setopt hist_ignore_space
setopt hist_ignore_all_dups
setopt hist_save_no_dups

HISTSIZE=10000
SAVEHIST=10000
HISTFILE=~/.zsh_history

eval "$(fzf --zsh)"

bindkey '^I' vi-forward-word        # tab
bindkey '^@' fzf-tab-complete       # ctrl + space
```
`# exec zsh` reload zsh and then `# zinit zstatus` check status.

## Clean lazyvim
```
rm -rf ~/.local/share/nvim
rm -rf ~/.local/state/nvim
rm -rf ~/.cache/nvim

rm -rf ~/dotfiles/.config/nvim/lazy-lock.json
rm -rf ~/dotfiles/.config/nvim/lazyvim.json
```

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

## Create Arch Linux Shortcut 
shortcut > right-click > properties \
replace the `target` field with:
```
wt.exe -p "archlinux"
```


[ref1]: https://wiki.archlinux.org/title/Install_Arch_Linux_on_WSL
[ref2]: https://learn.microsoft.com/en-us/windows/wsl/install-manual
[ref3]: https://learn.microsoft.com/en-us/windows/wsl/install-manual#step-4---download-the-linux-kernel-update-package
[ref4]: https://github.com/ohmyzsh/ohmyzsh?tab=readme-ov-file#basic-installation
[ref5]: https://github.com/aloxaf/fzf-tab?tab=readme-ov-file#oh-my-zsh
[ref6]: https://github.com/kutsan/zsh-system-clipboard?tab=readme-ov-file#installation
[ref7]: https://github.com/zsh-users/zsh-syntax-highlighting/blob/master/INSTALL.md#oh-my-zsh
[zinit]: https://github.com/zdharma-continuum/zinit