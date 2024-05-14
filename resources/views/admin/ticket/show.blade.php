@extends('admin.layouts.master')

@section('head-tag')
<title>نمایش تیکت ها</title>
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item font-size-12"> <a href="#"> خانه</a></li>
      <li class="breadcrumb-item font-size-12"> <a href="#"> بخش تیکت ها</a></li>
      <li class="breadcrumb-item font-size-12"> <a href="#"> تیکت ها</a></li>
      <li class="breadcrumb-item font-size-12 active" aria-current="page"> نمایش تیکت ها</li>
    </ol>
  </nav>


  <section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                نمایش تیکت ها
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="{{ route('admin.ticket.index') }}" class="btn btn-info btn-sm">بازگشت</a>
            </section>

            <section class="card mb-3">
                <section class="card-header text-white bg-custom-pink">
               {{ $ticket->user->fullName }} --  {{ $ticket->id }}
                </section>
                <section class="card-body">
                    <h5 class="card-title">موضوع :{{ $ticket->subject }}
                    </h5>
                    <p class="card-text">{{ $ticket->description }}
                    </p>
                </section>
            </section>

            <div class="border my-2">
                @foreach ($ticket->children as $child)

                    <section class="card m-4">
                        <section class="card-header bg-light d-flex justify-content-between">
                            <div>
                                {{ $child->user->fullName}}  - پاسخ دهنده : {{ $child->admin ? $child->admin->user->fullName : 'نامشخص' }}
                            </div>
                            <small>{{ jalaliDate($child->created_at) }}</small>
                        </section>
                        <section class="card-body">
                            <p class="card-text">
                                {{ $child->description }}
                            </p>
                        </section>
                    </section>
                @endforeach
            </div>

            @if($ticket->parent == null)

            <section>
                <form action="{{ route('admin.ticket.answer' , $ticket->id) }}" method="post">
                    @csrf
                    <section class="row">
                        <section class="col-12">
                            <div class="form-group">
                                <label for="">پاسخ تیکت </label>
                               <textarea class="form-control form-control-sm" name="description" rows="4">
                                   {{ old('description') }}
                               </textarea>
                                @error('description')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                </span>
                                @enderror
                            </div>
                        </section>
                        <section class="col-12">
                            <button class="btn btn-primary btn-sm">ثبت</button>
                        </section>
                    </section>
                </form>
            </section>

            @endif

        </section>
    </section>
</section>

@endsection
