<?php
// if(isset($_GET['id'])){
//     $sql = "DELETE  FROM tbl_baiviet WHERE id= {$_GET['id']}";
//     if (mysql_query($sql)){
//         echo "<div class='alert alert-success'>XÓA THÀNH CÔNG</div>";
//     }
//     else{
//         echo "<div class='alert alert-danger'>XÓA THẤT BẠI</div>";
//     }
// }

?>
<div class="content">
    <h2>Danh sách Tin tức</h2>
    <a href="?view=baiviet/them" class="btn btn-success">Thêm tin tức</a>
    <table class="table table-bordered">
        <tr>
            <td>STT</td>
            <td>Loại tin</td>
            <td>Thể loại</td>
            <td>Tiêu Đề</td>
            <td>Tiêu Đề Không Dấu</td>
            <td>Hình</td>
            <td>Tóm tắt</td>
            <td>Tác vụ</td>
        </tr>
        <?php
            $STT=1;
            foreach ($baiviet as $bv ) {
                ?>    
                <tr>
                    <td>
                        <?php echo $STT ?>
                    </td>
                    <td>
                        <?php echo $bv->TenLoaiTin ?>
                    </td>
                    <td>
                        <?php echo $bv->TenTheLoai ?>
                    </td>
                    <td>
                        <?php echo $bv->TieuDe ?>
                    </td>
                    <td>

                        <?php echo $bv->TieuDeKhongDau ?>
                    </td>
                    <td>
                        <img height="50" width="50" src="../public/image/tintuc/<?php echo $bv->Hinh ?>" class="img-responsive" >
                    </td>
                    
                    <td>
                        <?php echo $bv->TomTat?>
                    </td>
                    <td>
                        <a href="?view=baiviet/sua&id= <?php echo $bv->id?>" class="btn btn-primary">Sửa</a>
                        <a href="?view=baiviet/ds&id= <?php echo $bv->id?>" class="btn btn-danger">Xóa</a>
                    </td>
                </tr>
        <?php
            $STT++;
           }
        ?>
    </table>
    <div class="row text-center">
        <div class="col-lg-12">
            <?php echo $thanhphantrang ?>
        </div>
    </div>
    
</div>