<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Login - Library Girls</title>

    <style>

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;

            font-family: 'Times New Roman', Times, serif;

            background: #fdeef3;
        }

        .login-card {
            width: 380px;
            padding: 35px;

            background: white;

            border-radius: 20px;

            box-shadow:
                0 10px 30px rgba(185, 94, 130, .15);
        }

        .logo {
            text-align: center;
            font-size: 35px;
            margin-bottom: 5px;
        }

        h1 {
            text-align: center;
            color: #8d4565;
            margin-bottom: 5px;
        }

        .subtitle {
            text-align: center;
            color: #888;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            color: #6b3a4f;
            font-weight: bold;
        }

        input {
            width: 100%;
            box-sizing: border-box;

            padding: 12px;

            margin-bottom: 18px;

            border: 1px solid #e5b9ca;

            border-radius: 10px;
        }

        input:focus {
            outline: none;
            border-color: #d2789b;
        }

        button {
            width: 100%;

            padding: 12px;

            border: none;
            border-radius: 10px;

            background: #d2789b;
            color: white;

            font-size: 16px;
            font-weight: bold;

            cursor: pointer;
        }

        button:hover {
            background: #b95e82;
        }

        .error {
            padding: 10px;
            margin-bottom: 18px;

            background: #f8d7da;
            color: #842029;

            border-radius: 8px;
        }

    </style>

</head>

<body>

    <div class="login-card">

        <div class="logo">
            🎀
        </div>

        <h1>Library Girls</h1>

        <div class="subtitle">
            Silakan login untuk melanjutkan
        </div>

        <?php if (isset($error)): ?>

            <div class="error">
                <?= htmlspecialchars($error) ?>
            </div>

        <?php endif; ?>

        <form
            method="POST"
            action="/library/public/login"
        >

            <label>
                Username
            </label>

            <input
                type="text"
                name="username"
                placeholder="Masukkan username"
                required
            >

            <label>
                Password
            </label>

            <input
                type="password"
                name="password"
                placeholder="Masukkan password"
                required
            >

            <button type="submit">
                Login
            </button>

        </form>

            <div style="
    text-align: center;
    margin-top: 20px;
    color: #777;
">

    Belum punya akun?

    <a
        href="/library/public/register"
        style="
            color: #b95e82;
            text-decoration: none;
            font-weight: bold;
        "
    >
        Daftar sekarang
    </a>

</div>

    </div>
            
</body>

</html>