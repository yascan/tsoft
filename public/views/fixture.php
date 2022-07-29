<?= view('layouts.header') ?>

    <h3>Karşılaşma Tablosu</h3>

    <div class=" float-end">
        <?php if ($isFixture): ?>
            <a href="<?= route('start') ?>" class="btn btn-primary">
                Müsabakayı Başlat
            </a>
        <?php else: ?>
            <a href="<?= route('createFixture') ?>" class=" btn btn-success">
                Fikstür Oluştur
            </a>
        <?php endif; ?>
        <a href="<?= route('destroyAll') ?>" class="btn btn-danger">
            Fikstürü Sil
        </a>
    </div>

    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">Ev Sahibi Takım</th>
            <th scope="col">Misafir Takım</th>
            <th scope="col">Maç Sonucu</th>
            <th scope="col">Puan Durumu</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($matches as $match) { ?>
            <tr>
                <td><?= $match->first_name ?></td>
                <td><?= $match->second_name ?></td>
                <td><?= $match->first_score . " - " . $match->second_score ?></td>
                <td><?= $match->first_point . " - " . $match->second_point ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

<?= view('layouts.footer') ?>