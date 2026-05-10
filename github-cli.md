## Github CLI

### Installation
winget: \
`winget install --id GitHub.cli`

> *upgrade: `winget upgrade --id GitHub.cli`*

### Login
`gh auth login`

### Switch user
status: \
`gh auth status`

switch: \
`gh auth switch`

### Set credential helper
`gh auth setup-git`

check: \
`git config --system --get-all credential.helper` \
`git config --global --get-all credential.helper`