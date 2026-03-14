# Installation Arch Linux

> Note: Arch Linux do not support Secure Boot.

> VMware: VM->Setting->Options->Advanced->Firmware type->`UEFI`.

## *1.* Virtual Console
- verify boot mode
    `# cat /sys/firmware/efi/fw_platform_size`
- connect to internet
    `# ip link`
    - wireless network
    `# iwctl`
    `# device list`
    `# station <name> get-networks`
    `# station <name> connect <ssid>`

    `# ping 8.8.8.8`
    - via ssh (optional) `# systemctl status sshd` `# ip addr show` set password `# passwd` connect from client `ssh root@<server_ip>`
- update system clock
    `# timedatectl`
    `# timedatectl set-timezone Asia/Bangkok`
- partition the disks
    - create
    `# lsblk` `# cfdisk /dev/<disk_name>` select `gpt`,
    create first one size 1GiB type as EFI System and then, create second one type as Linux filesystem, select `write` and then, `quit`.
    - disk encrypt `# cryptsetup luksFormat /dev/<root_partition>` `# cryptsetup luksOpen /dev/<root_partition> cryptroot`
    - format `# mkfs.fat -F 32 /dev/<efi_system_partition>`
    ~~`# mkfs.ext4 /dev/<root_partition>`~~ `# mkfs.btrfs /dev/mapper/crytproot`
    - mount ~~`# mount /dev/<root_partition> /mnt`~~

        ```
        # mount /dev/mapper/cryptroot /mnt
        # btrfs subvolume create /mnt/@
        # btrfs subvolume create /mnt/@home
        # umount /mnt
        # mount -o noatime,compress=zstd,ssd,discard=async,subvol=@ /dev/mapper/cryptroot /mnt
        # mkdir -p /mnt/home
        # mount -o noatime,compress=zstd,ssd,discard=async,subvol=@home /dev/mapper/cryptroot /mnt/home
        ```
        `# mount --mkdir /dev/<efi_system_partition> /mnt/boot`
- installation
    ~~`# archinstall`~~
    - ~~disk configuration->partitioning->pre-mounted configuration and then type, `/mnt`~~
    - ~~bootloader->systemd-boot~~
    - ~~profile->minimal~~
    - ~~audio->pipewire~~
    - ~~network configuration->use NetworkManager~~
    ```
    # pacstrap -K /mnt base linux linux-firmware
    # genfstab -U /mnt >> /mnt/etc/fstab
    # arch-chroot /mnt
    ```
- arch-chroot
    > live-usb: ~~`# mount /dev/<root_partition> /mnt` `# mount /dev/<efi_system_partition> /mnt/boot`~~
    `# cryptsetup open <root_partition> cryptroot` `# mount -o subvol=@ /dev/mapper/cryptroot /mnt` `# mount <efi_system_partition> /mnt/boot` and then, `# arch-chroot /mnt`
    - localization edit `/etc/locale.gen` and then, uncomment `en_US.UTF-8 UTF-8`
        ```
        # locale-gen
        # echo "LANG=en_US.UTF-8" >> /etc/locale.conf
        # echo "KEYMAP=us" >> /etc/vconsole.conf
        ```
    - hostname `echo "<hostname>" >> /etc/hostname` set root password `# passwd`
    - user `# useradd -m -G wheel <user_name>` set password `# passwd <user_name>` enable user sudo `# EDITOR=nvim visudo` uncomment `%wheel ALL=(ALL:ALL) ALL`
    - initramfs add `encrypt` between `block` and `filesystems` to the `HOOK=(...)` in `/etc/mkinitcpio.conf` and then, `# mkinitcpio -P`
    - install packages
        ```
        # pacman -S base-devel pipewire networkmanager intel-ucode grub efibootmgr
        ```
    - grub config `# grub-install --target=x86_64-efi --efi-directory=/boot --bootloader-id=GRUB`

        add the following to the `GRUB_CMDLINE_LINUX_DEFAULT` in `/etc/default/grub` (find UUID `# blkid <root_partition>`)
        ```
        cryptdevice=UUID=<uuid>:cryptroot root=/dev/mapper/cryptroot
        ```

        add windows boot to list, place the following in `/etc/grub.d/40_custom` (find UUID vfat ESP) and update config file `# grub-mkconfig -o /boot/grub/grub.cfg`
        ```
        menuentry "Windows 11"{
            insmod part_gpt
            insmod fat
            search --no-floppy --fs-uuid --set=root <uuid>
            chainloader /EFI/Microsoft/Boot/bootmgfw.efi
        }
        ```
    > check: `# efibootmgr`, check file `/boot/EFI/GRUB/grubx64.efi`, check file `/boot/grub/grub.cfg`, check UUID `/etc/fstab` file.

    `# exit` `# umount -R /mnt` `# reboot`
- session env root
    `# sudo su -`
- remove package
    `# sudo pacman -Rns <package_name>`

## *2.* Install zsh
> current shell: `# echo $SHELL`

