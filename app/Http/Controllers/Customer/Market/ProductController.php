<?php

namespace App\Http\Controllers\Customer\Market;

use App\Http\Controllers\Controller;
use App\Models\Content\Comment;
use App\Models\Market\Compare;
use App\Models\Market\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\CodeCoverage\Report\PHP;

class ProductController extends Controller
{
    public function product(Product $product)
    {
//        The first method
        $relatedProducts = $product->category->products->except($product->id);

//        The second method
//        $relatedProducts = Product::with('category')->whereHas('category' , function ($category) use($product){
//            $category->where('id' , $product->category->id );
//        })->get()->except($product->id);

        return view('customer.market.product.product' , compact('relatedProducts' , 'product'));
    }

    public function addComment(Product $product , Request $request)
    {
        $request->validate([
         'body' => 'required|max:2000',
            'g-recaptcha-response' => 'recaptcha'
        ]);

        $inputs['body'] = str_replace(PHP_EOL , '<br/>' , $request->body );
        $inputs['author_id'] = Auth::user()->id;
        $inputs['commentable_id'] = $product->id;
        $inputs['commentable_type'] = Product::class;
        Comment::create($inputs);
        return back()->with('swal-success' , 'نظر شما ثبت شد و از طریق ادمین نشان داده میشود');
    }

    public function addToFavorite(Product $product)
    {
        if(Auth::check()){
            $product->user()->toggle(Auth::user()->id);
            if($product->user->contains(Auth::user()->id)){
                return response()->json(['status' => 1]);
            }
            else{
                return response()->json(['status' => 2]);
            }
        }
        else{
            return response()->json(['status' => 3]);
        }
    }

    public function addRate(Product $product , Request $request)
    {
        $productIds = \auth()->user()->isUserPurchedProduct($product->id);
        if(Auth::check() and $productIds->count() > 0 ){
            $user = \auth()->user();
            $user->rate($product , $request->rating);
            return back()->with('alert-section-success' , 'امتیاز شما با موفقیت ثبت گردید');
        }else{
            return back()->with('alert-section-error' , 'شما اجازه ثبت امتیاز ندارید - ابتدا باید محصول را خریداری نمایید');
        }

    }

    public function addToCompare(Product $product)
    {
        if(Auth::check()){
            $user = Auth::user();
            if($user->compare()->count() > 0 ){
                $userCompareList = $user->compare;
            }else{
                $userCompareList =  Compare::create(['user_id' => $user->id]);
            }
            $product->compares()->toggle($userCompareList->id);
            if($product->compares->contains($userCompareList->id)){
                return response()->json(['status' => 1]);
            }
            else{
                return response()->json(['status' => 2]);
            }
        }
        else{
            return response()->json(['status' => 3]);
        }
    }

    public function viewApi()
    {
        return view('api.products');
    }

}
