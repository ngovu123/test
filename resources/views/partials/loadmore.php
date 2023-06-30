<?php 
foreach ($imagesLoad as $item) {
?>
    <div class="item_larger animated single-left col-xs-12 col-sm-6 col-md-4" data-id="">
        <div class="item" id="<?= $item->id ?>">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <a href="<?= route('downloadpage', $item->id) ?>" class="head_item item_ajax">
                <img src="<?= url('').'/'.config('view.filepath') ?>/thumb/<?= $item->name ?>">
            </a>
            <a class="content_item" href="<?= route('downloadpage', $item->id) ?>">
                <h3><?= strtoupper($item->title) ?></h3>
                <span class="the-date"><?= date("F j, Y", strtotime($item->created_at)) ?></span>
            </a>
            <div class="item_info">
                <a href="javascript:void(0);" class="buttonlike" align="right" image-id="<?= $item->id ?>"><img src="<?= config('view.rootpath') ?>/img/icon_like.png"> <b id="id<?= $item->id ?>"><?= $item->count_like ?></b></a>
                <a href="<?= route('downloadpage', $item->id) ?>" class="download" align="right"><img src="<?= config('view.rootpath') ?>/img/icon_download.png"> <?= $item->count_download ?></a>
                <a href="<?= route('downloadpage', $item->id) ?>" class="download" align="right">
                    <?php  if ($item->price==0) {
                        echo ' <strong>Free</strong> ';
                    }  else {
                        echo '<strong style="color:#d35400">'.$item->price.'</strong><span class="glyphicon glyphicon-usd"></span>';
                    }
                    ?>
                </a>
            </div>
        </div>
    </div>
<?php }?>