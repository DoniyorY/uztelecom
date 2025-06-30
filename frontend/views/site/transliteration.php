<?php
$this->title = 'Транслитерация';
$this->params['breadcrumbs'][] = $this->title;
$base=Yii::$app->request->baseUrl;
?>
<script src="<?="$base/js/transliteration.js"?>"></script>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"><?= ($this->title) ? $this->title : '' ?></h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a
                                href="<?=Yii::$app->homeUrl?>">Главная</a></li>
                    <li class="breadcrumb-item active"><?= ($this->title) ? $this->title : '' ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body border-0">
        <form name="transliteration">
            <div class="row">
                <hr class="mt-2">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="kyril"><h3>Кирилица</h3></label>
                        <textarea name="kiryl" id="kyril" onKeyUp="cyrlat()" cols="30" rows="20" class="form-control"></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="lotin"><h3>Латиница</h3></label>
                        <textarea name="lotin" id="lotin" onKeyUp="latcyr()" cols="30" rows="20" class="form-control"></textarea>
                    </div>
                </div>
                <div class="col-md-12 mt-5">
                    <button type="button" class="btn btn-primary w-100" onClick="reset(); transliteration.kyril.focus()"> Очистить</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- end page title -->




