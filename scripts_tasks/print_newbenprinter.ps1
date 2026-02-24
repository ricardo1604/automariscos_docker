$folderPath = "E:\wamp64\www\automariscos\impresiones"
$targetPath = "E:\wamp64\www\automariscos\impresiones\impresos"
$printerName = "AUTOP2"

# Get a list of Word documents in the folder
# $wordFiles = Get-ChildItem -Path $folderPath -Filter *.docx

# Get a list of Word documents in the folder starting with "precuenta_"
$wordFiles = Get-ChildItem -Path $folderPath -Filter precuenta_*.docx


$wordApp = New-Object -ComObject Word.Application

foreach ($file in $wordFiles) {
    Write-Host "Processing: $($file.Name)"
    
    # Open the Word document
    $doc = $wordApp.Documents.Open($file.FullName)
    
    # Set the page layout options
    $doc.PageSetup.PageWidth = 226.772  # 80mm converted to points
    $doc.PageSetup.PageHeight = 841.890  # 297mm converted to points
    $doc.PageSetup.LeftMargin = 18.0  # 0.25 inch converted to points
    $doc.PageSetup.RightMargin = 36.0  # 0.5 inch converted to points
    $doc.PageSetup.TopMargin = 5.0  # Adjust as needed
    
    # Save the Word document as PDF
    $pdfPath = [System.IO.Path]::ChangeExtension($file.FullName, 'pdf')
    $refPdfPath = [ref]$pdfPath
    $doc.SaveAs($refPdfPath, [ref][Microsoft.Office.Interop.Word.WdSaveFormat]::wdFormatPDF)

    
    # Close the Word document
    $doc.Close()
    
    # Print the PDF
    # Start-Process -FilePath $pdfPath -Verb Print
    Start-Process -FilePath $pdfPath -Verb Print -ArgumentList "/P:$printerName"
    
    # Wait for the print job to complete (adjust the sleep time as needed)
    Start-Sleep -Seconds 5
    
    # Delete the PDF file
    Remove-Item -Path $pdfPath -Force
    
    # Move the Word file to the target directory
    $targetFilePath = Join-Path -Path $targetPath -ChildPath $file.Name
    Move-Item -Path $file.FullName -Destination $targetFilePath
}

$wordApp.Quit()
