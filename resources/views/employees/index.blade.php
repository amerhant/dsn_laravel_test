@extends('layouts.app')
@section('content')
<div class="container"> 
    <div class="row">  
        <form id="upload" action="/employees/import" enctype="multipart/form-data" method="post">
            <div class="errors">
                @if(count($errors)>0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
                @endif 
            </div>
            {{ csrf_field() }}
            <input type="file" id="file" name="excel" onchange="$('#upload').submit();" style="display: none;">
        </form>
        <div id="employees">
            <table class="table table-striped">
                <tr>
                    <th>Surname</th>
                    <th>Name</th>
                    <th>Patronymic</th>
                    <th>Position</th>
                    <th>Year of birth</th>
                    <th>Year salary</th>
                    <th>Actions</th>
                </tr>
                @foreach ($employees as $employee)
                <tr>
                    <td>{{$employee->surname}}</td>
                    <td>{{$employee->name}}</td>
                    <td>{{$employee->patronymic}}</td>
                    <td>{{$employee->position}}</td>
                    <td>{{$employee->year_birth}}</td>
                    <td>{{$employee->year_salary.' '.$employee->currency.'.'}}</td>
                    <td>
                <center>
                    <form style="float:right;" role="form" method="POST" action = "/employees/{{$employee->id}}">
                        <input type="hidden" name="_method" value="DELETE"> 
                        {{ csrf_field() }}
                        <button class="btn btn-danger btn-sm" type="submit" name="submit">Del</button>
                    </form>
                </center>
                <a role="button" style="float:right;" class="btn btn-primary btn-sm" href="/employees/{{$employee->id}}/edit">Edit</a>
                </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
    <div class="row">
        <div id="pagination" class="col-md-10">
            {{ $employees->links() }}
        </div> 
    </div>
</div>   
@endsection