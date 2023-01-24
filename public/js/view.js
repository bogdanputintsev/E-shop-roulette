
class View
{
    WriteFeedback()
    {
        if(user.id != null)
        {
            console.info("[Отзывы]: Запрос отправлен");
            data.WriteFeedback();
        }
        else
            view.OpenWindow("#window-authorize");
    }
    LiveTapeStart()
    {
        console.info("[Live Tape]: Успех");
        for (let i = tape.length - 1; i >= 0; i--) {
            $(".online-inner").prepend('<div class="block" style="background: url(/img/game/' + tape[i].image_key + '-SMALL.png) no-repeat center;"></div>').children(":first").append('<div class="values"><p>' + tape[i].username + '</p><p class="tapeTime">' + tape[i].date + "</p></div>");
            $("#winnings_count").text(tape.global);
        }
    }
    LiveTapeUpdate()
    {
        tape = data.LiveTape();
        if ( tape.global > parseInt($("#winnings_count").text()) )
        {
            for( let t = tape.global - parseInt($("#winnings_count").text()); t > 0; t--)
            {
                if($(".online-inner .block").length == 11) {
                    $(".online-inner .block").slice(parseInt($("#winnings_count").text()) - tape.global).hide(500, function() {
                        $(".online-inner").children(":last").remove()
                    })
                }
                $(".online-inner").prepend('<div class="block" style="background: url(/img/game/' + tape[t - 1].image_key + '-SMALL.png) no-repeat center; display:none;"></div>').children(":first").append('<div class="values"><p>' + tape[t - 1].username + '</p><p class="tapeTime">' + tape[t - 1].date + "</p></div>").show(1000);
            }
            $("#winnings_count").text(tape.global);
            console.info("[Live Tape]: Обновлено");
        }
        for ( let t = 1; t < $(".online-inner .block").length; t++ )
            $(".online-inner .tapeTime").slice(t - 1).text(tape[t - 1].date);

    }
    UsersOnline()
    {
        $("#online_count").text(dataUser.GetUsersOnline());
    }
    BalanceUpdate()
    {
        $("#balance-value").text(dataUser.GetUserBalance());
    }
    OpenWindow(elementId)
    {
        $.fancybox.close();             // Закрываем все предыдущие всплывающие окна
        $.fancybox.open({
            src  : elementId,                       // Всегда начинается с #
            type : 'inline',
            opts : {
                afterShow : function( instance, current ) {
                    console.info( 'Открыл окно ' + elementId );
                }
            }
        });
    }
    OpenMessageWindow(header, message)
    {
        $.fancybox.close();             // Закрываем все предыдущие всплывающие окна
        $("#message-header").text(header);
        $("#message-text").text(message);
        $.fancybox.open({
            src  : "#window-message",
            type : 'inline',
            opts : {
                afterShow : function( instance, current ) {
                    console.info( '[Сообщение]: ' + message );
                }
            }
        });
    }
    KeySellSuccess(info, income)
    {
        if(info.endsWith("[Продажа ключа]: Успех"))
        {
            user.balance = parseInt(user.balance) + parseInt(income);
            roulette.lastIncome = parseInt(income);
            view.BalanceUpdate();
            console.info("Новый баланс: " + user.balance + " ("+income + ")");
        }
        else
        {
            console.error(info);
            view.OpenMessageWindow("Ошибка", "Пожалуйста, попробуйте позже. В случае помощи, обратитесь в техподдержку.");
        }
    }
    TakeKeySuccess(info, price_sell)
    {
        user.balance = parseInt(user.balance) - parseInt(price_sell);
        if(info.endsWith("[Выдача ключа]: Успех"))
        {
            console.info(info);
            view.OpenWindow("#window-sell");
            view.BalanceUpdate();
        }
        else if(info.endsWith("[Выдача ключа]: Ключ не был найден"))
        {
            console.info(info);
            view.OpenMessageWindow("Ключи к данной игре закончились", "Мы автоматически начислили Вам средства с продажи ключа");
            view.BalanceUpdate();
        }
        else
        {
            console.error(info);
            view.OpenMessageWindow("Ошибка", "Пожалуйста, попробуйте позже. Мы автоматически начислили Вам средства с продажи ключа. В случае помощи, обратитесь в техподдержку.");
        }
    }
}