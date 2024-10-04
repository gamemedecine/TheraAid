<?php
include("databse.php");

$var_notif ="SELECT * FROM tbl_notifications WHERE user_id=30";
$var_qry = mysqli_query($var_conn,$var_notif);

?>
<html>
    <head>
        <title>Notification</title>
    </head>
    <body>
        <table style="border:1px solid black;border-collapse:collapse">
            <tr>
                <th>Notification</th>
            </tr>
            
            <?php
                while($var_rec= mysqli_fetch_array($var_qry)){
                    ?>
                    <tr>
                    <td style="border: 1px solid black;">
                        <?php echo "<button onclick=\"window.location.href='TherapistsAppointment.php';\">"
                        .$var_rec["type"]."</button>";?>
                    </tr>
                    <?php
                }
            ?>
          
        </table>
    </body>
</html>