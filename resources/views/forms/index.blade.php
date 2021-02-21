@extends('forms.layout')
 
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb"> {{-- adauga margini --}}
            <div class="pull-left"> {{-- tine in stanga --}}
                <h2>Formular de contact</h2>
            </div>
            <div class="pull-right"> {{-- tine in dreapta --}}
                <a class="btn btn-success" href="{{ route('forms.create') }}"> Create </a> {{-- duce in viewul create--}}
            </div>
        </div>
    </div>
   
    @if ($message = Session::get('success')) {{-- errori --}}
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
   
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>          {{-- headere--}}
            <th>Details</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($forms as $form)
        <tr>
            <td>{{ ++$i }}</td>        
            <td>{{ $form->name }}</td>
            <td>{{ $form->email }}</td>         {{-- date celule--}}
            <td>{{ $form->phone }}</td>
            <td>{{ $form->detail }}</td>
            <td>
                <form action="{{ route('forms.destroy',$form->id) }}" method="POST">    {{-- sterge formular --}}
   
                    <a class="btn btn-info" href="{{ route('forms.show',$form->id) }}">Show</a> {{-- arata date formular --}}
    
                    <a class="btn btn-primary" href="{{ route('forms.edit',$form->id) }}">Edit</a>  {{-- editeaza formular --}}
   
                    @csrf
                    @method('DELETE')
    
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
        {!! NoCaptcha::renderJs() !!}
    </table>    
@endsection