# Git commands

### Move/Rename file
```
git mv <file_target> <file_destination>
git status
git commit -m "move .. to .."
```

### Delete file
File:
```
git rm <file>
```
Folder:
```
git rm -r <folder>
```
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

## Commit guidelines
bug: `fix(<scope>):` \
optimize: `refactor(<scope>):` \
conventional: `chore: ..cleanup` \
add new config: `conf(<scope>):` \
undo: `re-commit`