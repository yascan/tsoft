<?= view('layouts.header') ?>
<h3>Takım Listesi</h3>
<div class=" float-end">
    <buttun class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addTeams">Takım ekle</buttun>
</div>
<table class="table table-hover">
    <thead>
    <tr>
        <th scope="col">Takım</th>
        <th scope="col">Gücü</th>
        <th scope="col">Puan <i class="fa-solid fa-angle-down"></i></th>
        <th scope="col">İşlem</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($teams as $team) { ?>
        <tr>
            <td><?= $team->name ?></td>
            <td><?= $team->power ?></td>
            <td><?= $team->point ?></td>
            <td>
                <a onclick="return confirm('Silmek istediğinize emin misiniz?')"
                   href="<?= route('delete', ['{id}' => $team->id]) ?>" class="btn btn-danger">Sil</a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<!-- Modal -->
<div class="modal fade" id="addTeams" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Takım Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="store" method="POST">
                    <div class="mb-3">
                        <label for="name">Takım Adı</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="power">Takım Gücü</label>
                        <input type="text" name="power" id="power" class="form-control">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                <button type="submit" class="btn btn-primary">Kaydet</button>
            </div>
            </form>
        </div>
    </div>
</div>
<?= view('layouts.footer') ?>