<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Library Girls</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&family=Gloock&display=swap"
        rel="stylesheet"
    >

    <style>

        /* ============================================================
           PALET PINK COQUETTE
           ============================================================ */
        :root {
            --blush:     #fdf2f5;   /* latar halaman       */
            --cream:     #fffaf7;   /* kartu / panel       */
            --rose:      #e8a9c0;   /* sidebar utama       */
            --rose-deep: #d2789b;   /* aksen kuat / tombol */
            --rose-dark: #b95e82;   /* hover               */
            --ribbon:    #f6d3de;   /* border lembut       */
            --ink:       #6b4a56;   /* teks utama          */
            --ink-soft:  #a4818f;   /* teks sekunder       */
            --sidebar-w: 258px;
        }

        body {
            background-color: var(--blush);
            background-image:
                radial-gradient(circle at 18% 12%, rgba(255, 255, 255, .85) 0 2px, transparent 3px),
                radial-gradient(circle at 68% 62%, rgba(232, 169, 192, .30) 0 2px, transparent 3px);
            background-size: 120px 120px, 90px 90px;
            font-family: 'Times New Roman', Times, serif;
            color: var(--ink);
        }


        /* ============================================================
           SIDEBAR
           ============================================================ */
        .sidebar {
            width: var(--sidebar-w);
            position: fixed;
            left: 14px;
            top: 14px;
            bottom: 14px;
            display: flex;
            flex-direction: column;
            padding: 20px 16px 18px;
            border-radius: 26px;
            background: linear-gradient(180deg, #f3bfd2 0%, var(--rose) 55%, #e096b2 100%);
            box-shadow: 0 10px 30px rgba(185, 94, 130, .18);
            overflow-y: auto;
            scrollbar-width: thin;
        }

        /* --- papan nama / brand --- */
        .sidebar-brand {
            background: var(--cream);
            border: 2px solid #ffffff;
            border-radius: 20px;
            padding: 16px 14px 14px;
            text-align: center;
            box-shadow: 0 6px 14px rgba(185, 94, 130, .16);
            position: relative;
        }

        /* kilau bintang kecil di sekitar judul */
        .sidebar-brand .spark {
            position: absolute;
            color: var(--rose-deep);
            line-height: 1;
            pointer-events: none;
        }
        .sidebar-brand .spark-1 { top: 12px;    left: 18px;  font-size: 11px; }
        .sidebar-brand .spark-2 { top: 28px;    right: 16px; font-size: 8px;  }
        .sidebar-brand .spark-3 { bottom: 30px; left: 14px;  font-size: 7px;  }
        .sidebar-brand .spark-4 { bottom: 12px; right: 24px; font-size: 10px; }

        /* judul bergaya display serif kontras tinggi, dua baris rapat */
        .sidebar-brand .brand-title {
            font-family: 'Gloock', 'Playfair Display', 'Times New Roman', serif;
            font-size: 36px;
            font-weight: 400;
            line-height: .88;
            letter-spacing: -.025em;
            color: var(--ink);
            margin-top: 4px;
        }

        .sidebar-brand .brand-eyebrow {
            font-size: 9.5px;
            letter-spacing: .3em;
            text-transform: uppercase;
            color: var(--ink-soft);
            margin-top: 12px;
        }

        /* --- navigasi --- */
        .sidebar-nav {
            margin-top: 22px;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .sidebar-menu {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 10px 14px;
            border-radius: 14px;
            color: #7c4a5f;
            font-size: 16.5px;
            font-weight: 600;
            text-decoration: none;
            transition: background-color .18s ease, color .18s ease;
        }

        .sidebar-menu .menu-icon {
            width: 28px;
            height: 28px;
            flex: 0 0 28px;
            display: grid;
            place-items: center;
            border-radius: 9px;
            background: rgba(255, 255, 255, .55);
            color: var(--rose-dark);
        }

        .sidebar-menu .menu-svg {
            width: 17px;
            height: 17px;
            display: block;
        }

        .sidebar-menu:hover {
            background: rgba(255, 255, 255, .45);
            color: #6b3a4f;
        }

        .sidebar-menu.active {
            background: var(--cream);
            color: var(--rose-dark);
            box-shadow: 0 5px 12px rgba(185, 94, 130, .16);
        }

        .sidebar-menu.active .menu-icon {
            background: var(--rose-deep);
            color: #ffffff;
        }

        .sidebar-divider {
            height: 1px;
            margin: 16px 6px;
            background: rgba(255, 255, 255, .6);
        }

        .logout-menu {
            color: #8c4a63;
        }

        /* --- kartu tips di kaki sidebar --- */
        .sidebar-note {
            margin-top: auto;
            background: var(--cream);
            border-radius: 18px;
            padding: 13px 14px;
            box-shadow: 0 6px 14px rgba(185, 94, 130, .14);
        }

        .sidebar-note .note-title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 15px;
            color: var(--rose-dark);
            margin-bottom: 3px;
        }

        .sidebar-note .note-text {
            font-size: 12.5px;
            line-height: 1.45;
            color: var(--ink-soft);
        }

        .sidebar-decoration {
            text-align: center;
            font-size: 15px;
            letter-spacing: 6px;
            margin-top: 12px;
            opacity: .75;
        }


        /* ============================================================
           HEADER / TOPBAR
           ============================================================ */
        .main-content {
            margin-left: calc(var(--sidebar-w) + 28px);
            min-height: 100vh;
            padding: 14px 22px 0 0;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
            padding: 20px 26px;
            border-radius: 24px;
            background: var(--cream);
            border: 1px solid var(--ribbon);
            box-shadow: 0 8px 22px rgba(185, 94, 130, .10);
        }

        .topbar-title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 30px;
            font-weight: 600;
            line-height: 1.15;
            color: var(--ink);
        }

        .topbar-subtitle {
            font-size: 14px;
            color: var(--ink-soft);
            margin-top: 4px;
        }

        .topbar-side {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            flex-wrap: wrap;
            gap: 16px;
        }

        /* --- kolom pencarian --- */
        .topbar-search {
            display: flex;
            align-items: center;
            gap: 8px;
            flex: 1 1 320px;
            min-width: 260px;
            max-width: 420px;
            padding: 6px 6px 6px 14px;
            border-radius: 999px;
            background: #fdeef3;
            border: 1px solid var(--ribbon);
            transition: border-color .18s ease, box-shadow .18s ease;
        }

        .topbar-search:focus-within {
            border-color: var(--rose-deep);
            box-shadow: 0 0 0 3px rgba(210, 120, 155, .16);
        }

        .topbar-search .search-icon {
            font-size: 14px;
            line-height: 1;
            margin: 0;
            cursor: text;
        }

        .topbar-search input {
            flex: 1;
            min-width: 0;
            border: 0;
            background: transparent;
            font-size: 14px;
            color: var(--ink);
            outline: none;
        }

        .topbar-search input::placeholder {
            color: var(--ink-soft);
        }

        .topbar-search input::-webkit-search-cancel-button {
            -webkit-appearance: none;
        }

        .topbar-search .search-reset {
            display: grid;
            place-items: center;
            width: 24px;
            height: 24px;
            flex: 0 0 24px;
            border-radius: 50%;
            background: #f7dbe5;
            color: var(--rose-dark);
            font-size: 12px;
            text-decoration: none;
        }

        .topbar-search .search-reset:hover {
            background: var(--rose-deep);
            color: #ffffff;
        }

        .topbar-search button {
            border: 0;
            border-radius: 999px;
            padding: 8px 18px;
            background: var(--rose-deep);
            color: #ffffff;
            font-size: 14px;
            font-weight: 600;
            white-space: nowrap;
        }

        .topbar-search button:hover {
            background: var(--rose-dark);
        }

        /* --- info hasil pencarian di isi halaman --- */
        .search-summary {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 8px 16px;
            margin-bottom: 18px;
            border-radius: 999px;
            background: #fdeef3;
            border: 1px solid var(--ribbon);
            font-size: 13.5px;
            color: var(--ink);
        }

        .search-summary a {
            color: var(--rose-dark);
            font-weight: 600;
            text-decoration: none;
        }

        .search-summary a:hover {
            text-decoration: underline;
        }

        .topbar-meta {
            display: flex;
            flex-direction: column;
            gap: 5px;
            padding: 11px 16px;
            border-radius: 16px;
            background: #fdeef3;
            font-size: 13px;
            color: var(--ink);
        }

        .topbar-meta span {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .topbar-meta .meta-icon {
            color: var(--rose-deep);
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .topbar-user .user-name {
            font-weight: 700;
            font-size: 14px;
        }

        .topbar-user .user-role {
            font-size: 12px;
            color: var(--ink-soft);
        }

        .topbar-avatar {
            width: 44px;
            height: 44px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: var(--rose-deep);
            border: 2px solid #ffffff;
            box-shadow: 0 4px 10px rgba(185, 94, 130, .22);
            color: #ffffff;
            font-size: 18px;
        }


        /* ============================================================
           ISI HALAMAN
           ============================================================ */
        .content {
            padding: 26px 4px 40px;
        }

        .page-title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 26px;
            font-weight: 600;
            color: var(--ink);
        }

        .page-description {
            color: var(--ink-soft);
            margin-bottom: 25px;
        }

        .card {
            border: 1px solid var(--ribbon);
            border-radius: 20px;
            background: var(--cream);
            box-shadow: 0 6px 18px rgba(185, 94, 130, .08);
        }

        .btn-pink {
            background-color: var(--rose-deep);
            border-color: var(--rose-deep);
            color: white;
            border-radius: 12px;
            padding: 9px 18px;
            font-weight: 600;
        }

        .btn-pink:hover {
            background-color: var(--rose-dark);
            border-color: var(--rose-dark);
            color: white;
        }

        .table thead {
            background-color: #fce4ec;
            color: var(--ink);
        }

        .table th {
            font-weight: 600;
        }

        .table td,
        .table th {
            vertical-align: middle;
            padding: 13px;
        }

        .badge-tersedia {
            background-color: #f3c4d8;
            color: #8d4565;
            padding: 7px 12px;
            border-radius: 20px;
        }

        .badge-tidak-tersedia {
            background-color: #eadde2;
            color: #795e68;
            padding: 7px 12px;
            border-radius: 20px;
        }

        a:focus-visible,
        button:focus-visible {
            outline: 2px solid var(--rose-dark);
            outline-offset: 2px;
        }


        /* ============================================================
           RESPONSIF
           ============================================================ */
        @media (max-width: 991px) {

            .sidebar {
                position: static;
                width: auto;
                margin: 14px;
                bottom: auto;
            }

            .sidebar-note {
                margin-top: 18px;
            }

            .main-content {
                margin-left: 0;
                padding: 0 14px;
            }

            .topbar {
                padding: 18px;
            }

            .topbar-title {
                font-size: 24px;
            }

            .topbar-side {
                width: 100%;
                justify-content: flex-start;
            }

            .topbar-search {
                flex-basis: 100%;
                max-width: none;
                order: -1;
            }
        }

    </style>

</head>

<body>
