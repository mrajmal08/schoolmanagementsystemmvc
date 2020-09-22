<?php
$user_id = $myData;
$where = 'id =' . $user_id[0];
$sidebar = $sc->show(false, $where);
?>
<div class="nk-sidebar">
    <div class="nk-nav-scroll">
        <ul class="metismenu" id="menu">
            <li>
                <a class="has-arrow" href="#" aria-expanded="false">
                    <i class="icon-speedometer menu-icon"></i><span class="nav-text">Dashboard</span>
                </a>
                <ul aria-expanded="false">
                    <?php if ($sidebar[0]['role_id'] == 1 || $sidebar[0]['role_id'] == 2) { ?>
                        <li><a href="<?= urlPath('Principal') ?>">principals</a></li>
                        <li><a href="<?= urlPath('Teacher')?>">Teachers</a></li>
                        <li><a href="<?= urlPath('Student') ?>">Students</a></li>
                        <?php
                    }
                    if ($sidebar[0]['role_id'] == 3) { ?>
                        <li><a href="<?= urlPath('Teacher')?>">Teachers</a></li>
                        <li><a href="<?= urlPath('Student') ?>">Students</a></li>
                        <li><a href="<?= urlPath('classController')?>">Classes</a></li>
                        <li><a href="<?= urlPath('subjectController')?>">Subjects</a></li>
                        <?php
                    }
                    if ($sidebar[0]['role_id'] == 4) { ?>
                        <li><a href="my_class">My Classess</a></li>
                        <li><a href="my_subject">My Subjects</a></li>
                        <?php
                    }
                    ?>

                </ul>
            </li>
        </ul>
    </div>
</div>