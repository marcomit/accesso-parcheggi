<?php 
class Components{
    public static $items = [
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
            "icon" => "fas fa-check",
            "require_admin" => false,
            "sub_items" => [
                ["name" => "Autorizzazioni", "icon" => ""],
                ["name" => "Richieste", "icon" => ""],
            ]
        ],
        [
            "name" => "Veicoli",
            "icon" => "fa fa-car",
            "require_admin" => false,
            "sub_items" => [
                ["name" => "I miei veicoli", "icon" => "fas fa-car fa-sm"],
                ["name" => "Nuovo", "icon" => "fas fa-plus fa-sm"]
            ]
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
    public static function navbar(){
        $page_id = isset($_GET['page_id']) ? $_GET['page_id'] : 0;
        $current_idx = 0;
        foreach(self::$items as $idx => $item):
            if (($item['require_admin'] && $_SESSION['user']['RUOLO'] == "ADMIN") || !$item["require_admin"]):
                if(isset($item["sub_items"])):?>
                    <li class="nav-item <?= $page_id >= $current_idx && $page_id <= $current_idx - 1 + count($item['sub_items']) ? "active" : "" ?>">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse<?= $current_idx ?>"
                            aria-expanded="true" aria-controls="collapse<?= $current_idx ?>">
                            <i class="<?= $item["icon"] ?>"></i>
                            <span><?= $item["name"] ?></span>
                        </a>
                        <div id="collapse<?= $current_idx ?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <?php foreach($item["sub_items"] as $sub_item): $current_idx++?>
                                    <a class="collapse-item" href="index.php?page_id=<?= $current_idx - 1 ?>">
                                        <i class="<?= $sub_item["icon"] ?> text-dark-50"></i>
                                        <?= $sub_item["name"] ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </li>
                <?php else:
                    $current_idx++;?>
                    <li class="nav-item <?= $page_id == $current_idx - 1 ? "active" : "" ?>">
                        <a class="nav-link" href="index.php?page_id=<?= $current_idx - 1 ?>">
                            <i class="<?= $item["icon"] ?>"></i>
                            <span><?= $item["name"] ?></span>
                        </a>
                    </li>
        <?php endif; else: $current_idx++; endif; endforeach;

    }  
    public static function main_content(){
        if(!isset($_GET['page_id'])){
            return include('pages/index.php');
        }
        switch($_GET['page_id']) {
            case 1:
                include('pages/utenti.php');
                break;
            case 2:
                include('pages/autorizzazioni.php');
                break;
            case 3:
                include('pages/richieste.php');
                break;
            case 4:
                include('pages/veicoli.php');
                break;
            case 5:
                include('pages/inserisci-veicolo.php');
                break;
            case 6:
                include('pages/accessi.php');
                break;
            case 7:
                include('pages/statistiche.php');
                break;
            case 8:
                include('pages/profilo.php');
                break;
            case 9:
                include('pages/inserisci-richiesta.php');
                break;
            default:
                include('pages/index.php');
                break;
        }
    }
    public static function heading(string $title, string $icon = "", string $link = "", string $href = "", string $link_style = ""){?>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
            <?php if($icon !== "" || $link !== ""): ?>
            <a href="<?= $href ?>" class="btn btn-sm shadow-sm <?= $link_style ?>">
                <i class="<?= $icon ?>"></i>
                <?= $link ?>
            </a>
            <?php endif; ?>
        </div><?php
    }
    public static function not_found(string $href = "index.php", string $text = "404", string $msg = "Pagina non trovata"){?>
        <div class="text-center my-auto">
            <div class="error mx-auto" data-text="<?= $text ?>"><?= $text ?></div>
            <p class="lead text-gray-800 mb-5"><?= $msg ?></p>
            <p class="text-gray-500 mb-0"></p>
            <a href="<?= $href ?>">← Torna alla dashboard...</a>
        </div><?php
    }
    public static function card(string $title, string $content, string $icon, string $color = "primary", int $width = 0){?>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-<?= $color ?> shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-<?= $color ?> text-uppercase mb-1"><?= $title ?>
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= $content ?></div>
                                </div>
                                <div class="col <?= $width == 0 ? "d-none" : "" ?>">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-<?= $color ?>" role="progressbar"
                                            style="width: <?= $width ?>%" aria-valuenow="<?= $width ?>" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas <?= $icon ?> fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php }
}