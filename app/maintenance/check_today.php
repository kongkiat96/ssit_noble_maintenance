<?php
session_start();
error_reporting(0);
require("../../core/config.core.php");
require("../../core/connect.core.php");
require("../../core/functions.core.php");
$getdata = new clear_db();
$connect = $getdata->my_sql_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
mysqli_set_charset($connect, "utf8");

$show_case = $getdata->my_sql_query($connect, null, "building_list", "date_update ='" . htmlspecialchars($_GET['key']) . "'");
?>
<div class="modal-header">
    <h5 class="modal-title font-weight-bold"> วันที่ <u><?php echo @dateConvertor(date("Y-m-d")); ?></u></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="form-group">
        <table class="table table-bordered table-hover text-center" width="100%" id="dataTablesFixwidht">
            <thead class="table-info text-center font-weight-bold">
                <tr>
                    <td>#</td>
                    <td>Ticket</td>
                    <td>ชื่อผู้แจ้งปัญหา</td>
                    <td>สาขา</td>
                    <td>วันที่แจ้ง</td>
                    <td>วันที่แล้วเสร็จ</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $u = 0;
                $getcase = $getdata->my_sql_select($connect, null, "building_list", "date_update ='" . htmlspecialchars($_GET['key']) . "'");

                while ($showcase = mysqli_fetch_object($getcase)) {
                    $u++;
                ?>
                    <tr>
                        <td><?php echo $u; ?></td>
                        <td><?php echo $showcase->ticket; ?></td>
                        <td><?php
                            $search = $getdata->my_sql_query($connect, NULL, "employee", "card_key ='" . $showcase->se_namecall . "'");
                            if (COUNT($search) == 0) {
                                $chkName = $showcase->se_namecall;
                            } else {
                                $chkName = getemployee($showcase->se_namecall);
                            }

                            echo $chkName;
                            ?></td>
                        <td><?php echo $showcase->se_location; ?></td>
                        <td><?php echo @dateConvertor($showcase->date); ?></td>
                        <td><?php echo @dateConvertor($showcase->date_update); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

    </div>
</div>
<input type="text" name="key" hidden value="<?php echo $show_menu->user_key; ?>">
<script>
    $(document).ready(function() {

        $('#dataTablesFixwidht', '').dataTable({
            "autoWidth": false,
            "ordering": false,
        });
    });
</script>