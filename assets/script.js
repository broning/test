$(() => {

// добавляем товар в заказ
    $('.add_to_basket').click(function () {

        $(this).removeClass('btn-primary').addClass('btn-success');

        let item = $(this).parents('.item');
        let q = parseInt(item.find('.quantity').val());

        if (q > 0) {
            item.addClass('added');
            reCalc();
        }

    });

    $('[name=order_form]').submit(() => {
        let itemsStr = $('[name="items"]').val();

        if (itemsStr == '') {
            alert('Добавьте товары в корзину');
            return false;
        }
    });
});

// пересчитываем корзину
function reCalc() {
    let totalSumm = 0;
    let arItems = [];

    $('.added').each(function () {
        let id = $(this).data('id');
        let name = $(this).data('name');
        let q = $(this).find('.quantity').val();
        let price = $(this).find('.quantity').data('price');

        arItems.push({
            id: id,
            q: q,
        });

        totalSumm += price * q;

        $(this).find('.quantity').prop('disabled', true);
        $(this).find('.add_to_basket').text('В корзине');
    });


    $('.total_sum').html(totalSumm);

    $('[name="summ"]').val(totalSumm);
    $('[name="items"]').val(JSON.stringify(arItems));
}