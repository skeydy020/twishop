@extends('admin.main')

@section('content')
<div class="mx-5 py-4">
    <div class="row mt-4">
        <div class="col text-white rounded py-3 mr-4 text-right pr-4" style="background: #488A99;">
            <h5 class="mb-2 h3" id="userCount">{{ $newUsersToday }}</h5>
            <p class="h5"><i class="fa-solid me-1 fa-user"></i> Người dùng mới hôm nay</p>
        </div>
        <a href="/admin/donhangs?TTDonHang=Đơn%20hàng%20đã%20đặt" class="col bg-primary text-white rounded py-3 mr-4 text-right pr-4 hover">
            <h5 class="mb-2 h3" id="orderCount">{{ $orderedOrders }}</h5>
            <p class="h5"><i class="fa-solid me-1 fa-hourglass-half"></i> Đơn cần xác nhận</p>
        </a>
        <a href="/admin/donhangs?status=processing" class="col bg-success text-white rounded py-3 mr-4 text-right pr-4 hover">
            <h5 class="mb-2 h3" id="orderCount">{{ $pendingOrders }}</h5>
            <p class="h5"><i class="fa-solid me-1 fa-hourglass-half"></i> Đơn đang xử lý</p>
        </a>
        <a href="/admin/donhangs?TTDonHang=Đã%20giao%20hàng%20xong" class="col text-white bg-done rounded py-3 mr-4 text-right pr-4">
            <h5 class="mb-2 h3" id="completedOrderCount">{{ $completedOrdersToday }}</h5>
            <p class="h5"><i class="fa-solid me-1 fa-circle-check"></i> Đơn hoàn thành hôm nay</p>
        </a>
        <a href="/admin/donhangs?TTDonHang=Đơn%20hàng%20đã%20huỷ" class="col text-white rounded py-3 mr-4 text-right pr-4 bg-danger">
            <h5 class="mb-2 h3" id="completedOrderCount">{{ $cancelOrdersToday }}</h5>
            <p class="h5"><i class="fa-solid me-1 fa-triangle-exclamation"></i> Đơn đã huỷ hôm nay</p>
        </a>
    </div>
</div>
<div id="admin-bg">
</div>

@endsection 