<!DOCTYPE html>

<html>
<head>
<title>Zip It! File Zipper</title>
<link rel="STYLESHEET" type="text/css" href="zip-it.css">
</head>

<body class="zipItOutput">

<?php
// ---------------------------
// Zip-It! v1.1.0 by Matt Pass
// ---------------------------

// Folder name we'll save the zips into
$zipItSaveLocation = 'zips/';

// Here we're creating a zip filename based a date time stamp plus a random number
// You'll probably want something unique, but more useful in your project, like a URN.
$zipItFileName = time().rand(1,1000).'.zip';

// Start a class
Class zipIt {

	// Function to create a zip file with the user selected files
	public function zipFilesUp($zipName='',$overwriteZip=true) {

		// Incase the zip file exists already and we don't want to overwrite it, return
		if(file_exists($zipName) && !$overwriteZip) {return false;}

		// Otherwise, start to grab the user selected files from POST'ed variables and put them into an array
		$zipFiles = array();
		foreach($_POST as $formRef => $addItem) {

			// find all form fields we're due to zip up as well as protect from malicious references
			if (strpos($formRef,"zipIt") == 1 && strpos($addItem,"..") === false && strpos($addItem,"./") === false && strpos($addItem,"/") != 0 && strpos($addItem,".php") === false) {

				// If we're due to add this as an folder in the zip and it does exist as a folder
				if (substr($addItem, -1) == '/' && is_dir($addItem)) {
			
					// Start an array with our folder as the start
					$dirStack = array($addItem);

					// For as long as our array isn't empty
					while (!empty($dirStack)) {
					
						// Establish the current folder
						$currentDir = array_pop($dirStack);
						$dir = dir($currentDir);

						// For all the items in that folder
						while (false !== ($node = $dir->read())) {
							// If it's this folder or the parent folder, escape loop
							if (($node == '.') || ($node == '..')) { 
								continue; 
							}
							// If it's a real folder we're looking at, add that to our array to be scanned too
							if (is_dir($currentDir . $node)) { 
								array_push($dirStack, $currentDir . $node . '/'); 
							}
							// If it's a file though, add it to our list to be zipped
							if (is_file($currentDir . $node)) { 
							// echo $currentDir. $node."<br><br>";
								$zipFiles[] = $currentDir. $node;
							} 
						}  
					}
				// Otherwise, it's a single file we're looking for
				} else {
					// Only add the files the user has selected that actually exist
					if(strpos($formRef,"zipIt") == 1 && file_exists($addItem)) {
						$zipFiles[] = $addItem;
					}
				}
			}
    		}

		// OK, if we've added at least one file in our files array
		if(count($zipFiles)) {

			// Let the user know we're now adding files to their zip
			echo "<b>Adding " .count($zipFiles). " files to your zip.<br>";
			echo "Please wait...</b><br><br>";
	
			// Begin to create the new zip archive file
			$zip = new ZipArchive();

			// Return if we have a problem creating/overwriting our zip
	    		if($zip->open($zipName,$overwriteZip ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
				return false;
			}

			// Otherwise, we're OK to add those files to the zip, so do that
			foreach($zipFiles as $file) {
				$zip->addFile($file,$file);
			}

			// Finally, close the zip file
			$zip->close();

			// Inform the user we've created the zip and provide the link
			echo "<span class='zipItOutput zipItNoMargin'><b>Zip created!<br>";
			echo 'Download here:</b></span><br><br><a href="zip-it-download-zip.php?zipFile='.$zipName.'"><b>Zip File</b></a>';

			// We've been successful, so return with a positive response
			return file_exists($zipName);

		} else {
		// If we had 0 files, return
		return false;
		}
	}
}

// Trigger the function with the zip output name and add a file overwrite param (optional extra) if you wish
$zipItDoZip = new zipIt();
$zipItAddToZip = $zipItDoZip->zipFilesUp($zipItSaveLocation.$zipItFileName);

// If creating the zip failed in any way, report an error
if ($zipItAddToZip != 1) {
	echo "<span style='color: red'><b>Sorry, zip creation failed.</b></span><br><br>"
	."<span class='zipItOutput zipItNoMargin'><b>This may possibly because you've not specified any files to add to the zip, "
	."the zip file exists and you don't want to overwrite it, or perhaps you wish to overwrite the zip and can't.</b></span>";

}
?>

</body>

</html>