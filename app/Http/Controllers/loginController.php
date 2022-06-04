<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Validation\ValidationException;

class loginController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function loginfrontend()
	{
		return view('auth.login', ["title" => "Login"]);
	}

	public function postlogin(Request $request)
	{
		$request->validate([
			'username' => 'required',
			'password' => 'required',
			'captcha' => 'required|captcha'
		], [
			'username' => 'Username wajib diisi',
			'password' => 'Passoword wajib diisi',
			'captcha' => 'Captcha tidak valid'
		]);

		$credentials = [
			'username' => $request->username,
			'password' => $request->password,
		];

		if (Auth::attempt($credentials)) {
			$user = Auth::getProvider()->retrieveByCredentials($credentials);
			Auth::login($user, $request->get('remember'));
			$request->session()->regenerate();
			$userRole = Auth::user()->role;

			if ($userRole == "mainadmin") {
				return redirect()->intended('/homemainadmin');
			} elseif ($userRole == "admin") {
				return redirect()->intended('/homeadmin');
			} elseif ($userRole == "user") {
				return redirect()->intended('/home');
			} elseif ($userRole == "surveiyor") {
				return redirect()->intended('/homesyor');
			}
		} else {
			return \back()->with('errors', 'Username atau password salah');
		}

		return redirect('login')->with('error', 'login error');
	}

	public function forgotfrontend()
	{
		return view('auth.forgot', ["title" => "Forgot Password"]);
	}

	public function reloadCaptcha()
	{
		return response()->json(['captcha' => captcha_img()]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}
}
