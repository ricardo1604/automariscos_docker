$folderPath = "E:\wamp64\www\automariscos\impresiones"
$targetPath = "E:\wamp64\www\automariscos\impresiones\impresos"
$printerName = "AUTOP2"

# Get a list of Word documents in the folder
$wordFiles = Get-ChildItem -Path $folderPath -Filter *.docx

$wordApp = New-Object -ComObject Word.Application

# Set the active printer to the specified printer name
$wordApp.ActivePrinter = $printerName

foreach ($file in $wordFiles) {
    Write-Host "Printing: $($file.Name)"
    
    $doc = $wordApp.Documents.Open($file.FullName)
    
    # Set the page layout options
    $doc.PageSetup.PageWidth = 226.772  # 80mm converted to points
    $doc.PageSetup.PageHeight = 841.890  # 297mm converted to points
    $doc.PageSetup.LeftMargin = 18.0  # 0.25 inch converted to points
    $doc.PageSetup.RightMargin = 36.0  # 0.5 inch converted to points
    
    # Print the document
    $doc.PrintOut()
    
    # Wait for the print job to complete (adjust the sleep time as needed)
    Start-Sleep -Seconds 3
    
    $doc.Close()

    # Move the file to the target directory
    $targetFilePath = Join-Path -Path $targetPath -ChildPath $file.Name
    Move-Item -Path $file.FullName -Destination $targetFilePath
}

$wordApp.Quit()
