<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Thêm Bài Viết</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/form.css') ?>" >
        <script src="<?php echo base_url('assets/js/form.js') ?>"></script>
        <script src="<?php echo base_url('assets/ckeditor/ckeditor.js') ?>"></script>
         
    </head>
    <body >
        <div class="container">
            <!-- Form Started -->
            <div class="container form-top">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 col-sm-12 col-xs-12">
                        <div class="panel panel-danger">
                            <div class="panel-body">
                                <form  method="post" action="http://localhost/project/index.php/Welcome/add"  enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label><i class="fa fa-user" aria-hidden="true"></i> Tiêu Đề </label>
                                        <input type="text" name="tieude" class="form-control" placeholder="Enter Name">
                                    </div>
                                    <div class="form-group">
                                        <label><i class="fa fa-comment" aria-hidden="true"></i> Mô Tả</label>
                                        <textarea rows="3" name="mota" class="form-control" placeholder="Type Your Message"></textarea>
                                    </div>
                                     <div class="form-group">
                                        <label><i class="fa fa-comment" aria-hidden="true"></i> Chi Tiết </label>
                                        <textarea id="editor1" name="chitiet" cols="90" rows="15"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label><i class="fa fa-upload" aria-hidden="true"></i>Upload Image</label>
                                        <input type="file" name="picture" id="picture">
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-raised btn-block btn-danger">Thêm </button>
                                    </div>
                                </form>
                                <script>
                                    CKEDITOR.replace( 'editor1' );
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Form Ended -->
        </div>
    </body>
</html>