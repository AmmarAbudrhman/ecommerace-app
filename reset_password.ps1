# Check for Admin privileges
if (!([Security.Principal.WindowsPrincipal][Security.Principal.WindowsIdentity]::GetCurrent()).IsInRole([Security.Principal.WindowsBuiltInRole] "Administrator")) {
    Write-Host "Please run this script as Administrator!" -ForegroundColor Red
    Write-Host "Right-click this file and select 'Run with PowerShell' -> then accept the Admin prompt if asked, or open PowerShell as Admin and run this script."
    exit
}

$mysqlPath = "C:\Program Files\MySQL\MySQL Server 8.0\bin"
$serviceName = "MySQL95"

Write-Host "Stopping MySQL Service ($serviceName)..."
net stop $serviceName

Write-Host "Starting MySQL in skip-grant-tables mode..."
# We start it and keep the handle
$proc = Start-Process -FilePath "$mysqlPath\mysqld.exe" -ArgumentList "--skip-grant-tables" -PassThru -WindowStyle Hidden

# Wait for it to start
Start-Sleep -Seconds 10

Write-Host "Resetting root password to empty..."
# Try the modern way (MySQL 5.7+)
& "$mysqlPath\mysql.exe" -u root -e "FLUSH PRIVILEGES; ALTER USER 'root'@'localhost' IDENTIFIED BY ''; FLUSH PRIVILEGES;"

# If that failed, try the old way (just in case, though 8.0 shouldn't need it)
# & "$mysqlPath\mysql.exe" -u root -e "FLUSH PRIVILEGES; UPDATE mysql.user SET authentication_string='' WHERE User='root'; FLUSH PRIVILEGES;"

Write-Host "Stopping temporary MySQL process..."
Stop-Process -Id $proc.Id -Force

Start-Sleep -Seconds 5

Write-Host "Restarting MySQL Service..."
net start $serviceName

Write-Host "Done! Your root password is now empty."
Write-Host "You can now use DB_PASSWORD= in your .env file."
Read-Host -Prompt "Press Enter to exit"
