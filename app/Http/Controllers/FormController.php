<?php
  
namespace App\Http\Controllers;
   
use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use Image;


class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $forms = Form::latest()->paginate(8);    
    
        return view('forms.index',compact('forms'))
            ->with('i', (request()->input('page', 1) - 1) * 5);  # Navigare pagini
    }
     
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('forms.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:forms,email',
            'phone' => 'required',          # Inregistrare in baza de date
            'detail' => 'required',
            'image' => 'required|max:2048' ,   # mimes:jpeg,pdf nu mai pot uploada
            'g-recaptcha-response' => 'required|captcha',

        ]);
        $form = new Form($request->input()) ;
        $file = $request->file('image') ;
        
        if($file = $request->hasFile('image')) {
            $file = $request->file('image') ;
            $fileName = $file->getClientOriginalName() ;
            $destinationPath = public_path().'/storage/' ;
            $file->move($destinationPath,$fileName);
            $form->image = $fileName ;
                };
                
        $form->save(); 
       /*
       $img = $request->file('image');
       $extension = $img->getClientOriginalExtension();
       Storage::disk('public')->put($img->getFilename().'.'.$extension,  File::get($img));
   
       $form = new Form();
       
       $form->mime = $img->getClientMimeType();
       $form->image = $img->getClientOriginalName();
       $form->filename = $img->getFilename().'.'.$extension;
       $form->save();    
         */           
        Form::create($request->all());  # toate datele
     
        return redirect()->route('forms.index')     # redirectionare pagina principala dupa inregistrare in DB
                        ->with('success','Form created successfully.');
    }
     
    /**
     * Display the specified resource.
     *
     * @param  \App\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function show(Form $form)
    {
        $request = new Request ;
        return view('forms.show',compact('form'));
        $form = new Form($request->input()) ;
        $file = $request->file('image') ;
        
        if($file = $request->hasFile('image')) {
            $file = $request->file('image') ;
            $fileName = $file->getClientOriginalName() ;
            $destinationPath = public_path().'/storage/' ;
            $file->move($destinationPath,$fileName);
            $form->image = $fileName ;
                };
                
        $form->save(); 
    } 
     
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function edit(Form $form)
    {
        return view('forms.edit',compact('form'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Form $form)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:forms,email',
            'phone'=> 'required',
            'detail' => 'required',
            'image' => 'required|max:2048',                     # Actualziare date idem create
            'g-recaptcha-response' => 'required|captcha',
        ]);
    
        $form->update($request->all());
    
        return redirect()->route('forms.index')
                        ->with('success','Form updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function destroy(Form $form)
    {
        $form->delete();
    
        return redirect()->route('forms.index')
                        ->with('success','Form deleted successfully');
    }
}