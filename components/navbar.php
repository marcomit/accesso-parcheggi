<?php
$items = [
    [
        "name" => "Dashboard",
        "icon" => "fas fa-fw fa-tachometer-alt",
        "require_admin" => false
    ],
    [
        "name" => "Utenti",
        "icon" => "fa fa-user",
        "require_admin" => true
    ],
    [
        "name" => "Autorizzazioni",
        "icon" => "fas fa-fw fa-tachometer-alt",
        "require_admin" => false,
        "sub_items" => [
            ["name" => "Autorizzazioni"],
            ["name" => "Richieste"],
        ]
    ],
    [
        "name" => "Veicoli",
        "icon" => "fa fa-car",
        "require_admin" => false
    ],
    [
        "name" => "Accessi",
        "icon" => "fa fa-car",
        "require_admin" => false
    ],
    [
        "name" => "Statistiche",
        "icon" => "fas fa-fw fa-chart-area",
        "require_admin" => false
    ]
];

$page_id = isset($_GET['page_id']) ? $_GET['page_id'] : 0;
$current_idx = 0

?>

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

    <?php for($item = 0; $item < count($items); $item++): ?>
        <?php  if (($items[$item]['require_admin'] && $_SESSION['user']['RUOLO'] == "ADMIN") || !$items[$item]["require_admin"]): ?>
            <?php if(isset($items[$item]["sub_items"])): ?>
                <li class="nav-item <?= $page_id >= $current_idx && $page_id <= $current_idx - 1 + count($items[$item]['sub_items']) ? "active" : "" ?>">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse<?= $current_idx ?>"
                        aria-expanded="true" aria-controls="collapse<?= $current_idx ?>">
                        <i class="<?= $items[$item]["icon"] ?>"></i>
                        <span><?= $items[$item]["name"] ?></span>
                    </a>
                    <div id="collapse<?= $current_idx ?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <?php foreach($items[$item]["sub_items"] as $sub_item): $current_idx++?>
                                <a class="collapse-item" href="index.php?page_id=<?= $current_idx - 1 ?>"><?= $sub_item["name"] ?></a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </li>
            <?php else: $current_idx++?>
                <li class="nav-item <?= $page_id == $current_idx - 1 ? "active" : "" ?>">
                    <a class="nav-link" href="index.php?page_id=<?= $current_idx - 1 ?>">
                        <i class="<?= $items[$item]["icon"] ?>"></i>
                        <span><?= $items[$item]["name"] ?></span>
                    </a>
                </li>
            <?php endif; ?>
        <?php else: $current_idx++; endif; ?>
    <?php endfor; ?>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>