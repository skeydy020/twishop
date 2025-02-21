@extends('admin.main')

@section('content')
    <form action="" method="POST">
        <div class="card-body">
            
        <div class="form-group">
                        <label>Phân quyền người dùng</label>
                        <select class="form-control" name="role_id">
                            @foreach($quyens as $quyen)
                                <option value="{{ $quyen->id }}" {{ $user->role_id == $quyen->id ? 'selected' : '' }}>
                                    {{ $quyen->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Cập Nhật Quyền Người Dùng</button>
        </div>
        @csrf
    </form>
@endsection

