<header class="header header_style_01">
    <nav class="megamenu navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">
                    <img src="../../assets/img/kantor_desa/logo.png" width="50" alt="image">
                </a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="home.php"
                            class="<?php echo basename($_SERVER['PHP_SELF']) == 'home.php' ? 'active' : ''; ?>">Home</a>
                    </li>
                    <li><a href="profile.php"
                            class="<?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : ''; ?>">Profile</a>
                    </li>
                    <li><a href="surat_keterangan.php"
                            class="<?php echo basename($_SERVER['PHP_SELF']) == 'surat_keterangan.php' ? 'active' : ''; ?>">Surat
                            Keterangan</a>
                    </li>
                    <li><a href="informasi.php"
                            class="<?php echo basename($_SERVER['PHP_SELF']) == 'informasi.php' ? 'active' : ''; ?>">Informasi</a>
                    </li>
                    <li><a href="kontak.php"
                            class="<?php echo basename($_SERVER['PHP_SELF']) == 'kontak.php' ? 'active' : ''; ?>">Kontak</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>