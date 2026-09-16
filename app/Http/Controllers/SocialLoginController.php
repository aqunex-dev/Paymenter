<?php

namespace App\Http\Controllers;

use App\Actions\Auth\Login;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\GithubProvider;
use Laravel\Socialite\Two\GoogleProvider;
use SocialiteProviders\Discord\Provider as DiscordProvider;
use SocialiteProviders\OpenIDConnect\Provider as OIDCProvider;

class SocialLoginController extends Controller
{
    protected $discord_driver;

    protected $github_driver;

    protected $google_driver;

    public function __construct()
    {
        $this->discord_driver = Socialite::buildProvider(DiscordProvider::class, [
            'client_id' => config('settings.oauth_discord_client_id'),
            'client_secret' => config('settings.oauth_discord_client_secret'),
            'redirect' => '/oauth/discord/callback',
        ]);

        $this->github_driver = Socialite::buildProvider(GithubProvider::class, [
            'client_id' => config('settings.oauth_github_client_id'),
            'client_secret' => config('settings.oauth_github_client_secret'),
            'redirect' => '/oauth/github/callback',
        ]);

        $this->google_driver = Socialite::buildProvider(GoogleProvider::class, [
            'client_id' => config('settings.oauth_google_client_id'),
            'client_secret' => config('settings.oauth_google_client_secret'),
            'redirect' => '/oauth/google/callback',
        ]);
    }

    protected function oidcDriver()
    {
        $clientId = config('settings.oauth_oidc_client_id');
        $clientSecret = config('settings.oauth_oidc_client_secret');
        $redirect = '/oauth/oidc/callback';
        $baseUrl = config('settings.oauth_oidc_base_url');
        $scopes = config('settings.oauth_oidc_scopes') ?: 'openid email profile';

        $provider = Socialite::buildProvider(OIDCProvider::class, [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'redirect' => $redirect,
        ]);

        // Socialite's buildProvider only passes client_id/secret/redirect/scopes.
        // OIDC needs additional keys (base_url, scopes, etc.) via Manager's Config.
        $config = new \SocialiteProviders\Manager\Config($clientId, $clientSecret, $redirect, [
            'base_url' => $baseUrl,
            'scopes' => $scopes,
        ]);
        $provider->setConfig($config);

        return $provider;
    }

    public function redirect($provider)
    {
        if (!config("settings.oauth_$provider")) {
            abort(404);
        }

        return match ($provider) {
            'discord' => $this->discord_driver->scopes(['email'])->redirect(),
            'github' => $this->github_driver->scopes(['user:email'])->redirect(),
            'google' => $this->google_driver->scopes(['email'])->redirect(),
            'oidc' => $this->oidcDriver()->redirect(),
            default => abort(404)
        };
    }

    public function handle($provider)
    {
        $action = new Login;
        if ($provider == 'discord') {
            $oauth_user = $this->discord_driver->user();

            if ($oauth_user->user['verified'] == false) {
                return redirect()->route('login')->with('error', __('auth.oauth.unverified_discord_account'));
            }

            return $this->findUserAndLogin($oauth_user->email);
        } elseif ($provider == 'google') {
            $oauth_user = $this->google_driver->user();

            if (!$oauth_user->user['email_verified']) {
                return redirect()->route('login')->with('error', __('auth.oauth.unverified_google_account'));
            }

            return $this->findUserAndLogin($oauth_user->email);
        } elseif ($provider == 'github') {
            $oauth_user = $this->github_driver->user();

            return $this->findUserAndLogin($this->github_driver->user()->email);
        } elseif ($provider == 'oidc') {
            $oauth_user = $this->oidcDriver()->user();

            $email = $oauth_user->getEmail();

            if (!$email) {
                return redirect()->route('login')->with('error', __('auth.oauth.no_email'));
            }

            // Optional: respect email_verified claim when present
            $raw = $oauth_user->getRaw();
            if (array_key_exists('email_verified', $raw) && !$raw['email_verified']) {
                return redirect()->route('login')->with('error', __('auth.oauth.unverified_oidc_account'));
            }

            return $this->findUserAndLogin($email);
        } else {
            return redirect()->route('login');
        }
    }

    private function findUserAndLogin(string $email): RedirectResponse
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('register')->with('error', __('auth.oauth.account_not_registered'));
        }

        if ($user->tfa_secret) {
            Session::put('2fa', [
                'user_id' => $user->id,
                'remember' => true,
                'expires' => now()->addMinutes(5),
            ]);

            return redirect()->route('2fa');
        }

        (new Login)->execute($user, true);

        return redirect()->route('home');
    }
}
