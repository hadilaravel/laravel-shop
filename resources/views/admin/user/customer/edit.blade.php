@extends('admin.layouts.master')

@section('head-tag')
<title>ویرایش کاربر مشتری</title>
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
      <li class="breadcrumb-item font-size-12"> <a href="#">بخش کاربران</a></li>
      <li class="breadcrumb-item font-size-12"> <a href="#">کاربران مشتری</a></li>
      <li class="breadcrumb-item font-size-12 active" aria-current="page"> ویرایش کاربر مشتری</li>
    </ol>
  </nav>


  <section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                  ویرایش کاربر مشتری
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="{{ route('admin.user.customer.index') }}" class="btn btn-info btn-sm">بازگشت</a>
            </section>

            <section>
                <form action="{{ route('admin.user.customer.update' , $user->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <section class="row">

                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">نام</label>
                                <input type="text" name="first_name" value="{{ old('first_name' , $user->first_name) }}" class="form-control form-control-sm">
                            </div>
                            @error('first_name')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>

                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">نام خانوادگی</label>
                                <input type="text" name="last_name"  value="{{ old('last_name' , $user->last_name) }}" class="form-control form-control-sm">
                            </div>
                            @error('last_name')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>


                    <section class="col-12 ">
                            <div class="form-group">
                                <label for="">تصویر</label>
                                <input type="file" name="profile_photo_path" class="form-control form-control-sm">
                                <img class="mt-2" src="{{ asset($user->profile_photo_path) }}" width="150px" height="150px" >
                            </div>
                        @error('profile_photo_path')
                        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                    </section>

                        <section class="col-12">
                            <input type="submit" class="btn btn-primary btn-sm" value="ثبت">
                        </section>
                    </section>
                </form>
            </section>

        </section>
    </section>
</section>

@endsection
