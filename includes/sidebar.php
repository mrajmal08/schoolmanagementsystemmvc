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
                        <li><a href="<?= urlPath('principalController') ?>">principals</a></li>
                        <li><a href="<?= urlPath('teacherController')?>">Teachers</a></li>
                        <li><a href="<?= urlPath('studentController') ?>">Students</a></li>
                        <?php
                    }
                    if ($sidebar[0]['role_id'] == 3) { ?>
                        <li><a href="<?= urlPath('teacherController')?>">Teachers</a></li>
                        <li><a href="<?= urlPath('studentController') ?>">Students</a></li>
                        <li><a href="<?= urlPath('classController')?>">Classes</a></li>
                        <li><a href="<?= urlPath('subjectController')?>">Subjects</a></li>
                        <?php
                    }
                    if ($sidebar[0]['role_id'] == 4) { ?>
                        <li><a href="<?= urlPath('classController/myClass')?>">My Classess</a></li>
                        <li><a href="<?= urlPath('subjectController/mySubject')?>">My Subjects</a></li>
                        <?php
                    }
                    ?>

                </ul>
            </li>
        </ul>
    </div>
</div>