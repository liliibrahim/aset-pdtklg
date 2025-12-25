<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Pemantauan Aset ICT — PDT Klang</title>

    {{-- Vite --}}
    @vite(['resources/css/app.css','resources/js/app.js'])

    <style>
        :root {
            --pdt-blue: #0B3B7C;
            --pdt-blue-dark: #092e61;
            --pdt-blue-secondary: #1E40AF;
            --pdt-blue-secondary-dark: #162f85;
        }

        body {
            margin: 0;
            font-family: system-ui, -apple-system, Arial, sans-serif;
            background: #f3f4f6;
            color: #1f2937;
        }

        /* TOP BAR */
        .topbar {
            background: var(--pdt-blue);
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .topbar-left {
            display: flex;
            gap: 12px;
            align-items: center;
        }
        .topbar-left img {
            height: 42px;
        }

        /* HERO WRAPPER */
        .hero {
            max-width: 1200px;
            margin: auto;
            padding: 50px 20px 60px;
            display: flex;
            flex-wrap: wrap;
            gap: 35px;
            align-items: center;
        }

        .hero-text {
            flex: 1 1 350px;
        }

        .hero-title {
            font-size: 36px;
            font-weight: 800;
            line-height: 1.2;
        }

        .hero-desc {
            margin-top: 15px;
            color: #4b5563;
            font-size: 16px;
            max-width: 550px;
        }

        .hero-buttons {
            margin-top: 28px;
            display: flex;
            gap: 14px;
        }

        .btn-primary {
            padding: 12px 24px;
            background: var(--pdt-blue);
            color: white;
            font-weight: 600;
            border-radius: 999px;
            text-decoration: none;
            font-size: 14px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.15);
        }
        .btn-primary:hover {
            background: var(--pdt-blue-dark);
        }

        .hero-image {
            flex: 1 1 350px;
        }
        .hero-image img {
            width: 100%;
            border-radius: 18px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }

        footer {
            text-align: center;
            padding: 20px;
            background: white;
            border-top: 1px solid #e5e7eb;
            font-size: 14px;
            color: #6b7280;
        }
    </style>
</head>

<body>

    {{-- TOP BAR --}}
    <div class="topbar">
        <div class="topbar-left">
            <img src="{{ asset('image/jataselangor.png') }}" alt="Jata Selangor">
            <div>
                <div style="font-weight:700;">PEJABAT DAERAH DAN TANAH KLANG</div>
                <div style="font-size:13px; opacity:.9;">Sistem Pemantauan Aset ICT</div>
            </div>
        </div>

        {{-- Right Side: Email + Logout (only if logged in) --}}
        <div style="display:flex; align-items:center; gap:15px;">
            
            <a href="mailto:pdtklang@selangor.gov.my" style="color:white; text-decoration:none;">
                pdtklang@selangor.gov.my
            </a>

            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        style="
                            background:transparent;
                            border:1px solid white;
                            color:white;
                            padding:4px 10px;
                            font-size:12px;
                            border-radius:6px;
                            cursor:pointer;
                        ">
                        Log Keluar
                    </button>
                </form>
            @endauth

        </div>
    </div>

    {{-- FLASH MESSAGE: SUCCESS --}}
@if (session('success'))
    <div style="
        max-width: 1200px;
        margin: 20px auto 0;
        padding: 12px 20px;
        background: #ecfdf5;
        border: 1px solid #34d399;
        color: #065f46;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 500;
    ">
        {{ session('success') }}
    </div>
@endif

    {{-- HERO SECTION --}}
    <section class="hero">

        {{-- TEKS --}}
        <div class="hero-text">
            <h1 class="hero-title">
                Sistem Pemantauan Aset ICT<br>
                Pejabat Daerah dan Tanah Klang
            </h1>

            <p class="hero-desc">
                Platform untuk mengurus inventori, penempatan, penyelenggaraan
                dan pelupusan aset ICT di PDT Klang.
            </p>

            <div class="hero-buttons">

                {{-- USER BELUM LOGIN --}}
            @guest
                <a href="{{ route('login') }}" class="btn-primary">Log Masuk</a>

                <a href="{{ route('register') }}"
                style="
                        padding:12px 24px;
                        border:2px solid var(--pdt-blue);
                        color:var(--pdt-blue);
                        font-weight:600;
                        border-radius:999px;
                        text-decoration:none;
                        font-size:14px;
                ">
                    Daftar Akaun
                </a>
            @endguest
            
@guest
    <div class="mt-3 text-xs text-gray-500">
    Belum mempunyai akaun? Sila daftar.
</div>
@endguest
            </div>
        </div>

        {{-- GAMBAR --}}
        <div class="hero-image">
            <img src="{{ asset('image/technologyICT.jpg') }}" alt="Teknologi ICT">
        </div>

    </section>

    {{-- FOOTER --}}
    <footer>
        © {{ date('Y') }} Pejabat Daerah dan Tanah Klang — Sistem Pemantauan Aset ICT
    </footer>

</body>
</html>
