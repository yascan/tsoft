<?= view('layouts.header') ?>
    <div class="row">
        <div class="col-12">
            <h3>Puan durumu tablosu</h3>
        </div>
        <div class="col-12">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">Takım</th>
                    <th scope="col">Gücü</th>
                    <th scope="col">Galibiyet</th>
                    <th scope="col">Berabere</th>
                    <th scope="col">Malubiyet</th>
                    <th scope="col">Puan <i class="fa-solid fa-angle-down"></i></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($scorboard as $row) {?>
                    <tr>
                        <td><?= $row->name ?></td>
                        <td><?= $row->power ?></td>
                        <td><?= $row->won ?></td>
                        <td><?= $row->drawn ?></td>
                        <td><?= $row->lost ?></td>
                        <th scope="row"><?= $row->point ?></th>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
<?= view('layouts.footer') ?>