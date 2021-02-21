<?php
  
namespace App\Http\Controllers;
   
use App\Models\Form;
use Illuminate\Http\Request;
  
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
            'email' => 'required',
            'phone' => 'required',          # Inregistrare in baza de date
            'detail' => 'required',
            'g-recaptcha-response' => 'required|captcha',

        ]);
    
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
        return view('forms.show',compact('form'));
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
            'email' => 'required',
            'phone'=> 'required',
            'detail' => 'required',                     # Actualziare date idem create
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