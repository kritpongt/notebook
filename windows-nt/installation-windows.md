# Installation Windows OS

## Create owner partitions
`Shift + F10`
```
diskpart
list disk
select disk 0
clean
convert gpt

create partition efi size=1024          # EFI System
create partition msr size=16            # MSR
create partition primary size=205300    # Primary (200GB+500MB)
exit
exit
```

## Make Shared Data partition (Disk Management)
Prepare free space
1. Disk Management
2. Right-Click the **Unallocated** space and New Simple Volume...
3. Specify Volume Size
4. Assign the following drive letter: `X`
5. Format Partition
    - File system: NTFS
    - Allocation unit size: Default
    - Volume label: Workspace

## Turn off Fast Startup/Hibernation
1. Control Panel > Hardware and Sound > Power options
2. Choose what the power buttons do
3. Change settings that are currently unavailable
4. uncheck Turn on fast startup
5. uncheck Turn on hibernate
