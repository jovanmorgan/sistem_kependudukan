<!DOCTYPE html>
<html lang="en">

<?php include 'fitur/head.php'; ?>

<body>

    <!-- LOADER -->
    <div id="preloader">
        <div class="loader">
            <div class="loader__bar"></div>
            <div class="loader__bar"></div>
            <div class="loader__bar"></div>
            <div class="loader__bar"></div>
            <div class="loader__bar"></div>
            <div class="loader__ball"></div>
        </div>
    </div><!-- end loader -->
    <!-- END LOADER -->

    <?php include 'fitur/header.php'; ?>

    <div class="container">
        <h1>Kontak Kami</h1>

        <div class="contact-info">
            <div>
                <h2>Alamat Kantor</h2>
                <p><strong>Kantor Lurah Oepura</strong></p>
                <p>Jl. Soeharto No.1, Oepura, Kec. Maulafa, Kota Kupang, Nusa Tenggara Timur</p>
                <p>Kode Pos: 85142</p>
                <p>Telp: (0380) 123456</p>
                <p>Email: kantor.oepura@example.com</p>
            </div>
            <div>
                <h2>Jam Operasional</h2>
                <p>Senin - Jumat: 08:00 - 16:00</p>
                <p>Sabtu: 08:00 - 12:00</p>
                <p>Minggu: Tutup</p>
            </div>
        </div>

        <!-- Google Maps Embed -->
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3949.7216222340577!2d123.6047596!3d-10.1884142!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2c569b4f9b91d59d%3A0xaad64faf6b3d8782!2sKantor%20Lurah%20Oepura!5e0!3m2!1sen!2sid!4v1696044771189!5m2!1sen!2sid"
            allowfullscreen="" loading="lazy"></iframe>
    </div>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #f4f4f9;
        }

        .container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 40px;
            font-size: 2.5em;
            color: #333;
        }

        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 40px;
        }

        .contact-info {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .contact-info div {
            width: 48%;
        }

        .contact-info h2 {
            margin-bottom: 15px;
            font-size: 1.5em;
            color: #444;
        }

        .contact-info p {
            margin: 5px 0;
            font-size: 1.1em;
            color: #666;
        }

        iframe {
            width: 100%;
            height: 450px;
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            .contact-info div {
                width: 100%;
                margin-bottom: 20px;
            }
        }
    </style>

    <?php include 'fitur/footer.php'; ?>


    <div class="container">
        <h1>Kontak Kami</h1>

        <!-- Bagian Card untuk Informasi Kontak dan Jam Operasional -->
        <div class="card">
            <div class="contact-info">
                <div>
                    <h2>Alamat Kantor</h2>
                    <p><strong>Kantor Lurah Oepura</strong></p>
                    <p>Jl. Soeharto No.1, Oepura, Kec. Maulafa, Kota Kupang, Nusa Tenggara Timur</p>
                    <p>Kode Pos: 85142</p>
                    <p>Telp: (0380) 123456</p>
                    <p>Email: kantor.oepura@example.com</p>
                </div>
                <div>
                    <h2>Jam Operasional</h2>
                    <p>Senin - Jumat: 08:00 - 16:00</p>
                    <p>Sabtu: 08:00 - 12:00</p>
                    <p>Minggu: Tutup</p>
                </div>
            </div>
        </div>

        <!-- Google Maps Embed dengan Card dan Shadow -->
        <div class="card">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3949.7216222340577!2d123.6047596!3d-10.1884142!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2c569b4f9b91A0xaad64faf6b3d8782!2sKantor%20Lurah%20Oepura!5e0!3m2!1sen!2sid!4v1696044771189!5m2!1sen!2sid"
                allowfullscreen="" loading="lazy"></iframe>
        </div>

    </div>
    <a href="#" id="scroll-to-top" class="dmtop global-radius"><i class="fa fa-angle-up"></i></a>

    <?php include 'fitur/js.php'; ?>

</body>

</html>