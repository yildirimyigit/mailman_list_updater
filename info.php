<?php
/***************************************
 *** author: yigit.yildirim@boun.edu.tr
 ***************************************/

session_start();
if(!isset($_SESSION['login'])) {
    header('LOCATION:index.php'); die();
}

$command = escapeshellcmd('/var/www/html/panel/lists');
$output = shell_exec("python " .$command);
//echo $output;
//$lists=preg_split('/\s+/', trim($output));

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <title>Bulk Update Page</title>
</head>
<body>
    <div id="logo"><img src="image/logo.jpg" alt="logo" width="100%"/></div>
    <div id="content" align="center">
        <h3>Choose the list and upload the student list document</h3>
        <br/><br/><br/><br/>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <table>
                <tbody>
                    <tr>
                        <td style="text-align: left; vertical-align: middle;">&nbsp;<b>List</b>:</td>
                        <td>
                            <select name="list" id="list" required>
                                <option selected="selected">Choose a list</option>
                                <?php
                                $lists =["a","b","c"];  // TODO: delete, this is just for the local setup
                                foreach($lists as $item){
                                ?>
                                <option value="<?php echo strtolower($item); ?>"><?php echo $item; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: left; vertical-align: middle;">&nbsp;<b>Upload</b>:</td>
                        <td><input type="file" name="fileToUpload" id="fileToUpload"></td>
                    </tr>
                </tbody>
            </table>
            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>