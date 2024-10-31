<?php
$message = '';
$messageClass = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handling compress
    if (isset($_POST['compress'])) {
        $folderPath = $_POST['folderPath'];
        $zipPath = $_POST['zipPath'] ?: 'compressed_folder.zip';

        list($message, $messageClass) = zipFolder($folderPath, $zipPath);
    }

    // Handling extract
    if (isset($_POST['extract'])) {
        $zipPath = $_POST['zipPathExtract'];
        $extractPath = $_POST['extractPath'] ?: './';

        list($message, $messageClass) = extractZip($zipPath, $extractPath);
    }
}

function zipFolder($folderPath, $zipPath) {
    if (!is_dir($folderPath)) {
        return ["The folder does not exist.", "error"];
    }

    $zip = new ZipArchive();
    if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
        $folderPath = realpath($folderPath);
        $folderName = basename($folderPath);

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($folderPath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = $folderName . '/' . substr($filePath, strlen($folderPath) + 1);
                $zip->addFile($filePath, $relativePath);
            }
        }

        $zip->close();
        return ["Successfully compressed to: <a href='$zipPath' download>$zipPath</a>", "success"];
    } else {
        return ["Unable to create zip file.", "error"];
    }
}

function extractZip($zipPath, $extractPath) {
    if (!file_exists($zipPath)) {
        return ["The zip file does not exist.", "error"];
    }

    $zip = new ZipArchive();
    if ($zip->open($zipPath) === TRUE) {
        $zip->extractTo($extractPath);
        $zip->close();
        return ["Successfully extracted to: <a href='$extractPath' download>$extractPath</a>", "success"];
    } else {
        return ["Unable to extract zip file.", "error"];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zip File Tool</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            width: 800px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
        }

        .section {
            width: 48%;
        }

        h2 {
            color: #333;
            text-align: center;
        }

        label {
            display: block;
            font-weight: bold;
            margin: 10px 0 5px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .message {
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            text-align: center;
        }

        .message.success {
            background-color: #dff0d8;
            color: #3c763d;
        }

        .message.error {
            background-color: #f2dede;
            color: #a94442;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="section">
            <h2>Compress Folder to ZIP</h2>

            <?php if ($message && isset($_POST['compress'])): ?>
                <div class="message <?php echo $messageClass; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <label for="folderPath">Folder Path:</label>
                <input type="text" id="folderPath" name="folderPath" required>

                <label for="zipPath">ZIP File Name (optional):</label>
                <input type="text" id="zipPath" name="zipPath" placeholder="compressed_folder.zip">

                <button type="submit" name="compress">Compress Folder</button>
            </form>
        </div>

        <div class="section">
            <h2>Extract ZIP File</h2>

            <?php if ($message && isset($_POST['extract'])): ?>
                <div class="message <?php echo $messageClass; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <label for="zipPathExtract">ZIP File Path:</label>
                <input type="text" id="zipPathExtract" name="zipPathExtract" required>

                <label for="extractPath">Extract To (optional):</label>
                <input type="text" id="extractPath" name="extractPath" placeholder="./">

                <button type="submit" name="extract">Extract ZIP</button>
            </form>
        </div>
    </div>
</body>
</html>
