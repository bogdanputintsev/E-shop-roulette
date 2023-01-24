class Data
{
    BuyGame(game_id, amount)
    {
        var res;
        $.ajax({
            url: window.location.protocol +  "//" + window.location.host + "/handler/buy/",
            type: "POST",
            async: false,
            data: {
                game_id: game_id,
                pay_id: parseInt(user.id),
                amount: amount,
            },
            dataType: "text",
            success: function(result) {
                res = result;
            }
        });
        return res;
    }
    WriteFeedback()
    {
        $.ajax({
            url: window.location.protocol +  "//" + window.location.host + "/handler/bonuses/feedback/",
            type: "GET",
            data: { uid: parseInt(user.id) },
            dataType: "text",
            beforeSend: function(){
                console.info("[Отзывы]: Загрузка...");
                view.OpenWindow("#window-loading");
            },
            success: this.WriteFeedbackSuccess
        });
    }
    WriteFeedbackSuccess(info)
    {
        if(info.endsWith("[Отзывы]: Найдено"))
        {
            console.info(info);
            $.ajax({
                url: window.location.protocol + "//" + window.location.host +  "/" + "handler/key/sell",
                type: "POST",
                data: {
                    msg: "[Отзывы]: Запрос отправлен",
                    uid: parseInt(user.id),
                    ubalance: parseInt(user.balance),
                    income: 30,
                    case_id: -1,
                    case_price: 0,
                    code: "gift"
                },
                dataType: "text",
                beforeSend: function() {
                    view.OpenWindow("#window-loading");
                    console.info("[Отзывы]: Загрузка...");
                },
                success: function(info){
                    if(info.endsWith("[Продажа ключа]: Успех")){
                        view.OpenMessageWindow("Поздравляем!", "Мы начислили Вам бонусные рубли");
                        view.BalanceUpdate();
                    }
                    else
                        view.OpenMessageWindow("Ошибка", "Попробуйте, пожалуйста, позже");
                }
            });
        }
        else if(info.endsWith("[Отзывы]: Не обнаружено")) {
            view.OpenMessageWindow("Ошибка", "Мы не нашли Ваш отзыв либо он был написан очень давно");
        }
        else if(info.endsWith("[Отзывы]: Уже использовано")) {
            view.OpenMessageWindow("Ошибка", "Вы уже получили свой бонус");
        }
        else if(info.endsWith("[Отзывы]: Авторизация через Стим")) {
            view.OpenMessageWindow("Ошибка", "Пожалуйста, авторизируйтесь через ВКонтакте и повторите попытку");
        }
        else {
            view.OpenMessageWindow("Ошибка", "Попробуйте, пожалуйста, позже");
        }
    }
    BonusesStop()
    {
        $.ajax({
            url: window.location.protocol +  "//" + window.location.host + "/handler/bonuses/stop/" + user.id,
            type: "POST",
            data: {
                uid: parseInt(user.id)
            },
            success: function(){
                user.daily_gift = true;
            }
        });
    }
    LiveTape()
    {
        var result;
        $.ajax({
            url: window.location.protocol + "//" + window.location.host + "/" + "handler/livetape",
            dataType: "json",
            async:false,
            success: function(data)
            {
                result = data;
            }
        });
        return result;
    }
    LoadConfigs()
    {
        var result;
        console.log("Загружаю файл конфигурации...");
        $.ajax({
            url: window.location.protocol + "//" + window.location.host + "/" + "config/main.json",
            async:false,
            dataType: "json",
            success: function(e)
            {
                result = e;
                console.log("Файл конфигурации был загружен");
            }
        });
        return result;
    }
}