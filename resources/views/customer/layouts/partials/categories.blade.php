@foreach($categories as $category)

<span class="sidebar-nav-item-title">
    <a href="{{ route('customer.products' ,['search' => request()->search, 'category' => $category->id , 'sort' => request()->sort, 'min_price' => request()->min_price, 'max_price' => request()->max_price , 'brands' => request()->brands ] ) }}" class="d-inline">{{ $category->name }}</a>
    @if($category->children->count() > 0)
    <i class="fa fa-angle-left"></i>
    @endif
</span>
@if($category->children->count() > 0)
@include('customer.layouts.partials.sub-categories', ['categories' => $category->children])
@endif

@endforeach
