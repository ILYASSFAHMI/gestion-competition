<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Inscription — Compétition Inter-Écoles</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Space+Grotesk:wght@700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; min-height: 100vh; display: flex; background: #0a0b14; color: #e2e8f0; }
        .left {
            flex: 1; display: flex; align-items: center; justify-content: center;
            padding: 2rem; background: #111827;
        }
        .right {
            flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center;
            padding: 3rem; background: linear-gradient(135deg, #1a1f35 0%, #0f172a 100%);
            position: relative; overflow: hidden;
        }
        .right::before {
            content: ''; position: absolute; width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(99,102,241,0.2) 0%, transparent 70%);
            top: -100px; right: -100px; border-radius: 50%;
        }
        .right::after {
            content: ''; position: absolute; width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(139,92,246,0.15) 0%, transparent 70%);
            bottom: -50px; left: -50px; border-radius: 50%;
        }
        .form-box { width: 100%; max-width: 420px; }
        .brand { font-family: 'Space Grotesk', sans-serif; font-size: 1.5rem; font-weight: 800; margin-bottom: 2.5rem; }
        .brand span { color: #6366f1; }
        h1 { font-family: 'Space Grotesk', sans-serif; font-size: 1.75rem; font-weight: 800; margin-bottom: 0.4rem; }
        .sub { color: #64748b; font-size: 0.9rem; margin-bottom: 2rem; }
        .form-group { margin-bottom: 1.25rem; }
        label { display: block; font-size: 0.75rem; font-weight: 600; color: #64748b; margin-bottom: 0.4rem; letter-spacing: 0.5px; text-transform: uppercase; }
        input {
            width: 100%; background: rgba(0,0,0,0.3); border: 1px solid #1f2937;
            border-radius: 10px; padding: 0.7rem 1rem; color: #e2e8f0;
            font-size: 0.95rem; font-family: 'Inter', sans-serif; outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        input:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,0.15); }
        .form-error { color: #f87171; font-size: 0.8rem; margin-top: 0.3rem; }
        .btn-submit {
            width: 100%; padding: 0.8rem; border-radius: 10px; border: none; cursor: pointer;
            background: #6366f1; color: white; font-size: 1rem; font-weight: 700;
            font-family: 'Inter', sans-serif; transition: all 0.2s; margin-top: 0.5rem;
        }
        .btn-submit:hover { background: #4f46e5; transform: translateY(-1px); box-shadow: 0 4px 20px rgba(99,102,241,0.4); }
        .link { color: #6366f1; font-size: 0.875rem; text-decoration: none; }
        .link:hover { text-decoration: underline; }
        .divider { height: 1px; background: #1f2937; margin: 1.5rem 0; }
        .right-content { position: relative; z-index: 1; text-align: center; max-width: 400px; }
        .trophy { font-size: 5rem; margin-bottom: 1.5rem; }
        .right h2 { font-family: 'Space Grotesk', sans-serif; font-size: 2rem; font-weight: 800; margin-bottom: 1rem; }
        .right p { color: #64748b; line-height: 1.7; }
        .feature { display: flex; align-items: flex-start; gap: 0.75rem; text-align: left; margin-top: 1.5rem; padding: 1rem; background: rgba(99,102,241,0.05); border: 1px solid rgba(99,102,241,0.15); border-radius: 12px; }
        .feature-text { font-size: 0.875rem; color: #94a3b8; line-height: 1.5; }
        .feature-title { font-weight: 600; color: #e2e8f0; margin-bottom: 0.2rem; }
        @media (max-width: 768px) { .right { display: none; } }
    </style>
</head>
<body>
    <div class="left">
        <div class="form-box">
            <div class="brand">🏆 Compétition<span>Écoles</span></div>

            <h1>Créer un compte ✨</h1>
            <p class="sub">Rejoignez la plateforme pour participer au tournoi.</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label for="name">Nom complet</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus placeholder="ex: Ilyass Fahmi">
                    @error('name') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="email">Adresse email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required placeholder="exemple@ecole.ma">
                    @error('email') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input id="password" name="password" type="password" required placeholder="Minimum 8 caractères">
                    @error('password') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmer le mot de passe</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required placeholder="Confirmez le mot de passe">
                </div>

                <button type="submit" class="btn-submit">S'inscrire →</button>
            </form>

            <div class="divider"></div>

            <p style="text-align:center;font-size:0.875rem;color:#64748b;">
                Déjà un compte ?
                <a href="{{ route('login') }}" class="link">Se connecter</a>
            </p>
        </div>
    </div>

    <div class="right">
        <div class="right-content">
            <div class="trophy">🚀</div>
            <h2>Prêt à relever<br>le défi ?</h2>
            <p>Inscrivez-vous dès maintenant pour rejoindre vos camarades et représenter votre établissement.</p>
            <div class="feature">
                <span style="font-size:1.5rem;">🤝</span>
                <div class="feature-text">
                    <div class="feature-title">Travail d'équipe</div>
                    Associez-vous jusqu'à 4 membres pour former une équipe redoutable.
                </div>
            </div>
            <div class="feature" style="margin-top:0.75rem;">
                <span style="font-size:1.5rem;">⭐</span>
                <div class="feature-text">
                    <div class="feature-title">Gagnez des points</div>
                    Hissez votre école à la première place du classement général !
                </div>
            </div>
        </div>
    </div>
</body>
</html>
