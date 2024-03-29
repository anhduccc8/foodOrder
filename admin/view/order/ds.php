<?php
$chot = false;
$staus = array(
    1 => "Đang đặt",
    2 => "Đã hoàn tất thanh toán",
    3 => "Đã chuyển khoản, chờ xác nhận",
    4 => "Đã hủy",
    5 => "Chưa thanh toán",
);
if (isset($_GET['confirm_paid'])){
    $c_admin->confirmPaid($_GET['link']);
}
if (isset($_GET['confirm_unpaid'])){
    $c_admin->confirmUnPaid($_GET['link']);
}
if (isset($_GET['sua'])){
    $c_admin->confirmUnPaid($_GET['link']);
}
if (isset($_GET['hienthi'])){
    $hienthi = $_GET['hienthi'];
}else{
    $hienthi = 15;
}

ini_set('display_errors', false);
error_reporting(0);
?>
<div class="content">
    <h2>Danh sách Thực đơn</h2>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <?php
        $date_arr = array();
        $date_arr_count = array();
        for ($i = 0; $i<$hienthi; $i++ ){
            $key = date('dmY', strtotime('-'.$i.' days'));
            if (!(date('N', strtotime(date('Y-m-d', strtotime('-'.$i.' days')))) >= 6)){ // trừ t7 CN
                $date_arr[$key] = date('d/m/Y', strtotime('-'.$i.' days'));
                $countUnPaid = $c_admin->index2($key);
                $userUnPaid = $countUnPaid['userUnPaid'];
                $userDiffSucess = $countUnPaid['userDiffSucess'];
                $date_ar_countr[$key] = $userUnPaid->count;
                $date_ar_diff[$key] = $userDiffSucess->count;
            }
        }
//        $date_arr = array();
//        for ($i = 0; $i<7; $i++ ){
//            $key = date('dmY', strtotime('-'.$i.' days'));
//            $date_arr[$key] = date('d/m/Y', strtotime('-'.$i.' days'));
//        }
        foreach ($date_arr as $drk => $drv ){ ?>
            <li class="nav-item <?php if ($drk == date('dmY')){ echo 'active';} ?>">
                <a class="nav-link" id="<?= $drk ?>-tab" data-toggle="tab" href="#<?= $drk ?>" role="tab" aria-controls="<?= $drk ?>" aria-selected="true"><?= $drv; ?><?php if ($date_ar_countr[$drk] > 0){ ?><span style="color:red; font-weight: bold;"> (<?php  echo $date_ar_countr[$drk];?> chưa TT)</span><?php } ?>-<?php if ($date_ar_diff[$drk] > 0){ ?><span style="color:orange; font-weight: bold;"> (<?php  echo $date_ar_diff[$drk];?>)</span><?php } ?></a>
            </li>
        <?php }
        ?>
    </ul>
    <div class="tab-content" id="myTabContent">
        <?php

        $tt = 1;
        foreach ($date_arr as $drk => $drv ){
            $noi_dung_user = $c_admin->getUserOrder($drk);
            $user = $noi_dung_user['user']; ?>
            <div class="tab-pane <?php if ($drk == date('dmY')){ echo 'active';} ?>" id="<?= $drk ?>" role="tabpanel" aria-labelledby="<?= $drk ?>-tab">
                <table class="table table-bordered" >
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Họ Tên</th>
                        <th scope="col">Số suất đặt</th>
                        <th scope="col">Ghi chú</th>
                        <th scope="col">Tổng tiền</th>
                        <th scope="col">Tạo</th>
                        <th scope="col">Update</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Thao tác</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $t = 1;
                    $t_TongTien = 0;
                    $t_SoLuong = 0;
                    $text = '';
                    if (count($user) > 0){
                        foreach ($user as $u){
                            $text = $text .'<br>'. $u->Mota;
                            ?>
                            <tr>
                                <th scope="row"><?= $t ?></th>
                                <td><?= $u->HoTen; ?></td>
                                <td><?= $u->SoLuong; ?></td>
                                <td><?= $u->Mota; ?></td>
                                <td><?= number_format($u->TongTien, 0, '.', ','); ?> đ</td>
                                <td><?= $u->created_at ?></td>
                                <td><?php if ($u->updated_at != $u->created_at ){ echo $u->updated_at;}  ?></td>
                                <td>

                                    <!--                                                1 => "Đang đặt",-->
                                    <!--                                                2 => "Đã hoàn tất thanh toán",-->
                                    <!--                                                3 => "Đã chuyển khoản, chờ xác nhận",-->
                                    <!--                                                4 => "Đã hủy",-->
                                    <!--                                                5 => "Chưa thanh toán",-->
                                    <?php if ($chot && $tt == 1){ ?>
                                        <span class="label label-default">Đã chốt cơm</span>
                                    <?php } ?>
                                    <?php if ($u->Status_od == 1): ?>
                                        <span class="label label-primary"><?= $staus[$u->Status_od]; ?></span>
                                    <?php elseif ($u->Status_od == 4): ?>
                                        <span class="label label-danger"><?= $staus[$u->Status_od]; ?></span>
                                    <?php elseif ($u->Status_od == 3): ?>
                                        <span class="label label-warning"><?= $staus[$u->Status_od]; ?></span>
                                    <?php elseif ($u->Status_od == 2): ?>
                                        <span class="label label-success"><?= $staus[$u->Status_od]; ?></span>
                                    <?php elseif ($u->Status_od == 5): ?>
                                        <span class="label label-danger"><?= $staus[$u->Status_od]; ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($u->Status_od == 3 || $u->Status_od == 1 || $u->Status_od == 5){ ?>
                                        <a href="?view=order/ds&confirm_paid=<?php echo $u->id?>&link=<?= $drk ?>" class="label label-primary">Xác nhận đã thanh toán</a>
                                    <?php } ?>

                                    <?php if ($u->Status_od == 1 ){ ?>
                                        <a href="?view=order/ds&confirm_unpaid=<?php echo $u->id?>&link=<?= $drk ?>" class="label label-danger">Make chưa thanh toán</a>
                                    <?php } ?>
                                    <a href="?view=order/sua&id=<?php echo $u->id?>" class="label label-primary">Sửa</a>
                                </td>
                            </tr>
                            <?php $t+=1; if($u->Status_od != 4) {$t_TongTien = $t_TongTien + $u->TongTien; $t_SoLuong = $t_SoLuong + $u->SoLuong;} } ?>
                        <tr>
                            <td></td>
                            <td><strong>Tổng số suất</strong></td>
                            <td><strong><?= $t_SoLuong; ?></strong></td>
                            <td><strong>Tổng tiền</strong></td>
                            <td><strong><?= number_format($t_TongTien, 0, '.', ','); ?> đ</strong></td>
                        </tr>
                    <?php }else{ ?>
                        <tr><td colspan="7">Không có dữ liệu của ngày này</td></tr>
                    <?php }
                    ?>
                    </tbody>
                </table>
                <div>
                    <texarea><?= htmlspecialchars_decode($text) ?></texarea>
                </div>
            </div>
            <?php $tt+=1; }
        ?>
    </div>

</div>
