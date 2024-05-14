@foreach($categories as $category)
    <section class="sublist-item">
        <section class="sublist-item-toggle">{{ $category->name }}</section>
        <section class="sublist-item-sublist">
            <section class="sublist-item-sublist-wrapper d-flex justify-content-around align-items-center">
                @if($category->children)
                    @include('customer.layouts.menu.sub-categories' , ['subCategories' => $category->children])
                @endif
            </section>
        </section>
    </section>
@endforeach
