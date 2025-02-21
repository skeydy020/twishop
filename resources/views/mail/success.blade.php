<!DOCTYPE html>
<html>
<head>
    <title>Xác nhận đơn hàng</title>
</head>
<body>
    <h1>Xin chào {{ $khachhang }},</h1>
    <p>{{ $noidung }}</p>
    <p>Mã đơn hàng của bạn: <strong>DH{{ $donhang_id }}</strong></p>
    
    <h3>Chi tiết đơn hàng:</h3>
    <ul>
        @foreach($chitietdonhang as $chitiet)
            <li>{{ $chitiet->SanPham->name }} - Số lượng: {{ $chitiet->SoLuong }} - Giá: {{ $chitiet->Gia }}</li>
        @endforeach
    </ul>
    
    <p><strong>Tổng cộng: {{ $TongTien }} VND</strong></p>
    
    <p>Cảm ơn bạn đã mua hàng!</p>
</body>
</html>
