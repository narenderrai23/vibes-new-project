# GitHub SSH Setup Commands

This project is connected to:

```text
git@github.com-narenderrai23:narenderrai23/vibes-new-project.git
```

## 1. Create SSH Key

```powershell
ssh-keygen --% -t ed25519 -C 82692721+narenderrai23@users.noreply.github.com -f C:\Users\Mahadev\.ssh\id_ed25519_narenderrai23 -N ""
```

## 2. SSH Config

File:

```text
C:\Users\Mahadev\.ssh\config
```

Config:

```sshconfig
Host github.com-narenderrai23
  HostName github.com
  User git
  IdentityFile ~/.ssh/id_ed25519_narenderrai23
  IdentitiesOnly yes
```

## 3. Add Public Key To GitHub

Copy the public key:

```powershell
Get-Content $HOME\.ssh\id_ed25519_narenderrai23.pub | Set-Clipboard
```

Open GitHub SSH keys settings:

```text
https://github.com/settings/keys
```

Title:

```text
Mahadev Windows narenderrai23
```

Key:

```text
ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAICFj/xOZVvmiDdOZFIUXQax2frS9MdlNIwBNVH3IEXpl 82692721+narenderrai23@users.noreply.github.com
```

## 4. Test SSH Login

```powershell
ssh -T git@github.com-narenderrai23
```

Expected response:

```text
Hi narenderrai23! You've successfully authenticated, but GitHub does not provide shell access.
```

## 5. Set Git Remote

```powershell
cd C:\php-xampp\htdocs\laravel-starter
git remote set-url origin git@github.com-narenderrai23:narenderrai23/vibes-new-project.git
```

## 6. Push Main Branch

```powershell
git push -u origin main
```

## Useful Checks

Check current remote:

```powershell
git remote -v
```

Check Git user:

```powershell
git config --global --get user.name
git config --global --get user.email
```
