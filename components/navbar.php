<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon">
            <img src="https://www.ittvt.edu.it/wp-content/uploads/cropped-LOGO-SITO-ITT.png" />
        </div>
        <div class="sidebar-brand-text mx-3">Gestione accessi</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <?php require_once(__DIR__ . '/../components/components.php'); Components::navbar() ?>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>