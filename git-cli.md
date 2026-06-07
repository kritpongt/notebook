## Git CLI

### Set user/email (local)
```
git config user.name "<user>"
git config user.email "<email>"
```
*`git config user.name` check user*

### Move/Rename file
`git mv <file_target> <file_destination>`

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

### Remove index

### Worktree

### Fast forward merge
branch `feat/<feature_name>` -> `dev`
- `git checkout dev`
- `git pull --ff-only origin dev`
- `git merge --ff-only feat/<feature_name>`
- `git log --oneline -5`

---

## Commit guidelines
bug: `fix(<scope>):` \
optimize: `refactor(<scope>):` \
conventional: `chore: ..cleanup` \
add new config: `conf(<scope>):` \
undo: `re-commit`

## git ignore global
1. create file `.gitignore_global`
2. `git config --global core.excludesfile <gitignore_path>`

## Git LFS
`scoop install git-lfs`
```
git lfs install
git add .gitattributes
git add <files>

git lfs ls-files
git lfs push --all origin
```