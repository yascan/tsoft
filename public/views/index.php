<?= view('static.header') ?>
<div class="row">
    <div class="col-12">
        <div class="col">
            <h3>Takım listesi aşağıda iletilmiştir.</h3>
        </div>
        <div class="col">
            <a href="" class="float-end"><buttun class="btn btn-success">Takım ekle</buttun></a>
        </div>
    </div>
    <div class="col-12">
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">Takım</th>
                <th scope="col">Gücü</th>
                <th scope="col">İşlem</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($teams as $team){ ?>
                <tr>
                    <td><?= $team->name ?></td>
                    <td><?= $team->power ?></td>
                    <td><a href="<?= route('delete', ['{id}' => $team->id]) ?>"><button class="btn btn-danger">Sil</button></a></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?= view('static.footer') ?>