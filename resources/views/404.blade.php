<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <link rel="icon"
        href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAMAAABEpIrGAAAA3lBMVEVHcExNugBOugD6AAARZ7r6AABOugAVbbJVvgc1eb37AACUtd0faq+paQD6AABOugD6AAD6AQErcLQrcLR/qdeEs9r6AABOugBOugD6AQH6AAD2ODtOugBmwTtOugD7AAD////8Z2f9iIjI57lLugArbrSKz2j9tbT7NTVnwzW+5K7/19dDtwCn2o6e1oTh89b+qqvU7cY5tAb6vr/9yMf48+yCzVz//vxKh6nyEBhmp438KSbpoahiwibrRlDSm6p7Z5muZYY4kHmRS3qeu9ycf6Ohx7WZyZ/k5sRWsk+uCZO9AAAAJnRSTlMAoMvaUkRE/v5+ovLREibdx+4mlMDUfed9mnnEeMT//////////i/pLzUAAAGCSURBVDiNZZPpdoIwEEYHt0jVU7fTvSEIKShubOJy3O32/i9UEiIJ9v6dm/kyEwDIqej9RmONcUmrwX8qzfPONM3IxhytdVNGl9BxnLk3GmPBk1LuNunKYHhkmgu4lNd1uoyiKAyjmJCJFPCjqPco5cfdhBDiB1LA9+I8Cj0G4WBbMTQmUHQW+Rw1A+MaF5wwJSKCun0Tgg4b13U35lWYBTct0H7OcK5CMSSdlZoZuZAsVAPgMMjwpKFeowafQghzgcRjabzBUUSYsTT8wL6iwd4RyAxCRtuh4B1eXcFmrhizkZXxBXdGTiSFePGRsYYXKRjKNaxpxhqqirBKZMZ0wlkCKIKxky1EBgVoq8ZADsL5RlDIyF897cAm3S7TDlBWhVW+LDbkCDGh2EJsw2cvVj9RJqirSBFTMCxEdf5dFkLYupJhkDJGtCe+7E5xkNi3/JSlOM9oq8KszvID1Owqf9eDvGX2UBdaKf6eretVf9Id/p6aN2VO9bncMY6NRl9Xqn//GHG7JhWEMgAAAABJRU5ErkJggg=="
        sizes="192x192">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            /* Menggunakan font Poppins dari Google Fonts */
            background-color: #f0f2f5;
            /* Warna latar belakang abu-abu terang */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            /* Pastikan halaman mengisi seluruh tinggi viewport */
            color: #333;
            text-align: center;
        }

        .container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            /* Sedikit bayangan untuk efek 3D */
            max-width: 500px;
            width: 90%;
            /* Responsif untuk layar kecil */
        }

        .error-code {
            font-size: 8em;
            /* Ukuran teks besar untuk kode 404 */
            color: #e74c3c;
            /* Warna merah yang menarik perhatian */
            margin-bottom: 10px;
            font-weight: 700;
            /* Tebal */
            animation: bounce 1s infinite alternate;
            /* Animasi memantul */
        }

        .error-message {
            font-size: 1.8em;
            color: #555;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .explanation {
            font-size: 1.1em;
            color: #777;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .home-button {
            display: inline-block;
            color: #fff;
            padding: 12px 25px;
            border-radius: 5px;
            text-decoration: none;
            /* Hilangkan garis bawah default link */
            font-size: 1.1em;
            transition: background-color 0.3s ease;
            /* Transisi halus saat hover */
            background-color: #6bb931;
        }

        .home-button:hover {
            background-color: #2980b9;
            /* Warna biru lebih gelap saat hover */
        }

        /* Animasi untuk error-code */
        @keyframes bounce {
            from {
                transform: translateY(0);
            }

            to {
                transform: translateY(-10px);
            }
        }

        /* Media Queries untuk responsivitas */
        @media (max-width: 600px) {
            .error-code {
                font-size: 6em;
            }

            .error-message {
                font-size: 1.5em;
            }

            .explanation {
                font-size: 1em;
            }

            .home-button {
                padding: 10px 20px;
                font-size: 1em;
            }
        }

        .alert {
            position: relative;
            padding: .75rem 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-top-color: transparent;
            border-right-color: transparent;
            border-bottom-color: transparent;
            border-left-color: transparent;
            border-radius: .25rem;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
    </style>

<body>
    <div class="container">
        <h1 class="error-code"><img src="https://muj.co.id/wp-content/uploads/2022/07/Migas-Utama-Jabar-Footer.png">
        </h1>
        <p class="error-message">Error</p>
        <p class="explanation">
            @if ($error)
                <div class="alert alert-danger">
                    {{ $error }}
                </div>
            @endif
        </p>
        <a href="{{ env('ERP_HOST') }}" class="home-button">Kembali ke Halaman Utama</a>
    </div>
</body>

</html>
