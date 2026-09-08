$directories = @("c:\Users\aqila\Documents\ict_careline_center")
$excludeFolders = @(".git", "vendor", "node_modules", "api")

function Process-Directory {
    param ($Path)
    $items = Get-ChildItem -Path $Path -Force
    
    foreach ($item in $items) {
        if ($item.PSIsContainer) {
            if ($excludeFolders -notcontains $item.Name) {
                Process-Directory -Path $item.FullName
            }
        } else {
            if ($item.Extension -in ".php", ".js") {
                $content = Get-Content -Path $item.FullName -Raw
                if ($content -match "\.\./api/admin_" -or $content -match "\.\./api/staff_") {
                    $newContent = $content -replace "\.\./api/admin_", "../api/admin/admin_"
                    $newContent = $newContent -replace "\.\./api/staff_", "../api/staff/staff_"
                    Set-Content -Path $item.FullName -Value $newContent -Encoding UTF8
                    Write-Host "Updated $($item.FullName)"
                }
            }
        }
    }
}

Process-Directory -Path $directories[0]
Write-Host "Done."
