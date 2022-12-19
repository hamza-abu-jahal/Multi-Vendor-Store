<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $request = request();

        $categories = Category::leftJoin('categories as parents', 'parents.id', '=' , 'categories.parent_id')
            ->select([
                'categories.*',
                'parents.name as parent_name'
            ])
            ->selectRaw('(SELECt COUNT(*) FROM products WHERE category_id = categories.id) as products_count')
            ->filter($request->query())
            ->orderBy('categories.name')
            ->withTrashed()
            ->paginate(3); // collection

        return view('dashboard.categories.index' ,compact('categories'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parents = Category::all();
        $category = new Category();
        return view('dashboard.categories.create' , compact('parents' , 'category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate(Category::rules() , [
            'required' => 'This field (:attribute) is required',
            'name.unique' => 'This is name already exists!',

        ]);


        $request->merge([
           'slug' => Str::slug($request->post('name'))
        ]);

        $data = $request->except('image');


        $data['image'] = $this->UploadImage( $request);


        Category::create( $data );

        return redirect()->route('dashboard.categories.index')->with('success' , 'Categroy Created!');  //PRG
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {

        return view('dashboard.categories.show' , [
            'category' => $category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $category = Category::findOrFail($id);
        } catch (Exception $e){
            return redirect()->route('dashboard.categories.index')->with('info' , 'Record Not Found !');  //PRG
        }

        $parents = Category::where('id' , '<>' , $id)
        ->where(function($query) use ($id){

            $query->whereNull('parent_id')
                  ->orwhere('parent_id' , '<>' , $id);
        })
        ->get();

        return view('dashboard.categories.edit' , compact('category' , 'parents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate(Category::rules($id));

        $category = Category::findOrFail($id);

        $old_image = $category->image;

        $data = $request->except('image');

        $new_image = $this->UploadImage( $request);

        if($new_image) {
            $data['image'] = $new_image;
        }


        $category->update($data);

        if($old_image && $new_image)
        {
           Storage::disk('public')->delete($old_image);
        }

        return redirect()->route('dashboard.categories.index')->with('success' , 'Categroy Updated!');  //PRG

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //Category::destroy($id);
        //$category = Category::findOrFail($id);
        $category->delete(); // by model biding

        // if($category->image)
        // {
        //     Storage::disk('public')->delete($category->image);
        // }

        return redirect()->route('dashboard.categories.index')->with('success' , 'Categroy Deleted !');  //PRG


    }


    protected function UploadImage (Request $request)
    {

        if(!$request->hasFile('image')) {
            return;
        }

            $file = $request->file('image');
            $path = $file->store('upload' , [
                        'disk' => 'public'
                    ]);

            return $path;
    }




    public function trash()
    {
        $categories = Category::onlyTrashed()->paginate(3);
        return view('dashboard.categories.trash',compact('categories'));
    }


    public function restore($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('dashboard.categories.trash')->with('success' , 'Category Restored !');
    }


    public function forseDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();

        if($category->image)
        {
            Storage::disk('public')->delete($category->image);
        }

        return redirect()->route('dashboard.categories.trash')->with('success' , 'Category Delete Forever !');
    }
}


