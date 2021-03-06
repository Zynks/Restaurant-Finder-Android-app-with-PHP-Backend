<?php  
function encryptIt( $q ) { $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
    $qEncoded=base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );return( $qEncoded );
} ?>                
 <div class="page animsition">
    <div class="page-header">
        <h1 class="page-title">Restaurant Detail</h1>
        <ol class="breadcrumb">
            <li><a href="master.php">Home</a></li>
            <li class="active">View Restourant</li>
        </ol>
    </div>
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel">
                    <div class="panel-body">
                        <table class="table table-bordered table-hover toggle-circle" id="exampleFootableFiltering">
                            <thead>
                            <tr>
                                <td data-toggle="true" style="pointer-events: none;">image</td>
                                <td style="pointer-events: none;">Restaurant Name</td>
                                <td style="pointer-events: none;">Action</td>
                                <th data-hide="phone, tablet">Timing</th>
                                <th data-hide="phone, tablet">Address</th>
                                <th data-hide="phone, tablet">Zipcode</th>
                                <th data-hide="phone, tablet">Mobile</th>
                                <th data-hide="phone, tablet">Email</th>
                                <th data-hide="phone, tablet">Ratting</th>
                                <th data-hide="phone, tablet">Latitude</th>
                                <th data-hide="phone, tablet">Longitude</th>
                                <th data-hide="phone, tablet">Vegtype</th>
                                <th data-hide="phone, tablet">Food Type</th>
                                <th data-hide="phone, tablet">Status</th>
                            </tr>
                            </thead>
                            <div class="form-inline padding-bottom-15">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label">Status</label>
                                            <select id="filteringStatus" class="form-control">
                                                <option value="">Show all</option>
                                                <option value="active">Active</option>
                                                <option value="disabled">Disabled</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 text-right">
                                        <div class="form-group">
                                            <input id="filteringSearch" type="text" placeholder="Search" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <tbody>
                            <?php $query=mysqli_query($con,"select * from tbl_restourant ORDER BY id DESC "); while($row=mysqli_fetch_array($query)){
                            $query1=mysqli_query($con,"select * from tbl_images WHERE image_id='".$row['id']."' "); $row1=mysqli_fetch_array($query1);
                            $query2=mysqli_query($con,"select * from tbl_food WHERE food_id='".$row['id']."'");  ?>
                            <tr>
                                <?php $id1=$row['id']; ?>
                                <td><img src="uploads/<?php echo $row['thumimage']; ?>" height="70" width="70" /></td>
                                <td><?php echo $row['name']; ?></td>
                                <td>

                             <?php $idd=encryptIt($row['id']); $id=encrypt_decrypt('encrypt', $row['id']);$idd=encrypt_decrypt('encrypt', 'id'); ?>
                                    <a href="editrestaurant.php?<?php echo $idd; ?>=<?php echo $id; ?>" name="edit" type="submit" class="btn btn-outline btn-warning" title="Update Record">Edit</a>
                                  
                                   <?php $rit=$_SESSION['uname'];$qur=mysqli_query($con,"select * from adminlogin WHERE Username='$rit'");
                                    $user=mysqli_fetch_array($qur);
                                    if($user['right'] == 1 ) { ?>
                                    <button type="button" class="btn btn-outline btn-danger" onClick="deletefun(<?php echo $row["id"]; ?>)"
                                            title="Delete">delete</button>
                                    <button type="button" class="btn btn-outline btn-danger" onClick="addmenus(<?php echo $row["id"]; ?>)"
                                            title="Add new dish" data-target="#modelcat1" data-toggle="modal" > <span class="btn-label">
                                                    <i aria-hidden="true" class="icon wb-plus"></i>
                                                </span>&nbsp;&nbsp;&nbsp;&nbsp;Add New Dish </button>
                                        <?php if($row['is_active']== 1){ ?>
                                            <button type="button" class="btn btn-outline btn-success" onClick="disablefun(<?php echo $row["id"]; ?>)"
                                                    title="Disabled">Disabled</button>
                                        <?php } else { ?>
                                            <button type="button" class="btn btn-outline btn-primary" onClick="activefun(<?php echo $row["id"]; ?>)"
                                                    title="Disabled">Active</button>
                                        <?php } ?>
                                    <?php }
                                    else{
                                        ?>
                                        <button type="button" class="btn btn-outline btn-danger" onClick="rightdel()"
                                                title="Delete">delete</button>
                                        <?php if($row['is_active']== 1){ ?>
                                            <button type="button" class="btn btn-outline btn-success" onClick="rightdis()"
                                                    title="Disabled">Disabled</button>
                                        <?php } else { ?>
                                            <button type="button" class="btn btn-outline btn-primary" onClick="rightdis()"
                                                    title="Disabled">Active</button>
                                        <?php } ?> <?php
                                    }
                                    ?>
                                </td>
                                <td><?php echo $row['time']; ?></td>
                                <td><?php echo $row['address']; ?></td>
                                <td><?php echo $row['zipcode']; ?></td>
                                <td><?php echo $row['phone_no']; ?></td>
                                <td><?php echo $row['email']; ?></td>

                                <?php
                                $sql = mysqli_query($con, "SELECT res_id, AVG(ratting) AS ratavg FROM tbl_userfeedback WHERE res_id='" . $row['id'] . "'");
                                while ($res = mysqli_fetch_array($sql)) {
                                    $avg = $res['ratavg'];
                                    $vg1 = round($avg, 1);
                                } ?>
                                <td><?php echo $vg1; ?></td>
                                <td><?php echo $row['latitude']; ?></td>
                                <td><?php echo $row['longitude']; ?></td>
                                <?php if($row['Vegtype'] == "Both"){ ?>
                                <td><font color="#cd5c5c">Veg , Non-Veg </font></td>
                                <?php }  else{
                                    ?>
                                    <td><font color="#cd5c5c"><?php echo $row['Vegtype']; ?></font></td>
                                    <?php
                                }?>
                                <td>
                                    <?php while($row2=mysqli_fetch_array($query2)){ ?>
                                        <span class="label label-table label-success"><?php echo $row2['food_type'];?></span>
                                    <?php } ?>
                                </td>
                                <td><?php if($row['is_active'] == 0)
                                    {
                                        ?> <span class="label label-table label-danger">Disabled</span>
                                        <?php
                                    }
                                    else
                                    {
                                        ?><span class="label label-table label-info">Active</span>
                                        <?php
                                    }?></td>

                            </tr>

                            </tbody>

                            <?php
                            }

                            ?>

                            <tfoot>
                            <tr>
                                <td colspan="5">
                                    <div class="text-right">
                                        <ul class="pagination"></ul>
                                    </div>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-lg">
            <div class="col-lg-8 col-md-6">
                <div class="example-wrap">
                    <div class="example">
                        <div class="modal fade" id="exampleFormModal" aria-hidden="false" aria-labelledby="exampleFormModalLabel"
                             role="dialog" tabindex="-1">
                            <div class="modal-dialog">
                                <div id="showresults"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-lg">
              <div class="col-lg-4 col-md-6">
                <!-- Example Form Modal -->
                <div class="example-wrap">
                    <div class="example">
                        <!-- Modal -->
                        <div class="modal fade" id="modelcat1" aria-hidden="false" aria-labelledby="sadasd"
                             role="dialog" tabindex="-1">
                            <div class="modal-dialog">
                                <div id="addmenus"></div>
                            </div>
                        </div>
                        <!-- End Modal -->
                    </div>
                </div>
                <!-- End Example Form Modal -->
            </div>
    </div>
