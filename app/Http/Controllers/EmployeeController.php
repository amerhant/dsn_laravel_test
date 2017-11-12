<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Employee;
use Validator;

class EmployeeController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $employees = Employee::paginate(15);
        return view('employees/index')->with(['employees' => $employees]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('employees/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'surname' => 'required|string|max:20|min:3',
            'name' => 'required|string|max:15|min:3',
            'patronymic' => 'required|string|max:20|min:3',
            'position' => 'required|string|max:30|min:3',
            'year_birth' => 'required|numeric',
            'year_salary' => 'required|numeric',
            'currency' => 'required|string|max:3|min:3',
        ]);

        $options = $request->only('surname', 'name', 'patronymic', 'position', 'year_birth', 'year_salary', 'currency');
        Employee::create($options);
        return redirect()->route('employees.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $item = Employee::find($id);
        return view('employees/update')->with(['item' => $item]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $this->validate($request, [
            'surname' => 'required|string|max:20|min:3',
            'name' => 'required|string|max:15|min:3',
            'patronymic' => 'required|string|max:20|min:3',
            'position' => 'required|string|max:30|min:3',
            'year_birth' => 'required|numeric',
            'year_salary' => 'required|numeric',
            'currency' => 'required|string|max:3|min:3',
        ]);
        $item = Employee::find($id);
        $options = $request->only('surname', 'name', 'patronymic', 'position', 'year_birth', 'year_salary', 'currency');

        $item->surname = $options['surname'];
        $item->name = $options['name'];
        $item->patronymic = $options['patronymic'];
        $item->position = $options['position'];
        $item->year_birth = $options['year_birth'];
        $item->year_salary = $options['year_salary'];
        $item->currency = $options['currency'];
        $item->save();

        return redirect()->route('employees.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $item = Employee::find($id);
        $item->delete();
        return redirect()->route('employees.index');
    }

    public function importExcel(Request $request) {
        if ($request->hasFile('excel')) {
            $book = Excel::load($request->file('excel'), 'UTF-8')->all();
            $headers = $book->first()->keys()->toArray();
        }
        Validator::extend('valid_excel', function($attribute, $value, $parameters) {
            if ($parameters[0] == 6)
                return true;
        });
        $this->validate($request, [
            'excel' => 'required|max:50000|mimes:xls,xlsx|valid_excel:' . count($headers),
        ]);

        Employee::query()->truncate();
        foreach ($book as $value) {
            $options['surname'] = trim($value[$headers[0]]);
            $options['name'] = trim($value[$headers[1]]);
            $options['patronymic'] = trim($value[$headers[2]]);
            $options['year_birth'] = intval($value[$headers[3]]);
            $options['position'] = trim($value[$headers[4]]);
            $options['year_salary'] = intval(preg_replace("/[^0-9]/", '', $value[$headers[5]]));
            $options['currency'] = preg_replace('/[^а-яa-z]/ui', '', $value[$headers[5]]);
            Employee::create($options);
        }
        return redirect()->route('employees.index');
    }

    public function exportExcel() {
        Excel::create('export_excel', function($excel) {
            $excel->sheet('Лист1', function($sheet) {
                $index = 1;
                $employees = Employee::all();
                $sheet->row($index, array('Фамилия', 'Имя', 'Отчество', 'Год. рождения', 'Должность', 'Зп в год.',));
                foreach ($employees as $employee) {
                    $index++;
                    $sheet->row($index, array($employee['surname'], $employee['name'], $employee['patronymic'], $employee['year_birth'], $employee['position'], $employee['year_salary'] . ' ' . $employee['currency'] . '.',));
                }
            });
        })->export('xlsx');
    }

}