`# pacman -S zsh zsh-completions`
- `# zsh` press (1)
- configure settings for history press (1) (3) set SAVEHIST and then, (0)
- new completion system press (2) and then, (1)
- editing configuration press (3) (1) (v) for Vi keymap and then, (0)
- exit and saving press (0)

changing default shell
1. shell list `# chsh -l`
2. set `# chsh -s $(which zsh)` (`# chsh -s /usr/bin/zsh` if got an error)
> switch back to `bash`: `# chsh -s /usr/bin/bash`

configure prompt place the following in `~/.zshrc`
```
export PS1='%~ %# '
```

## *3.* Install DE/WM
`# pacman -S xorg xorg-xinit i3-wm`

### *3.1* xinitrc configuration
`# cp /etc/X11/xinit/xinitrc ~/.xinitrc` and then add an `exec i3`

### *3.2* autostart x
place the following in login shell initialization file (e.g. `~/.zprofile` for zsh)
```
# autostart x
if [ -z "$DISPLAY" ] && [ "$XDG_VTNR" = 1 ]; then
    exec startx
fi
```

### *3.3* file manager
`# pacman -S thunar`
### *3.4* launcher
`# pacman -S rofi`

### *3.5* display setup
`# pacman -S xrandr`

`# pacman -S feh` and then, place the following in `~/.config/i3/config`
```
# disable titlebar
for_window [class="^.*"] border pixel 2

# gaps inner/outer
gaps inner 2
gaps outer 2

# wallpaper
exec_always feh --bg-fill <path_to_image>
```

`# pacman -S picom` and then, place the following in `~/.config/i3/config`
```
# compositor
exec_always picom -f
```

### *3.6* terminal emulator
`# pacman -S alacritty` alacritty setup config, `# mkdir -p ~/.config/alacritty` and then, `# nvim ~/.config/alacritty/alacritty.toml`
```
[window]
opacity = 0.8
```

### *3.7* status bar
`# pacman -S polybar` setup, `# mkdir -p ~/.config/polybar` `# cp /etc/polybar/config.ini ~/.config/polybar`

and edit `~/.config/polybar/config.ini` change `[bar/...]` to `[bar/bar1]`

create a launch file `# nvim ~/.config/polybar/launch.sh` and then place the following
```
#!/bin/bash

# Terminate already running bar instances
# If all your bars have ipc enabled, you can use:
polyabr-msg cmd quit
# Otherwise you can use the nuclear option:
# killall -q polybar

# Launch polybar, using default config location ~/.config/polybar/config.ini
polybar bar1 2>&1 | tee -a /tmp/polybar1.log & disown
echo "polybar launched.."
```

make executable `# chmod +x ~/.config/polybar/launch.sh`

place the following and remove `bar{...}` in `~/.config/i3/config`
```
# polybar
exec_always --no-startup-id /home/<user>/.config/polybar/launch.sh
```

## *4.* Install AUR Helper

```
# pacman -S --needed base-devel git
# mkdir ~/aur && cd ~/aur
# git clone https://aur.archlinux.org/yay.git
# cd yay && makepkg -si
```

## *5.* Bluetooth
```
# pacman -S bluez bluez-utils blueman
# systemctl enable bluetooth
```

## *6.* Battery Consumption
```
# pacman -S tlp tlp-rdw powertop acpi
# systemctl enable tlp
# systemctl enable tlp-sleep
# systemctl mask systemd-rfkill.service
# systemctl mask systemd-rfkill.socket
```

## *7.* Connect Wifi (NetworkManager)
```
# systemctl enable NetworkManager --now
# nmcli device wifi list
# nmcli device wifi connect "<ssid>" password "<password>"
```

## *8.* OpenSSH
```
# pacman -S openssh
# systmectl enable sshd
```

## *9.* TigerVNC
`# pacman -S tigervnc`
- set password `# vncpasswd` and then, set file permission `# chmod 600 ~/.config/tigervnc/passwd`
- place the following in `/etc/tigervnc/vncserver.users`
    ```
    :1:<user>
    ```
- create `~/.config/tigervnc/config` and place the following
    ```
    session=lxqt
    geometry=1920x1080
    localhost
    alwaysshared
    ```
- `# systemctl start vncserver@:1`

> service status: `# systemctl status vncserver@:1.service`

on client
1. `# ssh -L 5901:localhost:5901 <user>@<ip_server>`
2. open vncviewer and then, connect to `localhost:1`

> ref:  installation1 https://gist.github.com/fjpalacios/441f2f6d27f25ee238b9bfcb068865db,
        installation2 https://github.com/radleylewis/arch_installation_guide,

## Commands
- Install Package: `pacman -Syu <package>` (do not `-Sy`)
- Remove: `pacman -Rns <package>`
- Error corrupted package: `pacman -Scc` and then `pacman -Syu`
- Shutdown: `shutdown now`
## Shortcut
- Switch to a TTY: `ctrl` + `alt` + `f2` (or FN + f2)
- Close i3-wm: `mod` + `shift` + `e`