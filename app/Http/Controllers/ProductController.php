<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Product/Index',[
            'products' => Product::orderBy('name')->get(),

        ]);
    }

    public function search($searchKey){
        return inertia('Product/Index', [
            'products' => Product::where('name', 'like' , "%$searchKey%")->orWhere('description', 'like' , "%$searchKey%")->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::orderBy('name', 'asc')->get();
        return inertia('Product/Create',[
            'products'=>Product::orderBy('name','asc'),
            'suppliers'=>$suppliers,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'sup_id'=>'required|numeric',
            'name' => 'required',
            'description' => 'required',
            'qty' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        $fileName = null;

        //process image
        if($request->pic){
            $fileName = time().'.'.$request->pic->extension();
            $request->pic->move(public_path('images/product_pics'), $fileName);
            $fields['pic'] = $fileName;
        }

        Product::create($fields);

        return redirect('/products')->banner( 'Product Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('supplier');
        return inertia('Product/Show', [
            'product' => $product,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return inertia('Product/Edit', [
            'suppliers'=>Supplier::orderBy('name')->get(),
            'product'=>$product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $fields = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'qty' => 'required|numeric',

        ]);

        $product->update($fields);
        return redirect('/products/' . $product->id)->banner( 'Product Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect('/products')->dangerBanner('Product successfully deleted');
    }

    public function toggle(Product $product){
        $product->active = !$product->active;
        $product->save();

        return back()->banner('Toggle Enable');
    }

    public function email(Product $product){
        $supplier = $product->supplier;
        $pdf = Pdf::loadView('pdf.prod-summary',[
            'product'=>$product,

        ]);

        $filename='prod/' .$product->name . ".pdf";
        $pdf->save($filename);

        Mail::send('emails.sop' ,['product'=>$product], function($message) use ($supplier, $filename){
            $message->to($supplier->email);
            $message->subject('Summary of Product');
            $message->attach($filename);
        });

        return back()->banner('Email has been sent successfully!');


    }
}