</div>
<script>
    function rightdel(){ alert("You Have Sample Admin ! Cannot Delete Restaurant Detail !!!"); }
    function rightdis(){ alert("You Have Sample Admin ! Cannot Active/Disabled Restaurant !!!"); }
</script>
<script>
    function addmenus(data){
        var id = data;
          //alert($tarun);
          
        $.ajax({
            type: "POST",
            url: "include/addmenus.php",
            data: "id=" + id,
            cache: false,
            beforeSend: function () {
                $("#login").val('Connecting...');
            },
            success: function (data) {
                if (data) {
                    console.log( data );
                    $('#addmenus').replaceWith($('#addmenus').html(data));
                   //  window.location.href = "addmenu_controler.php?id5=" + id;
                  //  var new_id = id;
                        
                   
                }
                else {


                }
            }
        });

    }
    
 
    
    
    

    function deletefun(data){
        var del=confirm("Are you sure you want to delete this restaurant Detail ? ");
        if(del == true) {
            var id = data;
            $.ajax({
                type: "POST",
                url: "include/delete.php",
                data: "id=" + id,
                cache: false,
                beforeSend: function () {
                    $("#login").val('Connecting...');
                },
                success: function (data) {
                    if (data == "delete") {
                        alert("Restaurant detail delete successfuly !");
                        window.location='viewrestourant.php';
                    }
                    else {
                        alert("Error!!!");
                    }
                }
            });
        }
        else{
        }
    }
    function editfun(data){
        var id = data;
        $.ajax({
            type: "POST",
            url: "include/viewres.php",
            data: "id=" + id,
            cache: false,
            beforeSend: function () {
                $("#login").val('Connecting...');
            },
            success: function (data) {
                if (data) {
                    $('#showresults').replaceWith($('#showresults').html(data));
                }
                else { }
            }
        });
    }
    function disablefun(data){
        var id = data;
        $.ajax({
            type: "POST",
            url: "include/disablerestaurant.php",
            data: "id=" + id,
            cache: false,
            beforeSend: function () {
                $("#login").val('Connecting...');
            },
            success: function (data) {
                if (data) {
                    window.location='viewrestourant.php';
                   // alert(id);
                }
                else {


                }
            }
        });
    }
    function activefun(data){

        var id = data;
        // alert(id);
        $.ajax({
            type: "POST",
            url: "include/disablerestaurant.php",
            data: "id1=" + id,
            cache: false,
            beforeSend: function () {
                $("#login").val('Connecting...');
            },
            success: function (data) {
                if (data == "update") {
                    window.location='viewrestourant.php';
                }
                else {


                }
            }
        });

    }
</script>       


                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       