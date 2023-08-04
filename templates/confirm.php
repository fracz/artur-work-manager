<?php
/* @var arary $params */
/* @var arary $model */
?>
<div class="container">
    <?php if (!$model): ?>
        <article class="message is-warning">
            <div class="message-header">
                <p>Zwróć uwagę!</p>
            </div>
            <div class="message-body">
                Jesteś pierwszą osobą, która odwołuje się do naprawy z tym identyfikatorem. Upewnij się, że wprowadzone
                dane są poprawne.
            </div>
        </article>
    <?php endif; ?>
    <?php if ($model && $model['assigned_' . $user->role]): ?>
        <article class="message is-danger">
            <div class="message-header">
                <p>Nie możesz obsłużyć tej naprawy</p>
            </div>
            <div class="message-body">
                Ta naprawa już została obsłużona przez innego użytkownika (lub przez Ciebie).
                Zatwierdzenie nie jest możliwe.
            </div>
        </article>
    <?php endif; ?>
    <h1 class="title">Naprawa ID <?= $params['nrNaprawy'] ?></h1>
    <dl>
        <dt>ID Przyjmującego</dt>
        <dd><?= $params['idPrzyjmujacego'] ?></dd>
        <dt class="mt-3">Data przyjęcia</dt>
        <dd><?= $params['dataPrzyjecia'] ?></dd>
        <dt class="mt-3">Model</dt>
        <dd><?= $params['model'] ?></dd>
        <dt class="mt-3">SN / IMEI</dt>
        <dd><?= $params['sn'] ?></dd>
        <?php if ($model): ?>
            <dt class="mt-3">Przyjmujący</dt>
            <dd>
                <?php
                $p = \App\Db::findOne('user', 'id = ?', [$model->assigned_p]);
                echo $p ? $p->username : '-';
                ?>
            </dd>
            <dt class="mt-3">Technik</dt>
            <dd>
                <?php
                $p = \App\Db::findOne('user', 'id = ?', [$model->assigned_t]);
                echo $p ? $p->username : '-';
                ?>
            </dd>
            <dt class="mt-3">Kontrola jakości</dt>
            <dd>
                <?php
                $p = \App\Db::findOne('user', 'id = ?', [$model->assigned_k]);
                echo $p ? $p->username : '-';
                ?>
            </dd>
        <?php endif; ?>
    </dl>
    <form action="/confirm" method="post" id="app">
        <input type="hidden" name="nrNaprawy" value="<?= $params['nrNaprawy'] ?>">
        <input type="hidden" name="idPrzyjmujacego" value="<?= $params['idPrzyjmujacego'] ?>">
        <input type="hidden" name="dataPrzyjecia" value="<?= $params['dataPrzyjecia'] ?>">
        <input type="hidden" name="model" value="<?= $params['model'] ?>">
        <input type="hidden" name="sn" value="<?= $params['sn'] ?>">
        <input type="hidden" name="confirm" value="1">
        <div class="has-text-centered mt-3">
            <?php if (!$model || !$model['assigned_' . $user->role]): ?>
                <button type="submit" class="button is-success is-large">Potwierdź</button>
            <?php endif; ?>
            <a href="/" class="button is-large">Anuluj</a>
        </div>
    </form>
</div>
