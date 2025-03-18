<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function store()
    {
        $validation = request()->validate([
            'emailAddress' => 'required|email'
        ]);
        if ($validation) {
            Subscriber::create([
                'email' => request('emailAddress')
            ]);
        }
        return redirect('http://localhost:5174');
    }
}
