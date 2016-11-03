<?php

namespace App\Http\Controllers\Account\Security;

use Hash;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PasswordController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        if (! Hash::check($request->current_password, $request->user()->password)) {
            return response()->json([
                'current_password' => ['The supplied password does not match our records.']
            ], 422);
        }

        $request->user()->forceFill([
            'password' => bcrypt($request->password)
        ])->save();
    }
}
