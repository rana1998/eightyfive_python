<?php
$page_title = 'View Announcement';
include 'header.php'; 

if(isset($_GET['id']))
{
    $id = intval(mysqli_real_escape_string($con,$_GET['id']));
    
    $q="select * from announcement where id='$id'";    
    $result = mysqli_query($con,$q);
    
    if(mysqli_num_rows($result) < 1)
    {
        $_SESSION['errorMsg'] = 'Wrong Access';
        header("location: index.php");
        exit();
    }
    else
    {
        $res = mysqli_fetch_assoc($result);
    }
    
}



?>
<style>
    .table-hover>tbody>tr:hover {
    --bs-table-accent-bg: var(--bs-table-hover-bg);
    color: #fff;
}
</style>
<!-- Page Content Start Here -->
<div class="page-wrapper">
    <div class="page-content">
        <!-- Breadcrumb-->
        <div class="row pt-2 pb-2">
            <div class="col-sm-9">
                <h4 class="page-title"><?= $page_title; ?></h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li>&nbsp; / &nbsp;</li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $page_title; ?></li>
                </ol>
            </div>
        </div>
        <!-- End Breadcrumb-->
        <div class="row">
            <div class="col-12">
                <div class="card">
					<div class="card-body">
						<div class="table-responsive">
							 <table id="default-datatable" class="table table-bordered table-striped table-hover">
                                <tr>
                                    <th>Title</th>
                                </tr>
                                <tr>
                                    <td><?=$res['title']?></td>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                </tr>
                                <tr>
                                    <td><?=$res['description']?></td>
                                </tr>
                                <tr>
                                    <td>
                                       <a target="blank" href="../admin_portal/<?=$res['file']?>"> 
                                            <img src="../admin_portal/<?=$res['file']?>" class="img-fluid text-center">
                                       </a>
                                    </td>
                                </tr>
            
                            </table>
						</div>
					</div>
				</div>
                
                
            </div>
        </div>
    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
    
    <?php include 'footer.php'; ?>