EPSON Advanced Printer Driver for TM-T88IV ReStick Ver.4

                                     Copyright (c) 2009 SEIKO EPSON CORPORATION


1. About this software
This package includes the following two software programs to use with an EPSON 
TM-T88IV ReStick printer.

1) Windows Printer Driver
This driver is a Windows Printer Driver for the TM-T88IV ReStick printer. This driver makes 
it possible to print from a Windows application.

2) StatusAPI
StatusAPI is a program that works in conjunction with the TM-T88IV ReStick printer driver.  
It offers an Application Program Interface for obtaining the printer status 
whether or not the printer is printing.  This API makes integrating printer
status handling functions with applications more simple.

For detailed information, please see each reference manual.

The driver operation has been verified with the following operating systems. 

    Microsoft Windows XP Professional 32bit SP3 English
    Microsoft Windows Embedded Standerd 2009 32bit
    Microsoft Windows Embedded POSReady 2009 32bit
    Microsoft Windows Vista Ultimate 32bit SP1 English
    Microsoft Windows 2003 Server R2 Enterprise 32bit SP2 English
    Microsoft Windows 2008 Server Standard/DataCenter 32bit English
    Microsoft Windows Vista Ultimate 64bit SP1 English 
    Microsoft Windows Server 2003 R2 Standard 64bit SP2 English
    Microsoft Windows Server 2008 Standard 64bit English 

This driver is not supported by Windows 95/98/NT/2000 and Windows XP 64bit.

EPSON IM series PC or IBM compatible PC
 
Supported Printers
  EPSON TM-T88IV ReStick

The printer driver operates regardless of the pritner firmware version.

2. Supplied Files
   APD_407E_TM-T88IVReStick.zip	: Printer Driver,StatusAPI installer with manuals

Refer to the installation manual APD4_TM-T88IV ReStick_Install_E_RevA.pdf.

3. Remarks
- For detailed information, please read each manual that is created by the 
  installation.
-The printer did extra paper feed when the last data of the page is device 
 font at Paper Conservation is "None" setting.( For all receipt printer). 
 We corresponded this phenomenon.
-When an error message is displayed during installation, the following procedure may enable to recover from the error.
  1) Specify the uninstall option, and execute the installer "APD_407E_T88IVReStick.exe /uninstall".
  2) Remove the error factor.
  3) Execute the installer "APD_407E_T88IVReStick.exe".

-Characters may not be printed correctly when using Easy Print of Windows Server 2008. For detailed information of this problem arising from the operating system, see the following web page provided by Microsoft Corporation.
  http://support.microsoft.com/kb/946411/

-In the Easy Print environment of Windows Server 2008, you cannot print the printer device font directly. However, you can print the device font converted from the True Type font by using "Font Substitution" of APD. For more information, see "Character Printing (Device Font)" in Printer Manual.

-To set properties of the printer driver redirected on the server using Terminal Service or Remote Desktop on the printer driver on a client, go to [Detailed Setting] Tab, and press the [Detailed Setting] button.

-HELP is unavailable when using a printer driver redirected through the server using Terminal Service or Remote Desktop.

-When using Terminal Service and Remote Desktop, interactive communication becomes unavailable between the PC and the printer, prohibiting displaying the printer status and obtaining printer information using the Status API.

-The port redirection function is unavailable for a client when using Terminal Service or Remote Desktop.

-At times, the status of the shared printer may not be displayed correctly or the Status API may not be opened. These problems arise from the security policy settings of the operating system. Although changing the settings of the operating system is possible by the following steps, it lowers the security policy.
(1) Go to [Start] - [Administrative tool] - [Local Security Policy].
(2) [Security Option] - [Network Access (Set "Limit anonymous sccesses to the named pipe and shared printer" to "Invalid".)]
However, you do not have to change the settings when a client PC is connected to the domain environment and when the same user name as a user name that is logged on a client is existing."


4.Modification from the old version
  Ver4.07
      -Supports the following OS
          Microsoft Windows Embedded Standerd 2009 32bit
          Microsoft Windows Embedded POSReady 2009 32bit
          Microsoft Windows 2003 Server R2 Enterprise 32bit SP2 English
          Microsoft Windows 2008 Server Standard/DataCenter 32bit English
          Microsoft Windows Vista Ultimate (x64) SP1 English 
          Microsoft Windows Server 2003 R2 Standard (x64) SP2 English
          Microsoft Windows Server 2008 Standard (x64) English

      -The following problem has been resolved:
         -When the Protected Mode of the IE7 security settings is enabled (the lowest right), the StatusAPI displays an error dialogue.
         -Right after the print completion status is obtained, an error that executes BiDirectIO/BiDirectIOEx is returned
         -Even if an IP address is specified with the zp option during the silent installation, the setting is not reflected.
         -When two or more printers are silently installed, they are not installed with the correct port setting.

  Ver4.06a
      -The following device font properties of each printer have been changed.
         FontAxx
         FontBxx
         Barcodex
         2D-Codex
         Control
         ConrolA
         etc
      -An improvement to eliminate the need for rebooting the PC on the upgrade installation has been made.

   Ver4.06
      -New release. 
