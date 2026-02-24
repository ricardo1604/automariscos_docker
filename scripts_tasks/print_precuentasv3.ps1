$folderPath = "D:\wamp64\www\automariscos\impresiones"
$targetPath = "D:\wamp64\www\automariscos\impresiones\impresos"
$area = "precuenta"
$mysqlServer = "automariscos"
$mysqlUser = "root"
$mysqlPassword = "root"

# Load MySQL.Data assembly
Add-Type -Path "C:\Program Files (x86)\MySQL\MySQL Connector NET 8.1.0\MySql.Data.dll"

# Set up MySQL connection
$connectionString = "server=$mysqlServer;user=$mysqlUser;password=$mysqlPassword;database=your_database_name;"
$mysqlConnection = New-Object MySql.Data.MySqlClient.MySqlConnection
$mysqlConnection.ConnectionString = $connectionString

# Open the connection
$mysqlConnection.Open()

# Query the printers table to get the printer name
$query = "SELECT nombre FROM printers WHERE area = @area"
$command = $mysqlConnection.CreateCommand()
$command.CommandText = $query
$command.Parameters.AddWithValue("@area", $area)
$printerName = $command.ExecuteScalar()

# Close the connection
$mysqlConnection.Close()

# Continue with the rest of your script
$wordFiles = Get-ChildItem -Path $folderPath -Filter *.docx
$wordApp = New-Object -ComObject Word.Application

foreach ($file in $wordFiles) {
    Write-Host "Printing: $($file.Name)"
    
    $doc = $wordApp.Documents.Open($file.FullName)
    
    # Set the page layout options
    $doc.PageSetup.PageWidth = 226.772  # 80mm converted to points
    $doc.PageSetup.PageHeight = 841.890  # 297mm converted to points
    $doc.PageSetup.LeftMargin = 18.0  # 0.25 inch converted to points
    $doc.PageSetup.RightMargin = 36.0  # 0.5 inch converted to points
    
    # Set the paper type
    $doc.PageSetup.PaperSize = [Microsoft.Office.Interop.Word.WdPaperSize]::wdPaperUser
    $doc.PageSetup.UserPaperSize = $true
    $doc.PageSetup.PageWidth = 226.772  # 80mm converted to points
    $doc.PageSetup.PageHeight = 841.890  # 297mm converted to points
    
    # Print the document with the retrieved printer name
    $doc.PrintOut([Type]::Missing, [Type]::Missing, [Type]::Missing, [Type]::Missing, $printerName)
    
    # Wait for the print job to complete (adjust the sleep time as needed)
    Start-Sleep -Seconds 10
    
    $doc.Close()

    # Move the file to the target directory
    $targetFilePath = Join-Path -Path $targetPath -ChildPath $file.Name
    Move-Item -Path $file.FullName -Destination $targetFilePath
}

$wordApp.Quit()
