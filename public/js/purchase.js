$("#purchase_button").click(function()
{
    if(user.username === undefined)
        view.OpenWindow("#window-authorize");
    else
        view.OpenWindow("#window-pay");
});
$("#button-buyGame").click(function()
{
    let res = data.BuyGame($(this).attr('game-id'), $(this).attr('price'));
    console.info(res);
    if( res.endsWith('SUCCESS')) {
        view.OpenMessageWindow("Успех!", "Сейчас вы будете перенаправлены на страницу с покупками, где вы сможете увидеть ключ от купленной игры");
        window.setTimeout(function(){
            window.location.href = window.location.protocol +  "//" + window.location.host + "/orders";
        }, 4000);
    }
    else if( res.endsWith('Failed to find keys'))
        view.OpenMessageWindow("Ошибка", "К сожалению, ключи к данной игре закончились. Попробуйте позже");
    else
        view.OpenMessageWindow("Ошибка", "Попробуйте, пожалуйста, позже");
});
