# zip-compression-extraction
A PHP-based tool for compressing and extracting .zip files. This tool provides a simple web interface for zipping folders and unzipping .zip files, making it easy to manage compressed files directly through the browser.

# Features
• Compress to .zip: Select any folder to compress it into a .zip file.
• Extract .zip files: Extract the contents of any .zip file to a specified directory.
• User-friendly interface: Simple and intuitive design for easy usage, with success and error messages styled for quick identification.

# Requirements
• PHP 7.2+: The tool requires PHP 7.2 or later for optimal performance.
• Web Server: Can be hosted on any server with PHP support, such as Apache or Nginx.

# Installation
• Clone the repository:
  git clone https://github.com/thaihoa110/zip-compression-extraction.git

• Navigate to the project folder:
  cd zip-compression-extraction

• Place the project folder on your web server and ensure PHP is configured correctly.

Usage
• Open your web browser and navigate to the URL where the project is hosted (e.g., http://localhost/zip-compression-extraction/file_compress_extract.php).

• Use the interface to:
  - Enter the path of the folder you want to compress or the path of the .zip file you want to extract.
  - Choose the action (Compress or Extract).
  - View the success or error message upon completion.

# File Structure
• file_compress_extract.php: Main PHP file with form and logic for compression and extraction.
• assets/: Contains any CSS or JS files (if applicable).

# Examples
• Compress: Enter a folder path and select "Compress to ZIP" to create a .zip file of the folder.

• Extract: Provide a .zip file path and specify the destination folder, then select "Extract ZIP" to extract contents.
