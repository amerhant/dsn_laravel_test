@extends('layouts.app')
@section('content')
<div class="container"> 
    <div class="row">  
        <form class="form-signin" role="form" method='POST' enctype="multipart/form-data" action = '/employees/<?php echo $item->id ?>'>
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
                    <input type="text" name='surname' value="<?php echo old('surname')==null?$item->surname:old('surname'); ?>" class="form-control" required>
                    <label for="name">Имя:</label>
                    <input type="text" name='name' value="<?php echo old('name')==null?$item->name:old('name'); ?>" class="form-control" required>
                    <label for="patronymic">Отчество:</label>
                    <input type="text" name='patronymic' value="<?php echo old('patronymic')==null?$item->patronymic:old('patronymic'); ?>" class="form-control" required>
                    <label for="position">Должность:</label>
                    <input type="text" name='position' value="<?php echo old('position')==null?$item->position:old('position'); ?>" class="form-control" required>
                    <label for="year_birth">Год рождения:</label>
                    <input type="number" name='year_birth' value="<?php echo old('year_birth')==null?$item->year_birth:old('year_birth'); ?>" class="form-control" required>
                    <label for="year_salary">Годовая зарплата:</label>
                    <input type="number" name='year_salary' value="<?php echo old('year_salary')==null?$item->year_salary:old('year_salary'); ?>" class="form-control" required>
                    <label for="currency">Валюта:</label>
                    <input type="text" name='currency' value="<?php echo old('currency')==null?$item->currency:old('currency'); ?>" class="form-control" required>
                    <br>
                    <input type="hidden" name="_method" value="PUT">
                    <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Сохранить</button>
                </div>
            </div> 
        </form>
    </div>
</div>   
@endsection