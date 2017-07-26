<!DOCTYPE html>
<html>
    <head>
        <title>Task 1</title>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="css/bootstrap.min.css"/>
        <link rel="stylesheet" href="css/style.css"/>
        <script src="js/jquery.js"></script>
        <script src="js/script.js" type="text/javascript"></script>
    </head>
    <body>
        <div class="container">
         <div class="<?=$flashMessage['status']?>" id="mes">
            <?=$flashMessage['message']?>
            <?php if(!empty($resUpl['infoUpl'])):?>
                <ul class="listResUpl" >
                    <?php foreach($resUpl['infoUpl'] as $resItemUpl):?>
                        <li class="<?=$resItemUpl['isUpload']?"success":"fail"?>"><?=$resItemUpl['fileName']?> - <?=$resItemUpl['isUpload']?"file downloaded":"error download"?></li>
                    <?php endforeach;?>
                </ul>
            <?php endif;?>
         </div>
        <div class="wrap_form">
            <form class="form-inline" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="fileInput">Select files:</label>
                  <input type="file" class="form-control" id="fileInput" name="data[]" required multiple />
                  <button class="btn btn-success">Add file(s)</button>
                </div>
            </form>
        </div>
        <?php if(!empty($files)):?>
            <table class='table table-striped'>
                <tr>
                    <th>№</th>
                    <th>File name</th>
                    <th>Size</th>
                    <th>Action</th>
                </tr>
                <?php $i = 1; foreach($files as $file):?>
                <tr>
                    <td><?=$i++;?></td>
                    <td><?=$file['filename'];?></td>
                    <td><?=$file['filesize']['size']." ".$file['filesize']['units'];?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" value="<?=$file['filename']?>" name="del_file"/>
                            <button class="btn btn-success"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
                        </form>
                                
                    </td>
                </tr>
                <?php endforeach;?>
            </table>
        <?php else:?> <b>directory is empty</b>
        <?php endif;?>
        </div>
        
    </body>
</html>
