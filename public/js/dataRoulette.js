class DataRoulette
{
    KeySell(uid, result, ubalance, price, income, case_id, case_price, price_sell, type, code)
    {
        $.ajax({
            url: window.location.protocol + "//" + window.location.host +  "/" + "handler/key/sell",
            type: "POST",
            data: {
                msg: "[Продажа ключа]: Запрос отправлен",
                uid: parseInt(uid),
                result: parseInt(result),
                ubalance: parseInt(ubalance),
                price: parseInt(price),
                income: parseInt(income),
                case_id: case_id,
                case_price: parseInt(case_price),
                price_sell: parseInt(price_sell),
                type: type,
                code: code
            },
            dataType: "text",
            beforeSend: function() {
                console.info("[Продажа ключа]: Загрузка...");
            },
            success: function(data) {
                view.KeySellSuccess(data, income);
            }
        });
    }
    TakeKey(result, uid, ubalance, game_price, price_sell, case_price, keytype)
    {
        $.ajax(
            {
                url: window.location.protocol + "//" + window.location.host +  "/" + "handler/key/take",
                type: "GET",
                data: {
                    msg: "[Выдача ключа]: Запрос отправлен",
                    result: result,
                    uid: parseInt(uid),
                    ubalance: parseInt(ubalance),
                    game_price: parseInt(game_price),
                    price_sell: price_sell,
                    case_price: parseInt(case_price),
                    keytype:keytype
                },
                dataType: "text",
                beforeSend: function(){
                    console.info("[Выдача ключа]: Загрузка...");
                },
                success: function(data){
                    view.TakeKeySuccess(data, price_sell);
                },
                error: function (data )
                {
                    console.error(data);
                }
            });
    }
}