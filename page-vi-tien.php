<?php
/**
 * Template Name: Ví Tiền
 */

get_header();

// Kiểm tra đăng nhập
if (!is_user_logged_in()) {
    wp_redirect(home_url('/wp-login.php'));
    exit;
}

$user_id = get_current_user_id();
$user = get_userdata($user_id);
$balance = get_user_meta($user_id, '_user_balance', true);
if ($balance === '') {
    $balance = 0;
}

$vip_name = get_user_meta($user_id, '_user_vip_name', true);
$vip_color = get_user_meta($user_id, '_user_vip_name', true);

// Hàm chuyển đổi tên VIP sang cấp
function vip_name_to_cap($vip_name) {
    $map = [
        'Ký Chủ Vô Danh' => 'cấp 1',
        'Tân Linh Ký Chủ' => 'cấp 2',
        'Ký Chủ Thức Tỉnh' => 'cấp 3',
        'Ký Chủ Phong Linh Hóa' => 'cấp 4',
        'Thống Lĩnh Phong Linh Trấn' => 'cấp 5',
        'Ký Chủ Tối Thượng' => 'cấp 6',
        'Linh Vương' => 'cấp 7',
        'Linh Vương Mộng Cảnh' => 'cấp 8',
    ];
    return isset($map[$vip_name]) ? $map[$vip_name] : $vip_name;
}

// Lấy thông tin giao dịch từ bảng tb_transactions
global $wpdb;
$transactions = $wpdb->get_results($wpdb->prepare(
    "SELECT * FROM tb_transactions 
    WHERE transaction_content = %s 
    ORDER BY transaction_date DESC",
    $user->user_login
));
?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <!-- Hiển thị số dư -->
            <div class="card mb-4">
                <div class="card-body">
                    <h3>Xin chào! <span style="text-transform: uppercase; color: #f4be44"><?php echo $user->user_login ?></span></h3>
                    <div class="d-flex align-items-center custom-tuvi">
                        <h5 class="mb-0 me-2">Danh hiệu </h5>
                        <?php if ($vip_name): ?>
                            <button class="btn-cus-vip <?php
                                switch ($vip_name) {
                                    case 'Ký Chủ Vô Danh':
                                        echo 'btn-cus-vip--ky-chu-vo-danh';
                                        break;
                                    case 'Tân Linh Ký Chủ':
                                        echo 'btn-cus-vip--tan-linh-ky-chu';
                                        break;
                                    case 'Ký Chủ Thức Tỉnh':
                                        echo 'btn-cus-vip--ky-chu-thuc-tinh';
                                        break;
                                    case 'Ký Chủ Phong Linh Hóa':
                                        echo 'btn-cus-vip--ky-chu-phong-linh-hoa';
                                        break;
                                    case 'Thống Lĩnh Phong Linh Trấn':
                                        echo 'btn-cus-vip--thong-linh-phong-linh-tran';
                                        break;
                                    case 'Ký Chủ Tối Thượng':
                                        echo 'btn-cus-vip--ky-chu-toi-thuong';
                                        break;
                                    case 'Linh Vương':
                                        echo 'btn-cus-vip--linh-vuong';
                                        break;
                                    case 'Linh Vương Mộng Cảnh':
                                        echo 'btn-cus-vip--linh-vuong-mong-canh';
                                        break;
                                    default:
                                        // Nếu không khớp với loại VIP nào
                                        echo '';
                                        break;
                                }
                                ?> mb-3">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <?php echo vip_name_to_cap($vip_name); ?>
                            </button>
                        <?php endif; ?>
                    </div>
                    <h5 class="card-title">xu hiện tại</h5>
                    <h2 class="text-warning"><?php echo number_format($balance); ?> xu</h2>
                </div>
            </div>

            <!-- Lịch sử giao dịch -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Lịch sử nạp xu</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Ngày</th>
                                    <th>Loại</th>
                                    <th>Số tiền</th>
                                    <th>Nội dung</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($transactions)) {
                                    foreach ($transactions as $transaction) {
                                        $amount = $transaction->amount_in;
                                        $type = $transaction->transaction_type;
                                        $date = $transaction->transaction_date;
                                        $content = $transaction->transaction_content;
                                        $status = $transaction->transaction_status;
                                        ?>
                                        <tr>
                                            <td><?php echo date('d/m/Y H:i', strtotime($date)); ?></td>
                                            <td><?php echo $type === 'purchase' ? 'Mua chương' : 'Nạp tiền'; ?></td>
                                            <td class="<?php echo $type === 'purchase' ? 'text-danger' : 'text-success'; ?>">
                                                <?php echo $type === 'purchase' ? '-' : '+'; ?><?php echo number_format($amount); ?> VNĐ
                                            </td>
                                            <td><?php echo esc_html($content); ?></td>
                                            <td>
                                                <?php
                                                $status_class = 'bg-success';
                                                $status_text = 'Hoàn thành';
                                                
                                                if ($status === 'pending') {
                                                    $status_class = 'bg-warning';
                                                    $status_text = 'Đang xử lý';
                                                } elseif ($status === 'failed') {
                                                    $status_class = 'bg-danger';
                                                    $status_text = 'Thất bại';
                                                }
                                                ?>
                                                <span class="badge <?php echo $status_class; ?>"><?php echo $status_text; ?></span>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo '<tr><td colspan="5" class="text-center">Chưa có giao dịch nào</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?> 