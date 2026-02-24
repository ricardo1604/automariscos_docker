$folderPath = "D:\wamp64\www\automariscos\impresiones"
$printerName = "EPSONP1"
$mysqlServer = "localhost"
$mysqlDatabase = "automariscos"
$mysqlUser = "root"
$mysqlPassword = "root"

# Load MySQL Assembly
Add-Type -Path "C:\Program Files (x86)\MySQL\MySQL Connector NET 8.1.0\MySQL.Data.dll"

# Get a list of Word documents in the folder
$wordFiles = Get-ChildItem -Path $folderPath -Filter *.docx

$wordApp = New-Object -ComObject Word.Application

$mysqlConnectionString = "Server=$mysqlServer;Database=$mysqlDatabase;Uid=$mysqlUser;Pwd=$mysqlPassword;"
$mysqlConnection = New-Object MySql.Data.MySqlClient.MySqlConnection($mysqlConnectionString)
$mysqlConnection.Open()

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
    
    # Print the document
    $doc.PrintOut()
    
    # Wait for the print job to complete (adjust the sleep time as needed)
    Start-Sleep -Seconds 10
    
    $doc.Close()

    # Update MySQL database
    $docFileName = $file.Name
    $orderNumber = [regex]::Match($docFileName, '_(\d+)\.docx').Groups[1].Value
    
    $updateQuery = "UPDATE historial_impresiones SET estado = 'impreso' WHERE orden = '$orderNumber'"
    $mysqlCommand = New-Object MySql.Data.MySqlClient.MySqlCommand($updateQuery, $mysqlConnection)
    $mysqlCommand.ExecuteNonQuery()

    # Delete the file
    Remove-Item -Path $file.FullName
}

$mysqlConnection.Close()
$wordApp.Quit()
