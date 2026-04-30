# Git commands

### Move/Rename file
```
git mv <file_target> <file_destination>
git status
git commit -m "move .. to .."
```

### Delete file
```
# file
git rm <file>

# cache(index)
git rm --cache <file>
```
`-r` remove folder \
and then `git commit -m "delete unnecessary files"`

### Fetch ignore local branch
Safety:
```
git chectout origin/main -- <file_local>
git pull origin main
```

All files:
```
git fetch origin main
git reset --hard origin/main
```

### Reset (backward 1 commit)
Safety:
```
git reset --soft HEAD~1
```
Hard Reset:
```
git reset --hard HEAD~1
```

## Remove index
```
```

## Commit guidelines
bug: `fix(<scope>):` \
optimize: `refactor(<scope>):` \
conventional: `chore: ..cleanup` \
add new config: `conf(<scope>):` \
undo: `re-commit`

## git ignore global
1. create file `.gitignore_global`
2. `git config --global core.excludesfile <gitignore_path>`

## SSH key
Run as administrator \
list:
```
ls $HOME\.ssh\
```

add key:
```
cd $HOME\.ssh

ssh-keygen -t ed25519 -C "<email>"
```

enable service, add key into file:
```
Start-Service ssh-agent

ssh-add $HOME\.ssh\id_ed25519_personal
```
> Note: `Set-Service -Name ssh-agent -StartupType Manual` to enable service

copy to github:
```
cat $HOME\.ssh\id_ed25519_personal.pub
```
GitHub > Setting > SSH and GPG Key > New SSH key

config:
```
code $HOME\.ssh\config
```
add the following:
```
Host github.com
  HostName github.com
  User git
  IdentityFile ~/.ssh/id_ed25519_personal
```

test:
```
ssh -T git@github.com
```