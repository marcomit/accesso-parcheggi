<?php
$items = [
    [
        "name" => "Dashboard",
        "icon" => "fas fa-fw fa-tachometer-alt",
        "page_id" => 0
    ],
    [
        "name" => "Gestione utenti",
        "icon" => "fa fa-user",
        "page_id" => 1
    ],
    [
        "name" => "Gestione autorizzazioni",
        "icon" => "fas fa-fw fa-tachometer-alt",
        "page_id" => 3,
        "sub_items" => [
            ["page_id" => 2, "name" => "Autorizzazioni"],
            ["page_id" => 3, "name" => "Richieste"],
        ]
    ],
    [
        "name" => "Gestione personale",
        "icon" => "fa fa-id-badge",
        "page_id" => 4
    ],
    [
        "name" => "Gestione veicoli",
        "icon" => "fa fa-car",
        "page_id" => 5
    ],
    [
        "name" => "Gestione accessi",
        "icon" => "fa fa-car",
        "page_id" => 6
    ],
];

$page_id = isset($_GET['page_id']) ? $_GET['page_id'] : 0;
?>

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
            <img src="https://www.ittvt.edu.it/wp-content/uploads/cropped-LOGO-SITO-ITT.png" />
        </div>
        <div class="sidebar-brand-text mx-3">Gestione accessi</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <?php for($item = 0; $item < count($items); $item++): ?>

        <li class="nav-item <?= $items[$item]['page_id'] === $page_id ? 'active' : '' ?>">
            <?php if(isset($items[$item]["sub_items"])): ?>
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse1"
                    aria-expanded="true" aria-controls="collapse1">
                    <i class="<?= $items[$item]["icon"] ?>"></i>
                    <span><?= $items[$item]["name"] ?></span>
                </a>
                <div id="collapse1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <?php foreach($items[$item]["sub_items"] as $sub_item): ?>
                            <a class="collapse-item" href="index.php?page_id=<?= $sub_item["page_id"] ?>"><?= $sub_item["name"] ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php else: ?>
                <a class="nav-link" href="index.php?page_id=<?= $items[$item]["page_id"] ?>">
                    <i class="<?= $items[$item]["icon"] ?>"></i>
                    <span><?= $items[$item]["name"] ?></span>
                </a>
            <?php endif; ?>
        </li>
    <?php endfor; ?>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span><?= $page_id ?></span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>