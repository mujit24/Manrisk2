<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\BeforeValidException;
use Illuminate\Support\Facades\Http;
use App\Models\User;


class AuthController extends Controller
{

    public function login(Request $request)
    {
        if ($request->has('token') && env('DEVELOPMENT', false)) {
            $token = $request->get('token');
            $env_api_erp_host = env('API_ERP_HOST');
            try {
                $credentials = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
                // Ambil user berdasarkan ID atau email di token
                // Cek jika token tidak tersedia
                if (! $token) {
                    return response()->json(['error' => 'Token tidak ditemukan di session.'], 401);
                }
                $user = User::find($credentials->sub); // atau User::where('email', $decoded->email)->first();
                if (!$user) {
                    return view('404', ['error' => 'User not found']);
                }
                // Login user secara manual ke Auth
                Auth::login($user);
                $env_api_erp_host = env('API_ERP_HOST');
                $cleanUrl = preg_replace('#^https?://#', '', request()->getSchemeAndHttpHost());
                $data_hak_akses = Http::withToken($token)->get($env_api_erp_host . '/data_akses', [
                    'app_url' => $cleanUrl
                ]);
                $request->session()->regenerate();
                $request->session()->put('token', $token);
                $request->session()->put('akses', $data_hak_akses['data']['akses']);
                $request->session()->put('menu', $data_hak_akses['data']['menu']);
                $redirect = $request->get('rd');
                if($redirect) {
                    return redirect()->away($redirect);
                } else {
                    return redirect()->intended(RouteServiceProvider::HOME)->with('success', 'Login berhasil!');
                }

            } catch (ExpiredException $e) {
                return view('404', ['error' => 'Token expired']);
            } catch (SignatureInvalidException $e) {
                return view('404', ['error' => 'Invalid signature']);
            } catch (BeforeValidException $e) {
                return view('404', ['error' => 'Token not valid yet']);
            } catch (\UnexpectedValueException $e) {
                return view('404', ['error' => 'Invalid token structure']);
            } catch (\Exception $e) {
                return view('404', ['error' => 'Token error: ' . $e->getMessage()]);
            }
        } else {
            if(env('DEVELOPMENT', false)){
                $env_api_erp_host = env('ERP_HOST');
                return redirect($env_api_erp_host);
            } else {
                return view('pages.page-login');
            }
        }
    }

    public function authenticating(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        if(env('DEVELOPMENT', false)){
            $env_api_erp_host = env('ERP_HOST');
            return redirect($env_api_erp_host);
        } else {
            return redirect('/login');
        }
    }

}
