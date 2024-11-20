<?php
    include("includes/header.php");

    include("../includes/connection.php");
?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">View Orders</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Order List
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Order ID</th>
                                            <th>Name</th>
                                            <th>Address</th>
                                            <th>Pincode</th>
                                            <th>City</th>
                                            <th>State</th>
                                            <th>Mobile</th>
                                            <th>Order Details</th>
                                            <th>Total Amount</th>
                                            <th>User ID</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php

                                            $o_q="SELECT * FROM orders";

                                            $o_res=mysqli_query($mysqli,$o_q);

                                            $count=1;

                                            while($o_row=mysqli_fetch_assoc($o_res))
                                            {
                                                echo '<tr class="odd gradeX">
                                                          <td>'.$count.'</td>
                                                          <td>'.$o_row['o_id'].'</td>
                                                          <td>'.$o_row['o_name'].'</td>
                                                          <td>'.$o_row['o_address'].'</td>
                                                          <td>'.$o_row['o_pincode'].'</td>
                                                          <td>'.$o_row['o_city'].'</td>
                                                          <td>'.$o_row['o_state'].'</td>
                                                          <td>'.$o_row['o_mobile'].'</td>
                                                          <td>'.$o_row['o_order_details'].'</td>
                                                          <td>'.$o_row['o_total_amount'].'</td>
                                                          <td>'.$o_row['o_rid'].'</td>
                                                          <td align="center"><a style="color: red;" href="process_orders_del.php?id='.$o_row['o_id'].'">x</a></td>
                                                      </tr>';
                                                $count++;
                                            }

                                        ?>
                                            
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
    
        </div>
        <!-- /#page-wrapper -->
<?php
    include("includes/footer.php");
?>
