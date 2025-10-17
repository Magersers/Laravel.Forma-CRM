<?php

namespace App\Http\Controllers;

use App\Models\users_zad;
use Illuminate\Http\Request;

class forma extends Controller
{

    public function form_valid(Request $req)
    {

    $valid = $req->validate([
    'name'      => 'required|string|max:100|min:6',
    'email'     => 'required|email|max:100',
    'phone'     => 'required|phone:RU|max:20',
    'opisanie'  => 'required|string|max:5000',
    ], [
    // Имя
    'name.required' => 'Поле «Имя» обязательно для заполнения.',
    'name.string'   => 'Поле «Имя» должно быть текстом.',
    'name.max'      => 'Поле «Имя» не должно превышать 100 символов.',
    'name.min'      => 'Поле «Имя» должно содержать не менее 6 символов.',

    // Email
    'email.required' => 'Поле «Email» обязательно для заполнения.',
    'email.email'    => 'Пожалуйста, введите корректный адрес электронной почты.',
    'email.max'      => 'Адрес электронной почты не должен превышать 100 символов.',

    // Телефон
    'phone.required' => 'Поле «Телефон» обязательно для заполнения.',
    'phone.phone'    => 'Пожалуйста, введите корректный номер телефона (в международном формате, например: +79101234567).',
    'phone.max'      => 'Номер телефона не должен превышать 20 символов.',

    // Описание
    'opisanie.required' => 'Поле «Описание» обязательно для заполнения.',
    'opisanie.string'   => 'Поле «Описание» должно быть текстом.',
    'opisanie.max'      => 'Поле «Описание» не должно превышать 5000 символов.',
]);

        $valid['status'] = 'new';
        $valid['arhiv'] = true;
        
        users_zad::create($valid);

        return redirect()->route('home');
    }
}
