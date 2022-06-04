<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExampleController extends Controller
{
  public function getExample()
  {
    return view('example');
  }

  public function postExample(Request $request)
  {
    // validate the user-entered Captcha code when the form is submitted
    $code = $request->input('CaptchaCode');
    $isHuman = captcha_validate($code);

    if ($isHuman) {
      // Captcha validation passed
      // TODO: continue with form processing, knowing the submission was made by a human
      return redirect()
            ->back()
            ->with('status', 'CAPTCHA validation passed, human visitor confirmed!');
    }

    // Captcha validation failed, return an error message
    return redirect()
          ->back()
          ->withErrors(['CaptchaCode' => 'CAPTCHA validation failed, please try again.']);
  }
}