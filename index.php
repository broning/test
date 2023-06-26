<?
include ($_SERVER['DOCUMENT_ROOT'].'/template/header.php');

$arItems = DB::getInstance()->getItems();?>

        <h2>Оформить заказ</h2><br>

        <form action="/order/" method="post" name="order_form">

            <div class="row catalog">
                <div class="col-12">
                    <?foreach ($arItems as $key => $arItem):?>
                        <div class="element-container mb-4 item" data-id="<?=$arItem['ID']?>" data-name="<?= $arItem['NAME'] ?>">
                            <div class="picture"><img src="assets/img/no-photo.jpg" alt=""></div>
                            <div class="description">
                                <b><?= $arItem['NAME'] ?></b><br>
                                <small><?= $arItem['DESCRIPTION'] ?></small><br>
                                <p class="mt-2"><b>Цена:</b> <?= $arItem['PRICE'] ?> руб.</p>
                                <input class="form-control quantity" type="number" min="1" max="999" value="1" data-price="<?=$arItem['PRICE']?>">
                                <a class="btn btn-primary mb-3 add_to_basket">В корзину</a>
                            </div>
                        </div>
                    <? endforeach; ?>

                    <div>
                        <h4>Сумма заказа: <span class="total_sum">0</span> руб.</h4>
                        <input type="hidden" name="summ" value="">
                        <input type="hidden" name="items" value="">
                    </div>
                </div>
            </div>

            <div class="row">

                    <div class="form-group mb-3">
                        <label for="fio">ФИО плательщика:</label>
                        <input type="text" class="form-control w-50" id="fio" name="fio" placeholder="Укажите ФИО плательщика" required>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="action" value="submitForm">Оформить заказ</button>
                    </div>
            </div>

        </form>

<?include ($_SERVER['DOCUMENT_ROOT'].'/template/footer.php');?>