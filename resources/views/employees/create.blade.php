@extends('layouts.app')
@section('content')
<div class="container"> 
    <div class="row">  
        <form class="form-signin" role="form" method='POST' enctype="multipart/form-data" action = '/employees'>
            <div class="row">
                <div class="col-md-6">
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
                    <label for="surname">Фамилия:</label>
                    <input type="text" name='surname' value="{{old('surname')}}" class="form-control" required>
                    <label for="name">Имя:</label>
                    <input type="text" name='name' value="{{old('name')}}" class="form-control" required>
                    <label for="patronymic">Отчество:</label>
                    <input type="text" name='patronymic' value="{{old('patronymic')}}" class="form-control" required>
                    <label for="position">Должность:</label>
                    <input type="text" name='position' value="{{old('position')}}" class="form-control" required>
                    <label for="year_birth">Год рождения:</label>
                    <input type="number" name='year_birth' value="{{old('year_birth')}}" class="form-control" required>
                    <label for="year_salary">Годовая зарплата:</label>
                    <input type="number" name='year_salary' value="{{old('year_salary')}}" class="form-control" required>
                    <label for="currency">Валюта:</label>
                    <input type="text" name='currency' value="{{old('currency')}}" class="form-control" required>
                    <br>
                    <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Добавить</button>
                </div>
            </div> 
        </form>
    </div>
</div>   
@endsection