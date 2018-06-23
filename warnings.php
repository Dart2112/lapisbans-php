<?php
include 'includes/head.php';
include 'includes/header.php';
include 'includes/MinecraftUUID.php'
?>
    <head>
        <title>Warnings - <?php echo $name; ?></title>
    </head>
<?php
// <<-----------------Database Connection------------>> //
require 'includes/data/database.php';
$sql = 'SELECT UUID, Reason, Warner, Expiry FROM Warns ORDER BY expires DESC LIMIT 20';
$retval = $conn->query($sql);
?>
    <body>
<div class="container content">
    <div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Warnings</h1>
        <table class="table table-hover table-bordered table-condensed">
            <thead>
            <tr>
                <th>
                    <center>Name</center>
                </th>
                <th>
                    <center>Warned By</center>
                </th>
                <th>
                    <center>Reason</center>
                </th>
                <th>
                    <center>Warned Until</center>
                </th>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = $retval->fetch_assoc()) {
                if ($row['Warner'] == "bccaa4aa-8083-3b76-8112-40a16447975f") {
                    $row['Warner'] = 'Console';
                } else {
                    $playerssql = 'SELECT UUID, Username FROM BanPlayers WHERE UUID = ' . $row['Warner'];
                    $playerdata = $conn->query($playerssql);
                    $row['Warner'] = $playerdata['Username'];
                }
                $playerssql = 'SELECT UUID, Username FROM BanPlayers WHERE UUID = ' . $row['UUID'];
                $playerdata = $conn->query($playerssql);
                $row['UUID'] = $playerdata['Username'];
                // <<-----------------Expiration Time Converter------------>> //
                $expiresEpoch = $row['Expiry'];
                $expiresConvert = $expiresEpoch / 1000;
                $expiresResult = date('F j, Y, g:i a', $expiresConvert);
                ?>
                <tr>
                    //https://minotar.net/avatar/username/25.png
                    <td><?php echo "<img src='https://minotar.net/avatar/" . $row['UUID'] . "/25.png' style='margin-bottom:5px;margin-right:5px;border-radius:2px;' />" . $row['UUID']; ?></td>
                    <td><?php echo "<img src='https://minotar.net/avatar/" . $row['Warner'] . "/25.png'  style='margin-bottom:5px;margin-right:5px;border-radius:2px;' />" . $row['Warner']; ?></td>
                    <td style="width: 30%;"><?php echo $row['reason']; ?></td>
                    <td><?php if ($row['Expiry'] == 0) {
                            echo 'Permanent Warning';
                        } else {
                            echo $expiresResult;
                        } ?></td>
                </tr>
            <?php }
            $conn->close();
            echo "</tbody></table>";
            ?>
    </div>
<?php include 'includes/footer.php'; ?>