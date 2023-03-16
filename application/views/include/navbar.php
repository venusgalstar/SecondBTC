<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <a class="navbar-brand" href="<?= site_url(); ?>">
        <img id="navbar-logo" src="<?= base_url('assets/home') ?>/img/logo-light.svg" height="40" alt="second logo" loading="lazy">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                <defs>
                    <style>
                        .fa-secondary {
                            opacity: .4
                        }
                    </style>
                </defs>
                <path d="M400 32H48A48 48 0 0 0 0 80v352a48 48 0 0 0 48 48h352a48 48 0 0 0 48-48V80a48 48 0 0 0-48-48zm-51.37 182.31L232.06 348.16a10.38 10.38 0 0 1-16.12 0L99.37 214.31C92.17 206 97.28 192 107.43 192h233.14c10.15 0 15.26 14 8.06 22.31z" class="fa-secondary" />
                <path d="M348.63 214.31L232.06 348.16a10.38 10.38 0 0 1-16.12 0L99.37 214.31C92.17 206 97.28 192 107.43 192h233.14c10.15 0 15.26 14 8.06 22.31z" class="fa-primary" />
            </svg>
        </span>
    </button>
    <div class="collapse navbar-collapse justify-content-between align-items-center w-100" id="navbarNav">
        <ul class="navbar-nav mx-auto text-center"></ul>
        <ul class="navbar-nav">
            <li class="nav-item mr-4">
                <a class="nav-link" href="<?= site_url('trade'); ?>">Trade</a>
            </li>
            <li class="nav-item mr-4">
                <a class="nav-link" href="<?= site_url('market'); ?>">Markets</a>
            </li>
            <li class="nav-item mr-4">
                <a class="nav-link" href="<?= site_url('wallet'); ?>">Wallet</a>
            </li>
            <li class="nav-item mr-4">
                <a class="nav-link" href="<?= site_url('orders'); ?>">Orders</a>
            </li>
            <li class="nav-item">
                <a class="btn btn-outline-primary" href="#">Connect Wallet</a>
            </li>
            <li class="nav-item ml-2">
                <a class="btn btn-outline-secondary" href="#"><img id="icon-theme" src="<?= base_url('assets/home') ?>/img/light-theme.svg" height="20" onclick="toggleLight(this)"></a>
            </li>
        </ul>
    </div>
</nav>