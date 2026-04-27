# TMUX (terminal multiplexer)

---

## 1. Starting Tmux (In Terminal)
| Command | Description |
| :--- | :--- |
| `tmux` | Start a new session |
| `tmux new -s <name>` | Start a new session with a name |
| `tmux ls` | List all active sessions |
| `tmux attach -t <name>` | Reconnect to a specific session |
| `tmux kill-session -t <name>` | Delete a specific session |
| `exit` | Close the current session (when inside) |

---

## 2. The Prefix Key
By default, all tmux shortcuts must be preceded by the **Prefix**: 
**`Ctrl + b`** (Press together, then release, then press the command key).

---

## 3. Session Management
| Key Combo | Action |
| :--- | :--- |
| `Prefix + d` | **Detach**: Exit the session but keep it running in the background |
| `Prefix + s` | **Switch**: Interactive list of all sessions |
| `Prefix + $` | **Rename**: Rename the current session |

---

## 4. Window Management (Tabs)
| Key Combo | Action |
| :--- | :--- |
| `Prefix + c` | **Create**: Open a new window (tab) |
| `Prefix + n` | **Next**: Go to the next window |
| `Prefix + p` | **Previous**: Go to the previous window |
| `Prefix + w` | **Watch**: Interactive list of all windows and panes |
| `Prefix + ,` | **Rename**: Rename the current window |
| `Prefix + 0-9` | **Jump**: Go to a window by its number |
| `Prefix + &` | **Kill**: Close the current window |

---

## 5. Pane Management (Split Screens)
| Key Combo | Action |
| :--- | :--- |
| `Prefix + %` | **Vertical Split**: Divide screen into Left and Right |
| `Prefix + "` | **Horizontal Split**: Divide screen into Top and Bottom |
| `Prefix + o` | **Cycle**: Switch focus to the next pane |
| `Prefix + Arrow Keys` | **Move**: Switch focus using directions |
| `Prefix + x` | **Close**: Close the current pane |
| `Prefix + z` | **Zoom**: Toggle full-screen for the current pane |
| `Prefix + Space` | **Layout**: Toggle through different screen layouts |

---

## 6. Copy Mode (Scrolling)
| Key Combo | Action |
| :--- | :--- |
| `Prefix + [` | **Enter Copy Mode**: Allows you to scroll up the terminal history |
| `q` | **Quit**: Exit copy mode |

---

## 7. Customizing (Optional)
Create or edit the file `~/.tmux.conf` to add custom settings.
Example: To use **hjkl** for switching panes:
```tmux
bind h select-pane -L
bind j select-pane -D
bind k select-pane -U
bind l select-pane -R