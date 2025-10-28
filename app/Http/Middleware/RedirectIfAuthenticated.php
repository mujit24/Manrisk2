<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Closure;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $token = $request->get('token');
        $env_api_erp_host = env('API_ERP_HOST');

        if ($token && env('DEVELOPMENT', false)) {
            $sessionToken = session('token');

            // Jika token berbeda dari session, lakukan proses login ulang
            if ($token !== $sessionToken) {
                try {
                    $credentials = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));

                    // Cari user dari ID (sub) atau email
                    $user = User::find($credentials->sub)
                        ?? User::where('email', $credentials->email ?? null)->first();

                    if (! $user) {
                        return response()->view('404', ['error' => 'User not found'], 401);
                    }

                    // Login user manual
                    Auth::login($user);
                    $request->session()->regenerate();
                    $request->session()->put('token', $token);

                    // Ambil hak akses
                    $cleanUrl = preg_replace('#^https?://#', '', $request->getSchemeAndHttpHost());
                    $akses = Http::withToken($token)->get($env_api_erp_host.'/data_akses', [
                        'app_url' => $cleanUrl,
                    ]);

                    if ($akses->successful()) {
                        $request->session()->put('akses', $akses['data']['akses']);
                        $request->session()->put('menu', $akses['data']['menu']);
                    }
                    $redirect = $request->get('rd');
                    if ($redirect) {
                        return redirect()->away($redirect);
                    } else {
                        return redirect()->intended(RouteServiceProvider::HOME)->with('success', 'Login berhasil!');
                    }
                } catch (ExpiredException $e) {
                    return response()->view('404', ['error' => 'Token expired'], 401);
                } catch (SignatureInvalidException $e) {
                    return response()->view('404', ['error' => 'Invalid signature'], 401);
                } catch (BeforeValidException $e) {
                    return response()->view('404', ['error' => 'Token not valid yet'], 401);
                } catch (\UnexpectedValueException $e) {
                    return response()->view('404', ['error' => 'Invalid token structure'], 401);
                } catch (\Exception $e) {
                    return response()->view('404', ['error' => 'Token error: '.$e->getMessage()], 401);
                }
            }
        }

        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
