<?php

use yii\helpers\Url;

?>

<form action="<?= Url::to(['directory-category/import-data']) ?>" method="post">
    <input type="text" name="<?= \Yii::$app->request->csrfParam ?>" value="<?= \Yii::$app->request->csrfToken ?>"
           hidden="hidden">
    <input type="text" hidden="hidden" name="category_id" value="<?=$category_id?>">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="importData">Import Url</label>
                <input type="text" name="import_url" class="form-control" id="importData" required>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="importAttrName">Import Attribute id</label>
                <input type="text" class="form-control" name="attr_id" id="importAttrName">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="importAttrName">Import Attribute Name</label>
                <input type="text" class="form-control" name="attr_name" id="importAttrName">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="limit">Set The Limit</label>
                <input type="number" name="limit" placeholder="Default 100" class="form-control" id="limit">
            </div>
        </div>
        <div class="col-md-3 mt-4">
            <div class="form-group">
                <button type="submit" class="btn btn-success w-100"> Load </button>
            </div>
        </div>
    </div>
</form>

