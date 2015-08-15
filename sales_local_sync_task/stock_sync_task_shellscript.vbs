Set WinScriptHost = CreateObject("WScript.Shell")
WinScriptHost.Run Chr(34) & "C:\xampp\htdocs\sample_sales_local_sync_task\stock_sync_task_script.bat" & Chr(34), 0
Set WinScriptHost = Nothing