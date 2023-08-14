<?php
ob_start();
include "header.php";

//delete announcement
if(isset($_GET['id']) and isset($_GET['action']) and $_GET['action']=='delete')
{
    
    $id = intval(mysqli_real_escape_string($con,$_GET['id']));
    
    $q="delete from announcement where id='$id'";
    $result=mysqli_query($con,$q);
    
    if($result == TRUE)
    {
        $_SESSION['successMsg']='Announcement Delete Successfully';
    	header("Location: create-announcement.php");
    	exit(); 
    }
    else
    {
        $_SESSION['errorMsg']='Something went wrong';
		header("Location: create-announcement.php");
		exit();
    }
    
 
}




// create announcement
	if(isset($_POST['create'])){
		
		$title = mysqli_real_escape_string($con,$_POST['title']);
		$description = mysqli_real_escape_string($con,$_POST['description']);
		$image = $_FILES['image'];
		
		$ImgName = $image['name'];
        $ImgError = $image['error'];
        $ImgTemp = $image['tmp_name'];
        $ImgSize = $image['size'];
    
        $ImgText = explode('.',$ImgName);
        $ImgCheck = strtolower(end($ImgText));
        $ImgExtention= array('png','jpg','jpeg');
	    
	    if(empty($title))
	    {
	        $_SESSION['errorMsg']='Please enter announcement title';
			header("Location: create-announcement.php");
			exit(); 
	    }
	    elseif(empty($description))
	    {
	        $_SESSION['errorMsg']='Please enter announcement description';
			header("Location: create-announcement.php");
			exit();
	    }
	    elseif(empty($ImgName))
	    {
	        $_SESSION['errorMsg']='Please select announcement image';
			header("Location: create-announcement.php");
			exit();
	    }
      //images size validation
        elseif($ImgSize > 5000000)
        {
            $_SESSION['errorMsg'] = "Image size is greater than 5MB";
            header("Location: create-announcement.php");
            exit();
        }
        elseif($ImgCheck=='png' || $ImgCheck=='jpg' || $ImgCheck=='jpeg' )
        {
            $ImgDestinationFile = '../member/images/announcement/'.md5(rand()).'-'.$ImgName;
            move_uploaded_file($ImgTemp,$ImgDestinationFile);
            
            $qy="INSERT INTO `announcement`(`title`, `description`, `file`) VALUES ('$title','$description','$ImgDestinationFile')";
            $result = mysqli_query($con,$qy);
            if($result == TRUE)
            {
                
				$_SESSION['successMsg']='Announcement Created Successfully';
				header("Location: create-announcement.php");
				exit();
            }
	   
        }
        else
        {
            $_SESSION['errorMsg'] = "Please select PNG,JPG,JPEG file only";
            header("Location: create-announcement.php");
            exit();
        }
	    
	}
?>
<!-- Main-body start -->
<div class="main-body">
	<div class="page-wrapper">
		<!-- Page-header start -->
		<div class="page-header">
			<div class="row align-items-end">
				<div class="col-lg-8">
					<div class="page-header-title">
						<div class="d-inline">
							<h4>Create Announcement</h4>
							<span>Create Announcements for members. </span>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="page-header-breadcrumb">
						<ul class="breadcrumb-title">
							<li class="breadcrumb-item">
								<a href="index-1.htm"> <i class="feather icon-home"></i> </a>
							</li>
							<li class="breadcrumb-item"><a href="#!">Create Announcement</a> </li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- Page-header end -->
		<div class="page-body">
			<div class="container">
				<div class="row">
					<div class="col-sm-8 ml-auto mr-auto">
						
						<div class="auth-box card">
							<div class="card-block">
								<div class="row">
									<div class="col-md-12">
										<h3 class="text-center ">Create Announcement</h3>

                                    <!-- Success Message -->
                                    <?php if (isset($_SESSION['successMsg'])) {
                                    ?>
                                    <div class="alert alert-success background-success mb-0">
                                    <button type="button" class="close m-0" data-dismiss="alert" aria-label="Close">
                                    <i class="icofont icofont-close-line-circled text-white"></i>
                                    </button>
                                    <strong>Success!</strong> <?php echo $_SESSION['successMsg'] ;?>
                                    </div>
                                    <?php
                                    unset($_SESSION['successMsg']);
                                    } ?>

                                    <!-- Error Message -->
                                    <?php if (isset($_SESSION['errorMsg'])) {
                                    ?>
                                    <div class="alert alert-danger background-danger mb-0">
                                    <button type="button" class="close m-0" data-dismiss="alert" aria-label="Close">
                                    <i class="icofont icofont-close-line-circled text-white"></i>
                                    </button>
                                    <strong>Error!</strong> <?php echo $_SESSION['errorMsg'] ;?>
                                    </div>
                                    <?php
                                    unset($_SESSION['errorMsg']);
                                    } ?>


									</div>
								</div>
							</div>
							<div class="card-body">
								<form  class="md-float-material form-material" method="POST" enctype="multipart/form-data">
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Title</label>
										<div class="col-sm-9">
											<input autocomplete="off" type="text" class="form-control" name="title" id="title">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Description</label>
										<div class="col-sm-9">
											<input autocomplete="off" type="text" class="form-control" name="description" id="description">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Image</label>
										<div class="col-sm-9">
											<input type="file" class="form-control" name="image" id="image">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-12">
											<button type="submit" class="btn btn-warning btn-md btn-block waves-effect text-center m-b-20" name = "create">Create</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- ROI Percentage Table -->
				<div class="row">
					<div class="col-sm-12">
						<!-- HTML5 Export Buttons table start -->
						<div class="card">
							<div class="card-header table-card-header text-center">
							</div>
							<div class="card-block">
								<div class="dt-responsive table-responsive">
									<table id="basic-btn" class="table table-sm table-striped table-bordered " data-page-length='10'>
										<thead>
											<tr>
												<th>#</th>
												<th>Title</th>
												<th>Description</th>
												<th>Image</th>
												<th>Date</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$sql = "SELECT * FROM `announcement` ORDER BY `date` DESC";
											$result = mysqli_query($con, $sql);
											$x= 1;
											while ( $data = mysqli_fetch_array($result)):
											?>
											<tr>
												<td><?php echo $x++;  ?></td>
												<td><?php echo $data['title'];?></td>
												<td><?php echo $data['description'];?></td>
												<td><a href="<?php echo $data['file'];?>" target="blank"><img src="<?php echo $data['file'];?>" height="20" width="20"></a></td>
												<td><?php echo date('Y-m-d',strtotime($data['date']) );  ?></td>
											    <td><a href="create-announcement.php?id=<?php echo $data['id']?>&action=delete" class="btn btn-danger btn-sm">Delete</a></td>
											</tr>
											<?php endwhile; ?>
										</tbody>
										<tfoot>
										<tr>
											<th>#</th>
											<th>Title</th>
											<th>Description</th>
											<th>Image</th>
											<th>Date</th>
											<th>Action</th>
										</tr>
										</tfoot>
									</table>
								</div>
							</div>
						</div>
						<!-- HTML5 Export Buttons end -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
include "footer.php";
?>