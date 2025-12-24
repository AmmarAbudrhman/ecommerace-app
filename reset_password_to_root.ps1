# Check for Admin privileges
if (!([Security.Principal.WindowsPrincipal][Security.Principal.WindowsIdentity]::GetCurrent()).IsInRole([Security.Principal.WindowsBuiltInRole] "Administrator")) {
    Write-Host "Please run this script as Administrator!" -ForegroundColor Red
    Write-Host "Right-click this file and select 'Run with PowerShell' -> then accept the Admin prompt if asked."
    exit
}

$mysqlPath = "C:\Program Files\MySQL\MySQL Server 8.0\bin"
$serviceName = "MySQL95"

Write-Host "Stopping MySQL Service ($serviceName)..."
net stop $serviceName

Write-Host "Starting MySQL in skip-grant-tables mode..."
$proc = Start-Process -FilePath "$mysqlPath\mysqld.exe" -ArgumentList "--skip-grant-tables" -PassThru -WindowStyle Hidden
Start-Sleep -Seconds 10

Write-Host "Resetting root password to 'root'..."
& "$mysqlPath\mysql.exe" -u root -e "FLUSH PRIVILEGES; ALTER USER 'root'@'localhost' IDENTIFIED BY 'root'; FLUSH PRIVILEGES;"

Write-Host "Stopping temporary MySQL process..."
Stop-Process -Id $proc.Id -Force
Start-Sleep -Seconds 5

Write-Host "Restarting MySQL Service..."
net start $serviceName

Write-Host "Done! Your root password is now 'root'."
Write-Host "---------------------------------------------------"
Write-Host "Please check the output above for any red error messages."
Write-Host "If you see 'Access denied' or other errors, the reset failed."
Write-Host "---------------------------------------------------"
Read-Host -Prompt "Press Enter to close this window"
