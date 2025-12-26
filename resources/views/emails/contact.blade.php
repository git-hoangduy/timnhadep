<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký nhận tin</title>
</head>
<body style="margin:0;padding:0;background:#f4f6f8;font-family:Arial,Helvetica,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f8;padding:20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:6px;overflow:hidden;">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background:#eb5d1e;color:#ffffff;padding:16px 24px;">
                            <h2 style="margin:0;font-size:20px;">📩 Tìm Nhà Đẹp - Đăng ký nhận tin</h2>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td colspan="2" style="padding:24px;">
                            <table width="100%" cellpadding="8" cellspacing="0">
                                <tr>
                                    <td width="30%" style="font-weight:bold;">Họ tên:</td>
                                    <td>{{ $name }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight:bold;">Email:</td>
                                    <td>{{ $email }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight:bold;">Số điện thoại:</td>
                                    <td>{{ $phone ?? 'Không có' }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight:bold;vertical-align:top;">Nội dung:</td>
                                    <!-- Đổi $message thành $content -->
                                    <td>{{ $content }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#f1f3f5;padding:12px 24px;font-size:12px;color:#666;text-align:center;">
                            Email này được gửi tự động từ timnhadep.net
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>