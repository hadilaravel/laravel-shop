@foreach($subCategories as $subCategory)
    <section class="sublist-column col">
        <a href="{{ route('customer.products' ,['search' => request()->search, 'category' => $subCategory->id , 'sort' => request()->sort, 'min_price' => request()->min_price, 'max_price' => request()->max_price , 'brands' => request()->brands ] ) }}" class="sub-category">{{ $subCategory->name }}</a>
    </section>
    @include('customer.layouts.menu.sub-categories' , ['subCategories' => $subCategory->children])
@endforeach
