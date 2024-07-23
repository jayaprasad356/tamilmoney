<?php

if (isset($_POST['btnPaid']) && isset($_POST['enable'])) {

    foreach ($_POST['enable'] as $enable) {
        $enable = $db->escapeString($fn->xss_clean($enable));

        $sql = "SELECT user_id, amount, status FROM recharge_orders WHERE id = $enable";
        $db->sql($sql);
        $res = $db->getResult();

        if (empty($res)) {
            continue;
        }

        $user_id = $res[0]['user_id'];
        $amount = $res[0]['amount'];
        $status = $res[0]['status'];

        if ($status != 1) {
            $sql = "SELECT id FROM users WHERE id = $user_id";
            $db->sql($sql);
            $res = $db->getResult();
            $num = $db->numRows($res);

            if ($num == 1) {
                $sql = "UPDATE recharge_orders SET status = 1 WHERE id = $enable";
                $db->sql($sql);

                $datetime = date('Y-m-d H:i:s');
                $type = 'recharge_orders';

                $sql = "INSERT INTO transactions (`user_id`, `amount`, `datetime`, `type`) VALUES ('$user_id', '$amount', '$datetime', '$type')";
                $db->sql($sql);

                $sql_query = "UPDATE users SET recharge = recharge + $amount, total_recharge = total_recharge + $amount WHERE id = $user_id";
                $db->sql($sql_query);
            }
        }
    }
    echo '<script>window.location.href = "recharge_orders.php";</script>';
    exit;
}
?>

<section class="content-header">
    <h1>Recharge Orders /<small><a href="home.php"><i class="fa fa-home"></i> Home</a></small></h1>
</section>
<!-- Main content -->
<section class="content">
<form name="recharge_orders.php" method="post" enctype="multipart/form-data">
<div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <div class="col-md-3">
                            <h4 class="box-title">Filter by Status</h4>
                            <select id="status" name="status" class="form-control">
                                <option value="0">Pending</option>
                                <option value="1">Approved</option>
                                <option value="1">Rejected</option>
                            </select>
                        </div>   
                    </div>
                    <div class="box-body table-responsive">
                        <div class="row">
                            <div class="form-group">
                                <div class="text-left col-md-2">
                                    <input type="checkbox" onchange="checkAll(this)" name="chk[]"> Select All</input>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-success" name="btnPaid">Verify</button>
                                </div>
                            </div>
                        </div>
                        <table id='users_table' class="table table-hover" data-toggle="table" data-url="api-firebase/get-bootstrap-table-data.php?table=recharge_orders" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-filter-control="true" data-query-params="queryParams" data-sort-name="id" data-sort-order="desc" data-show-export="false" data-export-types='["txt","excel"]' data-export-options='{
                            "fileName": "challenges-list-<?= date('d-m-Y') ?>",
                            "ignoreColumn": ["operate"] 
                        }'>
                            <thead>
                                <tr>
                                <th data-field="column"> All</th>
                                    <th data-field="id" data-sortable="true">ID</th>
                                    <th data-field="name" data-sortable="true"> Name</th>
                                    <th data-field="mobile" data-sortable="true"> Mobile</th>
                                    <th data-field="order_id" data-sortable="true">Order ID</th>
                                    <th data-field="amount" data-sortable="true">Amount</th>
                                    <th data-field="status" data-sortable="true">Status</th>
                                    <th data-field="datetime" data-sortable="true">DateTime</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="separator"> </div>
        </div>
        </form>
</section>


<script>
    $('#seller_id').on('change', function() {
        $('#products_table').bootstrapTable('refresh');
    });
    $('#status').on('change', function() {
        $('#users_table').bootstrapTable('refresh');
    });
    $('#date').on('change', function() {
        $('#users_table').bootstrapTable('refresh');
    });

    function queryParams(p) {
        return {
            "status": $('#status').val(),
            "seller_id": $('#seller_id').val(),
            "community": $('#community').val(),
            "date": $('#date').val(),
            limit: p.limit,
            sort: p.sort,
            order: p.order,
            offset: p.offset,
            search: p.search
        };
    }
</script>
<script>
    function checkAll(ele) {
        var checkboxes = document.getElementsByTagName('input');
        if (ele.checked) {
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type == 'checkbox') {
                    checkboxes[i].checked = true;
                }
            }
        } else {
            for (var i = 0; i < checkboxes.length; i++) {
                console.log(i)
                if (checkboxes[i].type == 'checkbox') {
                    checkboxes[i].checked = false;
                }
            }
        }
    }
</script>

