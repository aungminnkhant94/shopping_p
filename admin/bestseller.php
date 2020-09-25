<?php
session_start();
require '../config/config.php';
require '../config/common.php';


if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header('Location: login.php');
}


?>


<?php include('header.php'); ?>
<!-- Main content -->
<div class="content">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
<div class="card">
<div class="card-header">
<h3 class="card-title">Best Seller Items</h3>
</div>
<?php
$qty = 7;
$stmt = $pdo->prepare("SELECT * FROM sale_order_detail GROUP BY product_id HAVING SUM(quantity)>:qty ORDER BY id DESC ");
$stmt->execute(array(':qty'=>$qty));
$result = $stmt->fetchAll();
?>
<!-- /.card-header -->
<div class="card-body">

<br>
<table class="table table-bordered"id="d-table">
<thead>
<tr>
<th style="width: 10px">#</th>
<th>Name</th>
<th>Description</th>
<th>Quantity</th>
</tr>
</thead>
<tbody>
<?php
if ($result) {
    $i = 1;
    foreach ($result as $value) { ?>
        
        <?php
        $userStmt = $pdo->prepare("SELECT * FROM users WHERE id=".$value['product_id']);
        $userStmt->execute();
        $userResult = $userStmt->fetch(PDO::FETCH_ASSOC);
        ?>
        <tr>
        <td><?php echo $i;?></td>
        <td><?php echo escape($userResult[0]['name'])?></td>
        <td><?php echo escape(substr(userResult['description'],0, 30));?></td>
        <td><?php echo escape($userResult['quantity']);?></td>
        </tr>
        <?php
        $i++;
    }
}
?>
</tbody>
</table><br>
</div>
<!-- /.card-body -->

</div>
<!-- /.card -->
</div>
</div>
<!-- /.row -->
</div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<?php include('footer.html')?>

<script>
$(document).ready(function() {
    $('#d-table').DataTable();
} );
</script>